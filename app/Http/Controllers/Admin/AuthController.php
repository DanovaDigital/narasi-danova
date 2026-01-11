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
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'admin_key' => ['required', 'string'],
            'pin' => ['required', 'digits:6'],
        ]);

        $expectedKey = (string) config('news.admin_key');
        if ($expectedKey === '') {
            return back()->withErrors([
                'admin_key' => 'ADMIN_KEY belum dikonfigurasi di server.',
            ]);
        }

        if (! hash_equals($expectedKey, (string) $validated['admin_key'])) {
            return back()->withErrors([
                'admin_key' => 'Admin key salah.',
            ])->onlyInput('admin_key');
        }

        $admin = Admin::query()->orderBy('id')->first();
        if (! $admin) {
            return back()->withErrors([
                'admin_key' => 'Admin belum dibuat. Jalankan seeder terlebih dahulu.',
            ]);
        }

        // PIN is mandatory. If not configured, block login.
        if (! $admin->pin_hash) {
            return back()->withErrors([
                'pin' => 'PIN admin belum di-set. Jalankan: php artisan admin:set-pin ' . $admin->id . ' --pin=123456',
            ])->onlyInput('admin_key');
        }

        $pinInput = (string) $validated['pin'];
        if (! Hash::check($pinInput, $admin->pin_hash)) {
            return back()->withErrors([
                'pin' => 'PIN salah.',
            ])->onlyInput('admin_key');
        }

        Auth::guard('admin')->loginUsingId($admin->id);
        $request->session()->regenerate();

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
