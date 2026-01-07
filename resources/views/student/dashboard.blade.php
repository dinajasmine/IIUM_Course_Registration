
    @extends('student.layout')

    @section('content')
    <h1>Student Dashboard</h1>
    <h2>Welcome Student !</h2>

    @if($registrations->count() == 0)
        <p>You have no course registrations yet.</p>
    @endif


    <table border="1" cellpadding="8">
        <tr>
            <th>Subject Code</th>
            <th>Subject Name</th>
            <th>Credit Hours</th>
        </tr>

        @foreach($registrations as $reg)
        <tr>
            <td>{{ $reg->subject->code }}</td>
            <td>{{ $reg->subject->name }}</td>
        </tr>
        @endforeach
    </table>
    @endsection

