<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.app', 'layouts.navigation', 'layouts.footer'], function ($view) {
            $navCategories = Category::query()->orderBy('name')->get(['name', 'slug']);

            $settings = SiteSetting::query()
                ->whereIn('key', ['site_name', 'site_description', 'footer_text', 'whatsapp_number', 'whatsapp_message'])
                ->pluck('value', 'key');

            $rawWhatsappNumber = (string) ($settings['whatsapp_number'] ?? '');
            $whatsappNumber = preg_replace('/\D+/', '', $rawWhatsappNumber);
            $whatsappMessage = (string) ($settings['whatsapp_message'] ?? 'Halo, saya ingin mengajukan berita');
            $whatsappUrl = $whatsappNumber !== '' && strlen($whatsappNumber) >= 8
                ? ('https://wa.me/' . $whatsappNumber . '?text=' . rawurlencode($whatsappMessage))
                : null;

            $view->with([
                'navCategories' => $navCategories,
                'siteName' => (string) ($settings['site_name'] ?? config('app.name')),
                'siteDescription' => (string) ($settings['site_description'] ?? ''),
                'footerText' => (string) ($settings['footer_text'] ?? ''),
                'whatsappUrl' => $whatsappUrl,
            ]);
        });
    }
}
