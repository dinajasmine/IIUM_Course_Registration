<!DOCTYPE html>
<html lang="en">

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

        .sidebar a,
        .sidebar button,
        .sidebar .logout-btn,
        .sidebar form button {
            display: block;
            padding: 20px 15px;
            margin-bottom: 10px;
            background-color: #34495e;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
            border: none;
            text-align: centre;
            width: 100%;
            font-family: inherit;
            font-size: 16px;
            cursor: pointer;
            box-sizing: border-box;
        }

        .sidebar a:hover, .sidebar button:hover, .sidebar .logout-btn:hover{
            background-color: #1abc9c;
        }

        .sidebar a.active {
            background-color: #1abc9c;
        }

        .content{
            padding: 20px;
            flex: 1;
        }
    </style>

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

                <a href="{{ route('student.dashboard') }}"
                    class="{{ request()->is('student/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('student.manual-registration.create') }}"
                    class="{{ request()->is('student/manual-registration.create') ? 'active' : '' }}">
                    Manual Registration
                </a>

                <a href="/student/schedule"
                    class="{{ request()->is('student/schedule') ? 'active' : '' }}">
                    Schedule
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Logout
                    </button>
                </form>
            </div>

            <div class="content">
                @yield('content')
            </div>

        </div>
    </div>

</body>
</html>