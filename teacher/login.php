<?php 
require_once('../config.php');
session_start();

if(isset($_POST['login_btn'])){
  	$username = $_POST['username'];
  	$password = $_POST['password'];

    if(empty($username)){
      $error = "Username is Required!";
    }
    else if(empty($password)){
      $error = "Password is Required!";
    }
    else{
        $stm = $pdo->prepare("SELECT id,mobile,name FROM teachers WHERE mobile=? and password=?");
        $stm->execute(array($username,SHA1($password)));
        $teacherCount = $stm->rowCount();

        if($teacherCount == 1){
          $teacherData = $stm->fetchAll(PDO::FETCH_ASSOC);
          $_SESSION['teacher_loggedin'] = $teacherData;

          header('location:index.php');
        }
        else{
          $error = "Mobile Number or Password is Wrong!";
        } 
    } 
}


if(isset($_SESSION['teacher_loggedin'])){
  header('location:index.php');
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Teacher Login</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
               <h2 class="text-center"> Teacher Login</h2>
              </div> 
              <?php if(isset($error)) :?>
              <div class="alert alert-danger"><?php echo $error;?></div>
              <?php endif;?>
              <form class="pt-3" method="POST" action="">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" name="username" placeholder="Teacher Mobile">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button type="submit" name="login_btn" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Login</button>
                </div> 
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <script src="../vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="../js/off-canvas.js"></script>
  <script src="../js/misc.js"></script>
  <!-- endinject -->
</body>

</html>
