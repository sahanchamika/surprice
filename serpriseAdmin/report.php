<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

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

  /*---------------------user feedback count-----------------------*/
  $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
  $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
  $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------------chat count-----------------------*/
  $chat_count = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_resever = '$log_user_id' AND chat_state = 'Active'";
  $chat_count_result = mysqli_query($con, $chat_count) or die (mysqli_error($con));
  $chat_count_row = $chat_count_result-> fetch_assoc();

  /*---------get Revaneu table--------------*/
  $current_munth = date("n");
  $revaneu = "SELECT * FROM revanue";
  $revaneu_result = mysqli_query($con, $revaneu) or die (mysqli_error($con));
  
  /*---------get item by Revaneu table--------------*/
  $item_by_revaneu = "SELECT * FROM item_by_revanue";
  $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con));

  /*---------get group creater item by Revaneu table--------------*/
  $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id";
  $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));

   /*---------get item by quntity table--------------*/
   $item_by_quntity = "SELECT * FROM item_by_quntity ORDER BY item_by_quntity_qun ASC";
   $item_by_quntity_result = mysqli_query($con, $item_by_quntity) or die (mysqli_error($con));

   /*---------get one or not sold item--------------*/
   $no_sols_item = "SELECT item.item_id, item.item_name, item.item_price, item.item_quantity, item.item_discount, item.item_add_date, item.item_creator_id FROM item WHERE item.item_id NOT IN (SELECT item_by_quntity.item_by_quntity_item_id FROM item_by_quntity)";
   $no_sols_item_result = mysqli_query($con, $no_sols_item) or die (mysqli_error($con));
   

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
          <li class="active ">
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
            <a class="navbar-brand" href="#pablo">Revanue Report</a>
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
      <div class="content">
       <!---------notification card------------->
        <div class="row">
          <!---------Total Revanue card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="reveneu.php"><i class="nc-icon nc-money-coins text-danger"></i></a>
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
                  <a href=""><i class="fa fa-refresh"></i> Update Now</a> (30 day left)
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
                      <a href="soldreport.php"><i class="nc-icon nc-bag-16 text-success"></i></a>
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
                  <a href=""><i class="fa fa-refresh"></i> Update Now</a> (30 day left)
                </div>
              </div>
            </div>
          </div>
          <!---------Total item Revanue card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="reveneu.php"><i class="nc-icon nc-money-coins text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Item Revanue</p>
                      <p class="card-title"><?php echo $sold_item_total_row['SUM(`item_shipping_amount`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i> Update Now</a> (30 day left)
                </div>
              </div>
            </div>
          </div>
          <!---------Total flash Revanue card------------->
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="reveneu.php"><i class="nc-icon nc-money-coins text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Flash Revanue</p>
                      <p class="card-title"><?php echo $sold_flash_total_row['SUM(`flash_shipping_amount`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i> Update Now</a> (30 day left)
                </div>
              </div>
            </div>
          </div>
           <!---------Total price Revanue card------------->
           <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href="reveneu.php"><i class="nc-icon nc-money-coins text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Price Revanue</p>
                      <p class="card-title"><?php echo  $total_price_re; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i> Update Now</a> (30 day left)
                </div>
              </div>
            </div>
          </div>
        </div>
      <div class="content">
        <!----------item order tabel---------->
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Monthly Revanue & Total</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                       
                      </th>
                      <th>
                        Year
                      </th>
                      <th>
                        Jan
                      </th>
                      <th>
                        Feb
                      </th>
                      <th>
                        Mar
                      </th>
                      <th>
                        Apr
                      </th>
                      <th>
                        May
                      </th>
                      <th>
                        Jun
                      </th>
                      <th>
                        Jul
                      </th>
                      <th>
                        Aug
                      </th>
                      <th>
                        Sep
                      </th>
                      <th>
                        Oct
                      </th>
                      <th>
                        Nov
                      </th>
                      <th>
                        Dec
                      </th>
                      <th class="text-right">
                        Total 
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        while ($revaneu_row = $revaneu_result-> fetch_assoc()){
                          $total_rev_item = 0;
                          for($x = 1; $x <= 12; $x++){
                            $total_rev_item = $total_rev_item + $revaneu_row['m_'.$x.''];
                          }
                          $total_rev_min = $total_rev_item / 12;
                          echo '<tr>
                                  <td class="exper_table">
                                    '.$revaneu_row['revanue_type'].'
                                  </td>
                                  <td>
                                    '.$revaneu_row['revanue_year'].'
                                  </td>';
                                  if($current_munth >= 1){
                                    if($total_rev_min >= $revaneu_row['m_1']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_1'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_1'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 2){
                                    if($total_rev_min >= $revaneu_row['m_2']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_2'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_2'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 3){
                                    if($total_rev_min >= $revaneu_row['m_3']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_3'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_3'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 4){
                                    if($total_rev_min >= $revaneu_row['m_4']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_4'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_4'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 5){
                                    if($total_rev_min >= $revaneu_row['m_5']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_5'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_5'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 6){
                                    if($total_rev_min >= $revaneu_row['m_6']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_6'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_6'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 7){
                                    if($total_rev_min >= $revaneu_row['m_7']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_7'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_7'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 8){
                                    if($total_rev_min >= $revaneu_row['m_8']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_8'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_8'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 9){
                                    if($total_rev_min >= $revaneu_row['m_9']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_9'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_9'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 10){
                                    if($total_rev_min >= $revaneu_row['m_10']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_10'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_10'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 11){
                                    if($total_rev_min >= $revaneu_row['m_11']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_11'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_11'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  if($current_munth >= 12){
                                    if($total_rev_min >= $revaneu_row['m_12']){
                                      echo '<td class="exper_table">
                                        '.$revaneu_row['m_12'].'
                                        </td>';
                                    }else{
                                      echo '<td>
                                        '.$revaneu_row['m_12'].'
                                        </td>'; 
                                    }
                                  }else{
                                    echo '<td class="no_exper_table">
                                      No Update
                                    </td>'; 
                                  }
                                  echo '<td class="text-right">
                                      '. $total_rev_item.'
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
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Item By Monthly Revaneu</h4>
                <div>
                  <button type="button" class="shipp_dis_button" id="item_bt2">Item</button><button type="button" class="shipp_dis_button" id="flash_bt2">Flash</button>
                  <select class="month_select" id="sort">
                    <option class="month_select_option" value="0">No Sort</option>
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
                          
                        </th>
                        <th>
                          Item_id
                        </th>
                        <th>
                          Item Name
                        </th>
                        <th>
                          Item Price
                        </th>
                        <th>
                          Discount
                        </th>
                        <th>
                          Avalabel Quntity
                        </th>
                        <th>
                          Creater
                        </th>
                        <th>
                          Creater Email
                        </th>
                        <th>
                          Year
                        </th>
                        <th>
                          Jan
                        </th>
                        <th>
                          Feb
                        </th>
                        <th>
                          Mar
                        </th>
                        <th>
                          Apr
                        </th>
                        <th>
                          May
                        </th>
                        <th>
                          Jun
                        </th>
                        <th>
                          Jul
                        </th>
                        <th>
                          Aug
                        </th>
                        <th>
                          Sep
                        </th>
                        <th>
                          Oct
                        </th>
                        <th>
                          Nov
                        </th>
                        <th>
                          Dec
                        </th>
                        <th class="text-right">
                          Total
                        </th>
                      </tr>
                      </thead>
                      <tbody id="tabel_body2">
                        <?php
                          $count2 = 0;
                          while ($item_by_revaneu_row = $item_by_revaneu_result-> fetch_assoc()){
                            $count2 = $count2 +1;
                            $total_item_by_rev = 0;
                            for($i = 1; $i <= 12; $i++){
                              $total_item_by_rev = $total_item_by_rev + $item_by_revaneu_row['m_'.$i.''];
                            }
                            $item_id = $item_by_revaneu_row['item_by_revanue_item_id'];
                            $creater_id = $item_by_revaneu_row['item_by_revanue_item_creator_id'];
                            /*-------------------get item table----------------*/
                            $item = "SELECT * FROM item WHERE item_id='$item_id'";
                            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                            $item_row = $item_result-> fetch_assoc();

                            /*-------------------get creater table----------------*/
                            $creater = "SELECT * FROM creator WHERE creator_id='$creater_id'";
                            $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
                            $creater_row = $creater_result-> fetch_assoc();

                            $item_rev_min = $item_row['item_price'] * 3;

                            echo '<tr>
                                    <td>
                                      '. $count2.'
                                    </td>
                                    <td>
                                      '.$item_by_revaneu_row['item_by_revanue_item_id'].'
                                    </td>
                                    <td>
                                      '.$item_row['item_name'].'
                                    </td>
                                    <td>
                                      Rs: '.$item_row['item_price'].'
                                    </td>
                                    <td>
                                      '.$item_row['item_discount'].'%
                                    </td>';
                                    if($item_row['item_quantity'] == 0){
                                      echo'<td class="exper_table">
                                        All sold
                                      </td>';
                                    }else{
                                      if($item_row['item_quantity'] < 10){
                                        echo'<td class="exper_table">
                                        '.$item_row['item_quantity'].'
                                        </td>';
                                      }else{
                                        echo'<td>
                                            '.$item_row['item_quantity'].'
                                          </td>';
                                      }
                                    }
                                    
                                    echo'<td>
                                      '.$creater_row['creator_name'].'
                                    </td>
                                    <td>
                                      '.$creater_row['creator_email'].'
                                    </td>
                                    <td>
                                      '.$item_by_revaneu_row['item_by_revanue_year'].'
                                    </td>';
                                    if($current_munth >= 1){
                                      if($item_rev_min >= $item_by_revaneu_row['m_1']){
                                        if($item_by_revaneu_row['m_1'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_1'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_1'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 2){
                                      if($item_rev_min >= $item_by_revaneu_row['m_2']){
                                        if($item_by_revaneu_row['m_2'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_2'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_2'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 3){
                                      if($item_rev_min >= $item_by_revaneu_row['m_3']){
                                        if($item_by_revaneu_row['m_3'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_3'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_3'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 4){
                                      if($item_rev_min >= $item_by_revaneu_row['m_4']){
                                        if($item_by_revaneu_row['m_4'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_4'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_4'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 5){
                                      if($item_rev_min >= $item_by_revaneu_row['m_5']){
                                        if($item_by_revaneu_row['m_5'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_5'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_5'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 6){
                                      if($item_rev_min >= $item_by_revaneu_row['m_6']){
                                        if($item_by_revaneu_row['m_6'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_6'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_6'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 7){
                                      if($item_rev_min >= $item_by_revaneu_row['m_7']){
                                        if($item_by_revaneu_row['m_7'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_7'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_7'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 8){
                                      if($item_rev_min >= $item_by_revaneu_row['m_8']){
                                        if($item_by_revaneu_row['m_8'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_8'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_8'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 9){
                                      if($item_rev_min >= $item_by_revaneu_row['m_9']){
                                        if($item_by_revaneu_row['m_9'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_9'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_9'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 10){
                                      if($item_rev_min >= $item_by_revaneu_row['m_10']){
                                        if($item_by_revaneu_row['m_10'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_10'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_10'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 11){
                                      if($item_rev_min >= $item_by_revaneu_row['m_11']){
                                        if($item_by_revaneu_row['m_11'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_11'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_11'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 12){
                                      if($item_rev_min >= $item_by_revaneu_row['m_12']){
                                        if($item_by_revaneu_row['m_12'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$item_by_revaneu_row['m_12'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$item_by_revaneu_row['m_12'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                 
                                    echo'<td class="text-right">
                                      '.$total_item_by_rev.'
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
            <div class="card card-plain">
              <div class="card-header">
                <h4 class="card-title"> Item By Quntity</h4>
                <div>
                  <button type="button" class="shipp_dis_button" id="qunti_ite_bt">Item</button><button type="button" class="shipp_dis_button" id="qunti_fla_bt">Flash</button><button type="button" class="shipp_dis_button" id="qunti_pri_bt">Price</button>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <tr>
                        <th>
                          
                        </th>
                        <th>
                          Item Id
                        </th>
                        <th>
                          Item Name
                        </th>
                        <th>
                          Item Unit Price
                        </th>
                        <th>
                          Creater Name
                        </th>
                        <th>
                          Creater Email
                        </th>
                        <th>
                          Year
                        </th>
                        <th>
                          Avalabel Quntity
                        </th>
                        <th class="text-right">
                          Sold Quntity
                        </th>
                      </tr>
                      </thead>
                      <tbody id="tabel_body_item_qun">
                      <?php
                        $count3 = 0;
                        /*------------display item by quntity item------------*/
                        while ($item_by_quntity_row = $item_by_quntity_result-> fetch_assoc()){
                          $count3 = $count3 +1;
                          $quntity_item_id = $item_by_quntity_row['item_by_quntity_item_id'];
                          $quntity_creater_id = $item_by_quntity_row['item_by_quntity_creter_id'];
                          /*-------------------get item table----------------*/
                          $item = "SELECT * FROM item WHERE item_id='$quntity_item_id'";
                          $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                          $item_row = $item_result-> fetch_assoc();
                          /*-------------------get creater table----------------*/
                          $creater = "SELECT * FROM creator WHERE creator_id='$quntity_creater_id'";
                          $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
                          $creater_row = $creater_result-> fetch_assoc();
                          /*-------------check item quntity lowest -------------*/
                          if($item_by_quntity_row['item_by_quntity_qun'] >= 100){
                            echo'<tr class="no_exper_table">
                              <td>
                              '.$count3.'
                              </td>
                              <td>
                                '.$item_by_quntity_row['item_by_quntity_item_id'].'
                              </td>
                              <td>
                                '.$item_row['item_name'].'
                              </td>
                              <td>
                                '.$item_row['item_price'].'
                              </td>
                              <td>
                                '.$creater_row['creator_name'].'
                              </td>
                              <td>
                                '.$creater_row['creator_email'].'
                              </td>
                              <td>
                                '.$item_by_quntity_row['item_by_quntity_year'].'
                              </td>
                              <td>
                                '.$item_row['item_quantity'].'
                              </td>
                              <td class="text-right">
                                '.$item_by_quntity_row['item_by_quntity_qun'].'
                              </td>
                            </tr>';
                          }else{
                            if($item_by_quntity_row['item_by_quntity_qun'] <= 10){
                              echo'<tr class="exper_table">
                                <td>
                                '.$count3.'
                                </td>
                                <td>
                                  '.$item_by_quntity_row['item_by_quntity_item_id'].'
                                </td>
                                <td>
                                  '.$item_row['item_name'].'
                                </td>
                                <td>
                                  '.$item_row['item_price'].'
                                </td>
                                <td>
                                  '.$creater_row['creator_name'].'
                                </td>
                                <td>
                                  '.$creater_row['creator_email'].'
                                </td>
                                <td>
                                  '.$item_by_quntity_row['item_by_quntity_year'].'
                                </td>
                                <td>
                                  '.$item_row['item_quantity'].'
                                </td>
                                <td class="text-right">
                                  '.$item_by_quntity_row['item_by_quntity_qun'].'
                                </td>
                              </tr>';
                            }else{
                              echo'<tr>
                                <td>
                                '.$count3.'
                                </td>
                                <td>
                                  '.$item_by_quntity_row['item_by_quntity_item_id'].'
                                </td>
                                <td>
                                  '.$item_row['item_name'].'
                                </td>
                                <td>
                                  '.$item_row['item_price'].'
                                </td>
                                <td>
                                  '.$creater_row['creator_name'].'
                                </td>
                                <td>
                                  '.$creater_row['creator_email'].'
                                </td>
                                <td>
                                  '.$item_by_quntity_row['item_by_quntity_year'].'
                                </td>
                                <td>
                                  '.$item_row['item_quantity'].'
                                </td>
                                <td class="text-right">
                                  '.$item_by_quntity_row['item_by_quntity_qun'].'
                                </td>
                              </tr>';
                            }
                          }
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
                <h4 class="card-title"> Creater By Monthly Revaneu</h4>
                <div>
                  <button type="button" class="shipp_dis_button" id="cre_item_bt">Item</button><button type="button" class="shipp_dis_button" id="cre_flash_bt">Flash</button>
                  <select class="month_select" id="cre_sort">
                    <option class="month_select_option" value="0">No Sort</option>
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
                          
                        </th>
                        <th>
                          Creater Name
                        </th>
                        <th>
                          Creater Email
                        </th>
                        <th>
                          Creater Tel:
                        </th>
                        <th>
                          Avalabel Quntity
                        </th>
                        <th>
                          Sold Item
                        </th>
                        <th>
                          Total Item
                        </th>
                        <th>
                          Year
                        </th>
                        <th>
                          Jan
                        </th>
                        <th>
                          Feb
                        </th>
                        <th>
                          Mar
                        </th>
                        <th>
                          Apr
                        </th>
                        <th>
                          May
                        </th>
                        <th>
                          Jun
                        </th>
                        <th>
                          Jul
                        </th>
                        <th>
                          Aug
                        </th>
                        <th>
                          Sep
                        </th>
                        <th>
                          Oct
                        </th>
                        <th>
                          Nov
                        </th>
                        <th>
                          Dec
                        </th>
                        <th class="text-right">
                          Total
                        </th>
                      </tr>
                      </thead>
                      <tbody id="tabel_body_cre">
                      <?php
                          $count = 0;
                          /*----------display creater by revanue--------------*/
                          while ($creater_by_revaneu_row =  $creater_by_revaneu_result-> fetch_assoc()){
                            $creator_id = $creater_by_revaneu_row['item_by_revanue_item_creator_id'];
                            /*-------------------get creater table----------------*/
                            $creater = "SELECT * FROM creator WHERE creator_id='$creator_id'";
                            $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
                            $creater_row = $creater_result-> fetch_assoc();
                            /*----------------calculate total creater revanue------------------*/
                            $total_creater_by_rev = 0;
                            for($i = 1; $i <= 12; $i++){
                              $total_creater_by_rev = $total_creater_by_rev + $creater_by_revaneu_row['SUM(`m_'.$i.'`)'];
                            }
                            /*------number count------------*/
                            $count = $count +1;
                            echo '<tr>
                                    <td>
                                      '.$count.'
                                    </td>
                                    <td>
                                      '.$creater_row['creator_name'].'
                                    </td>
                                    <td>
                                      '.$creater_row['creator_email'].'
                                    </td>
                                    <td>
                                      '.$creater_row['creator_tel'].'
                                    </td>';
                                    if($creater_row['creator_item'] == 0){
                                      echo'<td class="exper_table">
                                        All Sold
                                      </td>';
                                    }else{
                                      if($creater_row['creator_item'] <= 10){
                                        echo'<td class="exper_table">
                                          '.$creater_row['creator_item'].'
                                        </td>';
                                      }else{
                                        echo'<td>
                                          '.$creater_row['creator_item'].'
                                        </td>';
                                      }
                                    }
                                    if($creater_row['creator_sold_iem'] <= 10){
                                      echo'<td class="exper_table">
                                        '.$creater_row['creator_sold_iem'].'
                                      </td>';
                                    }else{
                                      echo'<td>
                                        '.$creater_row['creator_sold_iem'].'
                                      </td>';
                                    }
                                    echo'<td>
                                      '.$creater_row['creator_total_item'].'
                                    </td>
                                    <td>
                                     '.$creater_by_revaneu_row['item_by_revanue_year'].'
                                    </td>';
                                    if($current_munth >= 1){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_1`)']){
                                        if($creater_by_revaneu_row['SUM(`m_1`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_1`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_1`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 2){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_2`)']){
                                        if($creater_by_revaneu_row['SUM(`m_2`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_2`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_2`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 3){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_3`)']){
                                        if($creater_by_revaneu_row['SUM(`m_3`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_3`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_3`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 4){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_4`)']){
                                        if($creater_by_revaneu_row['SUM(`m_4`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_4`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_4`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 5){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_5`)']){
                                        if($creater_by_revaneu_row['SUM(`m_5`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_5`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_5`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 6){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_6`)']){
                                        if($creater_by_revaneu_row['SUM(`m_6`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_6`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_6`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }if($current_munth >= 7){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_7`)']){
                                        if($creater_by_revaneu_row['SUM(`m_7`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_7`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_7`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 8){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_8`)']){
                                        if($creater_by_revaneu_row['SUM(`m_8`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_8`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_8`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 9){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_9`)']){
                                        if($creater_by_revaneu_row['SUM(`m_9`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_9`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_9`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 10){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_10`)']){
                                        if($creater_by_revaneu_row['SUM(`m_10`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_10`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_10`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 11){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_11`)']){
                                        if($creater_by_revaneu_row['SUM(`m_11`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_11`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_11`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    if($current_munth >= 12){
                                      if(500 >= $creater_by_revaneu_row['SUM(`m_12`)']){
                                        if($creater_by_revaneu_row['SUM(`m_12`)'] == NULL){
                                          echo '<td class="exper_table">
                                              0
                                            </td>';
                                        }else{
                                          echo '<td class="exper_table">
                                            '.$creater_by_revaneu_row['SUM(`m_12`)'].'
                                            </td>';
                                        }
                                      }else{
                                        echo '<td>
                                          '.$creater_by_revaneu_row['SUM(`m_12`)'].'
                                          </td>'; 
                                      }
                                    }else{
                                      echo '<td class="no_exper_table">
                                        No Update
                                      </td>'; 
                                    }
                                    echo'<td class="text-right">
                                        '.$total_creater_by_rev.'
                                    </td>
                                </tr>';
                          }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> One Or Not Sale Item</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                       
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
                        Item Price
                      </th>
                      <th>
                        Item Discount
                      </th>
                      <th>
                        Item Add Date
                      </th>
                      <th>
                        Creater Name
                      </th>
                      <th>
                        Creater Email
                      </th>
                      <th class="text-right">
                        Amount
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        $count4 = 0;
                        if(mysqli_num_rows($no_sols_item_result) > 0){
                          /*----------display one or not sold item--------------*/
                          while ($no_sols_item_result_row =  $no_sols_item_result-> fetch_assoc()){
                            $count4 = $count4 + 1;
                            $no_sold_item_cre_id = $no_sols_item_result_row['item_creator_id'];
                            /*--------------calculate total revanue in this item--------------*/
                            $no_sold_amount_diss = ($no_sols_item_result_row['item_price'] / 100) * $no_sols_item_result_row['item_discount'];
                            $no_sold_amount_diss_one = $no_sols_item_result_row['item_price'] - $no_sold_amount_diss;
                            $no_sold_amount_diss_all = $no_sold_amount_diss_one * $no_sols_item_result_row['item_quantity'];
                            /*-------------------get creater table----------------*/
                            $creater_sold = "SELECT * FROM creator WHERE creator_id='$no_sold_item_cre_id'";
                            $creater_sold_result = mysqli_query($con, $creater_sold) or die (mysqli_error($con));
                            $creater_sold_row = $creater_sold_result-> fetch_assoc();
                            /*------------get item add date and today differants---------------*/
                            $add_date_item = date_create($no_sols_item_result_row['item_add_date']);
                            $today =  date_create(date("Y-m-d"));
                            $ex_date_lo = date_diff($add_date_item, $today);
                            $ex_date = $ex_date_lo->format("%a");
                            if($ex_date >= 30){
                              echo'<tr class="exper_table">
                                <td>
                                  '.$count4.'
                                </td>
                                <td>
                                  '.$no_sols_item_result_row['item_id'].'
                                </td>
                                <td>
                                  '.$no_sols_item_result_row['item_name'].'
                                </td>
                                <td>
                                  '.$no_sols_item_result_row['item_quantity'].'
                                </td>
                                <td>
                                  Rs:'.$no_sols_item_result_row['item_price'].'
                                </td>
                                <td>
                                  '.$no_sols_item_result_row['item_discount'].'%
                                </td>
                                <td>
                                  '.$no_sols_item_result_row['item_add_date'].'
                                </td>
                                <td>
                                  '.$creater_sold_row['creator_name'].'
                                </td>
                                <td>
                                  '.$creater_sold_row['creator_email'].'
                                </td>
                                <td class="text-right">
                                  '.$no_sold_amount_diss_all.'
                                </td>
                              </tr>';
                            }else{
                              if($ex_date >= 5){
                                echo'<tr>
                                  <td>
                                    '.$count4.'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_id'].'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_name'].'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_quantity'].'
                                  </td>
                                  <td>
                                    Rs:'.$no_sols_item_result_row['item_price'].'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_discount'].'%
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_add_date'].'
                                  </td>
                                  <td>
                                    '.$creater_sold_row['creator_name'].'
                                  </td>
                                  <td>
                                    '.$creater_sold_row['creator_email'].'
                                  </td>
                                  <td class="text-right">
                                    '.$no_sold_amount_diss_all.'
                                  </td>
                                </tr>';
                              }else{
                                echo'<tr class="no_exper_table">
                                  <td>
                                    '.$count4.'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_id'].'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_name'].'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_quantity'].'
                                  </td>
                                  <td>
                                    Rs:'.$no_sols_item_result_row['item_price'].'
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_discount'].'%
                                  </td>
                                  <td>
                                    '.$no_sols_item_result_row['item_add_date'].'
                                  </td>
                                  <td>
                                    '.$creater_sold_row['creator_name'].'
                                  </td>
                                  <td>
                                    '.$creater_sold_row['creator_email'].'
                                  </td>
                                  <td class="text-right">
                                    '.$no_sold_amount_diss_all.'
                                  </td>
                                </tr>';
                              }
                            }
                          }
                        }else{
                          echo'<h2 class="no_error">Item Sold Good</h2>';
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
        $(document).ready(function(){
          //load item by monthly revanue
          $("#item_bt2").click(function(){
              //get select sort
              var b = document.getElementById("sort");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body2").load("exphp/itemByRev.php",{
                  //pass vaue
                   sort_N:result
                });
            });
            //load flash by monthly revanue
            $("#flash_bt2").click(function(){
              //get select sort
              var b = document.getElementById("sort");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body2").load("exphp/flashByRev.php",{
                   //pass vaue
                   sort_N:result
                });
            });
             //load creater by monthly revanue item
            $("#cre_item_bt").click(function(){
              //get select sort
              var b = document.getElementById("cre_sort");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body_cre").load("exphp/creByItemRev.php",{
                   //pass vaue
                   sort_N:result
                });
            });
             //load creater by monthly revanue flash
            $("#cre_flash_bt").click(function(){
              //get select sort
              var b = document.getElementById("cre_sort");
              var result = b.options[b.selectedIndex].value;
                $("#tabel_body_cre").load("exphp/creByflashRev.php",{
                   //pass vaue
                   sort_N:result
                });
            });
            //load item by quntity
            $("#qunti_ite_bt").click(function(){
                $("#tabel_body_item_qun").load("exphp/itemByQun.php",{
                   
                });
            });
            //load flash by quntity
            $("#qunti_fla_bt").click(function(){
                $("#tabel_body_item_qun").load("exphp/flashByQun.php",{
                   
                });
            });
            //load price by quntity
            $("#qunti_pri_bt").click(function(){
                $("#tabel_body_item_qun").load("exphp/priceByQun.php",{
                   
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
