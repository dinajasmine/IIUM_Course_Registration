@extends('student.layout')
@section('content')

<h1>Manual Registration Approval</h1>

    <table border="1">
        <tr>
            <th>Student ID</th>
            <th>Subject ID</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

    @foreach($registrations as $reg)
    <tr>
        <td>{{ $reg->user_id }}</td>
        <td>{{ $reg->subject_id }}</td>
        <td>{{ $reg->status }}</td>
        
        <td>
            <form method = "POST" action = "/admin/manual-approve/{{ $reg->id }}">
                @csrf
                <button type="submit">Approve</button>
            </form>
        </td>
    @endforeach

