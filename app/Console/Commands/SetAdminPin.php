<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SetAdminPin extends Command
{
    protected $signature = 'admin:set-pin {adminId? : Admin ID (omit to use the first admin)} {--pin= : 6-digit PIN (omit to clear)}';
    protected $description = 'Set or clear an admin PIN';

    public function handle()
    {
        $adminId = $this->argument('adminId');
        $pin = $this->option('pin');

        if ($adminId === null) {
            $admin = Admin::query()->orderBy('id')->first();
        } elseif (is_numeric($adminId)) {
            $admin = Admin::query()->find((int) $adminId);
        } elseif (Schema::hasColumn('admins', 'email')) {
            // Backward-compatible lookup for older schemas.
            $admin = Admin::query()->where('email', (string) $adminId)->first();
        } else {
            $admin = null;
        }

        if (! $admin) {
            $this->error('Admin not found. Provide admin ID (or omit to use the first admin).');
            return 1;
        }

        if ($pin === null) {
            $admin->pin_hash = null;
            $admin->save();
            $this->info('Cleared PIN for admin #' . $admin->id);
            return 0;
        }

        if (! preg_match('/^\d{6}$/', $pin)) {
            $this->error('PIN must be exactly 6 digits.');
            return 1;
        }

        $admin->pin_hash = Hash::make($pin);
        $admin->save();

        $this->info('PIN set for admin #' . $admin->id);
        return 0;
    }
}
