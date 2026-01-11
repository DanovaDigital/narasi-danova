<x-admin-layout>
    <x-slot name="heading">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: News Submissions</h2>
    </x-slot>

    <div class="mb-6">
        <h2 class="text-2xl font-serif font-bold text-gray-900">News Submissions</h2>
        <p class="text-sm text-gray-500 mt-1">Manage user-submitted news stories</p>
    </div>

    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
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
                    class="rounded-md px-3 py-1.5 text-sm font-medium {{ $status === $key ? 'bg-brand-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">{{ $label }}</a>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phone</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subject</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($submissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $submission->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->phone }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $submission->subject }}</td>
                        <td class="px-6 py-4">
                            @php
                            $badge = match ($submission->status) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'reviewed' => 'bg-blue-100 text-blue-800',
                            'approved' => 'bg-green-100 text-green-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-700',
                            };
                            @endphp
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $badge }}">{{ ucfirst($submission->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $submission->created_at?->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <a href="{{ route('admin.submissions.show', $submission) }}" class="text-brand-600 hover:text-brand-700">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2">No submissions found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($submissions->hasPages())
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
            {{ $submissions->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>