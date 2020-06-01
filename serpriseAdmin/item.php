<?PHP include 'conection.php' ?>
<?PHP
  session_start();
  $error_nacc ="";
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

  /*---------------------avalebel item count-----------------------*/
  $aval_item_count = "SELECT count(`item_id`) FROM item WHERE item_quantity > 0";
  $aval_item_count_result = mysqli_query($con, $aval_item_count) or die (mysqli_error($con));
  $aval_item_count_row = $aval_item_count_result-> fetch_assoc();

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


  /*-------------------get item table----------------*/
  $item = "SELECT * FROM item ORDER BY item_quantity ASC";
  $item_result = mysqli_query($con, $item) or die (mysqli_error($con));

  /*---------------------catagory table-----------------------*/
  $cata = "SELECT * FROM item_catagory";
  $cata_result = mysqli_query($con, $cata) or die (mysqli_error($con));

  /*---------------------creater table-----------------------*/
  $creater_list = "SELECT * FROM creator";
  $creater_list_result = mysqli_query($con, $creater_list) or die (mysqli_error($con));

  /*---------------------flash item list-----------------------*/
  $flash_item = "SELECT * FROM flash_sale ORDER BY flash_sale_quantity ASC LIMIT 8";
  $flash_item_result = mysqli_query($con, $flash_item) or die (mysqli_error($con));

  if(isset($_POST["submit_item"])){
    /*------get form data-------*/
    $item_name=$con->real_escape_string($_POST["name"]);
    $item_weight=$con->real_escape_string($_POST["weight"]);
    $item_price=$con->real_escape_string($_POST["price"]);
    $item_dissc=$con->real_escape_string($_POST["disscri"]);
    $item_qunt=$con->real_escape_string($_POST["qun"]);
    $item_dis=$con->real_escape_string($_POST["dis"]);
    $item_custom=$con->real_escape_string($_POST["custom"]);
    $item_creater=$con->real_escape_string($_POST["creater"]);
    $item_catagory=$con->real_escape_string($_POST["cata"]);
    $item_img= $con->real_escape_string('../serprise/img/item/item'.$_FILES['item_image']['name']);
    /*------form validation-------*/
    if(!empty($item_name) && !empty($item_weight) && !empty($item_price) && !empty($item_dis) && !empty($item_qunt) && !empty($item_dissc)){
      if($item_custom != '0' && $item_creater != '0' && $item_catagory != '0' ){
        if(preg_match("!image!",$_FILES['item_image']['type'])){
          if(copy($_FILES['item_image']['tmp_name'], $item_img)){
            $insert_item = "INSERT INTO item (item_catagory_code, item_creator_id, item_name, item_price, item_quantity, item_discription, item_custom, item_image, item_sale_rate, item_add_date, item_discount, item_weight)
            VALUES('$item_catagory', '$item_creater', '$item_name', '$item_price', '$item_qunt', '$item_dissc', '$item_custom', '$item_img', '0', '$today', '$item_dis', '$item_weight')";
            $insert_item_result = mysqli_query($con, $insert_item) or die (mysqli_error($con));

            if(mysqli_num_rows($insert_item_result) > 0){
              $error_nacc = 'Can not insert';
            }else{
            /*--------------load item-------------------*/
              header("location: item.php");
            }
          }else{
            $error_nacc ="Can't Insert Image";
          }
        }else{
          $error_nacc ="Select Valid Image";
        }
      }else{
        $error_nacc ="You Not Select Catagory, Creater Or Custom";
      }
    }else{
      $error_nacc ="Fill All Fild & Submit";
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
          <li class="active">
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
            <a class="navbar-brand" href="#pablo">Item Settings</a>
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
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Item Details Edit</h4>
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
                        
                      </th>
                      <th>
                        Item Id
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Item Price
                      </th>
                      <th>
                        Item Discount
                      </th>
                      <th>
                        Item Quntity
                      </th>
                      <th>
                        Catagory
                      </th>
                      <th>
                        Creater
                      </th>
                      <th>
                        Creater Email
                      </th>
                      <th>
                        Creater Tel:
                      </th>
                      <th>
                        Rate 
                      </th>
                      <th>
                        Add Date
                      </th>
                      <th>
                        Weight
                      </th>
                      <th class="text-right">
                        
                      </th>
                    </thead>
                    <tbody>
                    <?php
                      $number = 0;
                      while ($item_row = $item_result-> fetch_assoc()){
                        $number = $number +1;
                        $creater_id = $item_row['item_creator_id'];
                        $item_catagory = $item_row['item_catagory_code'];
                        $item_id = $item_row['item_id'];

                        /*-------------------get creater table----------------*/
                        $creater = "SELECT * FROM creator WHERE creator_id='$creater_id'";
                        $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
                        $creater_row = $creater_result-> fetch_assoc();

                        /*-------------------get catagory table----------------*/
                        $catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$item_catagory'";
                        $catagory_result = mysqli_query($con, $catagory) or die (mysqli_error($con));
                        $catagory_row = $catagory_result-> fetch_assoc();

                        if($item_row['item_quantity'] > 10){
                          echo'<tr>';
                        }else{
                          echo '<tr class="exper_table">';
                        }
                          echo'<td>
                            '.$number.'
                          </td>
                          <td>
                            <a href="updateQuntity.php?itemid='.$item_id.'"><button type="button" class="shipp_button">Quntity</button></a>
                          </td>
                          <td>
                            <a href="editItem.php?itemid='.$item_id.'"><button type="button" class="shipp_button">Edit</button></a>
                          </td>
                          <td>
                          '.$item_row['item_id'].'
                          </td>
                          <td>
                          '.$item_row['item_name'].'
                          </td>
                          <td>
                            Rs:'.$item_row['item_price'].'
                          </td>
                          <td>
                            '.$item_row['item_discount'].'%
                          </td>';
                          if($item_row['item_quantity'] == 0){
                            echo '<td>
                              All Sold
                            </td>';
                          }else{
                            echo'<td>
                              '.$item_row['item_quantity'].'
                            </td>';
                          }
                          echo' <td>
                            '.$catagory_row['item_catagory_name'].'
                          </td>
                          <td>
                            '.$creater_row['creator_name'].'
                          </td>
                          <td>
                            '.$creater_row['creator_email'].'
                          </td>
                          <td>
                            '.$creater_row['creator_tel'].'
                          </td>
                          <td>
                            '.$item_row['item_sale_rate'].'
                          </td>
                          <td>
                            '.$item_row['item_add_date'].'
                          </td>
                          <td>
                            '.$item_row['item_weight'].' Kg
                          </td>
                          <td class="text-right">
                            <a href="exphp/itemRemove.php?itemid='.$item_id.'"><button type="button" class="shipp_button">Remove</button></a>
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
                <h5 class="card-title">Add New Item</h5>
              </div>
              <p class="error"><?PHP echo $error_nacc; ?></p>
              <div class="card-body">
                <form action="item.php" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                      <label>Item Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Item Name">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Quntity</label>
                        <input type="number" name="qun" class="form-control" placeholder="Quntity">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                        <label>Discount</label>
                        <input type="number" name="dis" class="form-control" placeholder="Discount">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Weight</label>
                        <input type="text" name="weight" class="form-control" placeholder="Weight">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Creater</label>
                        <select class="form-control" name="creater">
                          <?php
                            echo'<option value="0">No Select</option>';
                            while($creater_list_row = $creater_list_result-> fetch_assoc()){
                              echo'<option value="'.$creater_list_row['creator_id'].'">'.$creater_list_row['creator_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Catagory</label>
                        <select class="form-control" name="cata">
                          <?php
                             echo'<option value="0">No Select</option>';
                            while($cata_row = $cata_result-> fetch_assoc()){
                              echo'<option value="'.$cata_row['item_catagory_code'].'">'.$cata_row['item_catagory_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Disscription</label>
                        <input type="text" name="disscri" class="form-control" placeholder="About somethings">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Custom</label>
                        <select class="form-control" name="custom">
                            <option value="0">No Select</option>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                      <label for="exampleInputEmail1">Item image (362 x 204 Size)</label>
                        <label class="form-control">.Jpg</label>
                        <input type="file" name="item_image" accept="image/*">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit_item" class="btn btn-primary btn-round">Add Item</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Flash Item Add</h4>
                <p class="card-category">8 Item Limit In Flash Sale</p>
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
                        Item Id
                      </th>
                      <th>
                        Item Name
                      </th>
                      <th>
                        Item Price
                      </th>
                      <th>
                        Flash Discount
                      </th>
                      <th>
                        Item Quntity
                      </th>
                      <th>
                        Catagory
                      </th>
                      <th>
                        Creater
                      </th>
                      <th>
                        Creater Email
                      </th>
                      <th>
                        Date Range
                      </th>
                      <th>
                        Delivary Company
                      </th>
                      <th>
                        Delivary Amount
                      </th>
                      <th class="text-right">
                        Weight
                      </th>
                    </thead>
                    <tbody>
                    <?php
                     $number2 = 0;
                     while ($flash_item_row = $flash_item_result-> fetch_assoc()){
                       $number2 = $number2 +1;
                       $creater_id = $flash_item_row['flash_sale_creator_id'];
                       $flash_item_catagory = $flash_item_row['flash_sale_cata_code'];
                       $flash_dily_id = $flash_item_row['flash_sale_dilivary_com_id'];
                       $flash_item_id = $flash_item_row['flash_sale_item_id'];
                       $flash_id = $flash_item_row['flash_sale_id'];

                       /*-------------------get creater table----------------*/
                       $creater = "SELECT * FROM creator WHERE creator_id='$creater_id'";
                       $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
                       $creater_row = $creater_result-> fetch_assoc();

                       /*-------------------get catagory table----------------*/
                       $catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$flash_item_catagory'";
                       $catagory_result = mysqli_query($con, $catagory) or die (mysqli_error($con));
                       $catagory_row = $catagory_result-> fetch_assoc();

                       /*-------------------get Delivary table----------------*/
                       $delivary_com = "SELECT * FROM delivery_company WHERE delivery_company_id='$flash_dily_id'";
                       $delivary_com_result = mysqli_query($con, $delivary_com) or die (mysqli_error($con));
                       $delivary_com_row = $delivary_com_result-> fetch_assoc();

                       /*-------------------get item table----------------*/
                       $item = "SELECT * FROM item WHERE item_id='$flash_item_id'";
                       $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                       $item_row = $item_result-> fetch_assoc();

                       if($flash_item_row['flash_sale_quantity'] > 5){
                         echo'<tr>';
                       }else{
                         echo '<tr class="exper_table">';
                       }
                       echo'<td>
                            '.$number2.'
                          </td>
                          <td>
                            <a href="addFlash.php?flshid='.$flash_id.'"><button type="button" class="shipp_button">+Add</button></a>
                          </td>
                          <td>
                          '.$flash_item_row['flash_sale_item_id'].'
                          </td>
                          <td>
                          '.$flash_item_row['flash_sale_name'].'
                          </td>
                          <td>
                            Rs:'.$flash_item_row['flash_sale_price'].'
                          </td>
                          <td>
                            '.$flash_item_row['flash_sale_discount'].'%
                          </td>';
                          if($flash_item_row['flash_sale_quantity'] == 0){
                            echo '<td>
                              All Sold
                            </td>';
                          }else{
                            echo'<td>
                              '.$flash_item_row['flash_sale_quantity'].'
                            </td>';
                          }
                          echo' <td>
                            '.$catagory_row['item_catagory_name'].'
                          </td>
                          <td>
                            '.$creater_row['creator_name'].'
                          </td>
                          <td>
                            '.$creater_row['creator_email'].'
                          </td>
                          <td>
                            '.$flash_item_row['flash_sale_time_rang'].'
                          </td>
                          <td>
                            '.$delivary_com_row['delivery_company_name'].'
                          </td>';
                          if($flash_item_row['flash_sale_delivary_cost'] == 0){
                            echo '<td>
                              Free
                            </td>';
                          }else{
                            echo'<td>
                              '.$flash_item_row['flash_sale_delivary_cost'].'
                            </td>';
                          }
                          echo'</td>
                          <td class="text-right">
                          <td>
                          '.$item_row['item_weight'].'Kg
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
