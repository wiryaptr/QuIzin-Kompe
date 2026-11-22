<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Participant;
use App\Models\Question;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameplayController extends Controller
{
    /**
     * Mengambil daftar soal dan opsi yang sudah diacak untuk room aktif.
     */
    public function questions(string $code): JsonResponse
    {
        $room = Room::with(['quiz.questions.options'])
            ->where('code', strtoupper(trim($code)))
            ->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        if ($room->status !== 'active') {
            return response()->json([
                'message' => 'Permainan belum dimulai atau sudah berakhir.',
            ], 422);
        }

        $questions = $room->quiz?->questions ?? collect();

        $formattedQuestions = $questions->shuffle()->values()->map(function ($question) {
            $options = $question->options->shuffle()->values()->map(function ($option) {
                return [
                    'id' => $option->id,
                    'option_text' => $option->option_text ?? $option->text ?? $option->label ?? null,
                ];
            });

            return [
                'id' => $question->id,
                'question_text' => $question->question_text ?? $question->prompt ?? $question->text ?? null,
                'time_limit' => $question->time_limit ?? 30,
                'base_points' => $question->points ?? 100,
                'options' => $options,
            ];
        });

        return response()->json([
            'data' => [
                'room_code' => $room->code,
                'status' => $room->status,
                'questions' => $formattedQuestions,
            ],
        ]);
    }

    /**
     * Memeriksa jawaban, menghitung skor di server, menyimpan ke answers,
     * dan memperbarui total_score peserta.
     */
    public function submitAnswer(Request $request, string $code): JsonResponse
    {
        $validated = $request->validate([
            'participant_id' => ['required', 'integer', 'exists:participants,id'],
            'question_id' => ['required', 'integer', 'exists:questions,id'],
            'option_id' => ['required', 'integer', 'exists:options,id'],
            'response_time_ms' => ['nullable', 'integer', 'min:0', 'max:600000'],
        ]);

        $room = Room::where('code', strtoupper(trim($code)))->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        if ($room->status !== 'active') {
            return response()->json([
                'message' => 'Room tidak dalam status aktif.',
            ], 422);
        }

        $participant = Participant::where('id', $validated['participant_id'])
            ->where('room_id', $room->id)
            ->first();

        if (! $participant) {
            return response()->json([
                'message' => 'Peserta tidak terdaftar di room ini.',
            ], 404);
        }

        $question = Question::with('options')->find($validated['question_id']);

        if (! $question) {
            return response()->json([
                'message' => 'Soal tidak ditemukan.',
            ], 404);
        }

        // Cegah peserta menjawab soal yang sama dua kali di room ini
        $alreadyAnswered = Answer::where('participant_id', $participant->id)
            ->where('question_id', $question->id)
            ->exists();

        if ($alreadyAnswered) {
            return response()->json([
                'message' => 'Soal ini sudah pernah dijawab oleh peserta.',
            ], 422);
        }

        $selectedOption = $question->options->firstWhere('id', $validated['option_id']);

        if (! $selectedOption) {
            return response()->json([
                'message' => 'Opsi jawaban tidak sesuai dengan soal yang dipilih.',
            ], 422);
        }

        $isCorrect = (bool) ($selectedOption->is_correct ?? false);
        $responseTimeMs = (int) ($validated['response_time_ms'] ?? 0);
        $timeLimitMs = (int) (($question->time_limit ?? 30) * 1000);
        $basePoints = (int) ($question->points ?? 100);

        $earnedPoints = 0;
        if ($isCorrect) {
            $clampedTimeMs = min(max($responseTimeMs, 0), max($timeLimitMs, 1));
            $speedRatio = max(0, 1 - ($clampedTimeMs / max($timeLimitMs, 1)));
            $bonusPoints = (int) round($basePoints * 0.5 * $speedRatio);
            $earnedPoints = $basePoints + $bonusPoints;
        }

        $result = DB::transaction(function () use (
            $participant,
            $question,
            $selectedOption,
            $isCorrect,
            $earnedPoints,
            $responseTimeMs
        ) {
            $answer = Answer::create([
                'participant_id' => $participant->id,
                'question_id' => $question->id,
                'option_id' => $selectedOption->id,
                'is_correct' => $isCorrect,
                'points' => $earnedPoints,
                'response_time_ms' => $responseTimeMs,
            ]);

            if ($earnedPoints > 0) {
                $participant->increment('total_score', $earnedPoints);
            }

            return [
                'answer' => $answer,
                'participant' => $participant->fresh(),
            ];
        });

        return response()->json([
            'message' => $isCorrect ? 'Jawaban benar!' : 'Jawaban kurang tepat.',
            'data' => [
                'is_correct' => $isCorrect,
                'points_earned' => $earnedPoints,
                'total_score' => $result['participant']->total_score,
                'answer' => $result['answer'],
            ],
        ], 201);
    }
}