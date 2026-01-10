<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewsletterJob;
use App\Models\Newsletter;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function index()
    {
        $newsletters = Newsletter::query()
            ->with('sender')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.newsletters.index', [
            'newsletters' => $newsletters,
        ]);
    }

    public function create()
    {
        $recipientCount = Subscriber::query()
            ->where('is_active', true)
            ->where('is_verified', true)
            ->whereNull('unsubscribed_at')
            ->count();

        return view('admin.newsletters.create', [
            'recipientCount' => $recipientCount,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'action' => ['required', 'in:send,draft'],
        ]);

        $recipientCount = Subscriber::query()
            ->where('is_active', true)
            ->where('is_verified', true)
            ->whereNull('unsubscribed_at')
            ->count();

        $newsletter = Newsletter::query()->create([
            'subject' => $data['subject'],
            'content' => $data['content'],
            'sent_by' => auth('admin')->id(),
            'sent_count' => $data['action'] === 'send' ? $recipientCount : 0,
            'sent_at' => $data['action'] === 'send' ? now() : null,
        ]);

        if ($data['action'] === 'send') {
            SendNewsletterJob::dispatch($newsletter->id);
            return redirect()->route('admin.newsletters.index')->with('success', 'Newsletter queued for sending.');
        }

        return redirect()->route('admin.newsletters.index')->with('success', 'Draft saved.');
    }

    public function show(Newsletter $newsletter)
    {
        $newsletter->load('sender');

        return view('admin.newsletters.show', [
            'newsletter' => $newsletter,
        ]);
    }
}
