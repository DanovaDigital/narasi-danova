<?php

namespace App\Http\Controllers;

use App\Mail\SubscriberVerification;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email'],
            'name' => ['nullable', 'string', 'max:255'],
        ]);

        $token = Str::random(40);
        $unsubscribeToken = Str::random(40);

        $subscriber = Subscriber::query()->create([
            'email' => $data['email'],
            'name' => $data['name'] ?? null,
            'verification_token' => $token,
            'unsubscribe_token' => $unsubscribeToken,
            'is_verified' => false,
            'is_active' => true,
            'subscribed_at' => now(),
        ]);

        Mail::to($subscriber->email)->send(new SubscriberVerification($subscriber));

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Terima kasih! Silakan cek email Anda untuk verifikasi subscription.',
            ]);
        }

        return redirect()->back()->with('success', 'Terima kasih! Silakan cek email Anda untuk verifikasi subscription.');
    }

    public function verify(string $token)
    {
        $subscriber = Subscriber::query()->where('verification_token', $token)->firstOrFail();

        $subscriber->update([
            'is_verified' => true,
            'verification_token' => null,
        ]);

        return redirect()->route('home')->with('success', 'Email berhasil diverifikasi.');
    }

    public function unsubscribe(string $token)
    {
        $subscriber = Subscriber::query()->where('unsubscribe_token', $token)->firstOrFail();

        $subscriber->update([
            'is_active' => false,
            'unsubscribed_at' => now(),
        ]);

        return redirect()->route('home')->with('success', 'Anda telah berhenti berlangganan.');
    }
}
