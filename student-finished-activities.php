<?php

require_once(__DIR__.'/globals.php');

$studentid = $_GET['studentid'];
$topicid = $_GET['topicid'];

$db = _db();


try {
        $q = $db->prepare('SELECT students.student_name, students.student_surname FROM students WHERE students.student_id = :student_id');
        $q->bindValue(':student_id', $studentid);
        $q->execute();
        $row = $q->fetch();
        // $students = $q->fetchAll();
    
    
    } catch(Exception $ex){
        _response(500, 'System under maintainance', __LINE__);
        exit(); 
    }

try {
        $q2 = $db->prepare('SELECT students.student_name, students.student_surname, activities.activity_name, topic_student_activity.activity_end_date FROM topic_student_activity
        INNER JOIN activities ON topic_student_activity.activity_id = activities.activity_id
        INNER JOIN topic_student ON activities.topic_id = topic_student.topic_id 
        INNER JOIN students ON topic_student.student_id = students.student_id 
        WHERE topic_student_activity.activity_end_date IS NOT NULL AND topic_student.topic_id = :topic_id AND students.student_id = :student_id');
        $q2->bindValue(':topic_id', $topicid);
        $q2->bindValue(':student_id', $studentid);
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
    <title>Student's finished activities</title>
</head>
<body>

    
    <h1>These are the finished activities for <?= $row['student_name'] ?> <?= $row['student_surname'] ?></h1>
    <div id="overview_wrapper">
        <div>
        <?php
        while($activity = $q2->fetch()){
        ?>
            <a href=""><?= $activity['activity_name'] ?></a>
        <?php
        }
        ?>
        </div>
    </div>


    <script src="script.js"></script>

</body>
</html>
