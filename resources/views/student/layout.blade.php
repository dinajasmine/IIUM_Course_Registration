<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>

    <style>
        body { 
            display:flex; 
            font-family: Arial;
            margin:0;
        }

        .banner{
            width:100%;
            background:#ffffff;
            border-bottom:1px solid #ccc;
            flex-shrink: 0;
        }
        
        .banner img(){
            width:100%; 
            height:auto; 
            display: block;
        }

        .main-container{
            display: flex;
            flex:1;
        }

        .sidebar{
            width: 300px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .sidebar h3{
            margin-bottom: 20px;
        }

        .sidebar a{
            display: block;
            padding: 20px 15px;
            margin-bottom: 10px;
            background-color: #34495e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
        }
        .sidebar a:hover{
            background-color: #1abc9c;
        }

        .sidebar a.active{
            background-color: #1abc9c;
        }

        .content{
            padding: 20px;
            flex: 1;
        }
    </style>
</head>
<body>

    <!--IIUM BANNER-->
    <div style="width:100%; background:#ffffff; border-bottom:1px solid #ccc; text-align:center;">
        <div class="banner" style="display:inline-block; background:linear-gradient(135deg, #2c3e50 0%, #1abc9c 100%)">
            <img src="https://upload.wikimedia.org/wikipedia/commons/d/de/IIUM_Logo_2019.svg" 
                alt="IIUM Banner"
                style="width:800px; height:200px; object-fit:contain;">
        </div>



        <div class="main-container">

            <div class="sidebar">
                <h3>Student Menu</h3>

                <a href="/student/dashboard"
                    class="{{ request()->is('student/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="/student/manual-register"
                    class="{{ request()->is('student/manual-register') ? 'active' : '' }}">
                    Manual Registration
                </a>

                <a href="/student/schedule"
                    class="{{ request()->is('student/schedule') ? 'active' : '' }}">
                    Schedule
                </a>

                <a href="/student/logout">
                    Logout
                </a>
            </div>

            <div class="content">
                @yield('content')
            </div>

        </div>
    </div>

</body>
</html>