<?php

require_once(__DIR__.'/globals.php');

$topicid = $_GET['id'];

$db = _db();

// try {
//     $q = $db->prepare('SELECT students.student_name, students.student_surname, topics.topic_name FROM students
//     INNER JOIN topic_student ON students.student_id = topic_student.student_id
//     INNER JOIN topics ON topic_student.topic_id = topics.topic_id 
//     WHERE topics.topic_id = :topic_id');
//     $q->bindValue(':topic_id', $topicid);
//     $q->execute();
//     $row = $q->fetch();
//     // $students = $q->fetchAll();


// } catch(Exception $ex){
//     _response(500, 'System under maintainance', __LINE__);
//     exit(); 
// }


try {
        $q = $db->prepare('SELECT topics.topic_name FROM topics WHERE topics.topic_id = :topic_id');
        $q->bindValue(':topic_id', $topicid);
        $q->execute();
        $row = $q->fetch();
        // $students = $q->fetchAll();
    
    
    } catch(Exception $ex){
        _response(500, 'System under maintainance', __LINE__);
        exit(); 
    }

try {
        $q2 = $db->prepare('SELECT students.student_id, students.student_name, students.student_surname FROM students
        INNER JOIN topic_student ON students.student_id = topic_student.student_id
        INNER JOIN topics ON topic_student.topic_id = topics.topic_id 
        WHERE topics.topic_id = :topic_id');
        $q2->bindValue(':topic_id', $topicid);
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
    <title>Topic student list</title>
</head>
<body>

    
    <h1>This is the student list for <?= $row['topic_name'] ?></h1>
    <div id="overview_wrapper">
        <div>
        <?php
        while($student = $q2->fetch()){
        ?>
            <a href="student-finished-activities.php?studentid=<?= $student['student_id'] ?>&topicid=<?= $topicid ?>"><?= $student['student_name'] ?> <?= $student['student_surname'] ?></a>
        <?php
        }
        ?>
        </div>
    </div>


    <script src="script.js"></script>

</body>
</html>
