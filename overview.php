<?php

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

    <div>
        <div>
            <h2>Topic</h2>
            <div>
                <?php while(){ ?>
            </div>
        </div>

        <div>
            <h2>Started activities</h2>
        </div>

        <div>
            <h2>Finished activities</h2>
        </div>

        <div>
            <h2>Activities not started</h2>
        </div>
    </div>

</body>
</html>