<form method="POST" action="{{ route('subscribe') }}" class="space-y-3" data-newsletter-form>
    @csrf

    <div>
        <label for="newsletter_email" class="block text-xs font-medium text-gray-700">Email</label>
        <input
            id="newsletter_email"
            name="email"
            type="email"
            required
            placeholder="nama@email.com"
            class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500" />
        @error('email')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="newsletter_name" class="block text-xs font-medium text-gray-700">Nama (opsional)</label>
        <input
            id="newsletter_name"
            name="name"
            type="text"
            placeholder="Nama Anda"
            class="mt-1 block w-full rounded-lg border-gray-300 text-sm shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500" />
        @error('name')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="inline-flex cursor-pointer items-center justify-center rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-primary-700 hover:shadow-md">
        Berlangganan
    </button>

    <p class="text-xs text-gray-500" data-newsletter-message></p>
</form>