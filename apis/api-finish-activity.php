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

    $q = $db->prepare('SELECT * FROM activities WHERE activity_id = :activity_id');
    $q->bindValue(':activity_id', $_POST['activity_id']);
    $q->execute();
    $activity = $q->fetch();

    $q = $db->prepare('UPDATE topic_student_activity SET activity_end_date = :activity_end_date 
                       WHERE activity_id = :activity_id AND topic_student_id = :topic_student_id');
    $q->bindValue(':activity_id', $_POST['activity_id']);
    $q->bindValue(':topic_student_id', $_POST['topic_student_id']);
    $q->bindValue(':activity_end_date', $timestamp);
    $q->execute();

    if($activity['next_activity_id']){
      $q = $db->prepare('INSERT INTO topic_student_activity(topic_student_id, activity_id) 
                         VALUES (:topic_student_id, :activity_id)');
      $q->bindValue(":topic_student_id", $_POST['topic_student_id']);
      $q->bindValue(":activity_id", $activity['next_activity_id']);
      $q->execute();
    } else {
      $q = $db->prepare('UPDATE topic_student SET topic_end_date = :topic_end_date 
                       WHERE topic_id = :topic_id AND topic_student_id = :topic_student_id');
      $q->bindValue(':topic_id', $_POST['topic_id']);
      $q->bindValue(':topic_student_id', $_POST['topic_student_id']);
      $q->bindValue(':topic_end_date', $timestamp);
      $q->execute();
    }
    
    $db->commit();

    _response(200, 'Success', __LINE__);
    
  } catch(Exception $ex){
    $db->rollBack();
    _response(500, 'System under maintainance', __LINE__);
  }