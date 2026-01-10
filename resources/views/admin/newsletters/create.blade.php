<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Compose Newsletter</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="text-sm text-gray-600">Will be sent to <span class="font-medium">{{ $recipientCount }}</span> active & verified subscribers.</p>

                    <form method="POST" action="{{ route('admin.newsletters.store') }}" class="mt-6 space-y-4">
                        @csrf

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                            <input id="subject" name="subject" value="{{ old('subject') }}" class="mt-1 border rounded-md px-3 py-2 text-sm w-full" required />
                            @error('subject')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea id="content" name="content" rows="10" class="mt-1 border rounded-md px-3 py-2 text-sm w-full" required>{{ old('content') }}</textarea>
                            @error('content')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" name="action" value="draft" class="rounded-md bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-900 hover:bg-gray-300">Save Draft</button>
                            <button type="submit" name="action" value="send" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800" onclick="return confirm('Send this newsletter now?')">Send Newsletter</button>
                            <a href="{{ route('admin.newsletters.index') }}" class="ml-auto text-sm text-gray-700 hover:underline self-center">Cancel</a>
                        </div>

                        @error('action')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>