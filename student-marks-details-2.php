<?php require_once('header.php');
$class_id = $_GET['class'];

$stm = $pdo->prepare("SELECT exam_marks_1.class_id,exam_marks_1.subject_id,exam_marks_1.exam_id,exam_marks_1.st_marks,exam_marks_1.st_id,students.name as st_name,subjects.name as subject_name,subjects.code as subject_code FROM exam_marks_1 
INNER JOIN students ON exam_marks_1.st_id=students.id
INNER JOIN subjects ON exam_marks_1.subject_id=subjects.id
WHERE exam_marks_1.class_id=?");

$stm->execute(array($class_id));
$getMarks = $stm->fetchAll(PDO::FETCH_ASSOC);

$st_list = [];
foreach($getMarks as $marksByStudent){
    $st_list[$marksByStudent['st_id']][] = $marksByStudent;
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
                    <th>Subjects</th>
                    <th>Marks</th> 
                </tr>
               
                <?php  
                $bb=0;
                $student_data = []; 
                foreach($st_list as $newList) : ?>
                <tr>
                    <td>1</td>
                    <td><?php echo $newList[0]['st_name']; ?></td>
                    
                    <td>
                        <?php  foreach($newList as $st_subject) : ?> 
                        <?php echo $st_subject['subject_name']."-".$st_subject['subject_code'];?> <br> 
                        <?php endforeach; ?>
                    </td>

                    <td>
                        <?php  
                        $total=0;
                        $ii=1;
                        foreach($newList as $st_subject) : ?> 
                        <?php 
                        $student_data[$bb]['subjects']['subject_id_'.$ii] = $st_subject['subject_id'];
                        $student_data[$bb]['subjects']['subject_'.$ii] = $st_subject['subject_name'];
                        $student_data[$bb]['subjects']['subject_'.$ii.'_marks'] = $st_subject['st_marks'];


                        $total=$total+$st_subject['st_marks'];
                        echo $st_subject['st_marks'];?> <br> 
                        <?php $ii++; endforeach; ?>
                        <?php echo "Total Marks: ".$total; ?>

                    </td>
                    <?php  
                      $student_data[$bb]['st_id'] = $newList[0]['st_id'];
                      $student_data[$bb]['st_name'] = $newList[0]['st_name'];
                      $student_data[$bb]['class_id'] = $newList[0]['class_id'];
                      $student_data[$bb]['total_marks'] = $total;  

                    $bb++;
                    ?>
                </tr>
                <?php endforeach;?>

            </table> 
            <br>
            <form action="" method="POST">
                <input type="submit" class="btn btn-success" name="generate_btn" value="Generate Results">
            </form> 
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