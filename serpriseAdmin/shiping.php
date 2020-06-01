<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------order item--------------------*/

  $order_item = "SELECT * FROM order_item";
  $order_item_result = mysqli_query($con, $order_item) or die (mysqli_error($con));

   /*---------------flash item --------------------*/

   $flash_item = "SELECT * FROM flash_order";
   $flash_item_result = mysqli_query($con, $flash_item) or die (mysqli_error($con));

   /*---------------price box order get group, price box group id--------------------*/

   $price_item = "SELECT * FROM price_box_order  GROUP BY price_box_order_group_id";
   $price_item_result = mysqli_query($con, $price_item) or die (mysqli_error($con));

   /*---------------get item shipping table--------------------*/

   $item_shipping = "SELECT * FROM item_shipping";
   $item_shipping_result = mysqli_query($con, $item_shipping) or die (mysqli_error($con));

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
          <li class="active ">
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
            <a class="navbar-brand" href="">Shiping Customer Order</a>
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
                <h4 class="card-title"> Item Order Shiping</h4>
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
                        Order Date
                      </th>
                      <th>
                        Username
                      </th>
                      <th>
                        Full Name
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
                        Item Id
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Item Quntity
                      </th>
                      <th>
                        Delivary Company
                      </th>
                      <th>
                        Delivary Cost
                      </th>
                      <th class="text-right">
                        total cost
                      </th>
                    </thead>
                    <tbody>
                    <?php
                      /*--------------------item order table have item-------------------------*/ 
                      if(mysqli_num_rows($order_item_result) > 0){
                        /*-------------------create exper date----------------*/
                        $expire_date=date("Y-m-d",strtotime("-3 day"));
                        $number = 0;
                          while ($row = $order_item_result-> fetch_assoc()){
                              /*--------------------display order item-------------------------*/
                              $item_id = $row['order_item_id'];
                              $item_user_id = $row['order_user_id'];
                              $deli_com = $row['order_dilivary_com_id'];
                              $order_date = $row['order_date'];
                              $item_order_id = $row['order_id'];
                              $number = $number+1;
                              /*-------------------get item table----------------*/
                              $item = "SELECT * FROM item WHERE item_id='$item_id'";
                              $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                              $item_row = $item_result-> fetch_assoc();
                              /*-------------------get user table----------------*/
                              $item_user = "SELECT * FROM user WHERE user_id='$item_user_id' AND user_status='user'";
                              $item_user_result = mysqli_query($con, $item_user) or die (mysqli_error($con));
                              $item_user_row = $item_user_result-> fetch_assoc();
                              /*-------------------get delivary company table----------------*/
                              $company = "SELECT * FROM delivery_company WHERE delivery_company_id='$deli_com'";
                              $company_result = mysqli_query($con, $company) or die (mysqli_error($con));
                              $company_row = $company_result-> fetch_assoc();
                              /*-------------------check oder date xpr----------------*/
                              if($order_date> $expire_date){
                                /*-------------------no exper----------------*/
                                echo '<tr class="no_exper_table">
                                  <td>
                                    '.$number.'
                                  </td>
                                  <td>
                                    <a href="exphp/itemShipping.php?orid='.$item_order_id.'"><button type="button" class="shipp_button">Shipe</button></a>
                                  </td>
                                  <td>
                                    '.$row['order_date'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_username'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_full_name'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_province'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_distric'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_address'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_email'].'
                                  </td>
                                  <td>
                                    '.$item_row['item_id'].'
                                  </td>
                                  <td>
                                    '.$item_row['item_name'].'
                                  </td>
                                  <td>
                                    '.$row['order_quntity'].'
                                  </td>
                                  <td>
                                    '.$company_row['delivery_company_name'].'
                                  </td>
                                  <td>
                                    Rs: '.$row['order_delivary_cost'].'
                                  </td>
                                  <td class="text-right">
                                    Rs: '.$row['order_amount'].'
                                  </td>
                                </tr>';
                              }else{
                                /*-------------------exper----------------*/
                                echo '<tr class="exper_table">
                                  <td>
                                    '.$number.'
                                  </td>
                                  <td>
                                    <a href="exphp/itemShipping.php?orid='.$item_order_id.'"><button type="button" class="shipp_button">Shipe</button></a>
                                  </td>
                                  <td>
                                    '.$row['order_date'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_username'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_full_name'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_province'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_distric'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_address'].'
                                  </td>
                                  <td>
                                    '.$item_user_row['user_email'].'
                                  </td>
                                  <td>
                                    '.$item_row['item_id'].'
                                  </td>
                                  <td>
                                    '.$item_row['item_name'].'
                                  </td>
                                  <td>
                                    '.$row['order_quntity'].'
                                  </td>
                                  <td>
                                    '.$company_row['delivery_company_name'].'
                                  </td>
                                  <td>
                                    Rs: '.$row['order_delivary_cost'].'
                                  </td>
                                  <td class="text-right">
                                    Rs: '.$row['order_amount'].'
                                  </td>
                                </tr>';
                              }
                          }
                      }else{
                        echo'<h2 class="no_error">No Order Now</h2>';
                      }
                    ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-----------flash order table--------------->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Flash Order Shiping</h4>
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
                        Order Date
                      </th>
                      <th>
                        Username
                      </th>
                      <th>
                        Full Name
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
                        Item Id
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Item Quntity
                      </th>
                      <th>
                        Delivary Company
                      </th>
                      <th>
                        Delivary Cost
                      </th>
                      <th class="text-right">
                        total cost
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        /*--------------------flash order have item-------------------------*/ 
                        if(mysqli_num_rows($flash_item_result) > 0){
                          /*--------------------create exper date-------------------------*/
                          $number1 = 0;
                          $expire_date=date("Y-m-d",strtotime("-2 day"));
                            while ($flash_row = $flash_item_result-> fetch_assoc()){
                                /*--------------------flash order display-------------------------*/
                                $flash_order_id = $flash_row['flash_order_id'];
                                $f_item_id = $flash_row['flash_order_item_id'];
                                $f_item_user_id = $flash_row['flash_order_user_id'];
                                $f_deli_com = $flash_row['flash_order_deli_com_id'];
                                $f_order_date = $flash_row['flash_order_date'];
                                $number1 =  $number1+1;
                                /*--------------------get item table-------------------------*/
                                $f_item = "SELECT * FROM item WHERE item_id='$f_item_id'";
                                $f_item_result = mysqli_query($con, $f_item) or die (mysqli_error($con));
                                $f_item_row = $f_item_result-> fetch_assoc();
                                /*--------------------get user table-------------------------*/
                                $f_item_user = "SELECT * FROM user WHERE user_id='$f_item_user_id' AND user_status='user'";
                                $f_item_user_result = mysqli_query($con, $f_item_user) or die (mysqli_error($con));
                                $f_item_user_row = $f_item_user_result-> fetch_assoc();
                                /*--------------------get delivary company table-------------------------*/
                                $f_company = "SELECT * FROM delivery_company WHERE delivery_company_id='$f_deli_com'";
                                $f_company_result = mysqli_query($con, $f_company) or die (mysqli_error($con));
                                $f_company_row = $f_company_result-> fetch_assoc();
                                /*---------------check exper------------------*/
                                if($f_order_date> $expire_date){
                                  /*--------------------no exper-------------------------*/
                                  echo '<tr class="no_exper_table">
                                    <td>
                                      '. $number1.'
                                    </td>
                                    <td>
                                      <a href="exphp/flashShipping.php?forid='.$flash_order_id.'"><button type="button" class="shipp_button">Shipe</button></a>
                                    </td>
                                    <td>
                                      '.$flash_row['flash_order_date'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_username'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_full_name'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_province'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_distric'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_address'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_email'].'
                                    </td>
                                    <td>
                                      '.$f_item_row['item_id'].'
                                    </td>
                                    <td>
                                      '.$f_item_row['item_name'].'
                                    </td>
                                    <td>
                                      '.$flash_row['flash_order_quntity'].'
                                    </td>
                                    <td>
                                      '.$f_company_row['delivery_company_name'].'
                                    </td>
                                    <td>
                                      Rs: '.$flash_row['flash_order_deliy_cost'].'
                                    </td>
                                    <td class="text-right">
                                      Rs: '.$flash_row['flash_order_amount'].'
                                    </td>
                                  </tr>';
                                }else{
                                  /*--------------------exper-------------------------*/
                                  echo '<tr class="exper_table">
                                    <td>
                                      '. $number1.'
                                    </td>
                                    <td>
                                      <a href="exphp/flashShipping.php?forid='.$flash_order_id.'"><button type="button" class="shipp_button">Shipe</button></a>
                                    </td>
                                    <td>
                                      '.$flash_row['flash_order_date'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_username'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_full_name'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_province'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_distric'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_address'].'
                                    </td>
                                    <td>
                                      '.$f_item_user_row['user_email'].'
                                    </td>
                                    <td>
                                      '.$f_item_row['item_id'].'
                                    </td>
                                    <td>
                                      '.$f_item_row['item_name'].'
                                    </td>
                                    <td>
                                      '.$flash_row['flash_order_quntity'].'
                                    </td>
                                    <td>
                                      '.$f_company_row['delivery_company_name'].'
                                    </td>
                                    <td>
                                      Rs: '.$flash_row['flash_order_deliy_cost'].'
                                    </td>
                                    <td class="text-right">
                                      Rs: '.$flash_row['flash_order_amount'].'
                                    </td>
                                  </tr>';
                                }
                            }
                        }else{
                          echo'<h2 class="no_error">No Order Now</h2>';
                        }
                      ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        <!-----------price box order table------------->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Price Box Order Shiping</h4>
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
                        Order Date
                      </th>
                      <th>
                        Username
                      </th>
                      <th>
                        Full Name
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
                        Item Id
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Item Quntity
                      </th>
                      <th>
                        Delivary Company
                      </th>
                      <th>
                        Delivary Cost
                      </th>
                      <th class="text-right">
                        total cost
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        /*--------------------price order have item-------------------------*/ 
                        if(mysqli_num_rows($price_item_result) > 0){
                          /*--------------------create exper date-------------------------*/
                          $number2 = 0;
                          $expire_date=date("Y-m-d",strtotime("-2 day"));
                            while ($price_row = $price_item_result-> fetch_assoc()){
                                /*--------------------price order display-------------------------*/
                                $p_group_id = $price_row['price_box_order_group_id'];
                                $p_item_user_id = $price_row['price_box_order_user_id'];
                                $p_deli_com = 2;
                                $p_set_order_date = $price_row['price_box_order_date'];
                                $p_item_quntity = 0;
                                $number2 = $number2+1;
                                /*--------------------get user table-------------------------*/
                                $p_item_user = "SELECT * FROM user WHERE user_id='$p_item_user_id' AND user_status='user'";
                                $p_item_user_result = mysqli_query($con, $p_item_user) or die (mysqli_error($con));
                                $p_item_user_row = $p_item_user_result-> fetch_assoc();
                                /*--------------------get delivary company table-------------------------*/
                                $p_company = "SELECT * FROM delivery_company WHERE delivery_company_id='$p_deli_com'";
                                $p_company_result = mysqli_query($con, $p_company) or die (mysqli_error($con));
                                $p_company_row = $p_company_result-> fetch_assoc();
                                /*--------------------price box order table-------------------------*/
                                $price_item_set = "SELECT * FROM price_box_order WHERE price_box_order_group_id='$p_group_id'";
                                $price_item_set_result = mysqli_query($con, $price_item_set) or die (mysqli_error($con));
                                /*--------------------display box all item details-------------------------*/
                                while ($price_row_set = $price_item_set_result-> fetch_assoc()){
                                  $p_item_id = $price_row_set['price_box_order_item_id'];
                                  $p_order_date = $price_row_set['price_box_order_date'];
                                  $p_item_quntity = $p_item_quntity + $price_row_set['price_box_order_quntity'];
                                  /*--------------------get item tabel, order group id-------------------------*/
                                  $p_item = "SELECT * FROM item WHERE item_id='$p_item_id'";
                                  $p_item_result = mysqli_query($con, $p_item) or die (mysqli_error($con));
                                  $p_item_row = $p_item_result-> fetch_assoc();
                                  /*--------------------check exper-------------------------*/
                                  if($p_order_date> $expire_date){
                                    /*--------------------no exper-------------------------*/
                                    echo '<tr class="no_exper_table">
                                      <td>
                                        
                                      </td>
                                      <td>
                                       
                                      </td>
                                      <td>
                                        '.$price_row_set['price_box_order_date'].'
                                      </td>
                                      <td>
                                        '.$p_item_user_row['user_username'].'
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no 
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        '.$p_item_user_row['user_email'].'
                                      </td>
                                      <td>
                                        '.$p_item_row['item_id'].'
                                      </td>
                                      <td>
                                        '.$p_item_row['item_name'].'
                                      </td>
                                      <td>
                                        '.$price_row_set['price_box_order_quntity'].'
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td class="text-right">
                                       no
                                      </td>
                                    </tr>';
                                  }else{
                                    /*--------------------exper-------------------------*/
                                    echo '<tr class="exper_table">
                                      <td>
                                        
                                      </td>
                                      <td>
                                        
                                      </td>
                                      <td>
                                        '.$price_row_set['price_box_order_date'].'
                                      </td>
                                      <td>
                                        '.$p_item_user_row['user_username'].'
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        '.$p_item_user_row['user_email'].'
                                      </td>
                                      <td>
                                        '.$p_item_row['item_id'].'
                                      </td>
                                      <td>
                                        '.$p_item_row['item_name'].'
                                      </td>
                                      <td>
                                        '.$price_row_set['price_box_order_quntity'].'
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td>
                                        no
                                      </td>
                                      <td class="text-right">
                                        no
                                      </td>
                                    </tr>';
                                  }
                                }
                               /*--------------------tatal row display after all item list display-------------------------*/
                                $price_group_id = $price_row['price_box_order_group_id'];
                                $price_user_ide = $price_row['price_box_order_user_id'];
                                if($p_set_order_date> $expire_date){
                                  /*--------------------no exper-------------------------*/
                                  echo '<tr class="no_exper_table">
                                    <td>
                                      '.$number2.'
                                    </td>
                                    <td>
                                      <a href="exphp/priceShipping.php?pgrid='.$price_group_id.'&pusid='.$price_user_ide.'"><button type="button" class="shipp_button">Shipe</button></a>
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_date'].'
                                    </td>
                                    <td>
                                      '.$p_item_user_row['user_username'].'
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_name'].'
                                    </td>
                                    <td>
                                      no
                                    </td>
                                    <td>
                                      no
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_address'].'
                                    </td>
                                    <td>
                                      '.$p_item_user_row['user_email'].'
                                    </td>
                                    <td>
                                      see up
                                    </td>
                                    <td>
                                      see up
                                    </td>
                                    <td>
                                      '.$p_item_quntity.'
                                    </td>
                                    <td>
                                      '.$p_company_row['delivery_company_name'].'
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_deli_cost'].'
                                    </td>
                                    <td class="text-right">
                                      '.$price_row['price_box_order_amount'].'
                                    </td>
                                  </tr>';
                                }else{
                                  /*--------------------exper-------------------------*/
                                  echo '<tr class="exper_table">
                                    <td>
                                      '.$number2.'
                                    </td>
                                    <td>
                                      <a href="exphp/priceShipping.php?pgrid='.$price_group_id.'&pusid='.$price_user_ide.'"><button type="button" class="shipp_button">Shipe</button></a>
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_date'].'
                                    </td>
                                    <td>
                                      '.$p_item_user_row['user_username'].'
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_name'].'
                                    </td>
                                    <td>
                                      no
                                    </td>
                                    <td>
                                      no
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_address'].'
                                    </td>
                                    <td>
                                      '.$p_item_user_row['user_email'].'
                                    </td>
                                    <td>
                                      see up
                                    </td>
                                    <td>
                                      see up
                                    </td>
                                    <td>
                                      '.$p_item_quntity.'
                                    </td>
                                    <td>
                                      '.$p_company_row['delivery_company_name'].'
                                    </td>
                                    <td>
                                      '.$price_row['price_box_order_deli_cost'].'
                                    </td>
                                    <td class="text-right">
                                      '.$price_row['price_box_order_amount'].'
                                    </td>
                                  </tr>';
                                }
                            }
                        }else{
                          echo'<h2 class="no_error">No Order Now</h2>';
                        }
                      ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Shipping Tables</h4>
                <div>
                  <button type="button" class="shipp_dis_button" id="item_bt">Item</button><button type="button" class="shipp_dis_button" id="flash_bt">Flash</button><button type="button" class="shipp_dis_button" id="price_bt">Price</button>
                  <select class="month_select" id="month">
                    <option class="month_select_option" value="0">30 days left</option>
                    <option class="month_select_option" value="1">Jan</option>
                    <option class="month_select_option" value="2">Feb</option>
                    <option class="month_select_option" value="3">Mar</option>
                    <option class="month_select_option" value="4">Apr</option>
                    <option class="month_select_option" value="5">May</option>
                    <option class="month_select_option" value="6">Jun</option>
                    <option class="month_select_option" value="7">Jul</option>
                    <option class="month_select_option" value="8">Aug</option>
                    <option class="month_select_option" value="9">Sep</option>
                    <option class="month_select_option" value="10">Oct</option>
                    <option class="month_select_option" value="11">Nov</option>
                    <option class="month_select_option" value="12">Dec</option>
                  </select>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          Number
                        </th>
                        <th>
                          Order Date
                        </th>
                        <th>
                          Shipping Date
                        </th>
                        <th>
                          Username
                        </th>
                        <th>
                          Full Name
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
                          Item Id
                        </th>
                        <th>
                          Item Name
                        </th>
                        <th>
                          Item Quntity
                        </th>
                        <th>
                          Delivary Company
                        </th>
                        <th>
                          Delivary Cost
                        </th>
                        <th>
                          total cost
                        </th>
                        <th class="text-right">
                          Add Admin
                        </th>
                      </tr>
                      </thead>
                    <tbody id="tabel_body">
                      <?php
                      /*--------------------item shipping table have item-------------------------*/ 
                        if(mysqli_num_rows($item_shipping_result) > 0){
                          /*----------date limit--------------*/
                          $limit_date=date("Y-m-d",strtotime("-30 day"));
                          $number3 = 0;
                          /*-------------diaplay item shipping---------------*/
                            while ($item_shipping_row = $item_shipping_result-> fetch_assoc()){
                            $ship_date =$item_shipping_row['item_shipping_date'];
                            $ship_user_id = $item_shipping_row['item_shipping_user_id'];
                            $ship_item_id = $item_shipping_row['item_shipping_item_id'];
                            $ship_deli_id = $item_shipping_row['item_shipping_deli_id'];

                             /*--------------------get user table-------------------------*/
                             $ship_item_user = "SELECT * FROM user WHERE user_id='$ship_user_id' AND user_status='user'";
                             $ship_item_user_result = mysqli_query($con, $ship_item_user) or die (mysqli_error($con));
                             $ship_item_user_row = $ship_item_user_result-> fetch_assoc();

                             /*--------------------get item tabel-------------------------*/
                             $ship_item = "SELECT * FROM item WHERE item_id='$ship_item_id'";
                             $ship_item_result = mysqli_query($con, $ship_item) or die (mysqli_error($con));
                             $ship_item_row = $ship_item_result-> fetch_assoc();

                              /*--------------------get delivary company table-------------------------*/
                              $ship_company = "SELECT * FROM delivery_company WHERE delivery_company_id='$ship_deli_id'";
                              $ship_company_result = mysqli_query($con, $ship_company) or die (mysqli_error($con));
                              $ship_company_row = $ship_company_result-> fetch_assoc();

                              if($ship_date > $limit_date){
                                $number3 = $number3+1;
                                echo '<tr>
                                  <td>
                                    '.$number3.'
                                  </td>
                                  <td>
                                    '.$item_shipping_row['item_shipping_order_date'].'
                                  </td>
                                  <td>
                                    '.$item_shipping_row['item_shipping_date'].'
                                  </td>
                                  <td>
                                    '.$ship_item_user_row['user_username'].'
                                  </td>
                                  <td>
                                    '.$ship_item_user_row['user_full_name'].'
                                  </td>
                                  <td>
                                    '.$ship_item_user_row['user_province'].'
                                  </td>
                                  <td>
                                    '.$ship_item_user_row['user_distric'].'
                                  </td>
                                  <td>
                                    '.$ship_item_user_row['user_address'].'
                                  </td>
                                  <td>
                                    '.$ship_item_user_row['user_email'].'
                                  </td>
                                  <td>
                                    '.$ship_item_row['item_id'].'
                                  </td>
                                  <td>
                                    '.$ship_item_row['item_name'].'
                                  </td>
                                  <td>
                                    '.$item_shipping_row['item_shipping_quntity'].'
                                  </td>
                                  <td>
                                    '.$ship_company_row['delivery_company_name'].'
                                  </td>
                                  <td>
                                    '.$item_shipping_row['item_shipping_deli_cost'].'
                                  </td>
                                  <td>
                                    '.$item_shipping_row['item_shipping_amount'].'
                                  </td>
                                  <td class="text-right">
                                    '.$item_shipping_row['item_shipping_admin'].'
                                  </td>
                                </tr>';
                              }else{

                              }
                            }
                        }else{
                          
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
      // display shipping details
        $(document).ready(function(){
            $("#item_bt").click(function(){
              //get select_month
              var b = document.getElementById("month");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body").load("exphp/itemshepdisplay.php",{
                  //pass vaue
                   mon_N:result
                });
            });
            $("#flash_bt").click(function(){
              //get select_month
              var b = document.getElementById("month");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body").load("exphp/flashshepdisplay.php",{
                   //pass vaue
                   mon_N:result
                });
            });
            $("#price_bt").click(function(){
              //get select_month
              var b = document.getElementById("month");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body").load("exphp/priceshepdisplay.php",{
                   //pass vaue
                   mon_N:result
                });
            });
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

</php>
