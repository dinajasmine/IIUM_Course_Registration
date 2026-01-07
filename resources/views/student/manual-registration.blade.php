
@extends('student.layout')
@section('content')


<h1>Manual Course Registration</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<form method="POST" action="/student/manual-registration">
    @csrf

    <div class="form-group">
        <label>Subject :</label>
        <input type="text" id="subject" name="subject" required
            placeholder="Enter subject name">
    </div>

    <div class="form-group">
        <label>Course Code :</label>
        <input type="text" id="course_code" name="course_code" required
            placeholder="Enter course code">
    </div>

    <div class="form-group">
        <label for="credit_hours">Current Credit Hours :</label>
        <input type="number" id="credit_hours" name="credit_hours" required
            placeholder="Enter credit hours">
    </div>

    <div class="form-group">
        <label>Reason: </label>
        <input type="text" id="reason" name="reason" required
            placeholder="Enter reason">
    </div>

    <button type="submit">Submit</button>
</form>

<style>
    .manual-registration-form{
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .manual-registration-form h2{
        color: #2c3e50;
        margin-bottom: 30px;
        text-align: center;
    }

    .form-group{
        margin-bottom: 25px;
    }

    .form-group label{
        display:block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #34495e;
    }

    .form-group input,
    .form-group textarea{
        height: 20px;
        width: 500px;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 16px;
        font-family: Arial, sans-serif;
        transition: border-color 0.3s;
    }

    .form-group input:foucs,
    .form-group textarea:focus{
        outline: none;
        border-color: #1abc9c;
        box-shadow: 0 0 2px rgba(26, 188, 156, 0.2);
    }

    .submit-btn{
        background-color: #1abc9c;
        color: white;
        padding: 12px 30px;
        border: none;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s;
        display: block;
        margin: 0 auto;
    }

    .submit-btn:hover{
        background-color: #16a085;
    }

</style>    
@endsection