<?php

require_once(__DIR__.'/globals.php');

// $mng = _dbMongoManager();
// $listdatabases = new MongoDB\Driver\Command(["listCollections" => 1]);
// $res = $mng->executeCommand("forum", $listdatabases);
// $collections = current($res->toArray());
// print_r($collections);

// $posts = executeBulkRead($collections.find());
// foreach ($posts as $post) {
//         var_dump($post);
//      };



// $client = new MongoDB\Client("mongodb://localhost:27017");
// echo "Connection to database successfully";

// $mng = _dbMongoManager();
// $forumdb = $mng->forum;
// $discussioncollection = $forumdb->discussion;


// $posts = $discussioncollection->find();
//  foreach ($posts as $post) {
//     var_dump($post);
//  };



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" />
    <title>Forum</title>
</head>
<body>
    <h1>Forum</h1>

            <div>
                <a href="forum-question.php"><h5>Sara Bertova</h5></a>
                <p>Nov 22nd 2021</p>
                <div>
                    Preco musime odovzdat vsetko v jeden den?
                </div>
            </div>

            <div>
                <h5>Sara Bertova</h5>
                <p>Nov 22nd 2021</p>
                <div>
                    Preco musime odovzdat vsetko v jeden den?
                </div>
            </div>

            <div>
                <h5>Sara Bertova</h5>
                <p>Nov 22nd 2021</p>
                <div>
                    Preco musime odovzdat vsetko v jeden den?
                </div>
            </div>

            
            
            <div id="your_question">
            <h2>What do you want to ask?</h2>
                <form onsubmit="return false">
                    <label>Ask</label>
                    <input type="hidden" name="name" value="Sara Bertova"></input>
                    <textarea name="question" placeholder="Enter your question"></textarea>
                    <button onclick="sendQuestion()">Send question</button>
                </form>
            </div>

            <!-- <button onclick="displayInput()" type="button" class="plus_button frog_position plusSign" id="frog_btn">
                    &#43;
            </button> -->


            <script src="script.js"></script>
     

</body>
</html>