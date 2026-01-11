<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->get('admin.credential_verified') === true) {
            return redirect()->route('admin.pin');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'credential' => ['required', 'string'],
        ]);

        $expected = (string) config('news.secret_credential', config('news.admin_key'));
        if ($expected === '') {
            return back()->withErrors([
                'credential' => 'Admin secret credential belum dikonfigurasi di server.',
            ]);
        }

        if (! hash_equals($expected, (string) $validated['credential'])) {
            return back()->withErrors([
                'credential' => 'Secret credential salah.',
            ])->onlyInput('credential');
        }

        // Set marker untuk step PIN.
        $request->session()->put('admin.credential_verified', true);
        $request->session()->put('admin.credential_verified_at', now()->timestamp);

        return redirect()->route('admin.pin');
    }

    public function showPin(Request $request)
    {
        if ($request->session()->get('admin.credential_verified') !== true) {
            return redirect()->route('admin.login');
        }

        $verifiedAt = (int) $request->session()->get('admin.credential_verified_at', 0);
        // Expire step 1 after 10 minutes.
        if ($verifiedAt > 0 && now()->timestamp - $verifiedAt > 600) {
            $request->session()->forget(['admin.credential_verified', 'admin.credential_verified_at']);
            return redirect()->route('admin.login')->withErrors([
                'credential' => 'Sesi verifikasi credential kadaluarsa. Silakan ulangi.',
            ]);
        }

        return view('admin.auth.pin');
    }

    public function verifyPin(Request $request)
    {
        if ($request->session()->get('admin.credential_verified') !== true) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'pin' => ['required', 'digits:6'],
        ]);

        $admin = Admin::query()->orderBy('id')->first();
        if (! $admin) {
            return redirect()->route('admin.login')->withErrors([
                'credential' => 'Admin belum dibuat. Jalankan seeder terlebih dahulu.',
            ]);
        }

        // PIN is mandatory. If not configured, block login.
        if (! $admin->pin_hash) {
            return back()->withErrors([
                'pin' => 'PIN admin belum di-set. Jalankan: php artisan admin:set-pin ' . $admin->id . ' --pin=123456',
            ]);
        }

        $pinInput = (string) $validated['pin'];
        if (! Hash::check($pinInput, $admin->pin_hash)) {
            return back()->withErrors([
                'pin' => 'PIN salah.',
            ]);
        }

        Auth::guard('admin')->loginUsingId($admin->id);
        $request->session()->forget(['admin.credential_verified', 'admin.credential_verified_at']);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->forget(['admin.credential_verified', 'admin.credential_verified_at']);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
