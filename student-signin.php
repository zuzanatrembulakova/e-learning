<?php

require_once(__DIR__.'/globals.php');

$db = _db();

try {
    $q = $db->prepare('SELECT * FROM teachers');
    $q->execute();
    $teachers = $q->fetchAll();


} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit(); 
}

?> 

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

    <main>
        <div id="teacher_list">
            <h1>Preview as teacher</h1>
            <div>
                <?php foreach($teachers as $teacher){ ?>
                    <div>
                    <a href="teacher-topics.php?id=<?= $teacher['teacher_id'] ?>"><?= $teacher['teacher_name'] ?> <?= $teacher['teacher_surname'] ?></a>
                <?php 
                    try {
                        $q = $db->prepare('CALL sp_getTopics(:teacher_id)');
                        $q->bindValue(':teacher_id', $teacher['teacher_id']);
                        $q->execute();
                    
                    } catch(Exception $ex){
                        _response(500, 'System under maintainance', __LINE__);
                        exit(); 
                    } ?>

                    <div>
                <?php while($topic = $q->fetch()){ ?>
                        <p><?= $topic['topic_name'] ?></p>
                <?php  } ?>
                    </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div id="sign_in">
            <h1>Or continue as a student</h1>
            <form onsubmit="return false" id="form_sign_in">
                <label>Username or email</label>
                <input type="text" name="username_email" type="text">
                <label>Password</label>
                <input name="password" type="password">
                <div>
                    <a href="student-signup.php">Create account</a>
                    <button onclick="signin()" id="signup_btn">Sign in</button>
                </div>
            </form>
        </div>
    </main>
    
    <script src="script.js"></script>

</body>
</html>

