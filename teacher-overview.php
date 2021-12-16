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

try{
    $q = $db->prepare('SELECT * FROM topics');
    $q->execute();
    $allTopics = $q->fetchAll();

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

<div id="user">
    <h1>You are logged in as <?= $row['teacher_name'] ?> <?= $row['teacher_surname'] ?></h1>
    <a href="bridge-signout.php">Sign out</a>
</div>

<main class="overview_main">
        
        <nav class="nav_bar">
            <h2>Discussion menu</h2>
            <div>
                <?php foreach($allTopics as $topic){ ?>
                    <a href="discussion.php?id=<?= $topic['topic_id'] ?>&teacherID=<?= $teacherid ?>"><?= $topic['topic_name'] ?></a>
                <?php } ?>
            </div>
        </nav>

        <div class="overview_wrapper">
            <h2>Overview</h2>
            <table id="overview_teacher">
                <tr>
                    <th>Topic</th>
                    <th>Student list for the topic</th>
                </tr>
                <?php while($topic = $q2->fetch()){ ?>
                    <tr class='one_topic'>
                        <td class="topic_name"><?= $topic['topic_name'] ?></td>
                        <td id="student_wrapper">
                            <?php
                                try {

                                    $q = $db->prepare('SELECT students.student_id, students.student_name, students.student_surname FROM students
                                    INNER JOIN topic_student ON students.student_id = topic_student.student_id
                                    INNER JOIN topics ON topic_student.topic_id = topics.topic_id 
                                    WHERE topics.topic_id = :topic_id
                                    ORDER BY students.student_surname ASC');
                                    $q->bindValue(':topic_id', $topic['topic_id']);
                                    $q->execute();
                                    $students = $q->fetchAll();
                                
                                } catch(Exception $ex){
                                        _response(500, 'System under maintainance', __LINE__);
                                        exit(); 
                                }

                                foreach($students as $student){?>
                                <div>
                                    <a href="student-finished-activities.php?studentid=<?= $student['student_id'] ?>&topicid=<?= $topic['topic_id'] ?>&teacherid=<?= $teacherid ?>"><?= $student['student_name'] ?> <?= $student['student_surname'] ?></a>
                                    <?php 
                                    
                                        try {

                                            $q = $db->prepare('SELECT topic_student.student_id, count(*) FROM topic_student
                                            WHERE topic_student.student_id = :student_id
                                            GROUP BY topic_student.student_id;');
                                            $q->bindValue(':student_id', $student['student_id']);
                                            $q->execute();

                                        } catch(Exception $ex){
                                            _response(500, 'System under maintainance', __LINE__);
                                            exit(); 
                                        }
                                    
                                        while($topicCount = $q->fetch()){ ?>
                                        <p>(Number of active topics: <?= $topicCount['count(*)'] ?>)</p>
                                        <?php } ?>
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
</main>

<script src="script.js"></script>
<script src="script-overview.js"></script>

</body>
</html>
