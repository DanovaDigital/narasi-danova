<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $filter = (string) $request->query('filter', 'all');
        $search = trim((string) $request->query('q', ''));

        $subscribers = Subscriber::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%');
            })
            ->when($filter === 'active', fn($q) => $q->where('is_active', true))
            ->when($filter === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($filter === 'verified', fn($q) => $q->where('is_verified', true))
            ->when($filter === 'unverified', fn($q) => $q->where('is_verified', false))
            ->orderByDesc('subscribed_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.subscribers.index', [
            'subscribers' => $subscribers,
            'filter' => $filter,
            'q' => $search,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $filter = (string) $request->query('filter', 'all');
        $search = trim((string) $request->query('q', ''));

        $query = Subscriber::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where('email', 'like', '%' . $search . '%');
            })
            ->when($filter === 'active', fn($q) => $q->where('is_active', true))
            ->when($filter === 'inactive', fn($q) => $q->where('is_active', false))
            ->when($filter === 'verified', fn($q) => $q->where('is_verified', true))
            ->when($filter === 'unverified', fn($q) => $q->where('is_verified', false))
            ->orderByDesc('subscribed_at');

        $filename = 'subscribers-' . now()->format('Y-m-d_His') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['email', 'name', 'is_active', 'is_verified', 'subscribed_at', 'unsubscribed_at']);

            $query->chunk(1000, function ($subscribers) use ($handle) {
                foreach ($subscribers as $subscriber) {
                    fputcsv($handle, [
                        $subscriber->email,
                        $subscriber->name,
                        (int) $subscriber->is_active,
                        (int) $subscriber->is_verified,
                        optional($subscriber->subscribed_at)->toDateTimeString(),
                        optional($subscriber->unsubscribed_at)->toDateTimeString(),
                    ]);
                }
            });

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')->with('success', 'Subscriber deleted.');
    }
}
