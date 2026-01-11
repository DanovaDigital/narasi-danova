<form method="POST" action="{{ route('subscribe') }}" class="space-y-3" data-newsletter-form>
    @csrf

    <div>
        <label for="newsletter_email" class="block text-xs font-medium text-gray-600">Email</label>
        <input
            id="newsletter_email"
            name="email"
            type="email"
            required
            placeholder="nama@email.com"
            class="mt-1 block w-full rounded-xl border-gray-200 bg-white text-sm font-sans shadow-sm transition-all duration-200 ease-in focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20" />
        @error('email')
        <p class="mt-1 text-xs text-brand-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="newsletter_name" class="block text-xs font-medium text-gray-600">Nama (opsional)</label>
        <input
            id="newsletter_name"
            name="name"
            type="text"
            placeholder="Nama Anda"
            class="mt-1 block w-full rounded-xl border-gray-200 bg-white text-sm font-sans shadow-sm transition-all duration-200 ease-in focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20" />
        @error('name')
        <p class="mt-1 text-xs text-brand-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition-all duration-200 ease-in hover:bg-brand-700 hover:shadow-md">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        Berlangganan
    </button>

    <p class="text-xs text-gray-500" data-newsletter-message></p>
</form>