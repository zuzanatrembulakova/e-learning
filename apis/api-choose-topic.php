<?php
require_once(__DIR__.'/../globals.php');

try {
  $dbForum = _dbForum();

  $insertOneResult = $dbForum->insertOne([
    'username' => 'admin',
    'email' => 'admin@example.com',
    'name' => 'Admin User',
 ]);

} catch(Exception $ex){
  _response(500, 'System under maintainance mongodb', __LINE__);
}

try {
    $db = _db();
} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
 }


 try {

    $timestamp = date('Y-m-d H:i:s');

    $q = $db->prepare('INSERT INTO topic_student VALUES (:topic_student_id, :topic_id, :student_id, :topic_start_date)');
    $q->bindValue(":topic_student_id", null);
    $q->bindValue(":topic_id", $_POST['tag']);
    $q->bindValue(":student_id", $_POST['student_id']);
    $q->bindValue(":topic_start_date", $timestamp);
    $q->execute();

    _response(200, 'Topic selected', __LINE__);
    
  } catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
  }
  

