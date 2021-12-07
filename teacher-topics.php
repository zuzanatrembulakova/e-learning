<?php

require_once(__DIR__.'/globals.php');

$teacherid = $_GET['id'];

$db = _db();

try {
    $q = $db->prepare('SELECT teachers.teacher_name, teachers.teacher_surname FROM teachers
    INNER JOIN topics ON teachers.teacher_id = topics.teacher_id 
    WHERE teachers.teacher_id = :teacher_id');
    $q->bindValue(':teacher_id', $teacherid);
    $q->execute();
    $row = $q->fetch();


} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit(); 
}

try {
    $q2 = $db->prepare('CALL sp_getTopics(:teacher_id)');
    $q2->bindValue(':teacher_id', $teacherid);
    $q2->execute();

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
    <title>Your topics</title>
</head>
<body>

    
    <h1>You are logged in as <?= $row['teacher_name'] ?> <?= $row['teacher_surname'] ?></h1>
    <div id="topics_wrapper">
        <div>
        <?php
        while($topic = $q2->fetch()){
        ?>
            <a href="topic-student-list.php?id=<?= $topic['topic_id'] ?>"><?= $topic['topic_name'] ?></a>
        <?php
        }
        ?>
        </div>
    </div>

<script src="script.js"></script>

</body>
</html>
