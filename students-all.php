<?php require_once('header.php'); ?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple"></i>                 
    </span>
    All Students
  </h3> 
</div>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">  
            <table class="table table-bordered" id="Table_Teacher_List">
                <thead>
                    <tr>
                        <th>#</th> 
                        <th>Name</th> 
                        <th>Roll</th> 
                        <th>Class</th> 
                        <th>Mobile</th> 
                        <th>Gender</th> 
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stm = $pdo->prepare("SELECT * FROM students ORDER BY id DESC");
                    $stm->execute();
                    $studentList = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $i=1;
                    foreach($studentList as $student) :
                    ?>
                    <tr>
                        <td><?php echo $i;$i++;?></td>
                        <td><?php echo $student['name'] ;?></td>
                        <td><?php echo $student['roll'] ;?></td> 
                        <td><?php echo $student['current_class'] ;?></td>
                        <td><?php echo $student['mobile'] ;?></td>
                        <td><?php echo $student['gender'] ;?></td>
                        <td>
                            <a href="" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit "></i></a>&nbsp;
                            <a href="" class="btn btn-sm btn-success"><i class="mdi mdi-eye "></i></a>&nbsp;
                            <a href="" class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>