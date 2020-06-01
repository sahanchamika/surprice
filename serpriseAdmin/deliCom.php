<?PHP include 'conection.php' ?>
<?PHP
  session_start();
  $error_c ="";
  $error_up_c ="";
  $error_new_c ="";
  $today = date("Y-m-d");
  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

   /*---------------------user feedback count-----------------------*/
   $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
   $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
   $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------------chat count-----------------------*/
  $chat_count = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_resever = '$log_user_id' AND chat_state = 'Active'";
  $chat_count_result = mysqli_query($con, $chat_count) or die (mysqli_error($con));
  $chat_count_row = $chat_count_result-> fetch_assoc();

  /*---------------------delivery compasny  list-----------------------*/
  $deli_com_list = "SELECT * FROM delivery_company";
  $deli_com_list_result = mysqli_query($con, $deli_com_list) or die (mysqli_error($con));

   /*---------------------delivery compasny cost list-----------------------*/
   $deli_com_cost_list = "SELECT * FROM delivery_company_cost";
   $deli_com_cost_list_result = mysqli_query($con, $deli_com_cost_list) or die (mysqli_error($con));

  /*---------------------delivery compasny select list-----------------------*/
  $deli_com_select_list = "SELECT * FROM delivery_company ORDER BY delivery_company_id ASC";
  $deli_com_select_list_result = mysqli_query($con, $deli_com_select_list) or die (mysqli_error($con));
 

  if(isset($_POST["submit"])){
    /*------get form data-------*/
    $com_name=$con->real_escape_string($_POST["c_name"]);
    $com_email=$con->real_escape_string($_POST["c_email"]);
    $com_tel=$con->real_escape_string($_POST["c_tel"]);
    
    /*------form validation-------*/
    if(!empty($com_name) && !empty($com_email) && !empty($com_tel)){
      if (filter_var($com_email, FILTER_VALIDATE_EMAIL)) {
        if(preg_match("/^[0-9]{3} [0-9]{7}$/", $com_tel)){
            $insert_deli_com = "INSERT INTO delivery_company (delivery_company_name, delivery_company_email, delivery_company_tel)
            VALUES('$com_name', '$com_email', '$com_tel')";
            $insert_deli_com_result = mysqli_query($con, $insert_deli_com) or die (mysqli_error($con));

            /*---------------------deli com id-----------------------*/
            $deli_com_id_get = "SELECT * FROM delivery_company WHERE delivery_company_name = '$com_name'";
            $deli_com_id_get_result = mysqli_query($con, $deli_com_id_get) or die (mysqli_error($con));
            $deli_com_id_get_row = $deli_com_id_get_result-> fetch_assoc();
            $deli_id = $deli_com_id_get_row['delivery_company_id'];

            $insert_new_com = "INSERT INTO delivery_company_cost (company_id, cost_0_250g, cost_250_500g, cost_500_750g, cost_750_1000g, cost_1000_1500g, cost_1500_2000g, cost_2000_3000g, cost_3000_5000g, cost_5000_maxg)
            VALUES('$deli_id', '0', '0', '0', '0', '0', '0', '0', '0', '0')";
            $insert_new_com_result = mysqli_query($con, $insert_new_com) or die (mysqli_error($con));

            if(mysqli_num_rows($insert_deli_com_result) > 0){
              $error_c = 'Can not insert';
            }else{
            /*--------------load delicom-------------------*/
              header("location: deliCom.php");
            }
          }else{
            $error_c ="Enter Valid Number";
          } 
      }else{
        $error_c ="Enter Valid Email";
      }
    }else{
      $error_c ="Fill All Fild & Submit";
    }
   }

   if(isset($_POST["submit2"])){
    /*------get form data-------*/
    $deli_company=$con->real_escape_string($_POST["deli_com"]);
    $deli_wight=$con->real_escape_string($_POST["wight"]);
    $deli_cost=$con->real_escape_string($_POST["com_cost"]);
    
    /*------form validation-------*/
    if(!empty($deli_company) && !empty($deli_wight) && !empty($deli_cost)){
      if($deli_wight == 1){
        /*-----------up date user details-------------*/
        $update_cost = "UPDATE delivery_company_cost SET cost_0_250g='$deli_cost' WHERE company_id='$deli_company'";
        $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
      }else{
        if($deli_wight == 2){
          /*-----------up date user details-------------*/
          $update_cost = "UPDATE delivery_company_cost SET cost_250_500g='$deli_cost' WHERE company_id='$deli_company'";
          $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
        }else{
          if($deli_wight == 3){
            /*-----------up date user details-------------*/
            $update_cost = "UPDATE delivery_company_cost SET cost_500_750g='$deli_cost' WHERE company_id='$deli_company'";
            $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
          }else{
            if($deli_wight == 4){
              /*-----------up date user details-------------*/
              $update_cost = "UPDATE delivery_company_cost SET cost_750_1000g='$deli_cost' WHERE company_id='$deli_company'";
              $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
            }else{
              if($deli_wight == 5){
                /*-----------up date user details-------------*/
                $update_cost = "UPDATE delivery_company_cost SET cost_1000_1500g='$deli_cost' WHERE company_id='$deli_company'";
                $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
              }else{
                if($deli_wight == 6){
                  /*-----------up date user details-------------*/
                  $update_cost = "UPDATE delivery_company_cost SET cost_1500_2000g='$deli_cost' WHERE company_id='$deli_company'";
                  $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
                }else{
                  if($deli_wight == 7){
                    /*-----------up date user details-------------*/
                    $update_cost = "UPDATE delivery_company_cost SET cost_2000_3000g='$deli_cost' WHERE company_id='$deli_company'";
                    $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
                  }else{
                    if($deli_wight == 8){
                      /*-----------up date user details-------------*/
                      $update_cost = "UPDATE delivery_company_cost SET cost_3000_5000g='$deli_cost' WHERE company_id='$deli_company'";
                      $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
                    }else{
                      if($deli_wight == 9){
                        /*-----------up date user details-------------*/
                        $update_cost = "UPDATE delivery_company_cost SET cost_5000_maxg='$deli_cost' WHERE company_id='$deli_company'";
                        $update_cost_result = mysqli_query($con, $update_cost) or die (mysqli_error($con));
                      }else{
                        $error_up_c = 'Invalid Selection';
                      }  
                    }  
                  }  
                }
              }  
            }  
          }  
        }  
      }

      if(mysqli_num_rows($update_cost_result) > 0){
        $error_up_c = 'Can not insert';
      }else{
      /*--------------load delicom-------------------*/
        header("location: deliCom.php");
      }
    }else{
      $error_up_c ="Fill All Fild & Submit";
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
  <!----------side bar------>
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
          <li>
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
          <li class="active">
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
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#">Delivary Company</a>
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
      <!----------item order tabel---------->
      <div class="content">
        <div class="row">
          <div class="col-md-10">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Delivary Company</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        Company Id
                      </th>
                      <th>
                        Company Name
                      </th>
                      <th>
                        Company Email
                      </th>
                      <th>
                        Company Tel:
                      </th>
                      <th class="text-right">
                        
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        $number = 0;
                        while ($deli_com_list_row = $deli_com_list_result-> fetch_assoc()){
                          $number = $number +1;
                          $deli_com_id = $deli_com_list_row['delivery_company_id'];
                          echo'<tr>
                            <td>
                              '.$number.'
                            </td>
                            <td>
                              '.$deli_com_id.'
                            </td>
                            <td>
                              '.$deli_com_list_row['delivery_company_name'].'
                            </td>
                            <td>
                              '.$deli_com_list_row['delivery_company_email'].'
                            </td>
                            <td>
                              '.$deli_com_list_row['delivery_company_tel'].'
                            </td>
                            <td class="text-right">
                              <a href="exphp/deliComRemove.php?comid='.$deli_com_id.'"><button type="button" class="shipp_button">Remove</button></a>
                            </td>
                          </tr>';
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
                <h5 class="card-title">Add Company</h5>
              </div>
              <p class="error"><?PHP echo $error_c; ?></p>
              <div class="card-body">
                <form action="deliCom.php" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                      <label>Company Name</label>
                        <input type="text" name="c_name" class="form-control" placeholder="Company Name">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Company Email</label>
                        <input type="email" name="c_email" class="form-control" placeholder="Email">
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Company Tel:</label>
                        <input type="text" name="c_tel" class="form-control" placeholder="Number">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Add Company</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Delivary Company Cost</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Company
                      </th>
                      <th>
                        Cost 0/250g
                      </th>
                      <th>
                      Cost 250/500g
                      </th>
                      <th>
                      Cost 500/750g
                      </th>
                      <th>
                        Cost 750/1000g
                      </th>
                      <th>
                        Cost 1000/1500g
                      </th>
                      <th>
                        Cost 1500/2000g
                      </th>
                      <th>
                        Cost 2000/3000g
                      </th>
                      <th>
                        Cost 3000/5000g
                      </th>
                      <th class="text-right">
                        Cost 5000/(more)g
                      </th>
                    </thead>
                    <tbody>
                        <?php
                          while ($deli_com_cost_list_row = $deli_com_cost_list_result-> fetch_assoc()){
                            $deli_com_id = $deli_com_cost_list_row['company_id'];
                            /*---------------------delivery company name----------------------*/
                            $deli_com_name = "SELECT * FROM delivery_company WHERE delivery_company_id = '$deli_com_id'";
                            $deli_com_name_result = mysqli_query($con, $deli_com_name) or die (mysqli_error($con));
                            $deli_com_name_row = $deli_com_name_result-> fetch_assoc();
                            echo'<tr>
                              <td>
                                '.$deli_com_name_row['delivery_company_name'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_0_250g'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_250_500g'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_500_750g'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_750_1000g'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_1000_1500g'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_1500_2000g'].'
                              </td>
                              <td>
                                '.$deli_com_cost_list_row['cost_2000_3000g'].'
                              </td>
                              <td>
                                Rs: '.$deli_com_cost_list_row['cost_3000_5000g'].'
                              </td>
                              <td class="text-right">
                                Rs: '.$deli_com_cost_list_row['cost_5000_maxg'].'
                              </td>
                            </tr>';
                          }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Update Company Cost</h5>
              </div>
              <p class="error"><?PHP echo $error_up_c; ?></p>
              <div class="card-body">
                <form action="deliCom.php" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                      <label>Company</label>
                        <select class="form-control" name="deli_com">
                          <?php
                            echo'<option value="0">No Select</option>';
                            while($deli_com_select_list_row = $deli_com_select_list_result-> fetch_assoc()){
                              echo'<option value="'.$deli_com_select_list_row['delivery_company_id'].'">'.$deli_com_select_list_row['delivery_company_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Weight</label>
                        <select class="form-control" name="wight">
                          <option value="0">No Select</option>
                          <option value="1">Cost 0/250g</option>
                          <option value="2">Cost 250/500g</option>
                          <option value="3">Cost 500/750g</option>
                          <option value="4">Cost 750/1000g</option>
                          <option value="5">Cost 1000/1500g</option>
                          <option value="6">Cost 1500/2000g</option>
                          <option value="7">Cost 2000/3000g</option>
                          <option value="8">Cost 3000/5000g</option>
                          <option value="9">Cost 5000/(more)g</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 px-1">
                      <div class="form-group">
                        <label>Company Cost:</label>
                        <input type="number" name="com_cost" class="form-control" value="0">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit2" class="btn btn-primary btn-round">Add Company</button>
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
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="../serpriseCreater/add.php" target="_blank">Suprisc.lk team </a>
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="js/core/jquery.min.js"></script>
  <script src="js/core/bootstrap.min.js"></script>
  <script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="js/plugins/chartjs.min.js"></script>
  <script src="js/plugins/bootstrap-notify.js"></script>
  <script src="js/paper-dashboard.min.js" type="text/javascript"></script>
  <script src="demo/demo.js"></script>
  <script type='text/javascript'>
      
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

</php>
