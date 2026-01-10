<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsSubmission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    private const STATUSES = ['pending', 'reviewed', 'approved', 'rejected'];

    public function index(Request $request)
    {
        $status = (string) $request->query('status', 'all');

        $submissions = NewsSubmission::query()
            ->when($status !== 'all', fn($q) => $q->where('status', $status))
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.submissions.index', [
            'submissions' => $submissions,
            'status' => $status,
        ]);
    }

    public function show(NewsSubmission $submission)
    {
        $submission->load('reviewer');

        return view('admin.submissions.show', [
            'submission' => $submission,
            'statuses' => self::STATUSES,
        ]);
    }

    public function update(Request $request, NewsSubmission $submission)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:' . implode(',', self::STATUSES)],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $submission->fill([
            'status' => $data['status'],
            'admin_notes' => $data['admin_notes'] ?? null,
            'reviewed_by' => auth('admin')->id(),
            'reviewed_at' => now(),
        ])->save();

        return redirect()->route('admin.submissions.show', $submission)->with('success', 'Submission updated.');
    }
}
