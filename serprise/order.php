<!--cart.lk-->
<?PHP include 'conection.php' ?>
<?PHP
session_start();

/*---login user id-----*/
$log_user_id = $_SESSION['log_user_id'];

/*---login user details-----*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$log_user_row = $log_user_result-> fetch_assoc();

/*-----------left 30 day-----------*/
$limit_date=date("Y-m-d",strtotime("-30 day"));

/*---order item table-----*/
$order_item = "SELECT * FROM order_item WHERE order_user_id='$log_user_id'";
$order_item_result = mysqli_query($con, $order_item) or die (mysqli_error($con));

/*---order flash table-----*/
$order_flash = "SELECT * FROM flash_order WHERE flash_order_user_id='$log_user_id'";
$order_flash_result = mysqli_query($con, $order_flash) or die (mysqli_error($con));

/*---order price table-----*/
$order_price = "SELECT *,SUM(`price_box_order_quntity`) FROM price_box_order WHERE price_box_order_user_id='$log_user_id' GROUP BY price_box_order_group_id";
$order_price_result = mysqli_query($con, $order_price) or die (mysqli_error($con));


$pending_order = mysqli_num_rows($order_item_result) + mysqli_num_rows($order_flash_result) + mysqli_num_rows($order_price_result);

/*---item shipping table-----*/
$item_shipping = "SELECT * FROM item_shipping WHERE item_shipping_user_id = '$log_user_id' AND item_shipping_date > '$limit_date' LIMIT 4";
$item_shipping_result = mysqli_query($con, $item_shipping) or die (mysqli_error($con));

/*---flash shipping table-----*/
$flash_shipping = "SELECT * FROM flash_shipping WHERE flash_shipping_user_id = '$log_user_id' AND flash_shipping_date > '$limit_date' LIMIT 3";
$flash_shipping_result = mysqli_query($con, $flash_shipping) or die (mysqli_error($con));

/*---price shipping table-----*/
$price_shipping = "SELECT *, SUM(`price_shipping_quntity`) FROM price_shipping WHERE price_shipping_user_id = '$log_user_id' AND price_shipping_date > '$limit_date' GROUP BY price_shipping_group_id LIMIT 3";
$price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));

/*---user item shipping count-----*/
$item_ship_count = "SELECT COUNT(`item_shipping_id`) FROM item_shipping WHERE item_shipping_user_id='$log_user_id'";
$item_ship_count_result = mysqli_query($con, $item_ship_count) or die (mysqli_error($con));
$item_ship_count_row = $item_ship_count_result-> fetch_assoc();

/*---user flash shipping count-----*/
$flash_ship_count = "SELECT COUNT(`flash_shipping_id`) FROM flash_shipping WHERE flash_shipping_user_id='$log_user_id'";
$flash_ship_count_result = mysqli_query($con, $flash_ship_count) or die (mysqli_error($con));
$flash_ship_count_row = $flash_ship_count_result-> fetch_assoc();

/*---user price shipping count-----*/
$price_ship_count = "SELECT * FROM price_shipping WHERE price_shipping_user_id = '$log_user_id' GROUP BY price_shipping_group_id";
$price_ship_count_result = mysqli_query($con, $price_ship_count) or die (mysqli_error($con));
$price_ship_count_row = mysqli_num_rows($price_ship_count_result);

/*-------calculate order count-----------*/
$total_comf_order = $item_ship_count_row['COUNT(`item_shipping_id`)'] + $flash_ship_count_row['COUNT(`flash_shipping_id`)'] + $price_ship_count_row;



