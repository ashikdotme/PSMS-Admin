<?php require_once('header.php'); ?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple"></i>                 
    </span>
    Assigned Subjects
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
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $teacher_id = $_SESSION['teacher_loggedin'][0]['id'];

                    $stm = $pdo->prepare("SELECT * FROM assign_teachers WHERE teacher_id=?");
                    $stm->execute(array($teacher_id));
                    $Lists = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $i=1;
                    foreach($Lists as $list) :
                    ?>
                    <tr>
                        <td><?php echo $i;$i++;?></td>
                        <td><?php echo getSubjectName($list['subject_id'])  ;?></td>  
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>