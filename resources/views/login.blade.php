<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body {
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;

            background: linear-gradient(90deg,
            #1e3c4f,
            #1f6f6b,
            #2aa18b
    );
        }

        .login-box {
            width: 500px;
            margin: 80px auto;
            background: #eee2e2;
            padding: 30px;
            border-radius: 6px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            display: block;       
            margin: 0 auto;       
            width: 100%;  
            max-width: 450px   
            height: auto;  
        }

        label {
            font-weight: bold;
            
        }

        input {
            width: 100%;
            padding: 10px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #a8d08d;
            border: none;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="login-box">
        <div class="logo">
            <img src="{{ asset('logo2.png') }}" alt="Logo">
            <p style="text-align:center; font-weight:bold; margin-top:10px;">Welcome to IIUM Course Registration.</p>
        <form action="/login" method="POST">
            @csrf
            <label for="username" style="display:block; text-align:left;">Username:</label>
            <input type="username" name="username" id="username" placeholder="Enter your username" required>

            <label for="password" style="display:block; text-align:left;">Password:</label>
            <input type="password" name="password" id="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>

            <p style="text-align:centre; margin-top:10px;">
            <a href="/forgot-password" style="text-decoration:underline; color:#0f3c4c;">Forgot password?</a>
        </form>
    </div>

</body>
</html>
