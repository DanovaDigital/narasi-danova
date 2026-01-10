<?php

namespace App\Http\Controllers;

use App\Mail\AdminNewSubmission;
use App\Models\Admin;
use App\Models\NewsSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsSubmissionController extends Controller
{
    public function create()
    {
        return view('news.submission');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $submission = NewsSubmission::query()->create($data);

        // Best-effort notify admins via email (doesn't block submission if mail isn't configured).
        try {
            $adminEmails = Admin::query()->pluck('email')->filter()->unique()->values();
            foreach ($adminEmails as $email) {
                Mail::to($email)->send(new AdminNewSubmission($submission));
            }
        } catch (\Throwable $e) {
            // Ignore mail errors for MVP.
        }

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Pengajuan berita berhasil dikirim.',
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan berita berhasil dikirim.');
    }
}
