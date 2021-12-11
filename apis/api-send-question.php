<?php
require_once(__DIR__.'/../globals.php');

try {

  $timestamp = date('Y-m-d H:i:s');

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


} catch (MongoDB\Driver\Exception\Exception $e) {

  _response(500, 'System under maintainance: mongodb failes:' . $e->getMessage(), __LINE__);
}

 
  

