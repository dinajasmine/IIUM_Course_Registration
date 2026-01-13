
    @extends('student.layout')

    @section('content')

    <head>
    <title>Student Dashboard</title>
    </head>

    <h1>Student Dashboard</h1>
    <h2>Welcome {{ auth()->user()->name }}!</h2>

    @if($registrations->count() == 0)
        <p>You have no course registrations yet.</p>
    @else
     <table border="1" cellpadding="8" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: #2c3e50; color: white;">
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Credit Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $reg)
            <tr>
                <td>
                    @if($reg->subject)
                        {{ $reg->subject->code }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($reg->subject)
                        {{ $reg->subject->name }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if($reg->subject && $reg->subject->credit_hours)
                        {{ $reg->subject->credit_hours }}
                    @else
                        N/A
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection

