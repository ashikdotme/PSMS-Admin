<?php require_once('header.php');

if(isset($_POST['create_btn'])){
    $name = $_POST['name'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    if(isset($_POST['subjects'])){
        $subjects = $_POST['subjects'];
    }
    else{
        $subjects = '';
    } 
    
    if(empty($name)){
        $error = "Class Name is Required!";
    }
    else if(empty($start_date)){
        $error = "Start Date is Required!";
    }   
    else if(empty($end_date)){
        $error = "End Date is Required!";
    }   
    else if(empty($subjects)){
        $error = "Subjects is Required!";
    }  
    else{  
        $subjects = json_encode($subjects);
        $insert = $pdo->prepare("INSERT INTO class(class_name,start_date,end_date,subjects) VALUES(?,?,?,?)"); 
        $insert->execute(array($name,$start_date,$end_date,$subjects));
        $success = "Class Create Success!";
    }
 
}


?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-airballoon"></i>                 
    </span>
    Add New Class
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
                <label for="name">Class Name:</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Class Name">
            </div>
           
            <div class="form-group">
                <label for="start_date">Start Date:</label>
                <input type="date" name="start_date" class="form-control" id="start_date" >
            </div> 

            <div class="form-group">
                <label for="end_date">End Date:</label>
                <input type="date" name="end_date" class="form-control" id="end_date" >
            </div> 

            <div class="form-group">
                <label>Subjects:</label> <br>
                <?php
                $stm = $pdo->prepare("SELECT * FROM subjects");
                $stm->execute();
                $result = $stm->fetchAll(PDO::FETCH_ASSOC); 
                foreach($result as $row) :
                ?>
                <label><input type="checkbox" value="<?php echo $row['id'];?>" name="subjects[]"> <?php echo $row['name'];?> - <?php echo $row['code'];?></label> <br>
                <?php endforeach;?>
            </div> 
            
            <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Create Class</button> 
        </form>
    </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>