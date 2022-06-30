<?php require_once('header.php'); ?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-airballoon"></i>                 
    </span>
    All Class
  </h3> 
</div>
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">  
            <table class="table table-bordered" id="Table_Teacher_List">
                <thead>
                    <tr>
                        <th style="width:20px;">#</th> 
                        <th>Class Name</th> 
                        <th>Start</th> 
                        <th>End</th>  
                        <th>Subjects</th>  
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $stm = $pdo->prepare("SELECT * FROM class ORDER BY id DESC");
                    $stm->execute();
                    $subList = $stm->fetchAll(PDO::FETCH_ASSOC);
                    $i=1;
                    foreach($subList as $sub) :
                    ?>
                    <tr>
                        <td><?php echo $i;$i++;?></td>
                        <td><?php echo $sub['class_name'] ;?></td>
                        <td><?php echo date('d-m-Y',strtotime($sub['start_date'])) ;?></td>
                        <td><?php echo date('d-m-Y',strtotime($sub['end_date'])) ;?></td> 
                        <td><?php 
                        // Get Subject Name and Code
                        $subject_list = json_decode($sub['subjects']); 
                        foreach($subject_list as $new_subject){
                            echo getSubjectName($new_subject)."<br>";
                        } 
                        ?></td> 
                        <td>
                            <a href="" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit "></i></a>&nbsp;
                            <a href="" class="btn btn-sm btn-success"><i class="mdi mdi-eye"></i></a>
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