<?php

namespace App\Http\Controllers;

use App\Models\PersonalNote;
use App\Models\PersonalTask;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function gemini_api(Request $request)
    {
        $user = Auth::user();
        $basicPrompt = "This is an application named SchedU, developed by PBL-IF2D01, with Alif Fajriadi as the team leader, and team members Bastian, Rafif Ihsan, and Dwiky. SchedU is an application that provides note-taking and scheduling features that can be used both personally and in groups.

Students can create, view, edit, and delete their personal notes, tasks, and schedules. Additionally, in a group setting, teachers and students can collaborate to manage shared notes, tasks, and schedules. The application includes four roles: admin, institution staff, teacher, and student.

Please act as a customer service agent for this application and respond briefly. tidy up in normal writing, don't have symbols, Below is the user's biodata:
Name: " . $user->name . "
Role: " . ($user->is_teacher == 1 ? "Teacher" : "Student") . "
he notes personal: " . PersonalNote::query()->where('user_uuid', $user->uuid)->get() . "
he task personal: " . PersonalTask::query()->where('user_uuid', $user->uuid)->get() . "

And here is the question: " . $request->input('message');

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
            ]), 'application/json')->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent');


            return response()->json($response->json());
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }
}
