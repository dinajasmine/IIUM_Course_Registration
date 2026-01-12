{{-- resources/views/admin/subject_assignment.blade.php --}}

@extends('admin.layout')
@section('content')

<div class="approval-container">
    <h1>Subject Assignment</h1>

    <form method="POST" action="{{ route('admin.subject.assignment.store') }}">
        @csrf

        @if($subjects->isEmpty())
            <div class="no-data">
                <p>No subjects available.</p>
            </div>
        @else
            <table class="approval-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Subject Code</th>
                        <th>Subject Title</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($subjects as $subject)
                        <tr>
                            <td>
                                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}">
                            </td>
                            <td>{{ $subject->code }}</td>
                            <td>{{ $subject->title }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <br>
            <button type="submit" class="btn-approve">Assign Subjects</button>
        @endif
    </form>
</div>

<style>
    .approval-container{
        padding: 20px;
    }

    h1{
        color: #2c3e50;
        margin-bottom: 30px;
        padding-bottom: 10px;
        border-bottom: 2px solid #1abc9c;
    }

    .no-data{
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .no-data p{
        color: #7f8c8d;
        font-size: 18px;
    }

    .approval-table{
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .approval-table thead{
        background-color: #2c3e50;
        color: white;
    }

    .approval-table th{
        padding: 15px;
        text-align: left;
        font-weight: 600;
    }

    .approval-table td {
        padding: 15px;
        border-bottom: 1px solid #eee;
    }

    .approval-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    input[type="checkbox"] {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .btn-approve {
        background-color: #2ecc71;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-approve:hover {
        background-color: #27ae60;
    }
</style>
@endsection
