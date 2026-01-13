{{-- resources/views/admin/dashboard.blade.php --}}

@extends('admin.layout')
@section('content')

<div class="approval-container">
    <h1>Admin Dashboard</h1>

    {{-- Menu / Quick Links --}}
    <div class="dashboard-menu">
       
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

    .dashboard-menu ul{
        list-style: none;
        padding: 0;
    }

    .dashboard-menu li{
        margin-bottom: 15px;
    }

    .dashboard-menu a{
        text-decoration: none;
        display: inline-block;
        padding: 10px 20px;
        border-radius: 5px;
        background-color: #2ecc71;
        color: white;
        font-weight: 500;
        transition: all 0.3s;
    }

    .dashboard-menu a:hover{
        background-color: #27ae60;
    }
</style>

@endsection
