<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  $error = "";
  $error2 = "";
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

  /*---------------------catagory table-----------------------*/
  $cata = "SELECT * FROM item_catagory";
  $cata_result = mysqli_query($con, $cata) or die (mysqli_error($con));

  /*---------------------creater table-----------------------*/
  $creater = "SELECT * FROM creator";
  $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));

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
    $item_id=$con->real_escape_string($_POST["itemide"]);
    $item_name=$con->real_escape_string($_POST["name"]);
    $item_weight=$con->real_escape_string($_POST["weight"]);
    $item_price=$con->real_escape_string($_POST["price"]);
    $item_dissc=$con->real_escape_string($_POST["diss"]);
    $item_qunt=$con->real_escape_string($_POST["qun"]);
    $item_dis=$con->real_escape_string($_POST["discri"]);
    /*------form validation-------*/
    if(!empty($item_name) && !empty($item_weight) && !empty($item_price) && !empty($item_dis)){
          
      $item2 = "SELECT * FROM item WHERE item_id='$item_id'";
      $item2_result = mysqli_query($con, $item2) or die (mysqli_error($con));
      $item2_row = $item2_result-> fetch_assoc();

      $item_qun = $item2_row['item_quantity'] + $item_qunt;
      /*-----------up date item details-------------*/
      $update_de = "UPDATE item SET item_quantity='$item_qun', item_name='$item_name', item_discription='$item_dis', item_weight='$item_weight', item_price='$item_price', item_discount='$item_dissc' WHERE item_id='$item_id'";
      $update_de_result = mysqli_query($con, $update_de) or die (mysqli_error($con));

      header("location: editItem.php?itemid=".$itemid."");
    }else{
      $error ="Fill All Fild & Submit";
    }
   }

   if(isset($_POST["submit2"])){
    /*------get form data-------*/
    $item_id=$con->real_escape_string($_POST["itemide2"]);
    $catagory=$con->real_escape_string($_POST["cata"]);
    $creater=$con->real_escape_string($_POST["cre"]);
    $custom=$con->real_escape_string($_POST["custom"]);

      /*-----------up date user details-------------*/
      $update_se = "UPDATE item SET item_catagory_code='$catagory', item_creator_id='$creater', item_custom='$custom' WHERE item_id='$item_id'";
      $update_se_result = mysqli_query($con, $update_se) or die (mysqli_error($con));

      header("location: editItem.php?itemid=".$itemid."");
   }

   if(isset($_POST["submit3"])){
    /*------get form data-------*/
    $item_id=$con->real_escape_string($_POST["itemide2"]);
    $item_img= $con->real_escape_string('../serprise/img/item/item'.$_FILES['itemimg']['name']);
    if(preg_match("!image!",$_FILES['itemimg']['type'])){
      if(copy($_FILES['itemimg']['tmp_name'], $item_img)){
        /*-----------up date item details-------------*/
        $update_img = "UPDATE item SET item_image='$item_img' WHERE item_id='$item_id'";
        $update_img_result = mysqli_query($con, $update_img) or die (mysqli_error($con));

        header("location: editItem.php?itemid=".$itemid."");
      }else{
        $error2 ="Can't Add Image";
      }
    }else{
      $error2 ="Plese Select Valid Image Image";
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
          <li class="active ">
            <a href="">
              <i class="nc-icon nc-single-copy-04"></i>
              <p>Edit Item</p>
            </a>
          </li>
          <li>
            <a href="item.php">
              <i class="nc-icon nc-layout-11"></i>
              <p>Item</p>
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
            <a class="navbar-brand" href="">Edit Item</a>
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
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title"></h5>
                <p class="error"><?PHP echo $error; ?></p>
              </div>
                <p class="error"><?PHP ?></p>
              <div class="card-body">
                <form action="editItem.php?itemid=<?php echo $itemid ; ?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>Item Id (disabled)</label>
                        <input type="text" class="form-control" disabled="" placeholder="Item id" value="<?php echo $item_row['item_id']; ?>">
                        <input type="hidden" name="itemide" class="form-control" placeholder="Item id" value="<?php echo $item_row['item_id']; ?>">
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
                      <label>Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price" value="<?php echo $item_row['item_price']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Discount</label>
                        <input type="number" name="diss" class="form-control" placeholder="Discount" value="<?php echo $item_row['item_discount']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Quntity</label>
                        <input type="number" name="qun" class="form-control" placeholder="Quntity" value="<?php echo $item_row['item_quantity']; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Item Name" value="<?php echo $item_row['item_name']; ?>">
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
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title"></h5>
              </div>
                <p class="error"><?PHP ?></p>
              <div class="card-body">
                <form action="editItem.php?itemid=<?php echo $itemid ; ?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-3 pl-2">
                      <div class="form-group">
                        <label>Catagory</label>
                        <input type="hidden" name="itemide2" class="form-control" placeholder="Item id" value="<?php echo $item_row['item_id']; ?>">
                        <select class="form-control" name="cata">
                          <?php
                            echo'<option value="'.$item_row['item_catagory_code'].'">No Select</option>';
                            while($cata_row = $cata_result-> fetch_assoc()){
                              echo'<option value="'.$cata_row['item_catagory_code'].'">'.$cata_row['item_catagory_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3 pl-2">
                      <div class="form-group">
                        <label>Creater</label>
                        <select class="form-control" name="cre">
                          <?php
                            echo'<option value="'.$item_row['item_creator_id'].'">No Select</option>';
                            while($creater_row = $creater_result-> fetch_assoc()){
                              echo'<option value="'.$creater_row['creator_id'].'">'.$creater_row['creator_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-3 pl-2">
                      <div class="form-group">
                        <label>Custom</label>
                        <select class="form-control" name="custom">
                          <?php
                            echo'<option value="'.$item_row['item_custom'].'">No Select</option>';
                          ?>
                            <option value="no">No</option>
                            <option value="yes">Yes</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit2" class="btn btn-primary btn-round">Update</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title"></h5>
              </div>
                <p class="error"><?PHP echo $error2; ?></p>
              <div class="card-body">
                <form action="editItem.php?itemid=<?php echo $itemid ; ?>" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-5">
                      <div class="form-group">
                        <label>Image (362 x 204 size)</label>
                        <input type="hidden" name="itemide2" class="form-control" placeholder="Item id" value="<?php echo $item_row['item_id']; ?>">
                        <input type="file" name="itemimg" class="form-control" accept="image/*">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit3" class="btn btn-primary btn-round">Update</button>
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
