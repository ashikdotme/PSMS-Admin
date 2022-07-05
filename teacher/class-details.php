<?php require_once('header.php'); 

// if(!isset($_GET['id'])){
//     header('location:routine-all.php');
// }

$class_id = $_GET['id'];
$teacher_id = $_SESSION['teacher_loggedin'][0]['id'];


$stm=$pdo->prepare("SELECT * FROM class WHERE id=?");
$stm->execute(array($class_id));
$details = $stm->fetchAll(PDO::FETCH_ASSOC);
$class_details = $details[0];
?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple"></i>                 
    </span>
        <?php echo getClassName($class_id,'class_name');?> Details
  </h3> 
</div>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">   
            <table class="table table-bordered">
                <tr>
                    <td><b>Class Name:</b></td>
                    <td><?php echo $class_details['class_name'];?></td>
                </tr>    
             
                <tr>
                    <td><b>Subjects:</b></td>
                    <td><?php 
                        // Get Subject Name and Code
                        $subject_list = json_decode($class_details['subjects']); 
                        foreach($subject_list as $new_subject){
                            echo getSubjectName($new_subject)."<br>";
                        } 
                        ?></td> 
                </tr>    
             
                <tr>
                    <td><b>Start Date:</b></td>
                    <td><?php echo $class_details['start_date'];?></td>
                </tr>    
                <tr>
                    <td><b>End Date:</b></td>
                    <td><?php echo $class_details['end_date'];?></td>
                </tr>    
             
            </table>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>