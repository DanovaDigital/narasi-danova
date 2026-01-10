<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Settings</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
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
                            <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">Save Settings</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>