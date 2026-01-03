<!DOCTYPE html>
<html lang="en">
<head>
    <h2>Manual Registration Approval</h2>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @foreach($registrations as $reg)
    <p>
        {{ $reg->user->name ?? 'Student'}} |
        {{ $reg->subject->name}}

        <form method = "POST" action = "/admin/manual-approve/{{ $reg->id }}">
            @csrf
            <button type="submit">Approve</button>
        </form>
    </p>
    @endforeach
</body>
</html>