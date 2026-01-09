@extends('admin.layout')
@section('content')

<head>
    <title>Manual Approval</title>
</head>

<div class="approval-container">
    <h1>Manual Registration Approval</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if (session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    @if($registrations->isEmpty())
        <div class="no data">
            <p>No pending manual registrations.</p>
        </div>
    @else
        <table class="approval-table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Subject</th>
                    <th>Course Code</th>
                    <th>Current Credit Hours</th>
                    <th>Completed Credit Hours</th>
                    <th>Reason</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($registrations as $registration)
                <tr>
                    <td>{{ $registration->student->name ?? 'N/A'}}</td>
                    <td>{{ $registration->subject_name ?? 'N/A'}}</td>
                    <td>{{ $registration->course_code }}</td>
                    <td>{{ $registration->current_credit_hours }}</td>
                    <td>{{ $registration->completed_credit_hours }}</td>
                    <td>{{ $registration->reason }}</td>
                    <td class="reason-cell">{{$registration->reason}}</td>
                    <td class="action-cell">
                        <form method="POST" action="{{ url('/admin/manual-approval/' . $registration->id . '/approve') }}" class="inline-form">
                            @csrf
                            <button type="submit" class="btn-approve">Approve</button>
                        </form>

                        <form method="POST" action="{{ url('/admin/manual-approval/' . $registration->id . '/reject') }}" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-reject">Reject</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
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

    .alert{
        padding : 15px;
        margin-bottom: 20px;
        border-radius: 6px;
    }

    .alert-success{
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .no-data{
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 02px 5px rgba(0,0,0,0.1);
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
    
    .reason-cell {
        max-width: 300px;
        word-wrap: break-word;
    }
    
    .action-cell {
        white-space: nowrap;
    }
    
    .inline-form {
        display: inline-block;
        margin-right: 5px;
    }
    
    .btn-approve, .btn-reject {
        padding: 8px 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }
    
    .btn-approve {
        background-color: #2ecc71;
        color: white;
    }
    
    .btn-approve:hover {
        background-color: #27ae60;
    }
    
    .btn-reject {
        background-color: #e74c3c;
        color: white;
    }
    
    .btn-reject:hover {
        background-color: #c0392b;
    }
</style>
@endsection


