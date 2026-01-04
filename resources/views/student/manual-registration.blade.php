<!DOCTYPE html>
<html lang="en">
<head>
    <h2>Manual Course Registration</h2>
    
</head>
<body>
    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif
    
    <form method = "POST" action="/student/manual-register">
        @csrf

        <label>Subject :</label>
        <textarea name="subject" rows="1" cols="50" required></textarea>

        <br><br>
        <label>Reason for Manual Registration:</label>
        <textarea name="reason" rows="1" cols="50" required></textarea>
        
        <br><br>
        <button type="submit">Submit</button>
    </form> 
</body>
</html>