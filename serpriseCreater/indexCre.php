<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['creater_id'];

  $current_year=date("Y");

  /*---------------------login creater details-----------------------*/
  $log_user = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------avalebel item count for log creater-----------------------*/
  $creater_aval_item_count = "SELECT count(`item_id`) FROM item WHERE item_quantity > 0 AND item_creator_id ='$log_user_id'";
  $creater_aval_item_count_result = mysqli_query($con, $creater_aval_item_count) or die (mysqli_error($con));
  $creater_aval_item_count_row = $creater_aval_item_count_result-> fetch_assoc();

  /*---------------------avalebel flash count for log creater-----------------------*/
  $creater_flash_count = "SELECT COUNT(`flash_sale_id`) FROM flash_sale WHERE flash_sale_creator_id='$log_user_id'";
  $creater_flash_count_result = mysqli_query($con, $creater_flash_count) or die (mysqli_error($con));
  $creater_flash_count_row = $creater_flash_count_result-> fetch_assoc();

  /*---------------------total sold item quntity -----------------------*/

  $sold_item_total = "SELECT SUM(`item_by_quntity_qun`) FROM item_by_quntity WHERE item_by_quntity_creter_id='$log_user_id'";
  $sold_item_total_result = mysqli_query($con, $sold_item_total) or die (mysqli_error($con));
  $sold_item_total_row = $sold_item_total_result-> fetch_assoc();

  $sold_flash_total = "SELECT SUM(`flash_by_quntity_qun`) FROM flash_by_quntity WHERE flash_by_quntity_creater_id='$log_user_id'";
  $sold_flash_total_result = mysqli_query($con, $sold_flash_total) or die (mysqli_error($con));
  $sold_flash_total_row = $sold_flash_total_result-> fetch_assoc();

  $sold_price_total = "SELECT SUM(`price_by_quntity_qun`) FROM price_by_quntity WHERE price_by_quntity_creater_id='$log_user_id'";
  $sold_price_total_result = mysqli_query($con, $sold_price_total) or die (mysqli_error($con));
  $sold_price_total_row = $sold_price_total_result-> fetch_assoc();

  $slod_quntity = $sold_item_total_row['SUM(`item_by_quntity_qun`)'] + $sold_flash_total_row['SUM(`flash_by_quntity_qun`)'] + $sold_price_total_row['SUM(`price_by_quntity_qun`)'];

   /*---------------------creater all sold item-----------------------*/
   $all_sold_item = "SELECT COUNT(`item_id`) FROM item WHERE item_creator_id= '$log_user_id' AND item_quantity = 0 ";
   $all_sold_item_result = mysqli_query($con, $all_sold_item) or die (mysqli_error($con));
   $all_sold_item_row = $all_sold_item_result-> fetch_assoc();

   /*---------------------creater item by quntity-----------------------*/
   $cre_item_qun = "SELECT * FROM item_by_quntity WHERE item_by_quntity_creter_id = '$log_user_id'";
   $cre_item_qun_result = mysqli_query($con, $cre_item_qun) or die (mysqli_error($con));

   /*--------------------get one or not sold item--------------*/
   $no_sols_item = "SELECT item.item_id, item.item_name, item.item_price, item.item_quantity, item.item_discount, item.item_add_date, item.item_creator_id FROM item WHERE  item_creator_id = '$log_user_id' AND item.item_id NOT IN (SELECT item_by_quntity.item_by_quntity_item_id FROM item_by_quntity)";
   $no_sols_item_result = mysqli_query($con, $no_sols_item) or die (mysqli_error($con));

  /*---------------------admin massage count-----------------------*/
  $admin_mass_count = "SELECT COUNT(`admin_cre_feed_id`) FROM admin_cre_feed WHERE admin_cre_feed_cre_id='$log_user_id' AND admin_cre_feed_state='Active'";
  $admin_mass_count_result = mysqli_query($con, $admin_mass_count) or die (mysqli_error($con));
  $admin_mass_count_row = $admin_mass_count_result-> fetch_assoc();

  /*---------------------item month revanue-----------------------*/
  $item_month_rev = "SELECT SUM(`m_1`), SUM(`m_2`),SUM(`m_3`),SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue WHERE item_by_revanue_item_creator_id = '$log_user_id'";
  $item_month_rev_result = mysqli_query($con, $item_month_rev) or die (mysqli_error($con));
  $item_month_rev_row = $item_month_rev_result-> fetch_assoc();
  /*---------------------flash month revanue-----------------------*/
  $flash_month_rev = "SELECT SUM(`m_1`), SUM(`m_2`),SUM(`m_3`),SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM flash_by_revanue WHERE flash_by_revanue_item_creator_id = '$log_user_id'";
  $flash_month_rev_result = mysqli_query($con, $flash_month_rev) or die (mysqli_error($con));
  $flash_month_rev_row = $flash_month_rev_result-> fetch_assoc();
  
  
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
              <img id="user_img" src="../serprise/<?php echo $row['creator_image']; ?>">
          </div>
        </a>
        <a href="" class="simple-text logo-normal">
          <p id="user_name"><?php echo $row['creator_name']; ?></p>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
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
          <li>
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
            <a class="navbar-brand" href="">Creater</a>
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
     <!---------notification card------------->
      <div class="content">
        <div class="row">
          <!---------creater Avalabel Item card------------->
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href=""><i class="nc-icon text-warning nc-layout-11"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">You'r Avalabel Item</p>
                      <p class="card-title"><?php echo  $creater_aval_item_count_row['count(`item_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href=""> Update Now</a> ( Item Types)
                </div>
              </div>
            </div>
          </div>
          <!---------creater Avalabel flash card------------->
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href=""><i class="nc-icon nc-tag-content text-primary"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">You'r Flash Item</p>
                      <p class="card-title"><?php echo $creater_flash_count_row['COUNT(`flash_sale_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href=""> Update Now</a>
                </div>
              </div>
            </div>
          </div>
          <!---------Sold Item quntity card------------->
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <a href=""><i class="nc-icon nc-box text-success"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Sold Item Quntity
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
                <a href=""><i class="fa fa-refresh"></i></a><a href=""> Update Now</a> (All Item Quntity)
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
                      <a href=""><i class="nc-icon nc-alert-circle-i text-danger"></i></a>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">All Sold Item</p>
                      <p class="card-title"><?php echo $all_sold_item_row['COUNT(`item_id`)'] ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href=""> Update Now</a>
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
                      <p class="card-category">Admin Massage</p>
                      <p class="card-title"><?php echo $admin_mass_count_row['COUNT(`admin_cre_feed_id`)']; ?>
                        <p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ">
                <hr>
                <div class="stats">
                  <a href=""><i class="fa fa-refresh"></i></a><a href="adminMassage.php"> Go Now</a>
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
                <h5 class="card-title">Creater Item Monthly Revanue Chart</h5>
                <p class="card-category">All Month Creater Revanue Report Chart(<?php echo $current_year; ?>)</p>
              </div>
              <div class="card-body">
                <canvas id="i_p_f_hart" width="400" height="100"></canvas>
              </div>
              <div class="card-footer">
                <div class="chart-legend">
                  <i class="fa fa-circle text-info"></i> Monthly Revanue
                </div>
                <hr/>
                <div class="stats">
                  <a href=""><i class="fa fa-history"></i> Update To Today</a>
                </div>
              </div>
            </div>
          </div>
          <!-----------flash order table--------------->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">  Item Sold Quntity</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Item Sold Quntity
                      </th>
                      <th>
                        Item Avalebel Quntity
                      </th>
                      <th class="text-right">
                        Item Price
                      </th>
                    </thead>
                    <tbody>
                      <?php
                        /*--------------------creater sold item quntity list-------------------------*/ 
                        if(mysqli_num_rows($cre_item_qun_result) > 0){
                          $number1 = 0;
                            while ($cre_item_qun_row = $cre_item_qun_result-> fetch_assoc()){
                                /*--------------------creater sold item quntity list display-------------------------*/
                                $sold_item_id = $cre_item_qun_row['item_by_quntity_id'];
                                $number1 =  $number1+1;
                                /*--------------------get item table-------------------------*/
                                $item = "SELECT * FROM item WHERE item_id='$sold_item_id'";
                                $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                                $item_row = $item_result-> fetch_assoc();
                              
                                  echo '<tr>
                                    <td>
                                      '.$number1.'
                                    </td>
                                    <td>
                                      '.$item_row['item_name'].'
                                    </td>
                                    <td>
                                      '.$cre_item_qun_row['item_by_quntity_qun'].'
                                    </td>';
                                    if($item_row['item_quantity'] > 5){
                                      echo'<td>
                                        '.$item_row['item_quantity'].'
                                      </td>';
                                    }else{
                                      echo'<td class="exper_table">
                                        '.$item_row['item_quantity'].'
                                      </td>';
                                    }
                                    echo'<td class="text-right">
                                      '.$item_row['item_price'].'
                                    </td>
                                  </tr>';
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
                                <td class="text-right">
                                Rs: '.$no_sold_amount_diss_all.'
                                </td>
                              </tr>';
                            }else{
                              if($ex_date >= 5){
                                echo'<tr>
                                  <td>
                                    '.$count4.'
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
                                  <td class="text-right">
                                  Rs: '.$no_sold_amount_diss_all.'
                                  </td>
                                </tr>';
                              }else{
                                echo'<tr class="no_exper_table">
                                  <td>
                                    '.$count4.'
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
                                  <td class="text-right">
                                  Rs: '.$no_sold_amount_diss_all.'
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
      <!----------footer---------->
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="add.php" target="_blank">Suprisc.lk team </a>
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
          var item_jan = "<?php echo $item_month_rev_row['SUM(`m_1`)'] + $flash_month_rev_row['SUM(`m_1`)'] ?>";
          var item_feb = "<?php echo $item_month_rev_row['SUM(`m_2`)'] + $flash_month_rev_row['SUM(`m_2`)'] ?>";
          var item_mar = "<?php echo $item_month_rev_row['SUM(`m_3`)'] + $flash_month_rev_row['SUM(`m_3`)'] ?>";
          var item_apr = "<?php echo $item_month_rev_row['SUM(`m_4`)'] + $flash_month_rev_row['SUM(`m_4`)'] ?>";
          var item_may = "<?php echo $item_month_rev_row['SUM(`m_5`)'] + $flash_month_rev_row['SUM(`m_5`)'] ?>";
          var item_jun = "<?php echo $item_month_rev_row['SUM(`m_6`)'] + $flash_month_rev_row['SUM(`m_6`)'] ?>";
          var item_jul = "<?php echo $item_month_rev_row['SUM(`m_7`)'] + $flash_month_rev_row['SUM(`m_7`)'] ?>";
          var item_aug = "<?php echo $item_month_rev_row['SUM(`m_8`)'] + $flash_month_rev_row['SUM(`m_8`)'] ?>";
          var item_sep = "<?php echo $item_month_rev_row['SUM(`m_9`)'] + $flash_month_rev_row['SUM(`m_9`)'] ?>";
          var item_oct = "<?php echo $item_month_rev_row['SUM(`m_10`)'] + $flash_month_rev_row['SUM(`m_10`)'] ?>";
          var item_nov = "<?php echo $item_month_rev_row['SUM(`m_11`)'] + $flash_month_rev_row['SUM(`m_11`)'] ?>";
          var item_dec = "<?php echo $item_month_rev_row['SUM(`m_12`)'] + $flash_month_rev_row['SUM(`m_12`)'] ?>";
          
          var speedCanvas = document.getElementById("i_p_f_hart");
          
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

          var speedData = {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [dataSecond]
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
          
    </script>
  </body>
</html>
