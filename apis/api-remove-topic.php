<?php 
require_once(__DIR__.'/../globals.php');

try {
    $db = _db();
} catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
 }


 try {

    $db->beginTransaction();

    $timestamp = date('Y-m-d H:i:s');

    $q = $db->prepare('SELECT * FROM topic_student WHERE topic_id = :topic_id');
    $q->bindValue('topic_id', $_POST['active_topic_id']);
    $q->execute();
    $topicStudent = $q->fetch();

    $q = $db->prepare('DELETE FROM topic_student_activity WHERE topic_student_id = :topic_student_id');
    $q->bindValue(':topic_student_id', $topicStudent['topic_student_id']);
    $q->execute();

    $q = $db->prepare('DELETE FROM topic_student WHERE topic_student_id = :topic_student_id');
    $q->bindValue(':topic_student_id', $topicStudent['topic_student_id']);
    $q->execute();
    $activity = $q->fetch();
    
    $db->commit();

    _response(200, 'Success', __LINE__);
    
} catch(Exception $ex){
  $db->rollBack();
  _response(500, 'System under maintainance', __LINE__);
}