<?php
require_once(__DIR__.'/../globals.php');

try{
    $db = _db();
  }catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
  }
  


 try{
    
    if (str_contains($_POST['username_email'], '@')) {
      $q = $db->prepare('SELECT * FROM students WHERE student_email = :student_email');
      $q->bindValue(':student_email', $_POST['username_email']);
    }
    else {
      $q = $db->prepare('SELECT * FROM students WHERE student_username = :student_username');
      $q->bindValue(':student_username', $_POST['username_email']);
    }
    $q->execute();
    $row = $q->fetch();
    if(!$row || $row['student_password']!=$_POST['password']){ _response(400, 'Wrong credentials', __LINE__); }
    
    // Success
    session_start();
    unset($row['password']);
    $_SESSION['student'] = $row;
    _response(200, 'Success login');
  
  
  }catch(Exception $ex){
    _response(500, 'System under maintainance', __LINE__);
  }
  

