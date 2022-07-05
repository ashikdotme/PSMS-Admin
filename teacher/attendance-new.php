<?php require_once('header.php');

if(isset($_POST['change_btn'])){
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    

    $teacher_id = $_SESSION['teacher_loggedin'][0]['id'];

    $statement = $pdo->prepare("SELECT password FROM teachers WHERE id=?");
    $statement->execute(array($teacher_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    $db_password = $result[0]['password'];


    if(empty($current_password)){
        $error = "Current password is Required!";
    }
    else if(empty($new_password)){
        $error = "New password is Required!";
    }
    else if(empty($confirm_new_password)){
        $error = "Confirm New password is Required!";
    }
    else if($new_password != $confirm_new_password ){
        $error = "New Password and Confirm New Password Does't Match!";
    }
    else if(SHA1($current_password) != $db_password ){
        $error = "Current Password is Wrong!";
    }
    else{ 
        $new__password = SHA1($confirm_new_password);

        $stm=$pdo->prepare("UPDATE teachers SET password=? WHERE id=?");
        $stm->execute(array($new__password,$teacher_id));
        $success = "Password change Successfully!";
        
    }


}


?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    New Attendance
  </h3> 
</div>
<div class="row">

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">  
        <?php if(isset($error)) :?>
        <div class="alert alert-danger"><?php echo $error;?></div>
        <?php endif;?>
        <?php if(isset($success)) :?>
        <div class="alert alert-success"><?php echo $success;?></div>
        <?php endif;?>
        <form class="forms-sample" method="POST" action="">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="select_class">Select Class:</label>
                        <select name="" class="form-control" id="select_class">
                            <option value=""></option>
                        </select>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="select_subject">Select Subject:</label>
                        <select name="" class="form-control" id="select_subject">
                            <option value=""></option>
                        </select>
                    </div> 
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="att_date">Select Date:</label>
                        <input type="date" name="att_date" class="form-control" id="att_date">
                    </div> 
                </div>
            </div>
           
            <button type="submit" name="change_btn" class="btn btn-gradient-primary mr-2">Submit</button> 
        </form>
    </div>
    </div>
</div>

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <form action="" method="POST">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student Name</th>
                        <th>Student Roll</th>
                        <th>Absent</th>
                        <th>Present</th>
                    </tr>
                </thead>
                <tbody>
                    <td>1</td>
                    <td>Asik</td>
                    <td>3444</td>
                    <td><label for="Absent"><input type="radio" value="0" name="status" id="Absent"> Absent</label></td>
                    <td><label for="Present"><input type="radio" value="1" name="status" id="Present"> Present</label></td>
                </tbody>
            </table>
            <br>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-success btn-sm" value="Submit Attendance">
            </div>

            </form>
        </div>
    </div>
</div>

</div>

<?php require_once('footer.php'); ?>