<?php 
$host = "localhost";
$db_name = "psms";
$user = "root";
$password = "";

date_default_timezone_set("Asia/Dhaka");
try{
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
}
catch(PDOException $m){
    echo "Connection failed: " . $m->getMessage();
}



// Count any Column Value from Students Table
// function stRowCount($col,$val){
//     global $pdo;
//     $stm=$pdo->prepare("SELECT $col FROM students WHERE $col=?");
//     $stm->execute(array($val));
//     $count = $stm->rowCount();
//     return $count;
// }
 
function getCount($tbl,$col,$val){
    global $pdo;
    $stm=$pdo->prepare("SELECT $col FROM $tbl WHERE $col=?");
    $stm->execute(array($val));
    $count = $stm->rowCount();
    return $count;
}

function getSubjectName($id){
    global $pdo;
    $stm=$pdo->prepare("SELECT name,code FROM subjects WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['name']."-".$result[0]['code'];
}

function getSubjectTeacher($id){
    global $pdo;
    $stm=$pdo->prepare("SELECT teacher_id FROM assign_teachers WHERE subject_id=?");
    $stm->execute(array($id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['teacher_id'];
}
// Get Teacher Name From Subject ID
function getSubjectTeacherName($id){
    global $pdo;
    $stm=$pdo->prepare("SELECT teacher_id FROM assign_teachers WHERE subject_id=?");
    $stm->execute(array($id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    $teacher_id =  $result[0]['teacher_id'];

    $stm=$pdo->prepare("SELECT name FROM teachers WHERE id=?");
    $stm->execute(array($teacher_id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return  $result[0]['name'];
}

function getClassName($id,$col){
    global $pdo;
    $stm=$pdo->prepare("SELECT $col FROM class WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result[0][$col];
}

// Get Teacher Info
function getTeacherInfo($id,$col){
    global $pdo;
    $stm=$pdo->prepare("SELECT $col FROM teachers WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result[0][$col];
}

// Get Exam Name form Exam ID
function getExamName($id){
    if($id == 1){
        return "First Term Exam";
    }
    else if($id == 2){
        return "Second Term Exam"; 
    }
    else if($id == 3){
        return "Final Term Exam"; 
    }
}


//  GET Student Data
function Student($id,$col){
    global $pdo;
    $stm=$pdo->prepare("SELECT $col FROM students WHERE id=?");
    $stm->execute(array($id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    return $result[0][$col];
}

// Require Function File
require_once('functions.php');