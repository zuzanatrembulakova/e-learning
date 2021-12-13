<?php

require_once(__DIR__.'/globals.php');

$db = _db();

$topicid = $_GET['id'];

if(isset($_GET['teacherID'])){
    $teacherid = $_GET['teacherID'];

    try{
        $q2 = $db->prepare('SELECT * FROM teachers WHERE teacher_id = :teacher_id');
        $q2->bindValue(":teacher_id", $teacherid);
        $q2->execute();
    
    } catch (PDOexception $ex){
        exit();
    }

} else {
    session_start();
}

try{

    $q = $db->prepare('SELECT topic_name FROM topics WHERE topic_id = :topic_id');
    $q->bindValue(":topic_id", $topicid);
    $q->execute();

} catch (PDOexception $ex){
    exit();
}

try{
    $q3 = $db->prepare('SELECT * FROM topics');
    $q3->execute();
    $allTopics = $q3->fetchAll();

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
    <link rel="stylesheet" href="css/style.css" />
    <title>Discussion</title>
</head>
<body>

<main id="discussion_main">

    <nav>
        <h2>Discussion menu</h2>
        <div>
            <?php foreach($allTopics as $oneTopic){ ?>
                <a href="discussion.php?id=<?= $oneTopic['topic_id'] ?>&teacherID=<?= $teacherid ?>"><?= $oneTopic['topic_name'] ?></a>
            <?php } ?>
        </div>
    </nav>

    <div>
        <?php
            while($topic = $q->fetch()){ ?>
            <h1>Discussion on <?= $topic['topic_name'] ?></h1>
        <?php } 

        $mng = _dbMongoManager();

        $filter = [
            "topic_id" => $topicid
        ];

        $options = [];
        
        $query = new MongoDB\Driver\Query($filter, $options);
        $cursor = $mng->executeQuery('forum.discussion', $query);
        
        $data = iterator_to_array($cursor);
        
        foreach ($data as $value) {
            $document = json_decode(json_encode($value), true);
        ?>
            <div class="post">
                <h3><?= $document['user_name'] ?></h3>
                <p><?= $document['datetime'] ?></p>
                <p><?= $document['question'] ?></p>
            </div>

        <?php } ?>


        <div id="your_question">
        <h3>What do you want to ask?</h3>
            <form onsubmit="return false">
                <?php if(isset($_SESSION)){ ?>
                    <input type="hidden" name="name" value="<?= $_SESSION['student']['student_name'] ?> <?= $_SESSION['student']['student_surname'] ?>">
                <?php } else if(isset($teacherid)){
                    while($teacher = $q2->fetch()){ ?>
                        <input type="hidden" name="name" value="<?= $teacher['teacher_name'] ?> <?= $teacher['teacher_surname'] ?>">
                        <input type="hidden" name="teacherid" value="<?= $teacherid ?>">
                <?php }
                } ?>
                <input type="hidden" name="topicid" value="<?= $topicid ?>">
                <textarea name="question" placeholder="Enter your question"></textarea>
                <button onclick="sendQuestion()">Send</button>
            </form>
        </div>
    </div>
</main>

<script src="script.js"></script> 

</body>
</html>