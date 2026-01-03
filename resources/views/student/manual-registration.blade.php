<!DOCTYPE html>
<html lang="en">
<head>
    <h2>Manual Course Registration</h2>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method = "POST">
        @csrf
        <label>Select Subject</label>
        <select name="subject_id">
            @foreach($subjects as $subject)
                <option value = "{{ $subject->id }}">
                    {{ $subject->code }} - {{$subject->name }}
                </option>
            @endforeach
        </select>
        
        <button type="submit">Register Course</button>
    </form> 
</body>
</html>