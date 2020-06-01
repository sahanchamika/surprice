<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  $taday = date("Y-m-d");

  /*---------------------user feedback count-----------------------*/
  $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
  $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
  $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------------chat count-----------------------*/
  $chat_count = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_resever = '$log_user_id' AND chat_state = 'Active'";
  $chat_count_result = mysqli_query($con, $chat_count) or die (mysqli_error($con));
  $chat_count_row = $chat_count_result-> fetch_assoc();

  /*---------------------get admin team-----------------------*/
  $admin_team = "SELECT * FROM user WHERE user_status = 'admin' AND user_id != '$log_user_id'";
  $admin_team_result = mysqli_query($con, $admin_team) or die (mysqli_error($con));

  /*---------------------get creater team-----------------------*/
  $creater_team = "SELECT * FROM creator";
  $creater_team_result = mysqli_query($con, $creater_team) or die (mysqli_error($con));

  /*----------error variabel-------------*/
  $error_emty = "";
  $error = "";
  /*----------click update------------*/
  if(isset($_POST["submit"])){
    /*----------get form data------------------------*/
    $f_name = $con->real_escape_string($_POST['f_name']);
    $username = $con->real_escape_string($_POST['username']);
    $email = $con->real_escape_string($_POST['email']);
    $tel = $con->real_escape_string($_POST['tel']);
    $prov = $con->real_escape_string($_POST['prov']);
    $diss = $con->real_escape_string($_POST['diss']);
    $address = $con->real_escape_string($_POST['address']);
    $birtday = $con->real_escape_string($_POST['birtday']);
    $gender = $con->real_escape_string($_POST['gender']);
    $passw1 = $con->real_escape_string($_POST['passw1']);
    $passw2 = $con->real_escape_string($_POST['passw2']);
    $user_image = $con->real_escape_string('img/user/admin'.$_FILES['user_image']['name']);
    /*----------form validation------------------------*/
    if(!empty($birtday) && !empty($username) && !empty($email) && !empty($tel) && !empty($prov) && !empty($diss) && !empty($address) && !empty($passw1) && !empty($passw2) && !empty($gender) && !empty($user_image)){
      if(preg_match("!image!",$_FILES['user_image']['type'])){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          if(preg_match("/^[0-9]{3} [0-9]{7}$/", $tel)){
              if($birtday < $taday){
                  /*----------get user------------------------*/
                  $user_name = "SELECT * FROM user WHERE user_username='$username' AND user_status='admin'";
                  $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));
                  if(mysqli_num_rows($user_name_result) > 0){
                      $error ="Sorry.. Username already taken";
                  }else{
                      if($passw1 == $passw2){
                          if(copy($_FILES['user_image']['tmp_name'], $user_image)){
                              $md5_passw2 = md5($passw2);
                              /*----------add new user------------------------*/
                              $insert_admin = "INSERT INTO user (user_status, user_full_name, user_email, user_province, user_distric, user_address, user_dob, user_gender, user_username, user_password, user_image, user_menber_ship, user_tel_number)
                              VALUES('admin', '$f_name', '$email', '$prov', '$diss', '$address', '$birtday', '$gender', '$username', '$md5_passw2', '$user_image', 'Nomal', '$tel')";
                              $insert_admin_result = mysqli_query($con, $insert_admin) or die (mysqli_error($con));

                              if(mysqli_num_rows($insert_admin_result) > 0){
                                  $error = 'Can not insert';
                              }else{
                                  /*--------------load index-------------------*/
                                  header("location: createAcc.php");
                              }
                          }else{
                              $error = 'Can not insert image';
                          }
                      }else{
                          $error ="New Password And Comform Password not Match";
                      }
                  }
              }else{
                  $error ="Enter Valid birthday";
              }
          }else{
              $error ="Enter Valid Tel. Number";
          } 
        }else{
          $error ="Enter Valid Email";
        }
      }else{
        $error ="Enter Valid Image";
      }
    }else{
      $error_emty ="Filed Emty, All filed Fill And Submit";
    } 
  }

  /*----------error variabel-------------*/
  $cre_error_emty = "";
  $cre_error = "";

    /*----------click update------------*/
    if(isset($_POST["cre_submit"])){
      /*----------get form data------------------------*/
      $cre_f_name = $con->real_escape_string($_POST['cre_f_name']);
      $cre_username = $con->real_escape_string($_POST['cre_username']);
      $cre_email = $con->real_escape_string($_POST['cre_email']);
      $cre_tel = $con->real_escape_string($_POST['cre_tel']);
      $cre_address = $con->real_escape_string($_POST['cre_address']);
      $cre_birtday = $con->real_escape_string($_POST['cre_birtday']);
      $cre_gender = $con->real_escape_string($_POST['cre_gender']);
      $cre_passw1 = $con->real_escape_string($_POST['cre_passw1']);
      $cre_passw2 = $con->real_escape_string($_POST['cre_passw2']);
      $cre_user_image = $con->real_escape_string('../serprise/img/creater/cre'.$_FILES['cre_user_image']['name']);
      /*----------form validation------------------------*/
      if(!empty($cre_birtday) && !empty($cre_username) && !empty($cre_email) && !empty($cre_tel) && !empty($cre_address) && !empty($cre_passw1) && !empty($cre_passw2) && !empty($cre_gender) && !empty($cre_user_image)){
        if(preg_match("!image!",$_FILES['cre_user_image']['type'])){
          if (filter_var($cre_email, FILTER_VALIDATE_EMAIL)) {
            if(preg_match("/^[0-9]{3} [0-9]{7}$/", $cre_tel)){
                if($cre_birtday < $taday){
                    /*----------get user------------------------*/
                    $user_name = "SELECT * FROM user WHERE user_username='$cre_username' AND user_status='admin'";
                    $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));
                    if(mysqli_num_rows($user_name_result) > 0){
                        $cre_error ="Sorry.. Username already taken";
                    }else{
                        if($cre_passw1 == $cre_passw2){
                            if(copy($_FILES['cre_user_image']['tmp_name'], $cre_user_image)){
                                $cre_md5_passw2 = md5($cre_passw2);
                                /*----------add new user------------------------*/
                                $insert_creater = "INSERT INTO creator (creator_name, creator_address, creator_email, creator_tel, creator_comment, creator_item, creator_sold_iem, creator_total_item, creator_username, creator_password, creator_gender, creator_image)
                                VALUES('$cre_f_name', '$cre_address', '$cre_email', '$cre_tel', 'New Creater No Added They Comment', '0', '0', '0', '$cre_username', '$cre_md5_passw2', '$cre_gender', '$cre_user_image')";
                                $insert_creater_result = mysqli_query($con, $insert_creater) or die (mysqli_error($con));
    
                                if(mysqli_num_rows($insert_creater_result) > 0){
                                    $cre_error = 'Can not insert';
                                }else{
                                    /*--------------load index-------------------*/
                                    header("location: createAcc.php");
                                }
                            }else{
                                $cre_error = 'Can not insert image';
                            }
                        }else{
                            $cre_error ="New Password And Comform Password not Match";
                        }
                    }
                }else{
                    $cre_error ="Enter Valid birthday";
                }
            }else{
                $cre_error ="Enter Valid Tel. Number";
            } 
          }else{
            $cre_error ="Enter Valid Email";
          }
        }else{
          $cre_error ="Enter Valid Image";
        }
      }else{
        $cre_error_emty ="Filed Emty, All filed Fill And Submit";
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
              <img id="user_img" src="<?php echo $row['user_image']; ?>">
          </div>
        </a>
        <a href="user.php" class="simple-text logo-normal">
          <p id="user_name"><?php echo $row['user_username']; ?></p>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="dashboard.php">
              <i class="nc-icon nc-bank"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="user.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Admin Profile</p>
            </a>
          </li>
          <li class="active ">
            <a href="createAcc.php">
              <i class="nc-icon nc-badge"></i>
              <p>Create Account</p>
            </a>
          </li>
          <li>
            <a href="customer.php">
              <i class="nc-icon nc-circle-10"></i>
              <p>User (customer)</p>
            </a>
          </li>
          <li>
            <a href="item.php">
              <i class="nc-icon nc-layout-11"></i>
              <p>Item</p>
            </a>
          </li>
          <li>
            <a href="shiping.php">
              <i class="nc-icon nc-delivery-fast"></i>
              <p>Shiping</p>
            </a>
          </li>
          <li>
            <a href="deliCom.php">
              <i class="nc-icon nc-bus-front-12"></i>
              <p>Delivary Company</p>
            </a>
          </li>
          <?php
            if($chat_count_row['COUNT(`chat_id`)'] >= 1){
              echo'<li>
                <a href="chat.php">
                  <i class="nc-icon nc-chat-33"></i>
                  <p>Chat</p><div class="chat_count"><p>'.$chat_count_row['COUNT(`chat_id`)'].'</p></div>
                </a>
              </li>';
            }else{
              echo'<li>
                <a href="chat.php">
                  <i class="nc-icon nc-chat-33"></i>
                  <p>Chat</p>
                </a>
              </li>';
            }
          ?>
          <li>
            <a href="createrItem.php">
              <i class="nc-icon nc-email-85"></i>
              <p>Creator item</p>
            </a>
          </li>
          <li>
            <a href="report.php">
              <i class="nc-icon nc-chart-bar-32"></i>
              <p>Revanue Report</p>
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
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="">Creater Account </a>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="exphp/logout.php">
                  <i class="nc-icon nc-button-power"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-magnify" onclick="refleshUser()">
                  <i class="nc-icon nc-refresh-69"></i><p id="refesh_user">Refesh User </p><p id="messag"></p>
                  <p>
                    <span class="d-lg-none d-md-block">Stats</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="feedback.php">
                  <?php
                    if($user_fedb_count_row['COUNT(`user_feedback_id`)'] > 0){
                      echo '<div class="notification_count"><p class="not_cou">'.$user_fedb_count_row['COUNT(`user_feedback_id`)'].'</p></div><i class="nc-icon nc-bell-55"></i>';
                    }else{
                      echo '<i class="nc-icon nc-bell-55"></i>';
                    }
                  ?>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="setting.php">
                  <i class="nc-icon nc-settings-gear-65"></i>
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
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Admin Team</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled team-members">
                  <?php
                    if(mysqli_num_rows($admin_team_result) > 0){
                      while ($admin_team_row = $admin_team_result-> fetch_assoc()){
                        $chat_id_user = $admin_team_row['user_id'];
                        /*--------------------- admin chat-----------------------*/
                        $chat = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_sender='$chat_id_user' AND chat_resever='$log_user_id' AND chat_state = 'Active'";
                        $chat_result = mysqli_query($con, $chat) or die (mysqli_error($con));
                        $chat_row = $chat_result-> fetch_assoc();
                        
                        echo'<li>
                          <div class="row">
                            <div class="col-md-2 col-2">
                              <div class="avatar">
                                <img src="'.$admin_team_row['user_image'].'" alt="" class="img-circle img-no-padding img-responsive" id="admin_team_img">
                              </div>
                            </div>
                            <div class="col-md-7 col-7">
                              '.$admin_team_row['user_full_name'].'
                            </div>';
                            if(($chat_row['COUNT(`chat_id`)'] >= 1)){
                              echo'<div class="col-md-3 col-3 text-right" id="chat_icom">
                                <a href="chat.php?chatid='.$chat_id_user.'"><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-chat-33"></i></btn></a>
                              </div>';
                            }else{
                              echo'<div class="col-md-3 col-3 text-right" id="chat_icom">
                                <a href="chat.php?chatid='.$chat_id_user.'"><btn class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="nc-icon nc-chat-33"></i></btn></a>
                              </div>';
                            }
                          echo'</div>
                        </li>';
                        /*---danger---*/
                      }
                    }else{
                      echo'<h4 class="no_error">You Only One Admin</h4>';
                    }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Create Admin Profile</h5>
              </div>
              <p class="error"><?PHP echo $error_emty.' '. $error; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-9 pr-1">
                      <div class="form-group">
                      <label>Full Name</label>
                        <input type="text" name="f_name" class="form-control" placeholder="Eg: Jone Whik">
                      </div>
                    </div>
                    
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Tel. Number</label>
                        <input type="text" name="tel" class="form-control" placeholder="000 0000000">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>Province</label>
                        <input type="text" name="prov" class="form-control" placeholder="Eg: Southern">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Distric</label>
                        <input type="text" name="diss" class="form-control" placeholder="Eg: Matara">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Date Of birt</label>
                        <input type="date" name="birtday" value="<?PHP echo $taday;?>" max="<?PHP echo $taday;?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Home name, road, town">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="gender">
                            <option value="male">Male</option>
                            <option value="female">Femail</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Email@gmail.com"></input>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                      <label for="exampleInputEmail1">Profile image</label>
                        <label class="form-control">.Jpg</label>
                        <input type="file" name="user_image" accept="image/*">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Jone">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="passw1" class="form-control" placeholder="8 charcter and lower,case">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Comform Password</label>
                        <input type="password" name="passw2" class="form-control" placeholder="8 charcter and lower,uper case">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Create Profile</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Creater Team</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled team-members">
                  <?php
                    if(mysqli_num_rows($creater_team_result) > 0){
                      while ($creater_team_row = $creater_team_result-> fetch_assoc()){
                        echo'<li>
                          <div class="row">
                            <div class="col-md-2 col-2">
                              <div class="avatar">
                                <img src="../serprise/'.$creater_team_row['creator_image'].'" alt="" class="img-circle img-no-padding img-responsive" id="admin_team_img">
                              </div>
                            </div>
                            <div class="col-md-7 col-7">
                              '.$creater_team_row['creator_name'].'
                            </div>
                          </div>
                        </li>';
                        /*---danger---*/
                      }
                    }else{
                      echo'<h4 class="no_error">No Creaters</h4>';
                    }
                  ?>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Create Creater Profile</h5>
              </div>
              <p class="error"><?PHP echo $cre_error_emty.' '. $cre_error; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-9 pr-1">
                      <div class="form-group">
                      <label>Full Name</label>
                        <input type="text" name="cre_f_name" class="form-control" placeholder="Eg: Jone Whik">
                      </div>
                    </div>
                    
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Tel. Number</label>
                        <input type="text" name="cre_tel" class="form-control" placeholder="000 0000000">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Date Of birt</label>
                        <input type="date" name="cre_birtday" value="<?PHP echo $taday;?>" max="<?PHP echo $taday;?>" class="form-control">
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="cre_address" class="form-control" placeholder="Home name, road, town">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="cre_gender">
                            <option value="male">Male</option>
                            <option value="female">Femail</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="cre_email" class="form-control" placeholder="Email@gmail.com"></input>
                      </div>
                    </div>
                    <div class="col-md-5">
                      <div class="form-group">
                      <label>Profile image</label>
                        <label class="form-control">.Jpg</label>
                        <input type="file" name="cre_user_image" accept="image/*">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="cre_username" class="form-control" placeholder="Jone">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="cre_passw1" class="form-control" placeholder="8 charcter and lower,case">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Comform Password</label>
                        <input type="password" name="cre_passw2" class="form-control" placeholder="8 charcter and lower,uper case">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="cre_submit" class="btn btn-primary btn-round">Create Profile</button>
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
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="../serpriseCreater/add.php">Suprisc.lk team </a>
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
  <script>
      var item_id =5;
          // user and main admin expage refresh
          function refleshUser(){
            if (item_id.length == 0) {
                document.getElementById("messag").innerHTML = "No Item";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("messag").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "exphp/mainAdmin2.php", true);
                xmlhttp.send();

            }

          }  
  </script>
</body>

</html>
