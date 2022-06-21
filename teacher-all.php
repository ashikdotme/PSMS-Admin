<?php require_once('header.php'); ?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple"></i>                 
    </span>
    All Teacher
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
                        <th>Email</th> 
                        <th>Mobile</th> 
                        <th>Gender</th> 
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stm = $pdo->prepare("SELECT * FROM teachers ORDER BY id DESC");
                    $stm->execute();
                    $teacherList = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $i=1;
                    foreach($teacherList as $teacher) :
                    ?>
                    <tr>
                        <td><?php echo $i;$i++;?></td>
                        <td><?php echo $teacher['name'] ;?></td>
                        <td><?php echo $teacher['email'] ;?></td>
                        <td><?php echo $teacher['mobile'] ;?></td>
                        <td><?php echo $teacher['gender'] ;?></td>
                        <td>
                            <a href="" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit "></i></a>&nbsp;
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