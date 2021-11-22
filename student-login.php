<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student sign in</title>
</head>
<body>


    <form onsubmit="return false" id="form_sign">

        <h1>Sign in</h1>

        <div>
            <label>Username</label>
            <input name="username" type="text">
        </div>

        <div>
            <label>Password</label>
            <input name="password" type="password">
        </div>

        <button onclick="signin()" id="signup_btn">Sign in</button>
           
    </form>
    
    <script src="script/script.js"></script>

</body>
</html>

