<?php

session_start();

require_once(__DIR__.'/globals.php');

$activityID = $_GET['id'];

$db = _db();

try{
    $q = $db->prepare('SELECT * FROM activities WHERE activity_id = :activity_id ');
    $q->bindValue(':activity_id', $activityID);
    $q->execute();
    $row = $q->fetch();

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

    <h1><?= $row['activity_name'] ?></h1>
    
    <script src="script.js"></script>

</body>
</html>