<?php

require_once(__DIR__.'/globals.php');

session_start();

$topicid = $_GET['id'];

$db = _db();

try{

    $q = $db->prepare('SELECT topic_name FROM topics WHERE topic_id = :topic_id');
    $q->bindValue(":topic_id", $topicid);
    $q->execute();

} catch (PDOexception $ex){
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
    <?php
        while($topic = $q->fetch()){
    ?>
    <h1>Discussion on <?= $topic['topic_name'] ?></h1>
    <?php
    }
    ?>
    <?php
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

    <?php
     }
     ?>


            <div id="your_question">
            <h3>What do you want to ask?</h3>
                <form onsubmit="return false">
                    <label>Ask</label>
                    <input type="hidden" name="name" value="<?= $_SESSION['student']['student_name'] ?> <?= $_SESSION['student']['student_surname'] ?>"></input>
                    <input type="hidden" name="topicid" value=<?= $topicid ?>></input>
                    <textarea name="question" placeholder="Enter your question"></textarea>
                    <button onclick="sendQuestion()">Send question</button>
                </form>
            </div>

            


            <script src="script.js"></script>
     

</body>
</html>