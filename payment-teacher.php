<?php require_once('header.php');

if(isset($_POST['create_btn'])){
    $teacher_id = $_POST['teacher_id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment_method'];
    $account_number = $_POST['account_number'];
      
    if(empty($teacher_id)){
        $error = "Teacher Name is Required!";
    }
    else if(empty($amount)){
        $error = "Amount is Required!";
    }
    else if(empty($payment_method)){
        $error = "Payment Method is Required!";
    }  
    else if(empty($account_number)){
        $error = "Account Number is Required!";
    }  
    else if(!is_numeric($amount)){
        $error = "Amount Must be Number!";
    }   
    else{ 
        // Update Teacher Balance
        $stm2=$pdo->prepare("UPDATE teachers SET balance=balance + ?,last_amount=? WHERE id=?");
        $stm2->execute(array($amount,$amount,$teacher_id));

        // Create Payment History
        $insert = $pdo->prepare("INSERT INTO teacher_payment_history(teacher_id,amount,payment_method,account_number) VALUES(?,?,?,?)"); 
        $insert->execute(array($teacher_id,$amount,$payment_method,$account_number));
        $success = "Teacher Payment Submit Success!";
    }


}


?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    Teacher Payment
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
                <label for="teacher_id">Select Teacher:</label>
                 <select name="teacher_id" id="teacher_id" class="form-control">
                 <?php 
                 $stm = $pdo->prepare("SELECT id,name FROM teachers");
                 $stm->execute();
                 $teacherList = $stm->fetchAll(PDO::FETCH_ASSOC); 
                 foreach($teacherList as $teacher) :
                 ?>
                 <option value="<?php echo $teacher['id'];?>"><?php echo $teacher['name'];?></option>
                 <?php endforeach;?>
                 </select>
            </div>
           
            <div class="form-group">
                <label for="amount">Salary Amount:</label>
                <input type="text" name="amount" class="form-control" id="amount" placeholder="Amount">
            </div>

            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method" class="form-control">
                    <option value="bKash">bKash</option>
                    <option value="Rocket">Rocket</option>
                    <option value="Nogot">Nogot</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_number">Account Number:</label>
                <input type="text" name="account_number" class="form-control" id="account_number" placeholder="Account Number">
            </div>
  
            <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Send Payment</button> 
        </form>
    </div>
    </div>
</div>
</div>

<?php require_once('footer.php'); ?>