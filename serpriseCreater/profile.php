<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['creater_id'];

   /*---------------------login creater details-----------------------*/
   $log_user = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
   $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
   $row = $log_user_result-> fetch_assoc();

  /*---------------------admin massage count-----------------------*/
  $admin_mass_count = "SELECT COUNT(`admin_cre_feed_id`) FROM admin_cre_feed WHERE admin_cre_feed_cre_id='$log_user_id' AND admin_cre_feed_state='Active'";
  $admin_mass_count_result = mysqli_query($con, $admin_mass_count) or die (mysqli_error($con));
  $admin_mass_count_row = $admin_mass_count_result-> fetch_assoc();

  /*----------error variabel-------------*/
  $error_emty = "";
  $error = "";
  /*----------click update------------*/
  if(isset($_POST["submit"])){
    /*----------get form data------------------------*/
    $username = $con->real_escape_string($_POST['username']);
    $email = $con->real_escape_string($_POST['email']);
    $tel = $con->real_escape_string($_POST['tel']);
    $comment = $con->real_escape_string($_POST['comm']);
    $passw1 = $con->real_escape_string($_POST['passw1']);
    $passw2 = $con->real_escape_string($_POST['passw2']);
    $passw3 = $con->real_escape_string($_POST['passw3']);
    /*----------form validation------------------------*/
    if(!empty($username) && !empty($email) && !empty($tel) && !empty($comment) && !empty($passw1) && !empty($passw2) && !empty($passw3)){
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /*----------get user------------------------*/
        $user_pass = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
        $user_pass_result = mysqli_query($con, $user_pass) or die (mysqli_error($con));
        $user_pass_row = $user_pass_result-> fetch_assoc();
        if($user_pass_row['creator_username'] != $username){
          $user_name = "SELECT * FROM creator WHERE creator_username='$username'";
          $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));
          if(mysqli_num_rows($user_name_result) <= 0){
              $md5_passw1 = md5($passw1);
              if($user_pass_row['creator_password'] == $md5_passw1){
                if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$passw2) && preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$passw3)){
                  $md5_passw2 = md5($passw2);
                  $md5_passw3 = md5($passw3);
                  if($md5_passw2 == $md5_passw3){
                    /*-----------up date user details-------------*/
                    $update_user = "UPDATE creator SET creator_email='$email', creator_tel='$tel', creator_comment='$comment', creator_username='$username', creator_password='$md5_passw3' WHERE creator_id='$log_user_id'";
                    $update_user_result = mysqli_query($con, $update_user) or die (mysqli_error($con));
                    header("location: profile.php");
                  }else{
                    $error ="Not Match New And Comform Password, Enter Corect Comform Password";
                  }
                }else{
                  $error ="Incorect Password Type New or Comform Passward,Enter New Pasword";
                }
              }else{
                $error ="Incorect Current Password, Enter Corect Password";
              }
          }else{
            $error ="Sorry.. Username already taken";
          }
        }else{
          /*----------get user------------------------*/
          $user_pass = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
          $user_pass_result = mysqli_query($con, $user_pass) or die (mysqli_error($con));
          $user_pass_row = $user_pass_result-> fetch_assoc();
              $md5_passw1 = md5($passw1);
              if($user_pass_row['creator_password'] == $md5_passw1){
                if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$passw2) && preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$passw3)){
                  $md5_passw2 = md5($passw2);
                  $md5_passw3 = md5($passw3);
                  if($md5_passw2 == $md5_passw3){
                    /*-----------up date user details-------------*/
                    $update_user = "UPDATE creator SET creator_email='$email', creator_tel='$tel', creator_comment='$comment', creator_username='$username', creator_password='$md5_passw3' WHERE creator_id='$log_user_id'";
                    $update_user_result = mysqli_query($con, $update_user) or die (mysqli_error($con));
                    header("location: profile.php");
                  }else{
                    $error ="Not Match New And Comform Password, Enter Corect Comform Password";
                  }
                }else{
                  $error ="Incorect Password Type New or Comform Passward,Enter New Pasword";
                }
              }else{
                $error ="Incorect Current Password, Enter Corect Password";
              }
        }
      }else{
        $error ="Enter Valid Email";
      }
    }else{
      $error_emty ="Filed Emty, All filed Fill And Submit";
    } 
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="favicon" sizes="76x76" href="img/favicon.png.png">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Surprise.lk/admin/user</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger"> 
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          <div class="logo-image-small">
              <img id="user_img" src="../serprise/<?php echo $row['creator_image']; ?>">
          </div>
        </a>
        <a href="" class="simple-text logo-normal">
          <p id="user_name"><?php echo $row['creator_name']; ?></p>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
        <ul class="nav">
          <li>
            <a href="indexCre.php">
              <i class="nc-icon nc-badge"></i>
              <p>Creater</p>
            </a>
          </li>
          <li>
            <a href="addItem.php">
            <i class="nc-icon nc-cart-simple"></i>
              <p>Add Item</p>
            </a>
          </li>
          <li  class="active">
            <a href="profile.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Profile</p>
            </a>
          </li>
          <li>
            <a href="exphp/logout.php">
              <i class="nc-icon nc-button-power"></i>
              <p>Log Out</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
   <!---------heder nav bar------------->
   <div class="main-panel">
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="">Creater Profile</a>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="adminMassage.php">
                  <?php
                    if($admin_mass_count_row['COUNT(`admin_cre_feed_id`)'] > 0){
                      echo '<div class="notification_count"><p class="not_cou">'.$admin_mass_count_row['COUNT(`admin_cre_feed_id`)'].'</p></div><i class="nc-icon nc-bell-55"></i>';
                    }else{
                      echo '<i class="nc-icon nc-bell-55"></i>';
                    }
                  ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-4">
            <div class="card card-user">
              <div class="image">
                <img src="img/banner02.png" alt="...">
              </div>
              <div class="card-body">
                <div class="author">
                  <a href="#">
                    <img class="avatar border-gray" src="../serprise/<?php echo $row['creator_image']; ?>" alt="">
                    <h5 class="title"><?php echo $row['creator_name']; ?></h5>
                  </a>
                  <p class="description">
                    <?php echo $row['creator_email']; ?>
                  </p>
                </div>
                <p class="description text-center">
                  <?php echo $row['creator_comment']; ?>
                </p>
              </div>
              <div class="card-footer">
                <hr>
                <div class="button-container">
                  <div class="row">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Edit Profile</h5>
              </div>
                <p class="error"><?PHP echo $error_emty.' '. $error; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                      <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $row['creator_username']; ?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $row['creator_email']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Tel. Number</label>
                        <input type="text" name="tel" class="form-control" placeholder="Tel. Number" value="<?php echo $row['creator_tel']; ?>">
                      </div>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>You'r Comment</label>
                        <input type="text" name="comm" class="form-control" placeholder="More Than 15 Word" value="<?php echo $row['creator_comment']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" name="passw1" class="form-control" placeholder="8 charcter and lower,case">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="passw2" class="form-control" placeholder="8 charcter and lower,case">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Comform Password</label>
                        <input type="password" name="passw3" class="form-control" placeholder="8 charcter and lower,uper case">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Update Profile</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="add.php">Suprisc.lk team </a>
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   js   -->
  <script src="js/core/jquery.min.js"></script>
  <script src="js/core/popper.min.js"></script>
  <script src="js/core/bootstrap.min.js"></script>
  <script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="js/plugins/chartjs.min.js"></script>
  <script src="js/plugins/bootstrap-notify.js"></script>
  <script src="js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <script src="demo/demo.js"></script>
</body>

</html>
