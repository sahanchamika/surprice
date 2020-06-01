<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  $today = date("Y-m-d");
  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------user feedback count-----------------------*/
  $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
  $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
  $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------catagory list table--------------------*/

  $cata = "SELECT * FROM item_catagory  ORDER BY item_catagory_id";
  $cata_result = mysqli_query($con, $cata) or die (mysqli_error($con));

  /*---------------Province list table--------------------*/

  $province_list = "SELECT * FROM delivery_provins  ORDER BY delivery_provins_id";
  $province_list_result = mysqli_query($con, $province_list) or die (mysqli_error($con));
  
  /*---------------delivery district list table--------------------*/

  $distric_list = "SELECT * FROM delivery_district  ORDER BY delivery_district_id";
  $distric_list_result = mysqli_query($con, $distric_list) or die (mysqli_error($con));

  /*---------------------update price box cost-----------------------*/
  $update_pri_cost = "SELECT * FROM price_box_details";
  $update_pri_cost_result = mysqli_query($con, $update_pri_cost) or die (mysqli_error($con));
  $update_pri_cost_row = $update_pri_cost_result-> fetch_assoc();

  /*---------------------update Company Details-----------------------*/
  $update_com_d = "SELECT * FROM serprise";
  $update_com_d_result = mysqli_query($con, $update_com_d) or die (mysqli_error($con));
  $update_com_d_row = $update_com_d_result-> fetch_assoc();

  $error = "";
  $error_emty = "";
  $error_emty_c = "";
  $error_c = "";
  $error_emty_p = "";
  $error_emty_d = "";
  $error_emty_pbc = "";
  $error_cd = "";
  $error_emty_cd = "";
  $error_emty_img1 = "";
  $error_emty_img2 = "";

  if(isset($_POST["submit1"])){
    /*----------get form data------------------------*/
    $ex_date = $con->real_escape_string($_POST['ex_date']);
    $diss = $con->real_escape_string($_POST['discount']);
    if(!empty($ex_date)){
      $day1 = date_create($ex_date);
      $day2 = date_create(date("Y-m-d"));
      $day_count= date_diff($day2,$day1);
      $flash_ex_d = $day_count->format("%a");
      if($flash_ex_d > 4){
        /*-----------up date flash deatails-------------*/
        $update_fl_details = "UPDATE flash_sale_details SET flash_sale_details_date='$ex_date', flash_sale_details_rang='$flash_ex_d', flash_sale_details_diss='$diss%' WHERE flash_sale_details_id='1'";
        $update_fl_details_result = mysqli_query($con, $update_fl_details) or die (mysqli_error($con));
      }else{
        $error = "Add 3 More Day";
      }
    }else{
      $error_emty = "Select Valid Date";
    }
  }

  if(isset($_POST["submit2"])){
    /*----------get form data------------------------*/
    $cata_code = $con->real_escape_string($_POST['catacode']);
    $cata_name = $con->real_escape_string($_POST['cataname']);
    $cata_img= $con->real_escape_string('../serprise/img/catogory/catagory'.$_FILES['cataimg']['name']);
    if(!empty($cata_code) && !empty($cata_name)){
      if(preg_match("!image!",$_FILES['cataimg']['type'])){
        if(copy($_FILES['cataimg']['tmp_name'], $cata_img)){
          /*-----------insert new catagory-------------*/
          $insert_cata = "INSERT INTO item_catagory (item_catagory_code, item_catagory_name, item_catagory_count, item_catagory_image)
          VALUES('$cata_code', '$cata_name', '0', '$cata_img')";
          $insert_cata_result = mysqli_query($con, $insert_cata) or die (mysqli_error($con));

          /*------load setting.php-------*/
          header('Location: setting.php');
        }else{
          $error_c ="Can't Add Image";
        }
      }else{
        $error_c ="Plese Select Valid Image Image";
      }
    }else{
      $error_emty_c = "Fill All Field And Submit";
    }
  }

  if(isset($_POST["submit3"])){
    /*----------get form data------------------------*/
    $province = $con->real_escape_string($_POST['pro']);
    if(!empty($province)){
      /*-----------insert new catagory-------------*/
      $insert_pro = "INSERT INTO delivery_provins (delivery_provins_name, delivery_provins_cord)
      VALUES('$province', NULL)";
      $insert_pro_result = mysqli_query($con, $insert_pro) or die (mysqli_error($con));

      /*------load setting.php-------*/
      header('Location: setting.php');

    }else{
      $error_emty_p = "Add Province And Submit";
    }
  }

  if(isset($_POST["submit4"])){
    /*----------get form data------------------------*/
    $distric = $con->real_escape_string($_POST['dist']);
    if(!empty($distric)){
      /*-----------insert new catagory-------------*/
      $insert_dist = "INSERT INTO delivery_district (delivery_district_name, delivery_district_cord)
      VALUES('$distric', NULL)";
      $insert_dist_result = mysqli_query($con, $insert_dist) or die (mysqli_error($con));

      /*------load setting.php-------*/
      header('Location: setting.php');

    }else{
      $error_emty_d = "Add District And Submit";
    }
  }

  if(isset($_POST["submit5"])){
    /*----------get form data------------------------*/
    $kg1 = $con->real_escape_string($_POST['1kg']);
    $f15kg = $con->real_escape_string($_POST['15kg']);
    $kg2 = $con->real_escape_string($_POST['2kg']);
    $kg3 = $con->real_escape_string($_POST['3kg']);
    $kg5 = $con->real_escape_string($_POST['5kg']);
    if(!empty($kg1) && !empty($f15kg) && !empty($kg2) && !empty($kg3) && !empty($kg5)){
      /*-----------up date price cost-------------*/
      $update_price_cost = "UPDATE price_box_details SET price_box_details_1kg='$kg1', price_box_details_1_5kg='$f15kg', price_box_details_2kg='$kg2', price_box_details_3kg='$kg3', price_box_details_5kg='$kg5' WHERE price_box_details_id='1'";
      $update_price_cost_result = mysqli_query($con, $update_price_cost) or die (mysqli_error($con));

      /*------load setting.php-------*/
      header('Location: setting.php');

    }else{
      $error_emty_pbc = "Fill All Filed And Submit";
    }
  }

  if(isset($_POST["submit6"])){
    /*----------get form data------------------------*/
    $email = $con->real_escape_string($_POST['email']);
    $tel = $con->real_escape_string($_POST['tel']);
    $city = $con->real_escape_string($_POST['city']);
    $open = $con->real_escape_string($_POST['open']);
    $addres = $con->real_escape_string($_POST['addres']);
    $story1 = $con->real_escape_string($_POST['ours1']);
    $story2 = $con->real_escape_string($_POST['ours2']);
    if(!empty($email) && !empty($tel) && !empty($city) && !empty($open) && !empty($addres) && !empty($story1) && !empty($story2)){
      if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        /*-----------up date price cost-------------*/
        $update_com_details = "UPDATE serprise SET serprise_email='$email', serprise_tlp='$tel', serprise_addres='$addres', serprise_country_city='$city', serprise_open_time='$open', serprise_about_story='$story1', serprise_about_story2='$story2' WHERE serprise_id='1'";
        $update_com_details_result = mysqli_query($con, $update_com_details) or die (mysqli_error($con));

        /*------load setting.php-------*/
        header('Location: setting.php');
      }else{
        $error_cd = "Enter Valid Email";
      }
    }else{
      $error_emty_cd = "Fill All Filed And Submit";
    }
  }
  
  
  if(isset($_POST["submit7"])){
    /*------get form data-------*/
    $about_img1= $con->real_escape_string('../serprise/img/about/about'.$_FILES['aboutimg1']['name']);
    if(preg_match("!image!",$_FILES['aboutimg1']['type'])){
      if(copy($_FILES['aboutimg1']['tmp_name'], $about_img1)){
        /*-----------up date item details-------------*/
        $update_about_img = "UPDATE serprise SET serprise_about_img1='$about_img1' WHERE serprise_id='1'";
        $update_about_img_result = mysqli_query($con, $update_about_img) or die (mysqli_error($con));

        /*------load setting.php-------*/
        header('Location: setting.php');
      }else{
        $error_emty_img1 ="Can't Add Image";
      }
    }else{
      $error_emty_img1 ="Plese Select Valid Image Image";
    }
   }

   if(isset($_POST["submit8"])){
    /*------get form data-------*/
    $about_img2= $con->real_escape_string('../serprise/img/about/about2'.$_FILES['aboutimg2']['name']);
    if(preg_match("!image!",$_FILES['aboutimg2']['type'])){
      if(copy($_FILES['aboutimg2']['tmp_name'], $about_img2)){
        /*-----------up date item details-------------*/
        $update_about_img = "UPDATE serprise SET serprise_about_img2='$about_img2' WHERE serprise_id='1'";
        $update_about_img_result = mysqli_query($con, $update_about_img) or die (mysqli_error($con));

        /*------load setting.php-------*/
        header('Location: setting.php');
      }else{
        $error_emty_img2 ="Can't Add Image";
      }
    }else{
      $error_emty_img2 ="Plese Select Valid Image Image";
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
          <li class="active ">
            <a href="user.php">
              <i class="nc-icon nc-single-02"></i>
              <p>Settings</p>
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
            <a class="navbar-brand" href="">Settings </a>
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
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-10">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Flash Date Update & Flash Details Edit</h5>
              </div>
                <p class="error"><?PHP echo $error_emty. ' '.$error; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                      <label>New Flash Exper Date</label>
                        <input type="date" name="ex_date" class="form-control" value="<?PHP echo $today;?>" min="<?PHP echo $today;?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Discount</label>
                        <input type="number" name="discount" class="form-control" value="0">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit1" class="btn btn-primary btn-round">Update Flash</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Add Catagory</h5>
              </div>
                <p class="error"><?PHP echo $error_emty_c.' '. $error_c; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                      <label>Catagory Code (Eg.:car001)</label>
                        <input type="text" name="catacode" class="form-control" placeholder="car001">
                      </div>
                    </div>
                    <div class="col-md-5 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Catagory Name</label>
                        <input type="text" name="cataname" class="form-control" placeholder="Surprise Card">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Catagory Image (362 x 270 size)</label>
                        <input type="file" name="cataimg" class="form-control" accept="image/*" >
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit2" class="btn btn-primary btn-round">Add Catagory</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Catagory List</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        Catagory code
                      </th>
                      <th>
                        Catagory Name
                      </th>
                      <th>
                        Avalebel Item
                      </th>
                      <th class="text-right">
                        
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        $number = 0;
                         while ($cata_row = $cata_result-> fetch_assoc()){
                          $cata_id = $cata_row['item_catagory_id'];
                          $number = $number + 1;

                          echo '<tr>
                          <td>
                            '.$number.'
                          </td>
                          <td>
                            '.$cata_row['item_catagory_code'].'
                          </td>
                          <td>
                            '.$cata_row['item_catagory_name'].'
                          </td>
                          <td>
                            '.$cata_row['item_catagory_count'].'
                          </td>';
                          if($cata_row['item_catagory_count'] <= 0){
                            echo '<td class="text-right">
                              <a href="exphp/catagoryRemove.php?caid='.$cata_id.'"><button type="button" class="shipp_button">Remove</button></a>
                            </td>';
                          }else{
                            echo '<td class="text-right">
                              <a href="#"><button type="button" class="shipp_button">Remove</button></a>
                            </td>';
                          }
                         }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Add Province</h5>
              </div>
                <p class="error"><?PHP echo $error_emty_p; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-11 pr-1">
                      <div class="form-group">
                      <label>Province</label>
                        <input type="text" name="pro" class="form-control" placeholder="Province">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit3" class="btn btn-primary btn-round">Add </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Add District</h5>
              </div>
                <p class="error"><?PHP echo $error_emty_d; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-11 pr-1">
                      <div class="form-group">
                      <label>District</label>
                        <input type="text" name="dist" class="form-control" placeholder="District">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit4" class="btn btn-primary btn-round">Add </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Province List</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        Province
                      </th>
                      <th class="text-right">
                        
                      </th>
                    </thead>
                    <tbody>
                    <?php
                        $number2 = 0;
                         while ($province_row = $province_list_result-> fetch_assoc()){
                          $number2 = $number2 + 1;
                          $pro_id = $province_row['delivery_provins_id'];
                          echo '<tr>
                          <td>
                            '.$number2.'
                          </td>
                          <td>
                            '.$province_row['delivery_provins_name'].'
                          </td>
                            <td class="text-right">
                              <a href="exphp/proRemove.php?proid='.$pro_id.'"><button type="button" class="shipp_button">Remove</button></a>
                            </td>';
                         }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> District List</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        District
                      </th>
                      <th class="text-right">
                        
                      </th>
                    </thead>
                    <tbody>
                    <?php
                        $number3 = 0;
                         while ($dist_row = $distric_list_result-> fetch_assoc()){
                          $number3 = $number3 + 1;
                          $dist_id = $dist_row['delivery_district_id'];
                          echo '<tr>
                          <td>
                            '.$number3.'
                          </td>
                          <td>
                            '.$dist_row['delivery_district_name'].'
                          </td>
                            <td class="text-right">
                              <a href="exphp/distRemove.php?disid='.$dist_id.'"><button type="button" class="shipp_button">Remove</button></a>
                            </td>';
                         }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Update Price Box Cost</h5>
              </div>
                <p class="error"><?PHP echo $error_emty_pbc; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                        <label>1Kg (Cost)</label>
                          <input type="number" name="1kg" class="form-control" value="<?PHP echo $update_pri_cost_row['price_box_details_1kg']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>1.5Kg (Cost)</label>
                        <input type="number" name="15kg" class="form-control" value="<?PHP echo $update_pri_cost_row['price_box_details_1_5kg']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>2Kg (Cost)</label>
                        <input type="number" name="2kg" class="form-control" value="<?PHP echo $update_pri_cost_row['price_box_details_2kg']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                        <label>3Kg (Cost)</label>
                          <input type="number" name="3kg" class="form-control" value="<?PHP echo $update_pri_cost_row['price_box_details_3kg']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>5Kg (Cost)</label>
                        <input type="number" name="5kg" class="form-control" value="<?PHP echo $update_pri_cost_row['price_box_details_5kg']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit5" class="btn btn-primary btn-round">Update Cost</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-10">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Update Company Details</h5>
              </div>
                <p class="error"><?PHP echo $error_emty_cd.' '.$error_cd; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-5 pl-3">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $update_com_d_row['serprise_email']; ?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label>Tel: Number</label>
                        <input type="text" name="tel" class="form-control" value="<?PHP echo $update_com_d_row['serprise_tlp']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>City / Cuntry</label>
                        <input type="text" name="city" class="form-control" value="<?PHP echo $update_com_d_row['serprise_country_city']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Open Time</label>
                          <input type="text" name="open" class="form-control" value="<?PHP echo $update_com_d_row['serprise_open_time']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 pl-3">
                      <div class="form-group">
                        <label>Address</label>
                        <textarea class="form-control" rows="6" cols="50" name="addres"><?PHP echo $update_com_d_row['serprise_addres']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 pl-3">
                      <div class="form-group">
                        <label>Our Story (01)</label>
                        <textarea class="form-control" rows="6" cols="50" name="ours1"><?PHP echo $update_com_d_row['serprise_about_story']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 pl-3">
                      <div class="form-group">
                        <label>Our Story (02)</label>
                        <textarea class="form-control" rows="6" cols="50" name="ours2"><?PHP echo $update_com_d_row['serprise_about_story2']; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit6" class="btn btn-primary btn-round">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card card-user">
                <p class="error"><?PHP echo $error_emty_img1; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-11 pr-1">
                      <div class="form-group">
                      <label>Abount Img 01</label>
                        <input type="file" name="aboutimg1" class="form-control" accept="image/*">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit7" class="btn btn-primary btn-round">Add </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card card-user">
                <p class="error"><?PHP echo $error_emty_img2; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-11 pr-1">
                      <div class="form-group">
                      <label>Abount Img 02</label>
                        <input type="file" name="aboutimg2" class="form-control" accept="image/*">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit8" class="btn btn-primary btn-round">Add </button>
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
