@extends('student.layout')

@section('content')

<head>
    <title>Student Dashboard</title>
    <style>
        .dashboard-container {
            margin-left: 250px;
            padding: 20px;
        }

        .banner {
            background: #207c85;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .content-box {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th {
            background: #207c85;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .btn {
            background: #207c85;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .btn:hover {
            background: #207c85;
        }
    </style>
</head>

@php
    $subjects = [
        [
            'course_code' => 'BICS1301',
            'subject_name' => 'Introduction to Human Computer Interaction',
            'credit' => 3
        ],
        [
            'course_code' => 'BICS1302',
            'subject_name' => 'Introduction to Database Management',
            'credit' => 3
        ],
        [
            'course_code' => 'BICS1303',
            'subject_name' => 'Web Technologies and Development',
            'credit' => 3
        ],
        [
            'course_code' => 'BITI1304',
            'subject_name' => 'Fundamentals of Information Technology',
            'credit' => 2
        ],
    ];
@endphp

<div class="dashboard-container">

    <!-- Banner -->
    <div class="banner">
        <h1>Subject Registered for Semester 1 2025/2026</h1>
    </div>

    <!-- Content -->
    <div class="content-box">

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Course Code</th>
                    <th>Subject Name</th>
                    <th>Credit Hours</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                <tr>
                    <td>{{ $subject['course_code'] }}</td>
                    <td>{{ $subject['subject_name'] }}</td>
                    <td>{{ $subject['credit'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection
