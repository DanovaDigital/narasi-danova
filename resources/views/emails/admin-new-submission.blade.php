<p>New news submission received.</p>

<ul>
    <li><strong>Name:</strong> {{ $submission->name }}</li>
    <li><strong>Phone:</strong> {{ $submission->phone }}</li>
    @if ($submission->email)
    <li><strong>Email:</strong> {{ $submission->email }}</li>
    @endif
    <li><strong>Subject:</strong> {{ $submission->subject }}</li>
</ul>

<p><strong>Message:</strong></p>
<p>{{ $submission->message }}</p>