?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk/order</title>
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
                                                <p><?php echo $log_user_row["user_username"]; ?></p>
                                            </div>
                                            <!--account icon-->
                                            <div class="user_icon">
                                                <img src="<?php echo $log_user_row["user_image"]; ?>" alt="">
                                            </div>
                                            <div class="user_icon-hover">
                                                <div id="acc-details">
                                                    <div class="acc-details-image">
                                                        <img src="<?php echo $log_user_row["user_image"]; ?>" alt="">
                                                    </div>
                                                    <div class="acc-details-txt">
                                                        <h2><?php echo $log_user_row["user_full_name"]; ?></h2>
                                                        <h3><?php echo $log_user_row["user_email"]; ?></h3>
                                                        <h4><i class="fa fa-gift"></i> .<?php echo $log_user_row["user_menber_ship"]; ?> Member</h4>
                                                        <p><?php echo $log_user_row["user_tel_number"]; ?></p>
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
            <h3 class="cart_sumery">Order Sumery</h3>
            <table class="cart_sumery_ta">
                <tr>
                    <td><p class="cart_sumery_p">Pending Order:</p></td>
                    <td><p class="cart_sumery_p"><?php echo $pending_order ; ?> Orders</p></td>
                </tr>
                <tr>
                    <td><p class="cart_sumery_p">Comform Order:</p></td>
                    <td><p class="cart_sumery_p"><?php echo $total_comf_order; ?> Orders</p></td>
                </tr>
                <tr>
                    <td><p class="cart_sumery_p">Menber Ship:</p></td>
                    <td><p class="cart_sumery_p"><?php echo $log_user_row["user_menber_ship"]; ?></p></td>
                </tr>
            </table>
            <?PHP
            
                /*-------check cart emty---------*/
                if($total_comf_order > 0 ){
                    echo '<button type="button" class="buy_crt" id="more_or_but" >More Order</button>';
                }else{
                    echo '<button type="button" class="buy_crt" >More Order</button>';
                }
            ?>
        
        </div>
        <div>
            <table class="cart_table">
                <tr class="cart_h_tr">
                    <th ><h1 class="t_space"></h1></th>
                    <th><h1 class="t_space">Name</h1></th>
                    <th ><h1 class="t_space">Quntity</h1></th>
                    <th ><h1 class="t_space">Total</h1></th>
                    <th ><h1 class="t_space">Order Date</h1></th>
                    <th ><h1 class="t_space">Shipping Date</h1></th>
                    <th ><h1 class="t_space"></h1></th>
                    
                </tr>
                <?php
                    /*-------check order item emty---------*/
                    if(mysqli_num_rows($order_item_result) > 0){
                        /*-------display order item---------*/
                        while($order_item_row = $order_item_result-> fetch_assoc()){
                            $order_item_id = $order_item_row['order_item_id'];
                            /*-------get item---------*/
                            $item = "SELECT * FROM item WHERE item_id='$order_item_id'";
                            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                            $item_row = $item_result-> fetch_assoc();
                                echo '<tr class="cart_tr">
                                    <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                    <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                    <td ><p class="p_space">'.$order_item_row['order_quntity'].'</p></td>
                                    <td ><p class="p_space">Rs:'.$order_item_row['order_amount'].'</p></td>
                                    <td ><p class="p_space">'.$order_item_row['order_date'].'</p></td>
                                    <td ><p class="p_space" id="cart_active">Pending..</p></td>
                                    <td ><p class="p_space">Item</p></td>
                                </tr>';
                        }  
                    /*--------no order item--------*/
                    }else{
                        echo '<h4 class="tabel_emty_error">No Order item </h4>';
                    }
                    /*-------check order flash emty---------*/
                    if(mysqli_num_rows($order_flash_result) > 0){
                        /*-------display order flash---------*/
                        while($order_flash_row = $order_flash_result-> fetch_assoc()){
                            $order_flash_id = $order_flash_row['flash_order_item_id'];
                            /*-------get item---------*/
                            $item = "SELECT * FROM item WHERE item_id='$order_flash_id'";
                            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                            $item_row = $item_result-> fetch_assoc();
                                echo '<tr class="cart_tr">
                                    <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                    <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                    <td ><p class="p_space">'.$order_flash_row['flash_order_quntity'].'</p></td>
                                    <td ><p class="p_space">Rs:'.$order_flash_row['flash_order_amount'].'</p></td>
                                    <td ><p class="p_space">'.$order_flash_row['flash_order_date'].'</p></td>
                                    <td ><p class="p_space" id="cart_active">Pending..</p></td>
                                    <td ><p class="p_space">Flash Sale</p></td>
                                </tr>';
                        }  
                    /*--------no order flash--------*/
                    }else{
                        echo '<h4 class="tabel_emty_error">No Flash Sale Order </h4>';
                    }
                    /*-------check order price emty---------*/
                    if(mysqli_num_rows($order_price_result) > 0){
                        /*-------display order price---------*/
                        while($order_price_row = $order_price_result-> fetch_assoc()){
                                echo '<tr class="cart_tr">
                                    <td ><p class="p_space"></p></td>
                                    <td ><p class="p_space">'.$order_price_row['price_box_order_name'].'</p></td>
                                    <td ><p class="p_space">'.$order_price_row['SUM(`price_box_order_quntity`)'].'</p></td>
                                    <td ><p class="p_space">Rs:'.$order_price_row['price_box_order_amount'].'</p></td>
                                    <td ><p class="p_space">'.$order_price_row['price_box_order_date'].'</p></td>
                                    <td ><p class="p_space" id="cart_active">Pending..</p></td>
                                    <td ><p class="p_space">Price Box</p></td>
                                </tr>';
                        }  
                    /*--------no order price--------*/
                    }else{
                        echo '<h4 class="tabel_emty_error">No Price Box Order </h4>';
                    }
                    echo'<tr class="cart_tr">
                        <td><p class="p_space" id="bad_reat">Ship Order</p></td>
                        <td><p class="p_space"></p></td>
                        <td><p class="p_space"></p></td>
                        <td><p class="p_space"></p></td>
                        <td><p class="p_space"></p></td>
                        <td><p class="p_space"></p></td>
                        <td><p class="p_space"></p></td>
                    </tr>';
                    echo'<tbody id="t_body">';
                        /*-------check item shipping emty---------*/
                        if(mysqli_num_rows($item_shipping_result) > 0){
                            /*-------display order item---------*/
                            while($item_shipping_row = $item_shipping_result-> fetch_assoc()){
                                $ship_item_item_id = $item_shipping_row['item_shipping_item_id'];
                                /*-------get item---------*/
                                $item = "SELECT * FROM item WHERE item_id='$ship_item_item_id'";
                                $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                                $item_row = $item_result-> fetch_assoc();
                                    echo '<tr class="cart_tr">
                                        <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                        <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                        <td ><p class="p_space">'.$item_shipping_row['item_shipping_quntity'].'</p></td>
                                        <td ><p class="p_space">Rs:'.$item_shipping_row['item_shipping_amount'].'</p></td>
                                        <td ><p class="p_space">'.$item_shipping_row['item_shipping_order_date'].'</p></td>
                                        <td ><p class="p_space" id="bad_reat">'.$item_shipping_row['item_shipping_date'].'</p></td>
                                        <td ><p class="p_space">Item</p></td>
                                    </tr>';
                            }  
                        /*--------no order item--------*/
                        }else{
                            
                        }
                        /*-------check flash shipping emty---------*/
                        if(mysqli_num_rows($flash_shipping_result) > 0){
                            /*-------display order flash---------*/
                            while($flash_shipping_row = $flash_shipping_result-> fetch_assoc()){
                                $ship_flash_item_id = $flash_shipping_row['flash_shipping_item_id'];
                                /*-------get item---------*/
                                $item = "SELECT * FROM item WHERE item_id='$ship_flash_item_id'";
                                $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                                $item_row = $item_result-> fetch_assoc();
                                    echo '<tr class="cart_tr">
                                        <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                        <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                        <td ><p class="p_space">'.$flash_shipping_row['flash_shipping_quntity'].'</p></td>
                                        <td ><p class="p_space">Rs:'.$flash_shipping_row['flash_shipping_amount'].'</p></td>
                                        <td ><p class="p_space">'.$flash_shipping_row['flash_shipping_order_date'].'</p></td>
                                        <td ><p class="p_space" id="bad_reat">'.$flash_shipping_row['flash_shipping_date'].'</p></td>
                                        <td ><p class="p_space">Flash Sale</p></td>
                                    </tr>';
                            }  
                        /*--------no order flash--------*/
                        }else{
                            
                        }
                        /*-------check price shipping emty---------*/
                        if(mysqli_num_rows($price_shipping_result) > 0){
                            /*-------display order price---------*/
                            while($price_shipping_row = $price_shipping_result-> fetch_assoc()){
                                
                                    echo '<tr class="cart_tr">
                                        <td ><p class="p_space">No</p></td>
                                        <td ><p class="p_space">No</p></td>
                                        <td ><p class="p_space">'.$price_shipping_row['SUM(`price_shipping_quntity`)'].'</p></td>
                                        <td ><p class="p_space">Rs:'.$price_shipping_row['price_shipping_amount'].'</p></td>
                                        <td ><p class="p_space">'.$price_shipping_row['price_shipping_order_date'].'</p></td>
                                        <td ><p class="p_space" id="bad_reat">'.$price_shipping_row['price_shipping_date'].'</p></td>
                                        <td ><p class="p_space">Price Box</p></td>
                                    </tr>';
                            }  
                        /*--------no order price--------*/
                        }else{
                            
                        }
                    echo'</tbody>';
                  echo '</form>';
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
        <script type='text/javascript'>
            // display comform all order details
                $(document).ready(function(){
                    $("#more_or_but").click(function(){
                        $("#t_body").load("exphp/comformOrder.php",{
                       
                        });
                    });
                });
        </script>
    </body>
</html>
<php?>