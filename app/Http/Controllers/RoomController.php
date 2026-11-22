<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Room;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Membuat room baru dengan kode unik dan status awal 'waiting'.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'quiz_id' => ['required', 'integer', 'exists:quizzes,id'],
            'host_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $hostId = $validated['host_id'] ?? $request->user()?->id;

        if (! $hostId) {
            return response()->json([
                'message' => 'host_id wajib diisi atau pengguna harus login.',
            ], 422);
        }

        $room = Room::create([
            'quiz_id' => $validated['quiz_id'],
            'host_id' => $hostId,
            'code' => $this->generateUniqueRoomCode(),
            'status' => 'waiting',
            'started_at' => null,
            'ended_at' => null,
        ]);

        return response()->json([
            'message' => 'Room berhasil dibuat.',
            'data' => $room,
        ], 201);
    }

    /**
     * Mengambil data lobby room beserta daftar peserta yang sudah masuk.
     */
    public function lobby(string $code): JsonResponse
    {
        $room = Room::with([
            'quiz:id,title,description',
            'participants' => function ($query) {
                $query->select('id', 'room_id', 'user_id', 'nickname', 'total_score', 'created_at')
                    ->orderBy('created_at');
            },
        ])->where('code', strtoupper($code))->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room dengan kode tersebut tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'data' => [
                'room' => $room,
                'participants' => $room->participants,
                'participant_count' => $room->participants->count(),
            ],
        ]);
    }

    /**
     * Mengubah status room menjadi 'active' (memulai permainan).
     */
    public function start(string $code): JsonResponse
    {
        $room = Room::where('code', strtoupper($code))->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        if ($room->status === 'finished') {
            return response()->json([
                'message' => 'Room sudah selesai dan tidak dapat dimulai ulang.',
            ], 422);
        }

        $room->update([
            'status' => 'active',
            'started_at' => $room->started_at ?? now(),
        ]);

        return response()->json([
            'message' => 'Permainan dimulai.',
            'data' => $room->fresh(),
        ]);
    }

    /**
     * Mengubah status room menjadi 'finished' (mengakhiri permainan).
     */
    public function finish(string $code): JsonResponse
    {
        $room = Room::where('code', strtoupper($code))->first();

        if (! $room) {
            return response()->json([
                'message' => 'Room tidak ditemukan.',
            ], 404);
        }

        $room->update([
            'status' => 'finished',
            'ended_at' => now(),
        ]);

        return response()->json([
            'message' => 'Permainan telah diakhiri.',
            'data' => $room->fresh(),
        ]);
    }

    /**
     * Menghasilkan kode room 6 karakter huruf/angka yang unik.
     */
    private function generateUniqueRoomCode(int $length = 6): string
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (Room::where('code', $code)->exists());

        return $code;
    }
}