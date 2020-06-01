<?PHP include 'conection.php' ?>
<?PHP
  session_start();
  /*----------log in php------------------------*/
  $error_log_emty = '';
  $error_log_username = '';
  /*----------click login------------------------*/
  if(isset($_POST["submit"])){
    /*----------get user name & password------------------------*/  
    $user_id = $con->real_escape_string($_POST['user_id']);
    $password = $con->real_escape_string($_POST['password']);

    if(!empty($user_id) && !empty($password)){
      /*----------get user------------------------*/
      $user_name = "SELECT * FROM user WHERE user_id='$user_id' AND user_status='admin'";
      $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));
      /*----------check user name carrect------------------------*/
      if(mysqli_num_rows($user_name_result) > 0){
          $row = $user_name_result-> fetch_assoc();
          $new_password = md5($password);
          /*----------check correct password------------------------*/
          if($new_password == $row["user_password"]){
              /*----------add session log user------------------------*/
              $_SESSION['log_admin_id'] = $row["user_id"];
              /*----------lode logindex------------------------*/
              header("location: exphp/mainAdminex.php");
              /*----------wrong password ------------------------*/
          }else{
              $error_log_emty = 'Opes Invalide data';
              $error_log_username = 'Incorrect password';
              $alert_error_emty = 'Incorrect password, use correct password and re log in ';
              echo "<script type='text/javascript'>alert('$alert_error_emty');</script>";
          }
          /*----------wrong usr name------------------------*/
      }else{
          $error_log_emty = 'Opes Invalide data';
          $error_log_username = 'Incorrect user Id';
          $alert_error_emty = 'Incorrect user Id, use correct user Id and re log in ';
          echo "<script type='text/javascript'>alert('$alert_error_emty');</script>";
      }
      /*----------emty field------------------------*/
    }else{
      $error_log_emty = 'Opes All feild fill and submit';
      $alert_error_emty = 'Log in form feild emty, all feild fill and Re log in';
      echo "<script type='text/javascript'>alert('$alert_error_emty');</script>"; 
    }
  }


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon.png">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Serprise.lk/admin</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <!-- CSS Files -->
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="demo/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="bg_image">
        <img src="img/newaccbg.png">
    </div>
    <div class="admin_inex">
      <div class="log_togel">
        <a class="log_link"><button class="log_user">Admin</button></a>
        <a class="log_link" href="index2.php"><button class="log_user1">Creator</button></a>
      </div>
      </div>
      <div class="log_form">
          <div class="col-md-10">
            <div class="card card-user">
              <div class="log_con">
                <div class="card-header">
                  <h5 class="log_tit">Log In Admin</h5>
                  <p class="error"><?PHP echo $error_log_emty.' '. $error_log_username; ?></p>
                </div>
                <div class="card-body">
                  <form action="index.php" method="post">
                    <div class="row">
                      <div class="col-md-10 pr-1">
                        <div class="form-group">
                          <label>User ID</label>
                          <input type="text" class="form-control" name="user_id" id="form-control" placeholder="Enter User ID">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-10 pr-1">
                        <div class="form-group">
                          <label>Password</label>
                          <input type="password" class="form-control" name="password" id="form-control" placeholder="Password">
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="update ml-auto mr-4">
                        <button type="submit" class="btn btn-primary btn-round" name="submit" id="log_button">Log IN</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
        </div>
      </div>
      <div class="left_box">
        <div class="welcome_ad">
          <h1 class="admin_h">Welcome !<br> To<br> Abmin Panal</h1>
          <div class="logo_sur">
            <img src="img/logo.png">
          </div>
        </div>
      </div>
    </div>
</body>
</html>