<!--sepricebox.lk-->
<?PHP include 'conection.php' ?>
<?PHP
session_start();

/*---login user id-----*/
$log_user_id = $_SESSION['log_user_id'];

/*---login user details-----*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$row = $log_user_result-> fetch_assoc();

/*---price box detail table-----*/
$box_detail = "SELECT * FROM price_box_details LIMIT 1";
$box_detail_result = mysqli_query($con, $box_detail) or die (mysqli_error($con));
$box_detail_row = $box_detail_result-> fetch_assoc();

/*---cart table-----*/
$box = "SELECT * FROM price_box WHERE box_user_id='$log_user_id'";
$box_result = mysqli_query($con, $box) or die (mysqli_error($con));

$box_count = "SELECT * FROM price_box WHERE box_user_id='$log_user_id'";
$box_count_result = mysqli_query($con, $box_count) or die (mysqli_error($con));

$number_of_item = 0;
$dilivary_cost = 0;
$total_amount = 0;

/*---cart summary-----*/
$box_cost = 0;
$tot = 0;
$weight = 0;
$number_of_item = mysqli_num_rows($box_count_result);
/*------calculate total amount & total weight & total dilivary cost-----*/
while ($row2 = $box_count_result-> fetch_assoc()){

    $tot = $tot + $row2['box_amount'];
    $weight = $weight + $row2['box_item_weight'];
    $dilivary_cost = $dilivary_cost + $row2['box_delivary_cost'];
}
/*---price box cost-----*/
if($weight < 1){
    $total_amount = $tot + $box_detail_row['price_box_details_1kg'];
    $box_cost = $box_detail_row['price_box_details_1kg'];
}else{
    if($weight < 1.5){
        $total_amount = $tot + $box_detail_row['price_box_details_1.5kg'];
        $box_cost = $box_detail_row['price_box_details_1.5kg'];
    }else{
        if($weight < 2){
            $total_amount = $tot + $box_detail_row['price_box_details_2kg'];
            $box_cost = $box_detail_row['price_box_details_2kg'];
        }else{
            if($weight < 3){
                $total_amount = $tot + $box_detail_row['price_box_details_3kg'];
                $box_cost = $box_detail_row['price_box_details_3kg'];
            }else{
                $total_amount = $tot + $box_detail_row['price_box_details_5kg'];
                $box_cost = $box_detail_row['price_box_details_5kg'];
            
            }
        }
    }
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
        <!--price box summary-->
        <div class="box_left">
            <h3 class="cart_sumery">Price Box</h3>
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
                    <td><p class="cart_sumery_p">Price box cost:</p></td>
                    <td><p class="cart_sumery_p">Rs: <?php echo $box_cost; ?></p></td>
                </tr>
                <tr>
                    <td><p class="cart_sumery_p">Total Amount:</p></td>
                    <td><p class="cart_sumery_p">Rs: <?php echo $total_amount; ?></p></td>
                </tr>
            </table>
            <?PHP
                /*-------price box check emty----------*/
                if($number_of_item > 0){
                    echo '<a href="exphp/buypricebox.php" ><button type="button" class="buy_crt" >Buy Price</button></a>';
                }else{
                    echo '<button type="button" class="buy_crt" >Buy Price</button>';
                }
            ?>
            
        </div>
        <div class="box_table">
            <table class="cart_table">
                <tr class="cart_h_tr">
                    <th ><h1 class="t_space"></h1></th>
                    <th><h1 class="t_space">Name</h1></th>
                    <th ><h1 class="t_space">Quntity</h1></th>
                    <th ><h1 class="t_space">Total</h1></th>
                    <th ><h1 class="t_space"></h1></th>
                    
                </tr>
                <?php
                    /*---price box check emty-----*/
                    if(mysqli_num_rows($box_result) > 0){
                        /*---price box display-----*/
                        while ($row = $box_result-> fetch_assoc()){
                            $box_i_id = $row['box_item_id'];
                            $box_id = $row['box_id'];
                            /*-----get price box item-----*/
                            $item = "SELECT * FROM item WHERE item_id='$box_i_id' LIMIT 1";
                            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                            $item_row = $item_result-> fetch_assoc();

                                echo '<tr class="cart_tr">
                                    <td ><div ><img src="'.$item_row['item_image'].'" class="cart_imag" ></div></td>
                                    <td ><p class="p_space">'.$item_row['item_name'].'</p></td>
                                    <td ><p class="p_space">'.$row['box_quntity'].'</p></td>
                                    <td ><p class="p_space">Rs:'.$row['box_amount'].'</p></td>
                                    <td ><p class="p_space"><a href="exphp/boxremove.php?box_id='.$box_id.'"><button type="button" class="remove" name="remove">Remove</button></a></p></td>
                                </tr>';
                            
                            
                        }
                        echo '</form>';
                    /*-------price box emty--------*/
                    }else{
                        echo '<h1 class="tabel_emty_error">No Seprice Box item </h1>';
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