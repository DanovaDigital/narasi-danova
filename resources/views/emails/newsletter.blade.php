<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $newsletter->subject }}</title>
</head>

<body>
    <h2>{{ $newsletter->subject }}</h2>
    <div>
        {!! nl2br(e($newsletter->content)) !!}
    </div>
</body>

</html>