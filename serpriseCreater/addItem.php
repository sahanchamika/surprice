<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['creater_id'];

  $error_nacc ="";
  $today = date("Y-m-d");

  /*---------------------login creater details-----------------------*/
  $log_user = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------admin massage count-----------------------*/
  $admin_mass_count = "SELECT COUNT(`admin_cre_feed_id`) FROM admin_cre_feed WHERE admin_cre_feed_cre_id='$log_user_id' AND admin_cre_feed_state='Active'";
  $admin_mass_count_result = mysqli_query($con, $admin_mass_count) or die (mysqli_error($con));
  $admin_mass_count_row = $admin_mass_count_result-> fetch_assoc();

  /*-------------------get item table----------------*/
  $item = "SELECT * FROM item WHERE item_creator_id = '$log_user_id' ORDER BY item_quantity ASC";
  $item_result = mysqli_query($con, $item) or die (mysqli_error($con));

  /*---------------------catagory table-----------------------*/
  $cata = "SELECT * FROM item_catagory";
  $cata_result = mysqli_query($con, $cata) or die (mysqli_error($con));

  /*---------------------creater new iten request list-----------------------*/
  $new_qun_req_item = "SELECT * FROM cerator_item_new_req  WHERE cerator_item_new_req_cre_id='$log_user_id' ORDER BY cerator_item_new_req_id DESC";
  $new_qun_req_item_result = mysqli_query($con, $new_qun_req_item) or die (mysqli_error($con));

  if(isset($_POST["submit"])){
    /*------get form data-------*/
    $item_name=$con->real_escape_string($_POST["name"]);
    $item_weight=$con->real_escape_string($_POST["weight"]);
    $item_price=$con->real_escape_string($_POST["price"]);
    $item_dissc=$con->real_escape_string($_POST["disscri"]);
    $item_qunt=$con->real_escape_string($_POST["qun"]);
    $item_custom=$con->real_escape_string($_POST["custom"]);
    $item_catagory=$con->real_escape_string($_POST["cata"]);
    $item_img=$con->real_escape_string('img/itemreq/itemreq'.$_FILES['item_image']['name']);
    /*------form validation-------*/
    if(!empty($item_name) && !empty($item_weight) && !empty($item_price) && !empty($item_qunt) && !empty($item_dissc)){
      if($item_custom != '0' && $item_catagory != '0' ){
        if(preg_match("!image!",$_FILES['item_image']['type'])){
          if(copy($_FILES['item_image']['tmp_name'], $item_img)){
            $insert_item = "INSERT INTO cerator_item_new_req(cerator_item_new_req_cre_id, cerator_item_new_req_item_name, cerator_item_new_req_price, cerator_item_new_req_qun, cerator_item_new_req_weight, cerator_item_new_req_cata, cerator_item_new_req_about, cerator_item_new_req_custom, cerator_item_new_req_img, cerator_item_new_req_state, cerator_item_new_req_date)
            VALUES('$log_user_id', '$item_name', '$item_price', '$item_qunt', '$item_weight', '$item_catagory', '$item_dissc', '$item_custom', '$item_img', 'Active', '$today')";
            $insert_item_result = mysqli_query($con, $insert_item) or die (mysqli_error($con));

            if(mysqli_num_rows($insert_item_result) > 0){
              $error_nacc = 'Can not insert';
            }else{
            /*--------------load addItem-------------------*/
              header("location: addItem.php");
            }
          }else{
            $error_nacc ="Can't Insert Image";
          }
        }else{
          $error_nacc ="Select Valid Image";
        }
      }else{
        $error_nacc ="You Not Select Catagory Or Custom";
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
              <img id="user_img" src="../serprise/<?php echo $row['creator_image']; ?>">
          </div>
        </a>
        <a href="" class="simple-text logo-normal">
          <p id="user_name"><?php echo $row['creator_name']; ?></p>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li>
            <a href="indexCre.php">
              <i class="nc-icon nc-badge"></i>
              <p>Creater</p>
            </a>
          </li>
          <li class="active ">
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
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Item Details Edit</h4>
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
                        Item Name
                      </th>
                      <th>
                        Item Sold Price
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
                        $item_id = $item_row['item_id'];

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
                            <a href="addItemqun.php?itemid='.$item_id.'"><button type="button" class="shipp_button">Add Quntity</button></a>
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
          <div class="col-md-12">
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Add New Item Request</h5>
              </div>
              <p class="error"><?PHP echo $error_nacc; ?></p>
              <div class="card-body">
                <form action="addItem.php" method="post" enctype = "multipart/form-data">
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                      <label>Item Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Item Name">
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Unit Price</label>
                        <input type="number" name="price" class="form-control" placeholder="Price">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3 px-3">
                      <div class="form-group">
                        <label>Quntity</label>
                        <input type="number" name="qun" class="form-control" placeholder="Quntity">
                      </div>
                    </div>
                    <div class="col-md-3 pl-1">
                      <div class="form-group">
                        <label>Weight (Kg)</label>
                        <input type="text" name="weight" class="form-control" placeholder="Weight">
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
                    <div class="col-md-9">
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
                      <button type="submit" name="submit" class="btn btn-primary btn-round">Add Item</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title"> Item Request List</h4>
                <button type="button" class="shipp_dis_button" id="new_btn">New</button><button type="button" class="shipp_dis_button" id="qun_btn">Quntity</button>
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
                        Item Price
                      </th>
                      <th>
                        Item Quntity
                      </th>
                      <th>
                        Catagory
                      </th>
                      <th>
                        Weight
                      </th>
                      <th>
                        Custom
                      </th>
                      <th class="text-right">
                        
                      </th>
                    </thead>
                    <tbody id="tabel_body">
                    <?php
                     $number2 = 0;
                     while ($new_qun_req_item_row = $new_qun_req_item_result-> fetch_assoc()){
                       $number2 = $number2 +1;
                      
                       $qun_req_item_catagory = $new_qun_req_item_row['cerator_item_new_req_cata'];

                       /*-------------------get catagory table----------------*/
                       $catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$qun_req_item_catagory'";
                       $catagory_result = mysqli_query($con, $catagory) or die (mysqli_error($con));
                       $catagory_row = $catagory_result-> fetch_assoc();
                        echo'<tr>
                          <td>
                            '.$number2.'
                          </td>
                          <td>
                          '.$new_qun_req_item_row['cerator_item_new_req_item_name'].'
                          </td>
                          <td>
                            Rs: '.$new_qun_req_item_row['cerator_item_new_req_price'].'
                          </td>
                          <td>
                            '.$new_qun_req_item_row['cerator_item_new_req_qun'].'
                          </td>
                          <td>
                            '.$catagory_row['item_catagory_name'].'
                          </td>
                          <td>
                            '.$new_qun_req_item_row['cerator_item_new_req_weight'].' Kg
                          </td>
                          <td>
                            '.$new_qun_req_item_row['cerator_item_new_req_custom'].'
                          </td>';
                          if($new_qun_req_item_row['cerator_item_new_req_state'] == "Active"){
                            echo'<td class="text-right" id="cre_req_pen">
                              Pending..
                            </td>';
                          }else{
                            if($new_qun_req_item_row['cerator_item_new_req_state'] == "Acsept"){
                              echo'<td class="text-right" id="cre_req_acs">
                                Acsept
                              </td>';
                            }else{
                              echo'<td class="text-right" id="cre_req_rem">
                                Sorry,No Acsept
                              </td>';
                            }
                          }
                        echo'</tr>';
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
  <script type='text/javascript'>
      // display shipping details
        $(document).ready(function(){
            $("#new_btn").click(function(){
                $("#tabel_body").load("exphp/newReq.php",{
          
                });
            });
            $("#qun_btn").click(function(){
                $("#tabel_body").load("exphp/qunReq.php",{
                  
                });
            });
        });
  </script>

</body>

</php>
