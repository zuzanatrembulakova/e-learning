<?php
require_once(__DIR__.'/../globals.php');

// try{
//     $db = _db();
//   }catch(Exception $ex){
//     _response(500, 'System under maintainance', __LINE__);
//   }
  


  try {

    $timestamp = date('Y-m-d H:i:s');
     // $mongo = new MongoClient();
    // $db = $mongo->QA;
    // $collection = $db->post;

    // if ($_POST) {
    //     $insert = array (
    //         'user_name' => $_POST['name'],
    //         'question' => $_POST['question']
    //     );

    //     if ($collection->insert($insert)) {
    //         echo ('success');

    //     }else {
    //         echo ('fail');
    //     }

    // } else {
    //     echo ('no data to store');
    // }




    $mng = _dbMongoManager();
  
    $bulk = new MongoDB\Driver\BulkWrite;

    $doc = array (
                'topic_id' => $_POST['topicid'],
                'user_name' => $_POST['name'],
                'datetime' => $timestamp,
                'question' => $_POST['question'],
            );
  
    $bulk->insert($doc);
  
    $result = $mng->executeBulkWrite('forum.discussion', $bulk);

    _response(200, 'Success', __LINE__);

    // $mng = _dbMongoManager();
    // $forumdb = $mng->forum;
    // $discussioncollection = $forumdb->discussion;

    // $doc = array (
    //               'user_name' => $_POST['name'],
    //               'time' => $timestamp,
    //               'question' => $_POST['question'],
    //           );
    
    // $discussioncollection->insert($doc);

  
  } catch (MongoDB\Driver\Exception\Exception $e) {
  
    _response(500, 'System under maintainance: mongodb failes:' . $e->getMessage(), __LINE__);
  }
  
 
  

