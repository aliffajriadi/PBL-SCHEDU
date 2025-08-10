<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PersonalNote;
use App\Models\PersonalTask;
use Illuminate\Http\Request;
use App\Models\PersonalSchedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function gemini_api(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $basicPrompt = "
Kamu adalah asisten SchedU.

⚠️ Penting: Balas HANYA dalam format JSON valid, tanpa teks tambahan, tanpa backtick, tanpa penjelasan. Waktu saat ini di aplikasi adalah $now.

Format untuk membuat tugas:
{
  \"action\": \"create_task\",
  \"title\": \"judul\",
  \"description\": \"deskripsi\",
  \"deadline\": \"Y-m-d H:i:s\"
}

Format untuk membuat catatan:
{
  \"action\": \"create_note\",
  \"title\": \"judul\",
  \"content\": \"isi catatan\"
}

Format untuk membuat jadwal:
{
  \"action\": \"create_schedule\",
  \"title\": \"judul\",
  \"content\": \"deskripsi\",
  \"start_datetime\": \"Y-m-d H:i:s\",
  \"end_datetime\": \"Y-m-d H:i:s\"
}

Format untuk jawaban umum:
{
  \"action\": \"answer_only\",
  \"message\": \"jawaban singkat\"
}

Data user:
Name: {$user->name}
Role: " . ($user->is_teacher ? "Teacher" : "Student") . "
Catatan personal: " . PersonalNote::where('user_uuid', $user->uuid)->get() . "
Tugas personal: " . PersonalTask::where('user_uuid', $user->uuid)->get() . "

Pesan user: " . $request->input('message');

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'X-goog-api-key' => env('API_KEY_GEMINI'),
            ])->withBody(json_encode([
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $basicPrompt]
                        ]
                    ]
                ]
            ]), 'application/json')
            ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');

            $json = $response->json();
            $textResult = $json['candidates'][0]['content']['parts'][0]['text'] ?? '{}';

            $cleanJson = preg_replace('/```(json)?/', '', $textResult);
            $cleanJson = str_replace('```', '', $cleanJson);
            $cleanJson = trim($cleanJson, " \n\r\t\0\x0B");

            $parsed = json_decode($cleanJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $parsed = [
                    'action' => 'answer_only',
                    'message' => $textResult
                ];
            }

            if ($parsed['action'] === 'create_task') {
                $deadline = $this->parseDate($parsed['deadline'] ?? $now, $now);

                PersonalTask::create([
                    'user_uuid'   => $user->uuid,
                    'title'       => $parsed['title'] ?? 'Tugas Tanpa Judul',
                    'content'     => $parsed['description'] ?? '',
                    'deadline'    => $deadline,
                    'is_finished' => 0
                ]);
            }

            if ($parsed['action'] === 'create_note') {
                PersonalNote::create([
                    'user_uuid' => $user->uuid,
                    'title'     => $parsed['title'] ?? 'Catatan Tanpa Judul',
                    'content'   => $parsed['content'] ?? '',
                ]);
            }

            if ($parsed['action'] === 'create_schedule') {
                $start = $this->parseDate($parsed['start_datetime'] ?? $now, $now);
                $end   = $this->parseDate($parsed['end_datetime'] ?? $now, $now);

                PersonalSchedule::create([
                    'user_uuid'      => $user->uuid,
                    'title'          => $parsed['title'] ?? 'Jadwal Tanpa Judul',
                    'content'        => $parsed['content'] ?? '',
                    'start_datetime' => $start,
                    'end_datetime'   => $end
                ]);
            }

            return response()->json($parsed);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    private function parseDate($dateString, $fallback)
    {
        try {
            return Carbon::parse($dateString)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return $fallback;
        }
    }
}
