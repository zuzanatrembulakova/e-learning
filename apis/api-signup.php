<?php
require_once(__DIR__.'/../globals.php');
// Validate name
if( ! isset( $_POST['name'] ) ){ _response(400,'Name is required'); }
if( strlen( $_POST['name'] ) < 2 ){ _response(400,'Name min 2 characters'); }
if( strlen( $_POST['name'] ) > 25 ){ _response(400,'Name max 25 characters'); }

// Validate last_name
if( ! isset( $_POST['surname'] ) ){ _response(400,'Surname is required'); }
if( strlen( $_POST['surname'] ) < 2 ){ _response(400,'Surname min 2 characters'); }
if( strlen( $_POST['surname'] ) > 40 ){ _response(400,'Surname max 40 characters'); }

// Validate username
if( ! isset( $_POST['username'] ) ){ _response(400,'Username is required'); }
if( strlen( $_POST['username'] ) < 2 ){ _response(400,'Username min 2 characters'); }
if( strlen( $_POST['username'] ) > 25 ){ _response(400,'Username max 25 characters'); }

// Validate email
if( ! isset( $_POST['email'] ) ){ _response(400,'Email is required'); }
if( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ){ _response(400,'Email is invalid'); }

// Validate the password
if( ! isset($_POST['password']) ){ _response(400,'Password required'); }
if(strlen($_POST['password']) < _PASSWORD_MIN_LEN){ _response(400,'Password min '._PASSWORD_MIN_LEN.' characters'); }
if(strlen($_POST['password']) > _PASSWORD_MAX_LEN){ _response(400,'Password max '._PASSWORD_MAX_LEN.' characters'); }

// Validate the match of the repeated password
if( ! isset($_POST['repeat_password']) ){ _response(400,'Password must be repeated'); }
if( $_POST['repeat_password'] != $_POST['password']){ _response(400,'Passwords do not match'); }

// Connect to DB
// include / require
$db = _db();

try{
  $q = $db->prepare("SELECT student_email FROM students WHERE student_email = :student_email");
  $q->bindValue(":student_email", $_POST['email']);
  $q->execute();
  $row = $q->fetch();
  if ($row) {
    _response(400,'User already exists'); 
  }

} catch(Exception $ex){
  http_response_code(500);
  // echo 'System under maintainance';
  exit();
}

try{
  // Insert data in the DB
  $q = $db->prepare('INSERT INTO students VALUES(:student_id, :student_name, :student_surname, :student_username, :student_password, :student_email)');
  $q->bindValue(":student_id", null); 
  $q->bindValue(":student_name", $_POST['name']);
  $q->bindValue(":student_surname", $_POST['surname']);
  $q->bindValue(":student_username", $_POST['username']);
  $q->bindValue(":student_password", $_POST['password']);
  $q->bindValue(":student_email", $_POST['email']);
  $q->execute();
  $user_id = $db->lastInsertId();
  // SUCCESS

  $user = array('student_id' => $user_id, 'student_name' => $_POST['name'], 'student_surname' => $_POST['surname'], 'student_username' => $_POST['username'], 'student_email' => $_POST['email']);
  session_start();
  $_SESSION['student'] = $user;

  _response(200,'Success');

}catch(Exception $ex){
  http_response_code(500);
  // echo 'System under maintainance';
  exit();
}



