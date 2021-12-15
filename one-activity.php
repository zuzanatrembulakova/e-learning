<?php

session_start();

require_once(__DIR__.'/globals.php');

$activityID = $_GET['id'];

$db = _db();

try{
    $q = $db->prepare('SELECT activity_name, activity_description FROM activities WHERE activity_id = :activity_id');
    $q->bindValue(':activity_id', $activityID);
    $q->execute();
    $row = $q->fetch();

} catch(Exception $ex){
    _response(500, 'System under maintenance', __LINE__);
    exit();
}

try{
    $q2 = $db->prepare('SELECT resource_link, resource_description FROM resources WHERE activity_id = :activity_id');
    $q2->bindValue(':activity_id', $activityID);
    $q2->execute();

} catch(Exception $ex){
    _response(500, 'System under maintenance', __LINE__);
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
    <title>Activity</title>
</head>
<body id="one">

    <h1><?= $row['activity_name'] ?></h1>
    <p><?= $row['activity_description'] ?></p>
    
    <h2>Resources</h2>

    <?php
        while($resource = $q2->fetch()){
    ?>
    <p><?= $resource['resource_description'] ?></p>
    <a id="resource_link" href="<?= $resource['resource_link'] ?>"><?= $resource['resource_link'] ?></a>
    <?php
        }
    ?>
    

    <script src="script.js"></script>

</body>
</html>