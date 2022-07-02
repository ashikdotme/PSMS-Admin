<?php require_once('header.php');

if(isset($_POST['create_btn'])){
    $teacher = $_POST['teachers'];
    $subject = $_POST['subject'];
    
    // Subject Assign Count 
    $subjectCount = getCount('assign_teachers','subject_id',$subject);
     
    if($subjectCount != 0){
        $error = "Already Assign Teacher for this Subject!";
    }  
    else{  

        $insert = $pdo->prepare("INSERT INTO assign_teachers(teacher_id,subject_id) VALUES(?,?)"); 
        $insert->execute(array($teacher,$subject));
        $success = "Teacher Assign Success!";
    }
 
}


?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    New Subject Assign
  </h3> 
</div>
<div class="row">
<div class="col-md-6 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">  
        <?php if(isset($error)) :?>
        <div class="alert alert-danger"><?php echo $error;?></div>
        <?php endif;?>
        <?php if(isset($success)) :?>
        <div class="alert alert-success"><?php echo $success;?></div>
        <?php endif;?>
        <form class="forms-sample" method="POST" action="">
            <div class="form-group">
                <label for="teachers">Teacher Name:</label>
                <?php 
                $stm=$pdo->prepare("SELECT id,name FROM teachers");
                $stm->execute();
                $tLists = $stm->fetchAll(PDO::FETCH_ASSOC);
                
                ?>
                <select name="teachers" id="teachers" class="form-control">
                    <?php 
                    foreach($tLists as $tlist) :
                    ?>
                    <option value="<?php echo $tlist['id'];?>"><?php echo $tlist['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
           
            <div class="form-group">
                <label for="subject">Subject:</label>
                <?php 
                $stm=$pdo->prepare("SELECT id,name,code FROM subjects");
                $stm->execute();
                $sLists = $stm->fetchAll(PDO::FETCH_ASSOC);
                
                ?>
                <select name="subject" id="subject" class="form-control">
                    <?php 
                    foreach($sLists as $slist) :
                    ?>
                    <option value="<?php echo $slist['id'];?>"><?php echo $slist['name']." - ".$slist['code'];?></option>
                    <?php endforeach;?>
                </select>
            </div> 
            <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Assign Subject</button> 
        </form>
    </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>