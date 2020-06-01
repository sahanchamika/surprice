<!--cart.lk-->
<?PHP include 'conection.php' ?>
<?PHP
session_start();

/*---login user id-----*/
$log_user_id = $_SESSION['log_user_id'];

/*---login user details-----*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$row = $log_user_result-> fetch_assoc();

/*---cart table-----*/
$cart = "SELECT * FROM cart WHERE cart_user_id='$log_user_id'";
$cart_result = mysqli_query($con, $cart) or die (mysqli_error($con));

$cart_count = "SELECT * FROM cart WHERE cart_user_id='$log_user_id'";
$cart_count_result = mysqli_query($con, $cart_count) or die (mysqli_error($con));

$number_of_item = 0;
$dilivary_cost = 0;
$total_amount = 0;

/*---cart summary-----*/
$number_of_item = mysqli_num_rows($cart_count_result);
/*------calculate total amount & total weight & total dilivary cost-----*/
while ($row2 = $cart_count_result-> fetch_assoc()){

    $dilivary_cost = $dilivary_cost + $row2['cart_delivery_cost'];
    $total_amount = $total_amount + $row2['cart_total_amount'];
}

?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk/cart</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    

    <!-- CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
        <header>
            <div class="header-area ">
                    <div id="sticky-header" class="main-header-area"> 
                        <div class="container-fluid">
                        <div class="header_bottom_border">
                            <div class="navbuttom">
                                <div class="row align-items-center">
                                    <div class="col-xl-2 col-lg-2">
                                        <div class="logo">
                                            <a href="logindex.php">
                                                <img src="img/logo.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6">
                                        <div class="main-menu  d-none d-lg-block">
                                            <nav>
                                                <ul id="navigation">
                                                    <li><a class="active" href="logindex.php">Home</a></li>
                                                    <li><a href="catagory.php?page=all">Go Shop Now</a></li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                                        <div class="social_wrap d-flex align-items-center justify-content-end">
                                            <div class="number">
                                                <p><?php echo $row["user_username"]; ?></p>
                                            </div>
                                            <!--account icon-->
                                            <div class="user_icon">
                                                <img src="<?php echo $row["user_image"]; ?>" alt="">
                                            </div>
                                            <div class="user_icon-hover">
                                                <div id="acc-details">
                                                    <div class="acc-details-image">
                                                        <img src="<?php echo $row["user_image"]; ?>" alt="">
                                                    </div>
                                                    <div class="acc-details-txt">
                                                        <h2><?php echo $row["user_full_name"]; ?></h2>
                                                        <h3><?php echo $row["user_email"]; ?></h3>
                                                        <h4><i class="fa fa-gift"></i> .<?php echo $row["user_menber_ship"]; ?> member</h4>
                                                        <p><?php echo $row["user_tel_number"]; ?></p>
                                                        <div class="acc-details-btn">
                                                            <div class="acc-details-btn-1"><a class="prise" href="exphp/logout.php">Log out</a></div>
                                                            <div class="acc-details-btn-2"><a class="prise" href="accsettings.php">Setting</a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="seach_icon">
                                        <a>
                                            <i class="fa fa-gift"></i>
                                        </a>
                                    </div>
                                    <div class="col-12">
                                        <div class="mobile_menu d-block d-lg-none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </header>
        <form action="cart.php" method="post">
        <!--------cart summary-------->
        <div class="cart_left">
            <h3 class="cart_sumery">Cart Sumery</h3>
            <table class="cart_sumery_ta">
                <tr>
                    <td><p class="cart_sumery_p">Number of Item:</p></td>
                    <td><p class="cart_sumery_p"><?php echo $number_of_item; ?> Item</p></td>
                </tr>
                <tr>
                    <td><p class="cart_sumery_p">Dilivary Cost:</p></td>
                    <td><p class="cart_sumery_p">Rs: <?php echo $dilivary_cost; ?></p></td>
                </tr>
                <tr>
                    <td><p class="cart_sumery_p">Total Amount:</p></td>
                    <td><p class="cart_sumery_p">Rs: <?php echo $total_amount; ?></p></td>
                </tr>
            </table>
            <?PHP
                /*-------check cart emty---------*/
                if($number_of_item > 0 ){
                    echo '<a href="exphp/buycatall.php" ><button type="button" class="buy_crt" >Buy Cart</button></a>';
                }else{
                    echo '<button type="button" class="buy_crt" >Buy Cart</button>';
                }
            ?>
        
        </div>
        <div>
            <table class="cart_table">
                <tr class="cart_h_tr">
                    <th ><h1 class="t_space"></h1></th>
                    <th><h1 class="t_space">Name</h1></th>
                    <th ><h1 class="t_space">Quntity</h1></th>
                    <th ><h1 class="t_space">Dilivary Cost</h1></th>
                    <th ><h1 class="t_space">Total</h1></th>
                    <th ><h1 class="t_space"></h1></th>
                    <th ><h1 class="t_space"></h1></th>
                    <th ><h1 class="t_space"></h1></th>
                    
                </tr>
                <?php
                    /*-------check cart emty---------*/
                    if(mysqli_num_rows($cart_result) > 0){
                        /*-------display cart---------*/
                        while ($row = $cart_result-> fetch_assoc()){
                            $cart_i_id = $row['cart_item_id'];
                            $catr_id = $row['cart_id'];
                            /*-------get item---------*/
                            $item = "SELECT * FROM item WHERE item_id='$cart_i_id' LIMIT 1";
                            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                            $item_row = $item_result-> fetch_assoc();
                            /*-------check cart item experd or no---------*/
                            if($row['cart_state'] == 'Active'){
                                /*--------not exper--------*/
                                echo '<tr class="cart_tr">
                                    <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                    <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                    <td ><p class="p_space">'.$row['cart_quntity'].'</p></td>
                                    <td ><p class="p_space">Rs:'.$row['cart_delivery_cost'].'</p></td>
                                    <td ><p class="p_space">Rs:'.$row['cart_total_amount'].'</p></td>
                                    <td ><p class="p_space" id="cart_active">'.$row['cart_state'].'</p></td>
                                    <td ><p class="p_space"><a href="exphp/buyonecart.php?cart_id='.$catr_id.'"><button type="button" class="cart_buy" name="buynow">Buy now</button></a></p></td>
                                    <td ><p class="p_space"><a href="exphp/remove.php?cart_id='.$catr_id.'"><button type="button" class="remove" name="remove">Remove</button></a></p></td>
                                </tr>';
                            }else{
                                /*--------exper--------*/
                                echo '<tr class="cart_tr_ex">
                                <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                <td ><p class="p_space">'.$row['cart_quntity'].'</p></td>
                                <td ><p class="p_space">Rs:'.$row['cart_delivery_cost'].'</p></td>
                                <td ><p class="p_space">Rs:'.$row['cart_total_amount'].'</p></td>
                                <td ><p class="p_space" id="bad_reat">'.$row['cart_state'].'</p></td>
                                <td ><p class="p_space">Can not buy now</p></td>
                                <td ><p class="p_space"><a href="exphp/remove.php?cart_id='.$catr_id.'"><button type="button" class="remove" name="remove">Remove</button></a></p></td>
                                </tr>';
                            }
                            
                        }
                        echo '</form>';
                    /*--------no cart item--------*/
                    }else{
                        echo '<h1 class="tabel_emty_error">No Cart item </h1>';
                    }

                ?>
            </table>
        </div>
        

    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/scrollIt.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/nice-select.min.js"></script>
    <script src="js/jquery.slicknav.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/gijgo.min.js"></script>
    <script src="js/slick.min.js"></script>
   
    <script src="js/contact.js"></script>
    <script src="js/jquery.ajaxchimp.min.js"></script>
    <script src="js/jquery.form.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <script src="js/mail-script.js"></script>
    <script src="js/main.js"></script>
    <script src="js/timer.js"></script>
    
</body>

</html>

<php?>