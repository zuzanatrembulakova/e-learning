<?php

require_once(__DIR__.'/globals.php');

$teacherid = $_GET['id'];

$db = _db();

// try {
//     $q = $db->prepare('SELECT teachers.teacher_id, teachers.teacher_name, teachers.teacher_surname, topics.topic_name, topics.teacher_id FROM teachers
//     INNER JOIN topics ON teachers.teacher_id = topics.teacher_id 
//     WHERE teachers.teacher_id = :teacher_id AND topics.teacher_id = :teacher_id');
//     $q->bindValue(':teacher_id', $teacherid);
//     $q->execute();
//     $rows = $q->fetchAll();


// } catch(Exception $ex){
//     _response(500, 'System under maintainance', __LINE__);
//     exit(); 
// }

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
    
    // $q2 = $db->prepare('SELECT topics.topic_id, topics.topic_name FROM topics
    // INNER JOIN teachers ON topics.teacher_id = teachers.teacher_id 
    // WHERE topics.teacher_id = :teacher_id');
    // $q2->bindValue(':teacher_id', $teacherid);
    // $q2->execute();

} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit(); 
}

// try {
//     $q3 = $db->prepare('SELECT students.student_name, students.student_surname FROM students
//     INNER JOIN topic_student ON students.student_id = topic_student.student_id
//     INNER JOIN topics ON topic_student.topic_id = topics.topic_id 
//     WHERE topics.topic_id = :topic_id');
//     $q3->bindValue(':topic_id', $topicid);
//     $q3->execute();


// } catch(Exception $ex){
//     _response(500, 'System under maintainance', __LINE__);
//     exit(); 
// }

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
    <div id="list_wrapper">
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
