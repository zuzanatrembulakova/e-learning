<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Student sign in</title>
</head>
<body>


    <div id="sign_in">
        <h1>Sign in</h1>
            <form onsubmit="return false" id="form_sign_in">
                <label>Username or email</label>
                <input type="text" name="username_email" type="text">
                <label>Password</label>
                <input name="password" type="password">
                <button onclick="signin()" id="signup_btn">Sign in</button>
            </form>
    </div>
    
    <script src="script.js"></script>

</body>
</html>

