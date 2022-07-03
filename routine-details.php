<?php require_once('header.php'); 

// if(!isset($_GET['id'])){
//     header('location:routine-all.php');
// }

$class_id = $_GET['id'];

$stm=$pdo->prepare("SELECT class_routine.class_name as class_id,class_routine.day,class_routine.subject_id,class_routine.teacher_id,class_routine.time_from,class_routine.time_to,class_routine.room_no,subjects.name as subject_name,subjects.code as subject_code,subjects.type as subject_type,class.class_name,teachers.name as teacher_name FROM class_routine 
INNER JOIN class ON class_routine.class_name=class.id
INNER JOIN subjects ON class_routine.subject_id=subjects.id
INNER JOIN teachers ON class_routine.teacher_id=teachers.id
WHERE class_routine.class_name=?
");
$stm->execute(array($class_id));
$routine_list = $stm->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple"></i>                 
    </span>
        <?php echo getClassName($class_id,'class_name');?> Routine
  </h3> 
</div>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">   
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width:20px;">#</th> 
                        <th>Subject Name</th>  
                        <th>Teacher Name</th>  
                        <th>Day</th>  
                        <th>Time From</th> 
                        <th>Time To</th> 
                        <th>Room No</th> 
                    </tr>
                </thead>
                <tbody>
                   <?php 
                   $i=1;
                    foreach($routine_list as $list) :
                   ?>
                    <tr>
                        <td><?php echo $i;$i++;?></td>
                        <td><?php echo $list['subject_name']."-".$list['subject_code'];?></td>
                        <td><?php echo $list['teacher_name'];?></td>
                        <td><?php echo $list['day'];?></td>
                        <td><?php echo $list['time_from'];?></td>
                        <td><?php echo $list['time_to'];?></td>
                        <td><?php echo $list['room_no'];?></td>
                    </tr>
                   <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>