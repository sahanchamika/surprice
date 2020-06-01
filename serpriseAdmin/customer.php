<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------user tabel customer--------------------*/
  $customer = "SELECT * FROM user WHERE user_status= 'user'";
  $customer_result = mysqli_query($con, $customer) or die (mysqli_error($con));

  /*---------------user tabel admin--------------------*/
  $admin = "SELECT * FROM user WHERE user_status= 'admin'";
  $admin_result = mysqli_query($con, $admin) or die (mysqli_error($con));

  /*---------------user tabel creater--------------------*/
  $creater = "SELECT * FROM creator";
  $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));

  /*---------------------user feedback count-----------------------*/
  $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
  $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
  $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------------chat count-----------------------*/
  $chat_count = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_resever = '$log_user_id' AND chat_state = 'Active'";
  $chat_count_result = mysqli_query($con, $chat_count) or die (mysqli_error($con));
  $chat_count_row = $chat_count_result-> fetch_assoc();


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
          <li class="active">
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
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Customer Details</a>
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Customer</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Number
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        Customer Name
                      </th>
                      <th>
                        Customer Username
                      </th>
                      <th>
                        Customer Member Ship
                      </th>
                      <th>
                        Province
                      </th>
                      <th>
                        Distric
                      </th>
                      <th>
                        Address
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Tel Number
                      </th>
                      <th>
                        Gender
                      </th>
                      <th>
                        Payment Type
                      </th>
                      <th>
                        Birthday
                      </th>
                      <th class="text-right">
                        Total Revanue
                      </th>
                    </thead>
                    <tbody>
                    <?php
                    $number = 0;
                     /*--------------------user tabel have customer-------------------------*/ 
                     if(mysqli_num_rows($customer_result) > 0){
                      while ($customer_row = $customer_result-> fetch_assoc()){
                        $number = $number + 1;
                        $user_id = $customer_row['user_id'];
                          /*------------get user revanue-------------*/
                          $item_ship = "SELECT SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_user_id = '$user_id'";
                          $item_ship_result = mysqli_query($con, $item_ship) or die (mysqli_error($con));
                          $item_ship_row = $item_ship_result-> fetch_assoc();

                          /*------------get user revanue-------------*/
                          $flash_ship = "SELECT SUM(`flash_shipping_amount`) FROM flash_shipping WHERE flash_shipping_user_id = '$user_id'";
                          $flash_ship_result = mysqli_query($con, $flash_ship) or die (mysqli_error($con));
                          $flash_ship_row = $flash_ship_result-> fetch_assoc();

                          /*------------get user revanue-------------*/
                          $price_ship = "SELECT price_shipping_amount FROM price_shipping WHERE price_shipping_user_id= '$user_id' GROUP BY price_shipping_group_id";
                          $price_ship_result = mysqli_query($con, $price_ship) or die (mysqli_error($con));
                          $price_amount = 0;
                          while ($price_ship_row = $price_ship_result-> fetch_assoc()){
                            $price_amount =  $price_amount + $price_ship_row['price_shipping_amount'];
                          }
                          $total_amount = $item_ship_row['SUM(`item_shipping_amount`)'] + $flash_ship_row['SUM(`flash_shipping_amount`)'] + $price_amount;
                          echo '<tr>
                                  <td>
                                    '.$number.'
                                  </td>
                                  <td>
                                    <a href="exphp/cutomerRemove.php?cusid='.$user_id.'"><button type="button" class="shipp_button">Remove</button></a>
                                  </td>
                                  <td>
                                    '.$customer_row['user_full_name'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_username'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_menber_ship'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_province'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_distric'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_address'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_email'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_tel_number'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_gender'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_payment_type'].'
                                  </td>
                                  <td>
                                    '.$customer_row['user_dob'].'
                                  </td>
                                  <td class="text-right">
                                    Rs: '.$total_amount.'
                                  </td>
                                </tr>';
                      }
                     }else{
                      echo'<h3 class="no_error">No Customer Register</h3>';
                     }
                    ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Admin</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Number
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        Admin Id
                      </th>
                      <th>
                        Admin Name
                      </th>
                      <th>
                        Admin Username
                      </th>
                      <th>
                        Province
                      </th>
                      <th>
                        Distric
                      </th>
                      <th>
                        Address
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Gender
                      </th>
                      <th>
                        Birthday
                      </th>
                      <th class="text-right">
                        Tel Number
                      </th>
                    </thead>
                    <tbody>
                    <?php
                    $number = 0;
                     /*--------------------user tabel have admin-------------------------*/ 
                     if(mysqli_num_rows($admin_result) > 0){
                      while ($admin_row = $admin_result-> fetch_assoc()){
                        $number = $number + 1;
                        $admin_id = $admin_row ['user_id'];
                          echo '<tr>
                                  <td>
                                    '.$number.'
                                  </td>
                                  <td>
                                    <a href="exphp/cutomerRemove.php?cusid='.$admin_id.'"><button type="button" class="shipp_button">Remove</button></a>
                                  </td>
                                  <td>
                                    '.$admin_id.'
                                  </td>
                                  <td>
                                    '.$admin_row['user_full_name'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_username'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_province'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_distric'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_address'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_email'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_gender'].'
                                  </td>
                                  <td>
                                    '.$admin_row['user_dob'].'
                                  </td>
                                  <td class="text-right">
                                   '.$admin_row['user_tel_number'].'
                                  </td>
                                </tr>';
                      }
                     }else{
                      echo'<h3 class="no_error">No Admin Register</h3>';
                     }
                    ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Creater</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Number
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        Creater Name
                      </th>
                      <th>
                        Creater Username
                      </th>
                      <th>
                        Address
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Gender
                      </th>
                      <th>
                        Tel Number
                      </th>
                      <th>
                        Sold Item
                      </th>
                      <th class="text-right">
                        Total Item
                      </th>
                    </thead>
                    <tbody>
                    <?php
                    $number = 0;
                     /*--------------------user tabel have admin-------------------------*/ 
                     if(mysqli_num_rows($creater_result) > 0){
                      while ($creater_row = $creater_result-> fetch_assoc()){
                        $number = $number + 1;
                        $creater_id = $creater_row['creator_id'];
                          echo '<tr>
                                  <td>
                                    '.$number.'
                                  </td>
                                  <td>
                                    <a href="exphp/createrRemove.php?creid='.$creater_id.'"><button type="button" class="shipp_button">Remove</button></a>
                                  </td>
                                  <td>
                                    '.$creater_row['creator_name'].'
                                  </td>
                                  <td>
                                    '.$creater_row['creator_username'].'
                                  </td>
                                  <td>
                                    '.$creater_row['creator_address'].'
                                  </td>
                                  <td>
                                    '.$creater_row['creator_email'].'
                                  </td>
                                  <td>
                                    '.$creater_row['creator_gender'].'
                                  </td>
                                  <td>
                                    '.$creater_row['creator_tel'].'
                                  </td>
                                  <td>
                                    '.$creater_row['creator_sold_iem'].'
                                  </td>
                                  <td class="text-right">
                                   '.$creater_row['creator_total_item'].'
                                  </td>
                                </tr>';
                      }
                     }else{
                      echo'<h3 class="no_error">No Creater Register</h3>';
                     }
                    ?> 
                    </tbody>
                  </table>
                </div>
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
