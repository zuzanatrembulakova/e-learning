<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Create account</title>
</head>
<body>
    
    <div id="sign_up">
        <h1>Create account for student</h1>
        <form id="form_sign_up" onsubmit="return false">
            <label>First name</label>
            <input type="text" name="name"></input>
            <label>Last name</label>
            <input type="text" name="surname"></input>
            <label>Username</label>
            <input type="text" name="username"></input>
            <label>Email</label>
            <input type="email" name="email"></input>
            <label>Password</label>
            <input type="password" name="password" placeholder="At least 6 characters"></input>
            <label>Re-enter password</label>
            <input type="password" name="repeat_password"></input>
            <button id="signup_btn" onclick="signup()">Sign up</button>
        </form>
    </div>

<script src="script.js"></script>

</body>
</html>

