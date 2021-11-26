<?php

session_start();

require_once(__DIR__.'/globals.php');

$db = _db();

try{
    $q = $db->prepare('SELECT * FROM topics WHERE topic_id IN (SELECT topic_id FROM topic_student WHERE student_id = :student_id)');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $activeTopics = $q->fetchAll();

} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit();
}

try{
    $q = $db->prepare('SELECT * FROM topics');
    $q->execute();
    $newTopics = $q->fetchAll();

} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
    exit();
}

try{
    $q = $db->prepare('SELECT * FROM activities WHERE activity_id IN 
    (SELECT activity_id FROM topic_student_activity WHERE topic_student_id IN 
    (SELECT topic_student_id FROM topic_student WHERE student_id = :student_id))');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $startedActivities = $q->fetchAll();

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

    <h1>You are logged in as <?= $_SESSION['student']['student_name'] ?> <?= $_SESSION['student']['student_surname'] ?></h1>
    <div id="overview_wrapper">
        <div>
            <h2>Active Topics</h2>
            <div>
               <?php foreach($activeTopics as $activeTopic){ ?>
                <p><?= $activeTopic['topic_name'] ?></p>
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

                <?php foreach($startedActivities as $startedActivity){ ?>
                    <form onsubmit="return false" id="form_started_activity">
                        <a href="one-activity.php?id=<?= $startedActivity['activity_id'] ?>"><?= $startedActivity['activity_name'] ?></a>
                        <button onclick='finishActivity()'>Done</button>
                    </form>
                <?php } ?>

            </div>
        </div>

        <div>
            <h2>Finished activities</h2>
        </div>

    </div>

    <script src="script.js"></script>

</body>
</html>