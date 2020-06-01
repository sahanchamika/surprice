<?PHP include 'conection.php' ?>
<?PHP
  /*----------log in php------------------------*/
  $error_emty = '';
  $error = '';

  $taday = date("Y-m-d");
  /*----------click login------------------------*/
  if(isset($_POST["submit"])){
    $full_name = $con->real_escape_string($_POST['f_name']);
    $tel_num = $con->real_escape_string($_POST['tel']);
    $skils = $con->real_escape_string($_POST['skil']);
    $birthday = $con->real_escape_string($_POST['birtday']);
    $address = $con->real_escape_string($_POST['address']);
    $gender = $con->real_escape_string($_POST['gender']);
    $email = $con->real_escape_string($_POST['email']);
    $user_image = $con->real_escape_string('../serpriseAdmin/img/newcreate/creater'.$_FILES['user_image']['name']);
    $username = $con->real_escape_string($_POST['username']);
    $pass1 = $con->real_escape_string($_POST['passw1']);
    $pass2 = $con->real_escape_string($_POST['passw2']);

    if(!empty($full_name) && !empty($tel_num) && !empty($skils) && !empty($birthday) && !empty($address) && !empty($email) && !empty($pass1) && !empty($pass2) && !empty($username)){
      if(preg_match("!image!",$_FILES['user_image']['type'])){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          if(preg_match("/^[0-9]{3} [0-9]{7}$/", $tel_num)){
              if($birthday < $taday){
                  /*----------get user------------------------*/
                  $user_name = "SELECT * FROM creator WHERE creator_username='$username'";
                  $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));
                  if(mysqli_num_rows($user_name_result) > 0){
                      $error ="Sorry.. Username already taken";
                  }else{
                      if($pass1 == $pass2){
                          if(copy($_FILES['user_image']['tmp_name'], $user_image)){
                              $md5_passw2 = md5($pass2);
                              /*----------add new user------------------------*/
                              $insert_creater_req = "INSERT INTO new_creater_add(new_creater_add_ful_name, new_creater_add_tel, new_creater_add_skil, new_creater_add_gender, new_creater_add_bathday, new_creater_add_addres, new_creater_add_email, new_creater_add_user_name, new_creater_add_img, new_creater_add_password, new_creater_add_state)
                              VALUES('$full_name', '$tel_num', '$skils', '$gender', '$birthday', '$address', '$email', '$username', '$user_image', '$md5_passw2', 'Active')";
                              $insert_creater_req_result = mysqli_query($con, $insert_creater_req) or die (mysqli_error($con));

                              if(mysqli_num_rows($insert_creater_req_result) > 0){
                                  $error = 'Can not insert';
                              }else{
                                  /*--------------load index-------------------*/
                                  header("location: newCreaterAfter.php");
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
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
  <link href="demo/demo.css" rel="stylesheet" />
</head>

<body>
    <div class="bg_image">
        <img src="img/newaccbg.png">
    </div>
        <div class="col-md-10" id="new_creater_box">
            <div class="card card-user">
              <div class="card-header">
                <div class="new_acc_heder"><h5 class="card-title">Create Admin Profile</h5></div>
              </div>
              <p class="error"><?PHP echo $error_emty, $error ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-9 pr-1">
                      <div class="form-group">
                      <label>Full Name</label>
                        <input type="text" name="f_name" class="form-control" placeholder="Eg: Jone Whik">
                      </div>
                    </div>
                    
                    <div class="col-md-3 ">
                      <div class="form-group">
                        <label>Tel. Number</label>
                        <input type="text" name="tel" class="form-control" placeholder="000 0000000">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-9 pr-1">
                      <div class="form-group">
                        <label>What You Skils</label>
                        <input type="text" name="skil" class="form-control" placeholder="What You Make and about you Skils">
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
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Add Request</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>