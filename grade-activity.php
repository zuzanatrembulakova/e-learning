<?php

session_start();

require_once(__DIR__.'/globals.php');

$activityID = $_GET['activityID'];
$studentID = $_GET['studentID'];
$teacherID = $_GET['teacherID'];

$db = _db();

try{
    $q = $db->prepare('SELECT activities.activity_name, activities.activity_description, students.student_name, 
    students.student_surname, topic_student_activity.topic_student_id FROM activities 
    INNER JOIN topic_student_activity ON activities.activity_id = topic_student_activity.activity_id
    INNER JOIN topic_student ON topic_student_activity.topic_student_id = topic_student.topic_student_id 
    INNER JOIN students ON topic_student.student_id = students.student_id
    WHERE activities.activity_id = :activity_id AND students.student_id = :student_id');
    $q->bindValue(':activity_id', $activityID);
    $q->bindValue(':student_id', $studentID);
    $q->execute();
    $row = $q->fetch();

} catch(Exception $ex){
    _response(500, 'System under maintenance', __LINE__);
    exit();
}

try{
    $q2 = $db->prepare('SELECT * FROM grades');
    $q2->execute();

} catch(Exception $ex){
    _response(500, 'System under maintenance', __LINE__);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Grade activity</title>
</head>
<body>

    <h1>Student: <?= $row['student_name'] ?> <?= $row['student_surname'] ?></h1>
    <h2>Activity: <?= $row['activity_name'] ?></h2>
    <p><?= $row['activity_description'] ?></p>
    
    
<form onsubmit="return false" id="form_grades">
        <input type="hidden" name="topic_studentID" value="<?= $row['topic_student_id'] ?>">
        <input type="hidden" name="activityID" value="<?= $activityID ?>">
        <input type="hidden" name="teacherID" value="<?= $teacherID ?>">
        <select name="grades">
            <?php while ($grade = $q2->fetch()){ ?>
                <option value="<?= $grade['grade_id'] ?>"><?= $grade['grade_name'] ?></option>
            <?php } ?>
        </select>
        <button onclick='gradeActivity()'>Grade</button>
    </form>


    

    <script src="script.js"></script>

</body>
</html>