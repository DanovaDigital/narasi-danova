<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Submission Detail</h2>
            <a href="{{ route('admin.submissions.index') }}" class="text-sm text-gray-700 hover:underline">Back</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 space-y-8">
                    <div>
                        <h3 class="text-lg font-semibold">Submission Info</h3>
                        <dl class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 text-sm">
                            <div>
                                <dt class="text-gray-600">Name</dt>
                                <dd class="font-medium">{{ $submission->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-600">Phone</dt>
                                <dd class="font-medium">{{ $submission->phone }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-600">Email</dt>
                                <dd class="font-medium">{{ $submission->email ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-600">Subject</dt>
                                <dd class="font-medium">{{ $submission->subject }}</dd>
                            </div>
                            <div class="sm:col-span-2">
                                <dt class="text-gray-600">Message</dt>
                                <dd class="mt-1 whitespace-pre-wrap">{{ $submission->message }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Status Update</h3>
                        <form method="POST" action="{{ route('admin.submissions.update', $submission) }}" class="mt-4 space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 border rounded-md px-3 py-2 text-sm w-full">
                                    @foreach ($statuses as $s)
                                    <option value="{{ $s }}" @selected(old('status', $submission->status) === $s)>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700">Admin Notes (optional)</label>
                                <textarea id="admin_notes" name="admin_notes" rows="4" class="mt-1 border rounded-md px-3 py-2 text-sm w-full" placeholder="Internal notes">{{ old('admin_notes', $submission->admin_notes) }}</textarea>
                                @error('admin_notes')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">Save</button>
                            </div>
                        </form>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold">Review History</h3>
                        <p class="mt-2 text-sm text-gray-700">
                            Reviewed by: <span class="font-medium">{{ $submission->reviewer?->name ?? '-' }}</span>
                            <span class="mx-2 text-gray-300">|</span>
                            Reviewed at: <span class="font-medium">{{ $submission->reviewed_at?->format('Y-m-d H:i') ?? '-' }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>