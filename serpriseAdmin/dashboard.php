<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------avalebel item count-----------------------*/
  $aval_item_count = "SELECT count(`item_id`) FROM item WHERE item_quantity > 0";
  $aval_item_count_result = mysqli_query($con, $aval_item_count) or die (mysqli_error($con));
  $aval_item_count_row = $aval_item_count_result-> fetch_assoc();

  /*---------------------total sold item quntity & total revenu calculate-----------------------*/
  $expire_date=date("Y-m-d",strtotime("-30 day"));
  $current_year = date("Y");

  $sold_item_total = "SELECT SUM(`item_shipping_quntity`), SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_date > '$expire_date'";
  $sold_item_total_result = mysqli_query($con, $sold_item_total) or die (mysqli_error($con));
  $sold_item_total_row = $sold_item_total_result-> fetch_assoc();

  $sold_flash_total = "SELECT SUM(`flash_shipping_quntity`), SUM(`flash_shipping_amount`)  FROM flash_shipping WHERE flash_shipping_date > '$expire_date'";
  $sold_flash_total_result = mysqli_query($con, $sold_flash_total) or die (mysqli_error($con));
  $sold_flash_total_row = $sold_flash_total_result-> fetch_assoc();

  $sold_price_total = "SELECT SUM(`price_shipping_quntity`) FROM price_shipping WHERE price_shipping_date > '$expire_date'";
  $sold_price_total_result = mysqli_query($con, $sold_price_total) or die (mysqli_error($con));
  $sold_price_total_row = $sold_price_total_result-> fetch_assoc();

  $price_re = "SELECT price_shipping_amount FROM price_shipping WHERE price_shipping_date > '$expire_date' GROUP BY price_shipping_group_id";
  $price_re_result = mysqli_query($con, $price_re) or die (mysqli_error($con));
  $total_price_re = 0;
  while ($price_re_row = $price_re_result-> fetch_assoc()){
    $total_price_re = $total_price_re + $price_re_row['price_shipping_amount'];
  }

  $slod_quntity = $sold_item_total_row['SUM(`item_shipping_quntity`)'] + $sold_flash_total_row['SUM(`flash_shipping_quntity`)'] + $sold_price_total_row['SUM(`price_shipping_quntity`)'];
  $total_reve = $total_price_re + $sold_flash_total_row['SUM(`flash_shipping_amount`)'] + $sold_item_total_row['SUM(`item_shipping_amount`)'];

  /*---------------------number of user-----------------------*/
  $user = "SELECT COUNT(`user_id`) FROM user WHERE user_status='user'";
  $user_result = mysqli_query($con, $user) or die (mysqli_error($con));
  $user_row = $user_result-> fetch_assoc();

   /*---------------------not shepping order-----------------------*/
   $order_item = "SELECT COUNT(`order_id`) FROM order_item ";
   $order_item_result = mysqli_query($con, $order_item) or die (mysqli_error($con));
   $order_item_row = $order_item_result-> fetch_assoc();

   $flash_item = "SELECT COUNT(`flash_order_id`) FROM flash_order ";
   $flash_item_result = mysqli_query($con, $flash_item) or die (mysqli_error($con));
   $flash_item_row = $flash_item_result-> fetch_assoc();

  $price_item = "SELECT * FROM price_box_order GROUP BY price_box_order_group_id";
  $price_item_result = mysqli_query($con, $price_item) or die (mysqli_error($con));
  $price_order_cont = 0;
  while ($price_item_row = $price_item_result-> fetch_assoc()){
    $price_order_cont = $price_order_cont + 1;
  }

  /*---------------------all sold item count-----------------------*/
  $sold_item_count = "SELECT COUNT(`item_id`) FROM item WHERE item_quantity <= 0";
  $sold_item_count_result = mysqli_query($con, $sold_item_count) or die (mysqli_error($con));
  $sold_item_count_row = $sold_item_count_result-> fetch_assoc();

  /*---------------------flash exper date-----------------------*/
  $flash_ex_day = "SELECT * FROM flash_sale_details LIMIT 1";
  $flash_ex_day_result = mysqli_query($con, $flash_ex_day) or die (mysqli_error($con));
  $flash_ex_day_row = $flash_ex_day_result-> fetch_assoc();
  $day1 = date_create($flash_ex_day_row['flash_sale_details_date']);
  $day2 = date_create(date("Y-m-d"));
  $day_count= date_diff($day2,$day1);
  $flash_ex = $day_count->format("%R%a days");

  /*---------------------user feedback count-----------------------*/
  $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
  $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
  $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------------chat count-----------------------*/
  $chat_count = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_resever = '$log_user_id' AND chat_state = 'Active'";
  $chat_count_result = mysqli_query($con, $chat_count) or die (mysqli_error($con));
  $chat_count_row = $chat_count_result-> fetch_assoc();
  
  /*---------------get dayle shipping revanue--------------------*/
  $limit_date_today=date("Y-m-d");
  $limit_date_yester=date("Y-m-d",strtotime("-1 day"));
  $limit_date_last=date("Y-m-d",strtotime("-2 day"));
  /*---------------get dayle item shipping revanue--------------------*/
  $item_revanue_last = "SELECT SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_date = '$limit_date_last'";
  $item_revanue_last_result = mysqli_query($con, $item_revanue_last) or die (mysqli_error($con));
  $item_revanue_last_row =  $item_revanue_last_result-> fetch_assoc();

  $item_revanue_yester = "SELECT SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_date = '$limit_date_yester'";
  $item_revanue_yester_result = mysqli_query($con, $item_revanue_yester) or die (mysqli_error($con));
  $item_revanue_yester_row =  $item_revanue_yester_result-> fetch_assoc();

  $item_revanue_today = "SELECT SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_date = '$limit_date_today'";
  $item_revanue_today_result = mysqli_query($con, $item_revanue_today) or die (mysqli_error($con));
  $item_revanue_today_row =  $item_revanue_today_result-> fetch_assoc();
  /*---------------get dayle flash shipping revanue--------------------*/
  $flash_revanue_today = "SELECT SUM(`flash_shipping_amount`) FROM flash_shipping WHERE flash_shipping_date = '$limit_date_today'";
  $flash_revanue_today_result = mysqli_query($con, $flash_revanue_today) or die (mysqli_error($con));
  $flash_revanue_today_row =  $flash_revanue_today_result-> fetch_assoc();

  $flash_revanue_yester = "SELECT SUM(`flash_shipping_amount`) FROM flash_shipping WHERE flash_shipping_date = '$limit_date_yester'";
  $flash_revanue_yester_result = mysqli_query($con, $flash_revanue_yester) or die (mysqli_error($con));
  $flash_revanue_yester_row =  $flash_revanue_yester_result-> fetch_assoc();

  $flash_revanue_last = "SELECT SUM(`flash_shipping_amount`) FROM flash_shipping WHERE flash_shipping_date = '$limit_date_last'";
  $flash_revanue_last_result = mysqli_query($con, $flash_revanue_last) or die (mysqli_error($con));
  $flash_revanue_last_row =  $flash_revanue_last_result-> fetch_assoc();
  /*---------------get dayle price shipping revanue--------------------*/
  $price_revanue_today = "SELECT price_shipping_amount FROM price_shipping WHERE price_shipping_date = '$limit_date_today' GROUP BY price_shipping_group_id";
  $price_revanue_today_result = mysqli_query($con, $price_revanue_today) or die (mysqli_error($con));
  $price_revanue_today1 = 0;
  while ($price_revanue_today_row = $price_revanue_today_result-> fetch_assoc()){
    $price_revanue_today1 = $price_revanue_today1 + $price_revanue_today_row['price_shipping_amount'];
  }

  $price_revanue_yester = "SELECT price_shipping_amount FROM price_shipping WHERE price_shipping_date = '$limit_date_yester' GROUP BY price_shipping_group_id";
  $price_revanue_yester_result = mysqli_query($con, $price_revanue_yester) or die (mysqli_error($con));
  $price_revanue_yester1 = 0;
  while ($price_revanue_yester_row = $price_revanue_yester_result-> fetch_assoc()){
    $price_revanue_yester1 = $price_revanue_yester1 + $price_revanue_yester_row['price_shipping_amount'];
  }

  $price_revanue_last = "SELECT price_shipping_amount FROM price_shipping WHERE price_shipping_date = '$limit_date_last'  GROUP BY price_shipping_group_id";
  $price_revanue_last_result = mysqli_query($con, $price_revanue_last) or die (mysqli_error($con));
  $price_revanue_last1 = 0;
  while ($price_revanue_last_row = $price_revanue_last_result-> fetch_assoc()){
    $price_revanue_last1 = $price_revanue_last1 + $price_revanue_last_row['price_shipping_amount'];
  }

  /*---------------------total month revanue-----------------------*/
  $total_month_rev = "SELECT * FROM revanue WHERE revanue_type = 'total' AND revanue_year = '$current_year'";
  $total_month_rev_result = mysqli_query($con, $total_month_rev) or die (mysqli_error($con));
  $total_month_rev_row = $total_month_rev_result-> fetch_assoc();
  /*---------------------item month revanue-----------------------*/
  $item_month_rev = "SELECT * FROM revanue WHERE revanue_type = 'item' AND revanue_year = '$current_year'";
  $item_month_rev_result = mysqli_query($con, $item_month_rev) or die (mysqli_error($con));
  $item_month_rev_row = $item_month_rev_result-> fetch_assoc();
  /*---------------------flash month revanue-----------------------*/
  $flash_month_rev = "SELECT * FROM revanue WHERE revanue_type = 'flash' AND revanue_year = '$current_year'";
  $flash_month_rev_result = mysqli_query($con, $flash_month_rev) or die (mysqli_error($con));
  $flash_month_rev_row = $flash_month_rev_result-> fetch_assoc();
  /*---------------------price month revanue-----------------------*/
  $price_month_rev = "SELECT * FROM revanue WHERE revanue_type = 'price' AND revanue_year = '$current_year'";
  $price_month_rev_result = mysqli_query($con, $price_month_rev) or die (mysqli_error($con));
  $price_month_rev_row = $price_month_rev_result-> fetch_assoc();
  
  $current_munth = date("n");
  $count3 = 0;
  $cre_rev_1 = 0;
  $cre_nam_1 = "";
  $cre_rev_2 = 0;
  $cre_nam_2 = "";
  $cre_rev_3 = 0;
  $cre_nam_3 = "";
  $cre_rev_4 = 0;
  $cre_nam_4 = "";
  $cre_rev_5 = 0;
  $cre_nam_5 = "";
  $cre_rev_6 = 0;
  $cre_nam_6 = "";
  $creator_revanue = "SELECT SUM(`m_$current_munth`), item_by_revanue_item_creator_id FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id LIMIT 6";
  $creator_revanue_result = mysqli_query($con, $creator_revanue) or die (mysqli_error($con));
  while ($creator_revanue_row = $creator_revanue_result-> fetch_assoc()){
    $count3 = $count3 + 1;
    $item_by_revanue_item_creator_id = $creator_revanue_row['item_by_revanue_item_creator_id'];
    /*---------------------get creater table-----------------------*/
    $creater_ditails = "SELECT * FROM creator WHERE creator_id = '$item_by_revanue_item_creator_id'";
    $creater_ditails_result = mysqli_query($con, $creater_ditails) or die (mysqli_error($con));
    $creater_ditails_row = $creater_ditails_result-> fetch_assoc();

    if($count3 == 1){
      $cre_rev_1 = $creator_revanue_row['SUM(`m_'.$current_munth.'`)'];
      $cre_nam_1 = $creater_ditails_row['creator_name'];
    }else{
      if($count3 == 2){
        $cre_rev_2 = $creator_revanue_row['SUM(`m_'.$current_munth.'`)'];
        $cre_nam_2 = $creater_ditails_row['creator_name'];
      }else{
        if($count3 == 3){
          $cre_rev_3 = $creator_revanue_row['SUM(`m_'.$current_munth.'`)'];
          $cre_nam_3 = $creater_ditails_row['creator_name'];
        }else{
          if($count3 == 4){
            $cre_rev_4 = $creator_revanue_row['SUM(`m_'.$current_munth.'`)'];
            $cre_nam_4 = $creater_ditails_row['creator_name'];
          }else{
            if($count3 == 5){
              $cre_rev_5 = $creator_revanue_row['SUM(`m_'.$current_munth.'`)'];
              $cre_nam_5 = $creater_ditails_row['creator_name'];
            }else{
              if($count3 == 6){
                $cre_rev_6 = $creator_revanue_row['SUM(`m_'.$current_munth.'`)'];
                $cre_nam_6 = $creater_ditails_row['creator_name'];
              }else{
                
              }
            }
          }
        }
      }
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
  <title>Surprise.lk/admin/dashboard</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="demo/demo.css" rel="stylesheet" />
</head>
<body class="">
  <!---------slide bar------------->
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
          <li class="active ">
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
            <a class="navbar-brand" href="">Dashboard</a>
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
     <!---------notification card------------->
      <div class="content">
        <div class="row">
          <!---------Avalabel Item card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="item.php"><i class="nc-icon text-warning nc-paper"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Avalabel Item</p>
                      <p class="card-title"><?php echo $aval_item_count_row['count(`item_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="item.php"> Go More</a> ( Item Types)
                </div>
              </div>
            </div>
          </div>
          <!---------Sold Item card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="report.php"><i class="nc-icon nc-bag-16 text-success"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Sold Item
                      </p>
                      <p class="card-title"><?php echo $slod_quntity; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                <a href=""><i class="fa fa-refresh"></i></a><a href="report.php"> Go More</a> (30 day left)
                </div>
              </div>
            </div>
          </div>
          <!---------Total Revanue card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="report.php"><i class="nc-icon nc-money-coins text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Total Revanue</p>
                      <p class="card-title"><?php echo $total_reve; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="report.php"> Go More</a> (30 day left)
                </div>
              </div>
            </div>
          </div>
          <!---------Total customer card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="customer.php"><i class="nc-icon nc-single-02 text-primary"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Total customer</p>
                      <p class="card-title"><?php echo $user_row['COUNT(`user_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="customer.php"> Go User Details</a>
                </div>
              </div>
            </div>
          </div>
          <!---------Not Ship Item card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="shiping.php"><i class="nc-icon nc-delivery-fast text-success"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Not Ship Item</p>
                      <p class="card-title"><?php echo  $order_item_row['COUNT(`order_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="shiping.php"> Shipp Now</a>
                </div>
              </div>
            </div>
          </div>
          <!---------Flash Not Ship card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="shiping.php"><i class="nc-icon nc-delivery-fast text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Not Flash Ship</p>
                      <p class="card-title"><?php echo $flash_item_row['COUNT(`flash_order_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="shiping.php"> Shipp Now</a>
                </div>
              </div>
            </div>
          </div>
          <!---------Not Ship Price card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="shiping.php"><i class="nc-icon nc-delivery-fast text-primary"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Not Ship Price </p>
                      <p class="card-title"><?php echo $price_order_cont; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="shiping.php"> Shipp Now</a>
                </div>
              </div>
            </div>
          </div>
          <!---------All Sold Item card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="report.php"><i class="nc-icon nc-alert-circle-i text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">All Sold Item</p>
                      <p class="card-title"><?php echo $sold_item_count_row['COUNT(`item_id`)'] ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="report.php"> Update Now</a>
                </div>
              </div>
            </div>
          </div>
          <!---------User Feedback card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="feedback.php"><i class="nc-icon nc-calendar-60 text-success"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">User Feedback</p>
                      <p class="card-title"><?php echo $user_fedb_count_row['COUNT(`user_feedback_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="feedback.php"> Go Now</a>
                </div>
              </div>
            </div>
          </div>
          <!---------Flash Exp.Date card------------->
          <?php
          /*------------check exper or not------------*/
            if($flash_ex > 0){
              /*------------not exper ------------*/
              echo '<div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card card-stats">
                  <div class="card-body ">
                    <div class="row">
                      <div class="col-5 col-md-4">
                        <div class="icon-big text-center icon-warning">
                          <a href="setting.php"><i class="nc-icon nc-bell-55 text-warning"></i></a>
                        </div>
                      </div>
                      <div class="col-7 col-md-8">
                        <div class="numbers">
                          <p class="card-category">Flash Exp.Date</p>
                          <p class="card-title">'.$flash_ex.'
                            <p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer ">
                    <hr>
                    <div class="stats">
                      <a href=""><i class="fa fa-refresh"></i></a><a href="setting.php"> Update Now</a> (Ex.date:'.$flash_ex_day_row['flash_sale_details_date'].')
                    </div>
                  </div>
                </div>
              </div>';
            }else{
              /*---------------exper-----------------*/
              echo '<div class="col-lg-4 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-body ">
                  <div class="row">
                    <div class="col-5 col-md-4">
                      <div class="icon-big text-center icon-warning">
                        <a href="setting.php"><i class="nc-icon nc-bell-55 text-danger"></i></a>
                      </div>
                    </div>
                    <div class="col-7 col-md-8">
                      <div class="numbers">
                        <p class="card-category" id="error_mess">Flash Exp.Date</p>
                        <p class="card-title" id="error_mess">'.$flash_ex.'
                          <p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer ">
                  <hr>
                  <div class="stats" id="error_mess">
                    <a href=""><i class="fa fa-refresh"></i></a><a href="setting.php"> Update Now</a> (Ex.date:'.$flash_ex_day_row['flash_sale_details_date'].')
                  </div>
                </div>
              </div>
            </div>';
            }
          ?>
         </div>
        <!----------daily revanue chart------------->
        <div class="row">
          <div class="col-md-12">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">Daly Revanue Chart</h5>
                <p class="card-category">Item, Flash & Price Total Daily Revanue</p>
              </div>
              <div class="card-body">
                <canvas id="daily_rev" width="400" height="100"></canvas>
              </div>
              <div class="card-footer">
                <div class="chart-legend">
                  <i class="fa fa-circle text-info"></i> Item Sale
                  <i class="fa fa-circle text-warning"></i> Flash Sale
                  <i class="fa fa-circle text-danger"></i> Price Sale
                </div>
                <hr/>
                <div class="stats">
                  <a onclick="refleshUser()" href="dashboard.php"><i class="fa fa-history"></i> Update To Today</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!----------monthly revanue chart------------->
        <div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">All Year Revanue Chart</h5>
                <p class="card-category">All Month Include in (<?php echo $current_year; ?>)</p>
              </div>
              <div class="card-body ">
                <canvas id=total_month_rev width="400" height="100"></canvas>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a onclick="refleshUser()" href="dashboard.php"><i class="fa fa-history"></i> Update To Today</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!----------top 6 creater revenive------------->
        <div class="row">
          <div class="col-md-4">
            <div class="card ">
              <div class="card-header ">
                <h5 class="card-title">This Month Top 6 Creater Revanue Chart</h5>
                <p class="card-category">Best Item Suplaer Performance</p>
              </div>
              <div class="card-body ">
                <canvas id="creater_rev"></canvas>
              </div>
              <div class="card-footer ">
                <div class="legend">
                  <i class="fa fa-circle" id="cre1"></i> <?php echo $cre_nam_1; ?>
                  <i class="fa fa-circle "id="cre2"></i> <?php echo $cre_nam_2; ?>
                  <i class="fa fa-circle "id="cre3"></i> <?php echo $cre_nam_3; ?>
                  <i class="fa fa-circle "id="cre4"></i> <?php echo $cre_nam_4; ?>
                  <i class="fa fa-circle "id="cre5"></i> <?php echo $cre_nam_5; ?>
                  <i class="fa fa-circle "id="cre6"></i> <?php echo $cre_nam_6; ?>
                </div>
                <hr>
                <div class="stats">
                  <a onclick="refleshUser()" href="dashboard.php"><i class="fa fa-history"></i> Update To Today</a>
                </div>
              </div>
            </div>
          </div>
          <!----------monthly revanue flash & item, price chart------------->
          <div class="col-md-8">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-title">Item, Flash & Price Monthly Revanue Chart</h5>
                <p class="card-category">All Month Individual Report Chart(<?php echo $current_year; ?>)</p>
              </div>
              <div class="card-body">
                <canvas id="i_p_f_hart" width="400" height="100"></canvas>
              </div>
              <div class="card-footer">
                <div class="chart-legend">
                  <i class="fa fa-circle text-info"></i> Item Sale
                  <i class="fa fa-circle text-warning"></i> Flash Sale
                  <i class="fa fa-circle text-danger"></i> Price Sale
                </div>
                <hr/>
                <div class="stats">
                  <a href="dashboard.php"><i class="fa fa-history"></i> Update To Today</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!----------footer---------->
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
  
  <script src="js/core/jquery.min.js"></script>
  <script src="js/core/bootstrap.min.js"></script>
  <script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>  
  <script src="js/plugins/chartjs.min.js"></script> 
  <script src="js/plugins/bootstrap-notify.js"></script> 
  <script src="js/paper-dashboard.min.js" type="text/javascript"></script>  
  <script src="demo/demo.js"></script>
  <script>
    //total revenue chart monthly
    var jan = "<?php echo $total_month_rev_row['m_1'] ?>";
    var feb = "<?php echo $total_month_rev_row['m_2'] ?>";
    var mar = "<?php echo $total_month_rev_row['m_3'] ?>";
    var apr = "<?php echo $total_month_rev_row['m_4'] ?>";
    var may = "<?php echo $total_month_rev_row['m_5'] ?>";
    var jun = "<?php echo $total_month_rev_row['m_6'] ?>";
    var jul = "<?php echo $total_month_rev_row['m_7'] ?>";
    var aug = "<?php echo $total_month_rev_row['m_8'] ?>";
    var sep = "<?php echo $total_month_rev_row['m_9'] ?>";
    var oct = "<?php echo $total_month_rev_row['m_10'] ?>";
    var nov = "<?php echo $total_month_rev_row['m_11'] ?>";
    var dec = "<?php echo $total_month_rev_row['m_12'] ?>";
      //get id
      ctx = document.getElementById('total_month_rev').getContext("2d");
      myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Des"],
          // chart line set
          datasets: [{
              borderColor: "#6bd098",
              backgroundColor: "#6bd098",
              pointRadius: 0,
              pointHoverRadius: 0,
              borderWidth: 3,
              //total value month vice
              data: [jan, feb, mar, apr, may, jun, jul, aug, sep, oct, nov, dec]
            },
          ]
        },
        options: {
          legend: {
            display: false
          },

          tooltips: {
            enabled: false
          },

          scales: {
            yAxes: [{
              //label set
              ticks: {
                fontColor: "#9f9f9f",
                beginAtZero: false,
                maxTicksLimit: 5,
              
              },
              //chart line
              gridLines: {
                drawBorder: false,
                zeroLineColor: "#ccc",
                color: 'rgba(255,255,255,0.05)'
              }

            }],
            //name set
            xAxes: [{
              barPercentage: 1.6,
              gridLines: {
                drawBorder: false,
                color: 'rgba(255,255,255,0.1)',
                zeroLineColor: "transparent",
                display: false,
              },
              ticks: {
                padding: 20,
                fontColor: "#9f9f9f"
              }
            }]
          },
        }
      });

      //top 6 creater revaneu
      var c1 = "<?php echo $cre_rev_1 ?>";
      var c2 = "<?php echo $cre_rev_2 ?>";
      var c3 = "<?php echo $cre_rev_3 ?>";
      var c4 = "<?php echo $cre_rev_4 ?>";
      var c5 = "<?php echo $cre_rev_5 ?>";
      var c6 = "<?php echo $cre_rev_6 ?>";
      
      ctx = document.getElementById('creater_rev').getContext("2d");
          myChart = new Chart(ctx, {
            type: 'pie',
            data: {
              labels: [1, 2, 3, 4, 5, 6],
              datasets: [{
                label: "",
                pointRadius: 0,
                pointHoverRadius: 0,
                backgroundColor: [
                  '#0041f5',
                  '#29f500',
                  '#00a0a0',
                  '#f89900',
                  '#f54500',
                  '#f50052'
                ],
                //display top 6 revaneu
                borderWidth: 0,
                data: [c1, c2, c3, c4, c5, c6]
              }]
            },

            options: {

              legend: {
                display: false
              },

              pieceLabel: {
                render: 'percentage',
                fontColor: ['white'],
                precision: 2
              },

              tooltips: {
                enabled: false
              },

              scales: {
                yAxes: [{

                  ticks: {
                    display: false
                  },
                  gridLines: {
                    drawBorder: false,
                    zeroLineColor: "transparent",
                    color: 'rgba(255,255,255,0.05)'
                  }

                }],

                xAxes: [{
                  barPercentage: 1.6,
                  gridLines: {
                    drawBorder: false,
                    color: 'rgba(255,255,255,0.1)',
                    zeroLineColor: "transparent"
                  },
                  ticks: {
                    display: false,
                  }
                }]
              },
            }
          });

          //item revenue chart monthly
          //item
          var item_jan = "<?php echo $item_month_rev_row['m_1'] ?>";
          var item_feb = "<?php echo $item_month_rev_row['m_2'] ?>";
          var item_mar = "<?php echo $item_month_rev_row['m_3'] ?>";
          var item_apr = "<?php echo $item_month_rev_row['m_4'] ?>";
          var item_may = "<?php echo $item_month_rev_row['m_5'] ?>";
          var item_jun = "<?php echo $item_month_rev_row['m_6'] ?>";
          var item_jul = "<?php echo $item_month_rev_row['m_7'] ?>";
          var item_aug = "<?php echo $item_month_rev_row['m_8'] ?>";
          var item_sep = "<?php echo $item_month_rev_row['m_9'] ?>";
          var item_oct = "<?php echo $item_month_rev_row['m_10'] ?>";
          var item_nov = "<?php echo $item_month_rev_row['m_11'] ?>";
          var item_dec = "<?php echo $item_month_rev_row['m_12'] ?>";
          //flash
          var flash_jan = "<?php echo $flash_month_rev_row['m_1'] ?>";
          var flash_feb = "<?php echo $flash_month_rev_row['m_2'] ?>";
          var flash_mar = "<?php echo $flash_month_rev_row['m_3'] ?>";
          var flash_apr = "<?php echo $flash_month_rev_row['m_4'] ?>";
          var flash_may = "<?php echo $flash_month_rev_row['m_5'] ?>";
          var flash_jun = "<?php echo $flash_month_rev_row['m_6'] ?>";
          var flash_jul = "<?php echo $flash_month_rev_row['m_7'] ?>";
          var flash_aug = "<?php echo $flash_month_rev_row['m_8'] ?>";
          var flash_sep = "<?php echo $flash_month_rev_row['m_9'] ?>";
          var flash_oct = "<?php echo $flash_month_rev_row['m_10'] ?>";
          var flash_nov = "<?php echo $flash_month_rev_row['m_11'] ?>";
          var flash_dec = "<?php echo $flash_month_rev_row['m_12'] ?>";
          //price
          var price_jan = "<?php echo $price_month_rev_row['m_1'] ?>";
          var price_feb = "<?php echo $price_month_rev_row['m_2'] ?>";
          var price_mar = "<?php echo $price_month_rev_row['m_3'] ?>";
          var price_apr = "<?php echo $price_month_rev_row['m_4'] ?>";
          var price_may = "<?php echo $price_month_rev_row['m_5'] ?>";
          var price_jun = "<?php echo $price_month_rev_row['m_6'] ?>";
          var price_jul = "<?php echo $price_month_rev_row['m_7'] ?>";
          var price_aug = "<?php echo $price_month_rev_row['m_8'] ?>";
          var price_sep = "<?php echo $price_month_rev_row['m_9'] ?>";
          var price_oct = "<?php echo $price_month_rev_row['m_10'] ?>";
          var price_nov = "<?php echo $price_month_rev_row['m_11'] ?>";
          var price_dec = "<?php echo $price_month_rev_row['m_12'] ?>";
          
          var speedCanvas = document.getElementById("i_p_f_hart");
           //flash data get
          var dataFirst = {
            data: [flash_jan, flash_feb, flash_mar, flash_apr, flash_may, flash_jun, flash_jul, flash_aug, flash_sep, flash_oct, flash_nov, flash_dec],
            fill: false,
            borderColor: '#fbc658',
            backgroundColor: 'transparent',
            pointBorderColor: '#fbc658',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8,
          };
           //item data get
          var dataSecond = {
            data: [item_jan, item_feb, item_mar, item_apr, item_may, item_jun, item_jul, item_aug, item_sep, item_oct, item_nov, item_dec],
            fill: false,
            borderColor: '#51CACF',
            backgroundColor: 'transparent',
            pointBorderColor: '#51CACF',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8
          };
           //price data get
          var datatherd = {
            data: [price_jan, price_feb, price_mar, price_apr, price_may, price_jun, price_jul, price_aug, price_sep, price_oct, price_nov, price_dec],
            fill: false,
            borderColor: 'brown',
            backgroundColor: 'transparent',
            pointBorderColor: 'brown',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8
          };

          var speedData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [dataFirst, dataSecond, datatherd]
          };

          var chartOptions = {
            legend: {
              display: false,
              position: 'top'
            }
          };

          var lineChart = new Chart(speedCanvas, {
            type: 'line',
            hover: false,
            data: speedData,
            options: chartOptions
          });

          var item_revanue_today = "<?php echo  $item_revanue_today_row['SUM(`item_shipping_amount`)'] ?>";
          var item_revanue_yester = "<?php echo $item_revanue_yester_row['SUM(`item_shipping_amount`)'] ?>";
          var item_revanue_last = "<?php echo  $item_revanue_last_row['SUM(`item_shipping_amount`)'] ?>";

          var flash_revanue_today = "<?php echo  $flash_revanue_today_row['SUM(`flash_shipping_amount`)'] ?>";
          var flash_revanue_yester = "<?php echo $flash_revanue_yester_row['SUM(`flash_shipping_amount`)'] ?>";
          var flash_revanue_last = "<?php echo  $flash_revanue_last_row['SUM(`flash_shipping_amount`)'] ?>";

          var price_revanue_today = "<?php echo  $price_revanue_today1 ?>";
          var price_revanue_yester = "<?php echo $price_revanue_yester1 ?>";
          var price_revanue_last = "<?php echo  $price_revanue_last1 ?>";

          var noCanvas = document.getElementById("daily_rev");
          var dataFirst = {
            data: [flash_revanue_last, flash_revanue_yester, flash_revanue_today],
            fill: false,
            borderColor: '#fbc658',
            backgroundColor: 'transparent',
            pointBorderColor: '#fbc658',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8,
          };

          var dataSecond = {
            data: [item_revanue_last, item_revanue_yester, item_revanue_today],
            fill: false,
            borderColor: '#51CACF',
            backgroundColor: 'transparent',
            pointBorderColor: '#51CACF',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8
          };

          var datatherd = {
            data: [price_revanue_last, price_revanue_yester, price_revanue_today],
            fill: false,
            borderColor: 'brown',
            backgroundColor: 'transparent',
            pointBorderColor: 'brown',
            pointRadius: 4,
            pointHoverRadius: 4,
            pointBorderWidth: 8
          };

          var speedData = {
            labels: ["Last day", "Yester day", "Today"],
            datasets: [dataFirst, dataSecond, datatherd]
          };

          var chartOptions = {
            legend: {
              display: false,
              position: 'top'
            }
          };

          var lineChart = new Chart(noCanvas, {
            type: 'line',
            hover: false,
            data: speedData,
            options: chartOptions
          });
    
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
