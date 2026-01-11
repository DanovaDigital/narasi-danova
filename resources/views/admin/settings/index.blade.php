<x-admin-layout>
    <x-slot name="heading">Settings</x-slot>

    <div class="max-w-5xl">
        <div class="mb-6">
            <h2 class="text-2xl font-serif font-bold text-gray-900">Site Settings</h2>
            <p class="text-sm text-gray-500 mt-1">Configure your website settings and preferences</p>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-100">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    @foreach ($settings as $group => $groupSettings)
                    <section class="border rounded-lg p-4">
                        <h3 class="text-lg font-semibold capitalize">{{ str_replace('_', ' ', $group) }}</h3>

                        <div class="mt-4 space-y-4">
                            @foreach ($groupSettings as $setting)
                            <div>
                                <label class="block text-sm font-medium text-gray-700" for="setting_{{ $setting->key }}">{{ str_replace('_', ' ', $setting->key) }}</label>

                                @if ($setting->type === 'textarea')
                                <textarea id="setting_{{ $setting->key }}" name="settings[{{ $setting->key }}]" rows="3" class="mt-1 border rounded-md px-3 py-2 text-sm w-full">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                                @elseif ($setting->type === 'boolean')
                                <div class="mt-2">
                                    <label class="inline-flex items-center gap-2 text-sm">
                                        <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" class="rounded" @checked(old('settings.' . $setting->key, (string) $setting->value) === '1') />
                                        <span>Enabled</span>
                                    </label>
                                </div>
                                @elseif ($setting->type === 'image' && $setting->key === 'site_logo')
                                <input id="setting_{{ $setting->key }}" type="file" name="site_logo" accept="image/*" class="mt-1 block text-sm" />

                                @if ($setting->value)
                                <div class="mt-2">
                                    <p class="text-xs text-gray-600">Current:</p>
                                    <img src="{{ Storage::disk('public')->url($setting->value) }}" alt="Site logo" class="mt-1 h-14 w-auto rounded border" />
                                </div>
                                @endif
                                @else
                                <input id="setting_{{ $setting->key }}" name="settings[{{ $setting->key }}]" value="{{ old('settings.' . $setting->key, $setting->value) }}" class="mt-1 border rounded-md px-3 py-2 text-sm w-full" />
                                @endif

                                @error('settings.' . $setting->key)
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                @if ($setting->type === 'image' && $setting->key === 'site_logo')
                                @error('site_logo')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </section>
                    @endforeach

                    <div>
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors shadow-soft">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>