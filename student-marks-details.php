<?php require_once('header.php');
$class_id = $_GET['class'];

// Get Class Count
$submit_count = getCount('students_results','class_id',$class_id);
$st_count = getCount('students','current_class',$class_id);
 


$stm = $pdo->prepare("SELECT exam_marks_1.class_id,exam_marks_1.subject_id,exam_marks_1.exam_id,exam_marks_1.st_marks,exam_marks_1.st_id,students.name as st_name,subjects.name as subject_name,subjects.code as subject_code FROM exam_marks_1 
INNER JOIN students ON exam_marks_1.st_id=students.id
INNER JOIN subjects ON exam_marks_1.subject_id=subjects.id
WHERE exam_marks_1.class_id=?");

$stm->execute(array($class_id));
$getMarks = $stm->fetchAll(PDO::FETCH_ASSOC);
$getMarksCount = $stm->rowCount();
 
$st_list = [];
foreach($getMarks as $marksByStudent){
    $st_list[$marksByStudent['st_id']][] = $marksByStudent;
}
 
// For Exam 2
$stm2 = $pdo->prepare("SELECT exam_marks_2.class_id,exam_marks_2.subject_id,exam_marks_2.exam_id,exam_marks_2.st_marks,exam_marks_2.st_id,students.name as st_name,subjects.name as subject_name,subjects.code as subject_code FROM exam_marks_2 
INNER JOIN students ON exam_marks_2.st_id=students.id
INNER JOIN subjects ON exam_marks_2.subject_id=subjects.id
WHERE exam_marks_2.class_id=?");

$stm2->execute(array($class_id));
$getMarks2 = $stm2->fetchAll(PDO::FETCH_ASSOC);
$getMarks2Count = $stm2->rowCount();
 
$st_list2 = [];
foreach($getMarks2 as $marksByStudent2){
    $st_list2[$marksByStudent2['st_id']][] = $marksByStudent2;
}
 
// For Exam 3
$stm3 = $pdo->prepare("SELECT exam_marks_3.class_id,exam_marks_3.subject_id,exam_marks_3.exam_id,exam_marks_3.st_marks,exam_marks_3.st_id,students.name as st_name,subjects.name as subject_name,subjects.code as subject_code FROM exam_marks_3 
INNER JOIN students ON exam_marks_3.st_id=students.id
INNER JOIN subjects ON exam_marks_3.subject_id=subjects.id
WHERE exam_marks_3.class_id=?");

$stm3->execute(array($class_id));
$getMarks3 = $stm3->fetchAll(PDO::FETCH_ASSOC);
$getMarks3Count = $stm3->rowCount();
 
$st_list3 = [];
foreach($getMarks3 as $marksByStudent3){
    $st_list3[$marksByStudent3['st_id']][] = $marksByStudent3;
}
 
 
?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    Student Marks Summary
  </h3> 
</div>
<div class="row">
 
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body"> 
       
            Class Name:  <?php echo getClassName($_GET['class'],'class_name') ;?>
            <br>
            <br>
      

            <table class="table table-bordered">
                <tr>
                    <th>#</th>
                    <th>Student Name</th>
                    <th>1st Exam Marks</th>
                    <th>2nd Exam Marks</th>
                    <th>Final Exam Marks</th> 
                </tr>
                <?php  
                $bb=0;
                $student_data = []; 
                foreach($st_list as $key => $newList) : ?>
                <tr>
                    <td>1</td>
                    <td><?php echo $newList[0]['st_name']; ?></td>
                    <td>
                        <?php 
                        if($getMarks3Count == $getMarksCount): 
                            $total=0;
                            foreach($newList as $st_subject) : ?> 
                            <?php echo $st_subject['subject_name']."-".$st_subject['subject_code']." = ".$st_subject['st_marks']."<br>";

                            $total=$total+$st_subject['st_marks'];
                            ?>  
                            <?php endforeach; ?> 
                            <br>
                        <?php echo "Total Marks: ".$total; ?>
                        <?php else : ?>
                            <span class="alert alert-danger">All Subject mark not submitted.</span>
                        <?php endif; ?>
                    </td>
                    <td>
                    <?php 
                        if($getMarks3Count == $getMarks2Count): 
                            $total2=0;
                            foreach($st_list2[$key] as $st_subject2) : ?> 
                            <?php echo $st_subject2['subject_name']."-".$st_subject2['subject_code']." = ".$st_subject2['st_marks']."<br>";

                            $total2=$total2+$st_subject2['st_marks'];
                            ?>  
                            <?php endforeach; ?> 
                            <br>
                            <?php echo "Total Marks: ".$total2; ?>
                        <?php else : ?>
                            <span class="alert alert-danger">All Subject mark not submitted.</span>
                        <?php endif; ?>
                    </td>
                    <td>
                    <?php 
                        $ii=0;
                        $total3=0;
                        foreach($st_list3[$key] as $st_subject3) : ?> 
                        <?php echo $st_subject3['subject_name']."-".$st_subject3['subject_code']." = ".$st_subject3['st_marks']."<br>";

                                
                        $student_data[$bb]['subjects'][$ii]['subject_id'] = $st_subject3['subject_id'];
                        $student_data[$bb]['subjects'][$ii]['subject_name'] = $st_subject3['subject_name'];
                        $student_data[$bb]['subjects'][$ii]['subject_marks'] = $st_subject3['st_marks'];
    
                        $total3=$total3+$st_subject3['st_marks'];
                        ?>  
                        <?php $ii++; endforeach; ?> 
                        <br>
                        <?php echo "Total Marks: ".$total3; ?>
                    </td>
                </tr>

                <?php  
                      $student_data[$bb]['st_id'] = $newList[0]['st_id'];
                      $student_data[$bb]['st_name'] = $newList[0]['st_name'];
                      $student_data[$bb]['class_id'] = $newList[0]['class_id'];
                      $student_data[$bb]['total_marks'] = $total3;  

                    $bb++;
                    ?>
                <?php endforeach;?>

 
            </table>
 
            <?php if($st_count != $submit_count) : ?>              
            <br>
            <form action="" method="POST">
                <input type="submit" class="btn btn-success" name="generate_btn" value="Generate Results">
            </form> 
            <?php endif;?>
            <?php  
            // Sort the Result Array
            function result_sort($a, $b) {
                if($a['total_marks']==$b['total_marks']) return 0;
                return $a['total_marks'] < $b['total_marks']?1:-1;
 
            } 
            usort($student_data,"result_sort"); 
             
            ?>
        </div>
    </div>
</div> 
 
</div>

<?php
if(isset($_POST['generate_btn'])){
  



    $ai=1;
    foreach($student_data as $data){ 
        $stm=$pdo->prepare("INSERT INTO students_results(class_id,st_id,st_name,total_marks,subjects,position) VALUES(?,?,?,?,?,?)");

        $stm->execute(array(
            $data['class_id'],
            $data['st_id'],
            $data['st_name'],
            $data['total_marks'],
            json_encode($data['subjects']),
            $ai,
        )); 
        $ai++; 
    }

    $success = "Success";
     
}
?>

<?php if(isset($success)) : ?>
<script>
    alert("Result Generate Success!");
</script>
<?php endif;?>




<?php 
require_once('footer.php'); ?>