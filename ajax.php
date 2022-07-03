<?php
require_once('config.php');

if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];

    $stm=$pdo->prepare("SELECT subjects FROM class WHERE id=?");
    $stm->execute(array($class_id));
    $subject_ids = $stm->fetchAll(PDO::FETCH_ASSOC);
    $subject_ids = $subject_ids[0]['subjects']; 
    $subject_list = json_decode($subject_ids); 

    // $get_subject_list = [];
    // foreach($subject_list as $new_subject){
    //     $get_subject_list[][$new_subject] = getSubjectName($new_subject);
    // }  
    // print_r($get_subject_list);
 
    $get_subject_options = '';
    foreach($subject_list as $new_subject){
        $get_subject_options .= '<option value="'.$new_subject.'">'.getSubjectName($new_subject).'</option>';
         
    }  
    echo $get_subject_options ;
 
}

