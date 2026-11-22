<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    /**
     * Masuk ke room menggunakan kode room dan nickname (support guest & user login).
     */
    public function join(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20'],
            'nickname' => ['required', 'string', 'min:2', 'max:30'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $code = strtoupper(trim($validated['code']));
        $nickname = trim($validated['nickname']);
        $userId = $request->user()?->id ?? ($validated['user_id'] ?? null);

        $room = Room::where('code', $code)->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        if ($room->status !== 'waiting') {
            return response()->json([
                'message' => 'Room sudah dimulai atau sudah berakhir.',
            ], 422);
        }

        // Cegah nickname kembar di room yang sama
        $nicknameExists = Participant::where('room_id', $room->id)
            ->whereRaw('LOWER(nickname) = ?', [strtolower($nickname)])
            ->exists();

        if ($nicknameExists) {
            return response()->json([
                'message' => 'Nickname sudah dipakai peserta lain di room ini.',
            ], 422);
        }

        // Jika user login sudah pernah join room yang sama, kembalikan data peserta yang ada
        if ($userId) {
            $existingUserParticipant = Participant::where('room_id', $room->id)
                ->where('user_id', $userId)
                ->first();

            if ($existingUserParticipant) {
                return response()->json([
                    'message' => 'Kamu sudah terdaftar di room ini.',
                    'data' => [
                        'room' => $room,
                        'participant' => $existingUserParticipant,
                    ],
                ]);
            }
        }

        $participant = Participant::create([
            'room_id' => $room->id,
            'user_id' => $userId,
            'nickname' => $nickname,
            'total_score' => 0,
        ]);

        return response()->json([
            'message' => 'Berhasil masuk ke room.',
            'data' => [
                'room' => $room,
                'participant' => $participant,
            ],
        ], 201);
    }

    /**
     * Mengambil daftar peserta di dalam room tertentu berdasarkan kode room.
     */
    public function indexByRoom(string $code): JsonResponse
    {
        $room = Room::where('code', strtoupper(trim($code)))->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        $participants = Participant::where('room_id', $room->id)
            ->select('id', 'room_id', 'user_id', 'nickname', 'total_score', 'created_at')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'data' => [
                'room_code' => $room->code,
                'status' => $room->status,
                'participants' => $participants,
            ],
        ]);
    }
}