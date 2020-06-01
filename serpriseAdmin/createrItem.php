<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  $error_emty ='';
  $today=date("Y-m-d");
  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------creater New Request--------------------*/
  $new_req = "SELECT * FROM new_creater_add WHERE new_creater_add_state='Active' ORDER BY new_creater_add_id DESC";
  $new_req_result = mysqli_query($con, $new_req) or die (mysqli_error($con));

   /*--------------- item quntity request--------------------*/
   $qun_item_req = "SELECT * FROM cerator_qun_req WHERE cerator_qun_req_satate='Active' ORDER BY cerator_qun_req_id DESC";
   $qun_item_req_result = mysqli_query($con, $qun_item_req) or die (mysqli_error($con));

   /*---------------new item request--------------------*/
   $new_item_req = "SELECT * FROM cerator_item_new_req WHERE cerator_item_new_req_state='Active' ORDER BY cerator_item_new_req_id DESC";
   $new_item_req_result = mysqli_query($con, $new_item_req) or die (mysqli_error($con));

   /*--------------------get creater table-------------------------*/
   $creater_list = "SELECT * FROM creator ";
   $creater_list_result = mysqli_query($con, $creater_list) or die (mysqli_error($con));
   
   /*---------------------user feedback count-----------------------*/
   $user_fedb_count = "SELECT COUNT(`user_feedback_id`) FROM user_feedback WHERE user_feedback_state = 'Active'";
   $user_fedb_count_result = mysqli_query($con, $user_fedb_count) or die (mysqli_error($con));
   $user_fedb_count_row = $user_fedb_count_result-> fetch_assoc();

  /*---------------------chat count-----------------------*/
  $chat_count = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_resever = '$log_user_id' AND chat_state = 'Active'";
  $chat_count_result = mysqli_query($con, $chat_count) or die (mysqli_error($con));
  $chat_count_row = $chat_count_result-> fetch_assoc();

  if(isset($_POST["submit"])){
    /*------get form data-------*/
    $massage=$con->real_escape_string($_POST["mass"]);
    $subject=$con->real_escape_string($_POST["sub"]);
    $send_id=$con->real_escape_string($_POST["cre"]);
    
    /*------form validation-------*/
    if(!empty($massage) && !empty($subject)){
      if($send_id != 0){
        $insert_massage = "INSERT INTO admin_cre_feed (admin_cre_feed_cre_id, admin_cre_feed_subject, admin_cre_feed_massage, admin_cre_feed_date, admin_cre_feed_admin, admin_cre_feed_state)
        VALUES('$send_id', '$subject', '$massage', '$today', '$log_user_id', 'Active')";
        $insert_massage = mysqli_query($con, $insert_massage) or die (mysqli_error($con));

          /*--------------load createrItem-------------------*/
          header("location: createrItem.php");
      }else{
        /*--------------------get creater table-------------------------*/
        $creater_list_all = "SELECT * FROM creator ";
        $creater_list_all_result = mysqli_query($con, $creater_list_all) or die (mysqli_error($con));
        while ($creater_list_all_row = $creater_list_all_result-> fetch_assoc()){
          $send_cre_id = $creater_list_all_row['creator_id'];

          $insert_massage = "INSERT INTO admin_cre_feed (admin_cre_feed_cre_id, admin_cre_feed_subject, admin_cre_feed_massage, admin_cre_feed_date, admin_cre_feed_admin, admin_cre_feed_state)
          VALUES('$send_cre_id', '$subject', '$massage', '$today', '$log_user_id', 'Active')";
          $insert_massage = mysqli_query($con, $insert_massage) or die (mysqli_error($con));
        }
        /*--------------load createrItem-------------------*/
        header("location: createrItem.php");
      }
    }else{
      $error_emty ="Fill All Fild & Submit";
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
          <li class="active">
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
            <a class="navbar-brand" href="">Creater Request</a>
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
      <!----------new Creater Request tabel---------->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Add New Creater</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        Full Name
                      </th>
                      <th>
                        Tel :
                      </th>
                      <th>
                        Email
                      </th>
                      <th>
                        Skil
                      </th>
                      <th>
                        Genger
                      </th>
                      <th>
                        Birthday
                      </th>
                      <th>
                        Address
                      </th>
                      <th>
                        UserName
                      </th>
                      <th class="text-right">
                      Image
                      </th>
                    </thead>
                    <tbody>
                    <?php
                      /*--------------------No Request------------------------*/ 
                      if(mysqli_num_rows($new_req_result) > 0){
                        $number = 0;
                          while ($new_req_row = $new_req_result-> fetch_assoc()){
                              $request_id = $new_req_row['new_creater_add_id'];
                                echo '<tr>
                                  <td>
                                    '.$number.'
                                  </td>
                                  <td>
                                    <a href="exphp/creReqRemove.php?rqid='.$request_id.'"><button type="button" class="shipp_button">Remove</button></a>
                                  </td>
                                  <td class="text-right">
                                    <a href="exphp/crereqacsept.php?rqid='.$request_id.'"><button type="button" class="shipp_button">Acpept</button></a>
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_ful_name'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_tel'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_email'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_skil'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_gender'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_bathday'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_addres'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_user_name'].'
                                  </td>
                                  <td>
                                    '.$new_req_row['new_creater_add_img'].'
                                  </td>
                                </tr>';
                              
                          }
                      }else{
                        echo'<h2 class="no_error">No Request Now</h2>';
                      }
                    ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-----------new item request table--------------->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> New Item Request</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Price
                      </th>
                      <th>
                        Quntity
                      </th>
                      <th>
                        Creater
                      </th>
                      <th>
                        Creater Email
                      </th>
                      <th>
                        Weight
                      </th>
                      <th>
                        Catagory
                      </th>
                      <th>
                        Catagory Avalbel Count
                      </th>
                      <th>
                        About
                      </th>
                      <th>
                        Custom
                      </th>
                      <th>
                        Date
                      </th>
                      <th class="text-right">
                        Image
                      </th>
                    </thead>
                    <tbody>
                      <?php 
                        if(mysqli_num_rows($new_item_req_result) > 0){
                          $number1 = 0;
                            while ($new_item_req_row = $new_item_req_result-> fetch_assoc()){
                                $new_item_req_id = $new_item_req_row['cerator_item_new_req_id'];
                                $new_item_req_cre_id = $new_item_req_row['cerator_item_new_req_cre_id'];
                                $new_item_req_cata_id = $new_item_req_row['cerator_item_new_req_cata'];
                                $number1 =  $number1+1;
                                /*--------------------get creater table-------------------------*/
                                $req_creater = "SELECT * FROM creator WHERE creator_id='$new_item_req_cre_id'";
                                $req_creater_result = mysqli_query($con, $req_creater) or die (mysqli_error($con));
                                $req_creater_row = $req_creater_result-> fetch_assoc();
                                /*--------------------get catagory table-------------------------*/
                                $req_catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$new_item_req_cata_id'";
                                $req_catagory_result = mysqli_query($con, $req_catagory) or die (mysqli_error($con));
                                $req_catagory_row = $req_catagory_result-> fetch_assoc();
                                
                                  echo '<tr>
                                    <td>
                                      '. $number1.'
                                    </td>
                                    <td>
                                      <a href="exphp/newItemReqRemove.php?nirqid='.$new_item_req_id.'"><button type="button" class="shipp_button">Remove</button></a>
                                    </td>
                                    <td>
                                      <a href="exphp/newItemReqAcsept.php?nirqid='.$new_item_req_id.'"><button type="button" class="shipp_button">Acsept</button></a>
                                    </td>
                                    <td>
                                      '.$new_item_req_row['cerator_item_new_req_item_name'].'
                                    </td>
                                    <td>
                                    Rs: '.$new_item_req_row['cerator_item_new_req_price'].'
                                    </td>
                                    <td>
                                      '.$new_item_req_row['cerator_item_new_req_qun'].'
                                    </td>
                                    <td>
                                      '.$req_creater_row['creator_name'].'
                                    </td>
                                    <td>
                                      '.$req_creater_row['creator_email'].'
                                    </td>
                                    <td>
                                      '.$new_item_req_row['cerator_item_new_req_weight'].'Kg
                                    </td>
                                    <td>
                                      '.$req_catagory_row['item_catagory_name'].'
                                    </td>
                                    <td>
                                      '.$req_catagory_row['item_catagory_count'].'
                                    </td>
                                    <td>
                                      '.$new_item_req_row['cerator_item_new_req_about'].'
                                    </td>
                                    <td>
                                      '.$new_item_req_row['cerator_item_new_req_custom'].'
                                    </td>
                                    <td>
                                      '.$new_item_req_row['cerator_item_new_req_date'].'
                                    </td>
                                    <td class="text-right">
                                      '.$new_item_req_row['cerator_item_new_req_img'].'
                                    </td>
                                  </tr>';
                                
                            }
                        }else{
                          echo'<h2 class="no_error">No Request Now</h2>';
                        }
                      ?> 
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-----------quntity item request table--------------->
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Quntity Item Request</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Price
                      </th>
                      <th>
                        Avalabel Price
                      </th>
                      <th>
                        Quntity
                      </th>
                      <th>
                        Avalabel Quntity
                      </th>
                      <th>
                        Sold Quntity
                      </th>
                      <th>
                        Creater
                      </th>
                      <th>
                        Creater Email
                      </th>
                      <th>
                        Weight
                      </th>
                      <th>
                        Avalabel Weight
                      </th>
                      <th>
                        Catagory
                      </th>
                      <th>
                        About
                      </th>
                      <th>
                        Custom
                      </th>
                      <th class="text-right">
                      Date
                      </th>
                    </thead>
                    <tbody>
                      <?php 
                        if(mysqli_num_rows($qun_item_req_result) > 0){
                          $number2 = 0;
                            while ($qun_item_req_row = $qun_item_req_result-> fetch_assoc()){
                                $qun_item_req_id = $qun_item_req_row['cerator_qun_req_id'];
                                $qun_item_req_item_id = $qun_item_req_row['cerator_qun_req_item_id'];
                                $qun_item_req_cre_id = $qun_item_req_row['cerator_qun_req_cre_id'];
                                $number2 =  $number2+1;

                                /*--------------------get creater table-------------------------*/
                                $qun_req_creater = "SELECT * FROM creator WHERE creator_id='$qun_item_req_cre_id'";
                                $qun_req_creater_result = mysqli_query($con, $qun_req_creater) or die (mysqli_error($con));
                                $qun_req_creater_row = $qun_req_creater_result-> fetch_assoc();

                                /*---------------------item table-----------------------*/
                                $qun_item = "SELECT * FROM item WHERE item_id='$qun_item_req_item_id'";
                                $qun_item_result = mysqli_query($con, $qun_item) or die (mysqli_error($con));
                                $qun_item_row = $qun_item_result-> fetch_assoc();
                                $qun_item_cata = $qun_item_row['item_catagory_code'];

                                /*--------------------get catagory table-------------------------*/
                                $qun_req_catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$qun_item_cata'";
                                $qun_req_catagory_result = mysqli_query($con, $qun_req_catagory) or die (mysqli_error($con));
                                $qun_req_catagory_row = $qun_req_catagory_result-> fetch_assoc();

                                /*--------------------get sold quntity table-------------------------*/
                                $sold_item = "SELECT * FROM item_by_quntity WHERE item_by_quntity_item_id='$qun_item_req_item_id'";
                                $sold_item_result = mysqli_query($con, $sold_item) or die (mysqli_error($con));
                                $sold_item_row = $sold_item_result-> fetch_assoc();

                                $sold_flash = "SELECT * FROM flash_by_quntity WHERE flash_by_quntity_item_id='$qun_item_req_item_id'";
                                $sold_flash_result = mysqli_query($con, $sold_flash) or die (mysqli_error($con));
                                $sold_flash_row = $sold_flash_result-> fetch_assoc();

                                $sold_price = "SELECT * FROM price_by_quntity WHERE price_by_quntity_item_id='$qun_item_req_item_id'";
                                $sold_price_result = mysqli_query($con, $sold_price) or die (mysqli_error($con));
                                $sold_price_row = $sold_price_result-> fetch_assoc();

                                $qun_sold_item = 0;
                                $qun_sold_item = $sold_item_row['item_by_quntity_qun'] + $sold_flash_row['flash_by_quntity_qun'] + $sold_price_row['price_by_quntity_qun'];
                                
                                  echo '<tr>
                                    <td>
                                      '. $number2.'
                                    </td>
                                    <td>
                                      <a href="exphp/creQunReqRemove.php?qunrqid='.$qun_item_req_id.'"><button type="button" class="shipp_button">Remove</button></a>
                                    </td>
                                    <td>
                                      <a href="exphp/creQunReqAcsept.php?qunrqid='.$qun_item_req_id.'"><button type="button" class="shipp_button">Acsept</button></a>
                                    </td>
                                    <td>
                                      '.$qun_item_row['item_name'].'
                                    </td>
                                    <td>
                                    Rs: '.$qun_item_req_row['cerator_qun_req_price'].'
                                    </td>
                                    <td>
                                      Rs:'.$qun_item_row['item_price'].'
                                    </td>
                                    <td>
                                      '.$qun_item_req_row['cerator_qun_req_qun'].'
                                    </td>
                                    <td>
                                      '.$qun_item_row['item_quantity'].'
                                    </td>';
                                    if($qun_sold_item <= 0){
                                      echo'<td class="exper_table">
                                        One Or Not
                                    </td>';
                                    }else{
                                      if($qun_sold_item <= 10){
                                        echo'<td>
                                        '.$qun_sold_item.'
                                      </td>';
                                      }else{
                                        echo'<td class="no_exper_table">
                                        '.$qun_sold_item.'
                                      </td>';
                                      }
                                    }
                                    echo'<td>
                                      '.$qun_req_creater_row['creator_name'].'
                                    </td>
                                    <td>
                                      '.$qun_req_creater_row['creator_email'].'
                                    </td>
                                    <td>
                                      '.$qun_item_req_row['cerator_qun_req_weight'].'Kg
                                    </td>
                                    <td>
                                      '.$qun_item_row['item_weight'].'Kg
                                    </td>
                                    <td>
                                      '.$qun_req_catagory_row['item_catagory_name'].'
                                    </td>
                                    <td>
                                      '.$qun_item_req_row['cerator_qun_req_about'].'
                                    </td>
                                    <td>
                                      '.$qun_item_req_row['cerator_qun_req_custom'].'
                                    </td>
                                    <td class="text-right">
                                      '.$qun_item_req_row['cerator_qun_req_date'].'
                                    </td>
                                  </tr>';
                                
                            }
                        }else{
                          echo'<h2 class="no_error">No Request Now</h2>';
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
                <h5 class="card-title">Add Creater Massage</h5>
              </div>
              <p class="error"><?PHP echo $error_emty; ?></p>
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-12 pr-3">
                      <div class="form-group">
                      <label>Massage</label>
                        <textarea class="form-control" rows="8" cols="50" name="mass" placeholder="Emty"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8 pr-1">
                      <div class="form-group">
                        <label>Subject</label>
                        <input type="text" name="sub" class="form-control" placeholder="Emty">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Creater</label>
                        <select class="form-control" name="cre">
                          <?php
                            echo'<option value="0">All Creater</option>';
                            while($creater_list_row = $creater_list_result-> fetch_assoc()){
                              echo'<option value="'.$creater_list_row['creator_id'].'">'.$creater_list_row['creator_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Send</button>
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
