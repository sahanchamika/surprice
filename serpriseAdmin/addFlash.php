<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  $error = " ";
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

  /*-------------------get item table----------------*/
  $item = "SELECT * FROM item ORDER BY item_quantity DESC";
  $item_result = mysqli_query($con, $item) or die (mysqli_error($con));

  /*-------------------get Delivary table----------------*/
  $delivary_com = "SELECT * FROM delivery_company";
  $delivary_com_result = mysqli_query($con, $delivary_com) or die (mysqli_error($con));

   if(isset($_GET['flshid'])){
    /*------get pass value -------*/
    $flashid=$_GET['flshid'];
  }

  if(isset($_POST["submit"])){
    /*------get form data-------*/
    $flash_id=$con->real_escape_string($_POST["flash_id"]);
    $deli_cost=$con->real_escape_string($_POST["decost"]);
    $deli_com=$con->real_escape_string($_POST["decompany"]);
    $price=$con->real_escape_string($_POST["price"]);
    $discount=$con->real_escape_string($_POST["dis"]);
    $quntity=$con->real_escape_string($_POST["quntity"]);
    $item_id=$con->real_escape_string($_POST["itemid"]);
    /*------form validation-------*/
    if(!empty($price) && !empty($quntity) && !empty($item_id)){

      $item_q = "SELECT * FROM item WHERE item_id='$item_id'";
      $item_q_result = mysqli_query($con, $item_q) or die (mysqli_error($con));
      $item_q_row = $item_q_result-> fetch_assoc();

      if($item_q_row['item_quantity'] >= $quntity){
        /*---------------------flash item list-----------------------*/
        $flash_q = "SELECT * FROM flash_sale WHERE flash_sale_id = '$flash_id'";
        $flash_q_result = mysqli_query($con, $flash_q) or die (mysqli_error($con));
        $flash_q_row = $flash_q_result-> fetch_assoc();
        $flash_quntity_now = $flash_q_row['flash_sale_quantity'];
        $flash_item_now = $flash_q_row['flash_sale_item_id'];
        /*--------get item avalebel quntity-------------------*/
        $item_alq = "SELECT * FROM item WHERE item_id='$flash_item_now'";
        $item_alq_result = mysqli_query($con, $item_alq) or die (mysqli_error($con));
        $item_alq_row = $item_alq_result-> fetch_assoc();
        $item_quntity_now = $item_alq_row['item_quantity'];
        /*--------caiculate old flash quntity-------------*/
        $old_flash_qun = $item_quntity_now + $flash_quntity_now;
        /*--------update item old flash quntity---------*/
        $update_item_qunt = "UPDATE item SET item_quantity='$old_flash_qun' WHERE item_id='$flash_item_now'";
        $update_item_qunt_result = mysqli_query($con, $update_item_qunt) or die (mysqli_error($con));

        /*----------new add flash item avelbel quntity---------*/
        $item_avalbel_qun = $item_q_row['item_quantity'];
        $after_add_itm_quntity = $item_avalbel_qun - $quntity;
        /*--------update item after adding flash sale---------*/
        $update_item_after_add = "UPDATE item SET item_quantity='$after_add_itm_quntity' WHERE item_id='$item_id'";
        $update_item_after_add_result = mysqli_query($con, $update_item_after_add) or die (mysqli_error($con));
        /*---------get flash sale details table---------*/
        $flash_details = "SELECT * FROM flash_sale_details LIMIT 1";
        $flash_details_result = mysqli_query($con, $flash_details) or die (mysqli_error($con));
        $flash_details_row = $flash_details_result-> fetch_assoc();

        $flash_cata = $item_q_row['item_catagory_code'];
        $flash_creater = $item_q_row['item_creator_id'];
        $flash_name = $item_q_row['item_name'];
        $flash_discri = $item_q_row['item_discription'];
        $flash_custom = $item_q_row['item_custom'];
        $flash_img = $con->real_escape_string($item_q_row['item_image']);
        $flash_rate = $item_q_row['item_sale_rate'];
        $flash_time = $flash_details_row['flash_sale_details_rang'];
        /*--------update flash---------*/
        $update_flash = "UPDATE flash_sale SET flash_sale_item_id='$item_id', flash_sale_cata_code='$flash_cata', flash_sale_creator_id='$flash_creater', flash_sale_name='$flash_name', flash_sale_price='$price', flash_sale_quantity='$quntity', flash_sale_discription='$flash_discri', flash_sale_custom='$flash_custom', flash_sale_image = '$flash_img', flash_sale_rate='$flash_rate', flash_sale_time_rang='$flash_time', flash_sale_dilivary_com_id='$deli_com', flash_sale_delivary_cost='$deli_cost', flash_sale_discount=' $discount' WHERE flash_sale_id='$flash_id'";
        $update_flash_result = mysqli_query($con, $update_flash) or die (mysqli_error($con));

        header("location: item.php");
      }else{
        $error ="Not Avalbel Quntity This Item";
      }  
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
              <i class="nc-icon nc-simple-add"></i>
              <p>Flash Sale Update</p>
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
            <a class="navbar-brand" href="#pablo">Update Flash Sale</a>
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
          <div class="col-md-10">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title"></h5>
                <p class="error"><?PHP echo $error; ?></p>
              </div>
              <div class="card-body">
                <form role="form" method = "post" action = "addFlash.php?flshid=<?php echo $flashid; ?>">
                  <div class="row">
                    <div class="col-md-4 px-3">
                      <div class="form-group">
                        <label>Item Id</label>
                        <input type="number" class="form-control" placeholder="Enter id" name="itemid">
                        <!-----get pass velue hidden input------->
                        <input type="hidden" name="flash_id" value="<?php echo $flashid; ?>">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Item Quntity</label>
                        <input type="number" class="form-control" placeholder="Item Quntity" name="quntity">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Disscount</label>
                        <input type="number" class="form-control" placeholder="Discount" name="dis" value="0">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 px-3">
                      <div class="form-group">
                        <label>Price</label>
                        <input type="number" class="form-control" placeholder="Price (Rs)" name="price">
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Delivary Company</label>
                        <select class="form-control" name="decompany">
                          <?php
                            while($delivary_com_row = $delivary_com_result-> fetch_assoc()){
                              echo'<option value="'.$delivary_com_row['delivery_company_id'].'">'.$delivary_com_row['delivery_company_name'].'</option>';
                            }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Delivary Cost</label>
                        <input type="number" class="form-control" placeholder="Delivary Cost" name="decost" value="0">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Add Flash</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Item Details</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive" id="max_tabel_hight">
                  <table class="table">
                    <thead class=" text-primary">
                      <th>
                        Number
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
                        Rate 
                      </th>
                      <th>
                        Add Date
                      </th>
                      <th class="text-right">
                        Weight
                      </th>
                    </thead>
                    <tbody>
                    <?php
                       $number = 0;
                       while ($item_row = $item_result-> fetch_assoc()){
                         $number = $number +1;
                         $item_catagory = $item_row['item_catagory_code'];
 
                         /*-------------------get catagory table----------------*/
                         $catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$item_catagory'";
                         $catagory_result = mysqli_query($con, $catagory) or die (mysqli_error($con));
                         $catagory_row = $catagory_result-> fetch_assoc();
 
                         if($item_row['item_quantity'] > 10){
                           echo'<tr class="no_exper_table">';
                         }else{
                           echo '<tr class="exper_table">';
                         }
                           echo'<td>
                             '.$number.'
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
                             '.$item_row['item_sale_rate'].'
                           </td>
                           <td>
                             '.$item_row['item_add_date'].'
                           </td>
                           <td class="text-right">
                            '.$item_row['item_weight'].' Kg
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
