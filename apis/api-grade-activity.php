<?php
require_once(__DIR__.'/../globals.php');

$db = _db();

try{

    $q = $db->prepare('UPDATE topic_student_activity SET grade_id = :grade_id
    WHERE activity_id = :activity_id AND topic_student_id = :topic_student_id');
    $q->bindValue(":grade_id", $_POST['grades']);
    $q->bindValue(":activity_id", $_POST['activityID']);
    $q->bindValue(":topic_student_id", $_POST['topic_studentID']);
    $q->execute();

    _response(200, 'Success', __LINE__);

} catch(Exception $ex){
  http_response_code(500);
  // echo 'System under maintainance';
  exit();
}


