<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: News Submissions</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-wrap gap-2">
                        @php
                        $statuses = [
                        'all' => 'All',
                        'pending' => 'Pending',
                        'reviewed' => 'Reviewed',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                        ];
                        @endphp

                        @foreach ($statuses as $key => $label)
                        <a
                            href="{{ route('admin.submissions.index', array_merge(request()->except('page'), ['status' => $key])) }}"
                            class="rounded-md px-3 py-1.5 text-sm {{ $status === $key ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">{{ $label }}</a>
                        @endforeach
                    </div>

                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600">
                                <tr>
                                    <th class="py-2 pr-4">Name</th>
                                    <th class="py-2 pr-4">Phone</th>
                                    <th class="py-2 pr-4">Subject</th>
                                    <th class="py-2 pr-4">Status</th>
                                    <th class="py-2 pr-4">Submitted</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($submissions as $submission)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $submission->name }}</td>
                                    <td class="py-3 pr-4 text-gray-700">{{ $submission->phone }}</td>
                                    <td class="py-3 pr-4 text-gray-700">{{ $submission->subject }}</td>
                                    <td class="py-3 pr-4">
                                        @php
                                        $badge = match ($submission->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'reviewed' => 'bg-blue-100 text-blue-800',
                                        'approved' => 'bg-green-100 text-green-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-700',
                                        };
                                        @endphp
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $badge }}">{{ ucfirst($submission->status) }}</span>
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $submission->created_at?->format('Y-m-d H:i') }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.submissions.show', $submission) }}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-gray-500">No submissions.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $submissions->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>