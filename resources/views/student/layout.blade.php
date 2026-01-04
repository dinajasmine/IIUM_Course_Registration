<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
    <style>
        body { display:flex; font-family: Arial;}
        .sidebar{
            width: 200px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .sidebar a{
            color: white;
            text-decoration: none;
            display: block;
            margin: 10px 0;
        }

        .content{
            padding: 20px;
            flex: 1;
        }
</head>
<body>
    <div class="sidebar">
        <h3>Student Menu</h3>
        <a href="/student/dashboard">Dashboard</a>
        <a href="/student/manual-register">Manual Registration</a>
        <a href="/student/schedule">Schedule</a>
        <a href="/student/logout">Logout</a>
    </div>

    <div style = "padding:20px; flex:1">
        @yield('content')
    </div>

</body>
</html>