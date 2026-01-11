<?php

return [
    // Backward-compat: ADMIN_KEY masih didukung.
    // Preferred: ADMIN_SECRET_CREDENTIAL
    'secret_credential' => env('ADMIN_SECRET_CREDENTIAL', env('ADMIN_KEY', '')),
    'admin_key' => env('ADMIN_KEY', ''),
    'admin_notification_emails' => array_values(array_filter(array_map(
        static fn($email) => trim((string) $email),
        explode(',', (string) env('ADMIN_NOTIFICATION_EMAILS', ''))
    ))),
];
