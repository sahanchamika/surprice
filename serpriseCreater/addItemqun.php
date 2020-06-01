<?PHP include 'conection.php' ?>
<?PHP
   session_start();
   /*---------------------login user id-----------------------*/
   $log_user_id = $_SESSION['creater_id'];

  $error = "";
  $error2 = "";

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------admin massage count-----------------------*/
  $admin_mass_count = "SELECT COUNT(`admin_cre_feed_id`) FROM admin_cre_feed WHERE admin_cre_feed_cre_id='$log_user_id' AND admin_cre_feed_state='Active'";
  $admin_mass_count_result = mysqli_query($con, $admin_mass_count) or die (mysqli_error($con));
  $admin_mass_count_row = $admin_mass_count_result-> fetch_assoc();

   if(isset($_GET['itemid'])){
    /*------get pass value -------*/
    $itemid=$_GET['itemid'];
    /*---------------------item table-----------------------*/
    $item = "SELECT * FROM item WHERE item_id='$itemid'";
    $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
    $item_row = $item_result-> fetch_assoc();
  }

   if(isset($_POST["submit1"])){
    /*------get form data-------*/
    $item_id=$con->real_escape_string($_POST["itemid"]);
    $item_weight=$con->real_escape_string($_POST["weight"]);
    $item_price=$con->real_escape_string($_POST["price"]);
    $item_costom=$con->real_escape_string($_POST["custom"]);
    $item_qunt=$con->real_escape_string($_POST["qun"]);
    $item_dis=$con->real_escape_string($_POST["discri"]);
    $today = date("Y-m-d");
    /*------form validation-------*/
    if(!empty($item_weight) && !empty($item_price) && !empty($item_costom) && !empty($item_qunt) && !empty($item_dis)){

      $insert_item_req = "INSERT INTO cerator_qun_req (cerator_qun_req_cre_id, cerator_qun_req_item_id, cerator_qun_req_qun, cerator_qun_req_price, cerator_qun_req_weight, cerator_qun_req_about, cerator_qun_req_custom, cerator_qun_req_satate, cerator_qun_req_date)
      VALUES('$log_user_id', '$item_id', '$item_qunt', '$item_price', '$item_weight', '$item_dis', '$item_costom', 'Active', '$today')";
      $insert_item_req_result = mysqli_query($con, $insert_item_req) or die (mysqli_error($con));

      header("location: addItemqun.php?itemid=".$itemid."");
    }else{
      $error ="Fill All Fild & Submit";
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
            <a href="">
              <i class="nc-icon nc-single-copy-04"></i>
              <p>Add Item Quntity</p>
            </a>
          </li>
          <li>
            <a href="addItem.php">
              <i class="nc-icon nc-cart-simple"></i>
              <p>Add Item</p>
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
            <a class="navbar-brand" href="">Add Item</a>
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
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title"></h5>
                <p class="error"><?PHP echo $error; ?></p>
              </div>
                <p class="error"><?PHP ?></p>
              <div class="card-body">
                <form action="addItemqun.php?itemid=<?php echo $itemid ; ?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>Item Name (disabled)</label>
                        <input type="text" class="form-control" disabled="" placeholder="Item id" value="<?php echo $item_row['item_name']; ?>">
                        <input type="hidden" name="itemid" class="form-control" placeholder="Item id" value="<?php echo $item_row['item_id']; ?>">
                      </div>
                    </div>
                    <div class="col-md-4 pr-1">
                      <div class="form-group">
                        <label>Weight (Kg)</label>
                        <input type="number" name="weight" class="form-control" placeholder="Weight(kg)" value="<?php echo $item_row['item_weight']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 pr-1">
                      <div class="form-group">
                      <label>Unit Price</label>
                        <input type="number" name="price" class="form-control" placeholder="0" value="0">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Select Custom or Not</label>
                        <select class="form-control" name="custom">
                          <?php
                            echo'<option value="'.$item_row['item_custom'].'">No Select</option>';
                          ?>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Quntity</label>
                        <input type="number" name="qun" class="form-control" placeholder="Quntity" value="0">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group">
                        <label>Discription</label>
                        <input type="text" name="discri" class="form-control" placeholder="Item Discription" value="<?php echo $item_row['item_discription']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit1" class="btn btn-primary btn-round">Update</button>
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
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="add.php" target="_blank">Suprisc.lk team </a>
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
  

</body>

</php>
