<?php

session_start();

require_once(__DIR__.'/globals.php');

$db = _db();

try {
    $q = $db->prepare('SELECT topic_student_activity.activity_id, topics.topic_name, 
    activities.activity_name, topics.topic_id, topic_student_activity.topic_student_id FROM topic_student_activity 
    INNER JOIN topic_student ON topic_student_activity.topic_student_id = topic_student.topic_student_id 
    INNER JOIN topics ON topic_student.topic_id = topics.topic_id 
    INNER JOIN activities ON topic_student_activity.activity_id = activities.activity_id 
    WHERE activity_end_date IS NULL AND topic_student.student_id = :student_id');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $rows = $q->fetchAll();


} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit(); 
}

try {
    $q = $db->prepare('SELECT activities.*, topic_student_activity.grade_id FROM activities
    INNER JOIN topic_student_activity ON topic_student_activity.activity_id = activities.activity_id
    INNER JOIN topic_student ON topic_student.topic_student_id = topic_student_activity.topic_student_id
    WHERE topic_student.student_id = :student_id AND topic_student_activity.activity_end_date IS NOT NULL');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $finishedActivities = $q->fetchAll();


} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit(); 
}

try {
    $q = $db->prepare('SELECT grades.grade_id, grades.grade_name FROM grades
    INNER JOIN topic_student_activity ON topic_student_activity.grade_id = grades.grade_id
    INNER JOIN topic_student ON topic_student_activity.topic_student_id = topic_student.topic_student_id
    WHERE topic_student.student_id = :student_id');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $activtyGrades = $q->fetchAll();


} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit(); 
}

try{
    $q = $db->prepare('SELECT topics.topic_name, topics.topic_id FROM topics 
    INNER JOIN topic_student ON topics.topic_id = topic_student.topic_id 
    WHERE topic_student.student_id = :student_id');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $activeTopics = $q->fetchAll();

} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit();
}

try{
    $q = $db->prepare('SELECT * FROM topics WHERE topic_id 
    NOT IN (SELECT topic_id FROM topic_student WHERE student_id = :student_id);');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $newTopics = $q->fetchAll();

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
    <title>Choose topic</title>
</head>
<body>

    <nav>
        <h2>Discussion</h2>
        <div>
            <?php foreach($allTopics as $topic){ ?>
                <a href="discussion.php?id=<?= $topic['topic_id'] ?>"><?= $topic['topic_name'] ?></a>
            <?php } ?>
        </div>
    </nav>

    <div id="user">
        <h1>You are logged in as <?= $_SESSION['student']['student_name'] ?> <?= $_SESSION['student']['student_surname'] ?></h1>
        <a href="bridge-signout.php">Sign out</a>
    </div>

    <div id="overview_wrapper">
        <div>
            <h2>Active Topics</h2>
            <div>
               <?php foreach($activeTopics as $activeTopic){ ?>
                    <form id="topic_form">
                        <p><?= $activeTopic['topic_name'] ?></p>
                        <input type="hidden" name="active_topic_id" value="<?= $activeTopic['topic_id'] ?>">
                        <button onclick='removeTopic()'>Sign out of topic</button>
                    </form>
                <?php } ?>
            </div>
            <div>
                <h3>Start new topic</h3>
                <form onsubmit="return false" id="form_topic">
                    <select name="tag">
                        <?php foreach($newTopics as $newTopic){ ?>
                            <option value="<?= $newTopic['topic_id'] ?>"><?= $newTopic['topic_name'] ?></option>
                        <?php } ?>
                    </select>
                    <input type="hidden" name="student_id" value="<?= $_SESSION['student']['student_id']; ?>">
                    <button onclick='chooseTopic()'>start</button>
                </form>
            </div>
        </div>

        <div>
            <h2>Started activities</h2>
            <div id="started_activities">

                <?php foreach($rows as $row){ ?>
                    <form onsubmit="return false" id="form_started_activity">
                        <input type="hidden" name="activity_id" value="<?= $row['activity_id'] ?>">
                        <input type="hidden" name="topic_student_id" value="<?= $row['topic_student_id'] ?>">
                        <input type="hidden" name="topic_id" value="<?= $row['topic_id'] ?>">
                        <a href="one-activity.php?id=<?= $row['activity_id'] ?>"><?= $row['activity_name'] ?></a>
                        <button onclick='finishActivity()'>Done</button>
                    </form>
                <?php } ?>

            </div>
        </div>

        <div>
            <h2>Finished activities</h2>
            <div id="started_activities">

                <?php foreach($finishedActivities as $finishedActivity){ ?>
                    <form onsubmit="return false" id="form_started_activity">
                        <a href="one-activity.php?id=<?= $finishedActivity['activity_id'] ?>"><?= $finishedActivity['activity_name'] ?></a>
                        <p><?php 
                        
                        if($finishedActivity['activity_is_graded'] == 1){ 
                            if($finishedActivity['grade_id']){
                                foreach($activtyGrades as $activtyGrade){
                                    echo $activtyGrade['grade_name'];
                                }
                            } else { ?>
                                Grade is pending
                           <?php }

                        } else { ?> Not graded <?php } ?></p>
                    </form>
                <?php } ?>

            </div>
        </div>

    </div>

    <script src="script.js"></script>

</body>
</html>