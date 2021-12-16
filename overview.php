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
    $q = $db->prepare('SELECT activities.*, topic_student_activity.grade_id, topics.topic_name FROM activities
    INNER JOIN topic_student_activity ON topic_student_activity.activity_id = activities.activity_id
    INNER JOIN topic_student ON topic_student.topic_student_id = topic_student_activity.topic_student_id
    INNER JOIN topics ON topic_student.topic_id = topics.topic_id 
    WHERE topic_student.student_id = :student_id AND topic_student_activity.activity_end_date IS NOT NULL');
    $q->bindValue(':student_id', $_SESSION['student']['student_id']);
    $q->execute();
    $finishedActivities = $q->fetchAll();


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
    <script src="https://kit.fontawesome.com/b08a3acf90.js" crossorigin="anonymous"></script>
    <title>Choose topic</title>
</head>
<body>

<div id="user">
    <h1>You are logged in as <?= $_SESSION['student']['student_name'] ?> <?= $_SESSION['student']['student_surname'] ?></h1>
    <a href="bridge-signout.php">Sign out</a>
</div>

<main class="overview_main">

        <nav class="nav_bar">
            <h2>Discussion menu</h2>
            <div>
                <?php foreach($allTopics as $topic){ ?>
                    <a href="discussion.php?id=<?= $topic['topic_id'] ?>"><?= $topic['topic_name'] ?></a>
                <?php } ?>
            </div>
        </nav>

        <div id="overview_student">

            <div>
                <table>
                    <tr><th>Active Topics<th></tr>
                    <?php foreach($activeTopics as $activeTopic){ ?>
                        <tr>
                            <form id="topic_form">
                                <td>
                                    <p><?= $activeTopic['topic_name'] ?></p>
                                    <input type="hidden" name="active_topic_id" value="<?= $activeTopic['topic_id'] ?>">
                                </td>
                                <td><button onclick='removeTopic()'>Sign out of topic</button></td>
                            </form>
                        </tr>
                        <?php } ?>
                </table>

                <div id="new_topic">
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

            <div id="right">
                <aside>
                    <div class="aside_title" onclick="foldAside('#started_activities', '#arrow1')">
                        <h2>Started activities</h2>
                        <i id="arrow1" class="fas fa-angle-down"></i>
                    </div>

                    <section id="started_activities">
                        <?php foreach($rows as $row){ ?>
                            
                            <form onsubmit="return false" id="form_started_activity">
                                <input type="hidden" name="activity_id" value="<?= $row['activity_id'] ?>">
                                <input type="hidden" name="topic_student_id" value="<?= $row['topic_student_id'] ?>">
                                <input type="hidden" name="topic_id" value="<?= $row['topic_id'] ?>">
                                <div>
                                    <p><?= $row['topic_name'] ?></p>
                                    <a href="one-activity.php?id=<?= $row['activity_id'] ?>"><?= $row['activity_name'] ?></a>
                                </div>
                                <button onclick='finishActivity()'>Done</button>
                            </form>
                            
                        <?php } ?>
                    </section>
                </aside>
            
                <aside>
                    <div class="aside_title" onclick="foldAside('#finished_activities', '#arrow2')">
                        <h2>Finished activities</h2>
                        <i id="arrow2" class="fas fa-angle-down"></i>
                    </div>

                    <section id="finished_activities">
                        <?php foreach($finishedActivities as $finishedActivity){ ?>

                           <div>
                                <form onsubmit="return false" id="form_started_activity">
                                    <p><?= $finishedActivity['topic_name'] ?></p>
                                    <a href="one-activity.php?id=<?= $finishedActivity['activity_id'] ?>"><?= $finishedActivity['activity_name'] ?></a>
                                </form>
                            
                                <p><?php 
                                
                                if($finishedActivity['activity_is_graded'] == 1){ 
                                    if($finishedActivity['grade_id']){
                                        try {
                                            $q = $db->prepare('SELECT grade_id, grade_name FROM grades
                                            WHERE grade_id = :grade_id');
                                            $q->bindValue(':grade_id', $finishedActivity['grade_id']);
                                            $q->execute();
                                            $activtyGrade = $q->fetch();
                                        
                                            echo $activtyGrade['grade_name'];
                                        } catch(Exception $ex){
                                            _response(500, 'System under maintainance', __LINE__);
                                            exit(); 
                                        }
                                    } else { ?>
                                        Grade is pending
                                <?php }

                                } else { ?> Not graded <?php } ?></p>
                             </div>
                                
                        <?php } ?>

                    </section>
                </aside>
            </div>   
        </div>
</main>

<script src="script.js"></script>
<script src="script-overview.js"></script>

</body>
</html>