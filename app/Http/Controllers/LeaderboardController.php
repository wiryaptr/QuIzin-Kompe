<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    /**
     * Menampilkan leaderboard peserta dalam satu room berdasarkan kode room.
     */
    public function roomLeaderboard(string $code): JsonResponse
    {
        $room = Room::with('quiz:id,title')
            ->where('code', strtoupper(trim($code)))
            ->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        $participants = Participant::where('room_id', $room->id)
            ->withSum('answers as total_response_time_ms', 'response_time_ms')
            ->withCount([
                'answers as correct_answers_count' => function ($query) {
                    $query->where('is_correct', true);
                },
                'answers as answered_questions_count',
            ])
            ->orderByDesc('total_score')
            ->orderBy('total_response_time_ms')
            ->orderBy('created_at')
            ->get()
            ->values()
            ->map(function ($participant, $index) {
                return [
                    'rank' => $index + 1,
                    'participant_id' => $participant->id,
                    'user_id' => $participant->user_id,
                    'nickname' => $participant->nickname,
                    'total_score' => (int) $participant->total_score,
                    'correct_answers' => (int) ($participant->correct_answers_count ?? 0),
                    'answered_questions' => (int) ($participant->answered_questions_count ?? 0),
                    'total_response_time_ms' => (int) ($participant->total_response_time_ms ?? 0),
                ];
            });

        return response()->json([
            'data' => [
                'room' => [
                    'id' => $room->id,
                    'code' => $room->code,
                    'status' => $room->status,
                    'quiz_title' => $room->quiz?->title,
                ],
                'leaderboard' => $participants,
            ],
        ]);
    }

    /**
     * Menampilkan riwayat pengerjaan kuis untuk pengguna yang login.
     */
    public function userHistory(Request $request, ?int $userId = null): JsonResponse
    {
        $targetUserId = $request->user()?->id ?? $userId;

        if (! $targetUserId) {
            return response()->json([
                'message' => 'User belum login atau user_id tidak diberikan.',
            ], 401);
        }

        $histories = Participant::where('user_id', $targetUserId)
            ->with(['room.quiz:id,title,description'])
            ->withCount([
                'answers as correct_answers_count' => function ($query) {
                    $query->where('is_correct', true);
                },
                'answers as answered_questions_count',
            ])
            ->latest('created_at')
            ->get()
            ->map(function ($participant) {
                return [
                    'participant_id' => $participant->id,
                    'nickname' => $participant->nickname,
                    'total_score' => (int) $participant->total_score,
                    'correct_answers' => (int) ($participant->correct_answers_count ?? 0),
                    'answered_questions' => (int) ($participant->answered_questions_count ?? 0),
                    'played_at' => $participant->created_at,
                    'room' => [
                        'id' => $participant->room?->id,
                        'code' => $participant->room?->code,
                        'status' => $participant->room?->status,
                        'quiz_title' => $participant->room?->quiz?->title,
                    ],
                ];
            });

        return response()->json([
            'data' => [
                'user_id' => (int) $targetUserId,
                'total_games_played' => $histories->count(),
                'histories' => $histories,
            ],
        ]);
    }
}