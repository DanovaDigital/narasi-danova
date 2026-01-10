<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Newsletter</h2>
            <a href="{{ route('admin.newsletters.index') }}" class="text-sm text-gray-700 hover:underline">Back</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold">{{ $newsletter->subject }}</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Sent: <span class="font-medium">{{ $newsletter->sent_at?->format('Y-m-d H:i') ?? 'Draft' }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            Sent Count: <span class="font-medium">{{ $newsletter->sent_count }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            Sent By: <span class="font-medium">{{ $newsletter->sender?->name ?? '-' }}</span>
                        </p>
                    </div>

                    <div class="prose max-w-none">
                        {!! nl2br(e($newsletter->content)) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>