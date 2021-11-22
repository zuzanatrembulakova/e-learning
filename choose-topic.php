<?php

session_start();

require_once(__DIR__.'/globals.php');

try{
    $db = _db();

    $q = $db->prepare('SELECT * FROM topics');
    $q->execute();

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
    <title>Choose topic</title>
</head>
<body>

    <form onsubmit="return false" id="form_topic">

            <div>
                <label>Choose 1 topic to start learning</label>
                <select name="tag">
                    <?php while($row = $q->fetch()){ ?>
                        <option value="<?= $row['topic_id'] ?>"><?= $row['topic_name'] ?></option>
                        <?php } ?>
                </select>
            </div>

            <div>
                <input type="hidden" name="student_id" value="<?= $_SESSION['student']['student_id']; ?>">
            </div>

            <button id="done_btn" onclick='chooseTopic()'>Next</button> 
    </form>

    <script src="script.js"></script>
    <script>
        var dt = new Date();
        document.getElementById('date_time').innerHTML=dt;
    </script>

</body>
</html>