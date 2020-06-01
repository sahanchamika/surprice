<!--Suprice.lk-->
<?PHP include 'conection.php' ?>
<?PHP
session_start();
/*----------log in php------------------------*/
$error_log_emty = '';
$error_log_username = '';
/*----------click login------------------------*/
if(isset($_POST["submit"])){
    /*----------get user name & password------------------------*/  
    $user_name = $con->real_escape_string($_POST['username']);
    $password = $con->real_escape_string($_POST['password']);
    /*----------check feild emty------------------------*/
    if(!empty($user_name) && !empty($password)){
        /*----------get user------------------------*/
        $user_name = "SELECT * FROM user WHERE user_username='$user_name' AND user_status='user'";
        $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));
        /*----------check user name carrect------------------------*/
        if(mysqli_num_rows($user_name_result) > 0){
            $row = $user_name_result-> fetch_assoc();
            $new_password = md5($password);
            /*----------check correct password------------------------*/
            if($new_password == $row["user_password"]){
                /*----------add session log user------------------------*/
                $_SESSION['log_user_id'] = $row["user_id"];
                /*----------lode logindex------------------------*/
                header("location: logindex.php");
                /*----------wrong password ------------------------*/
            }else{
                $error_log_emty = 'Opes Invalide data';
                $error_log_username = 'Incorrect password';
                $alert_error_emty = 'Incorrect password, use correct password and re log in ';
                echo "<script type='text/javascript'>alert('$alert_error_emty');</script>";
            }
            /*----------wrong usr name------------------------*/
        }else{
            $error_log_emty = 'Opes Invalide data';
            $error_log_username = 'Incorrect username';
            $alert_error_emty = 'Incorrect username, use correct username and re log in ';
            echo "<script type='text/javascript'>alert('$alert_error_emty');</script>";
        }
        /*----------emty field------------------------*/
    }else{
        $error_log_emty = 'Opes All feild fill and submit';
        $alert_error_emty = 'Log in form feild emty, all feild fill and Re log in';
        echo "<script type='text/javascript'>alert('$alert_error_emty');</script>"; 
    }
}
/*------------log in php end---------------*/

/*--------------catagory php---------------*/

$catagory1 = "SELECT * FROM item_catagory WHERE item_catagory_code='car001'";
$catagory_result1 = mysqli_query($con, $catagory1) or die (mysqli_error($con));
$row1 = $catagory_result1-> fetch_assoc();

$catagory2 = "SELECT * FROM item_catagory WHERE item_catagory_code='box002'";
$catagory_result2 = mysqli_query($con, $catagory2) or die (mysqli_error($con));
$row2 = $catagory_result2-> fetch_assoc();

$catagory3 = "SELECT * FROM item_catagory WHERE item_catagory_code='wal003'";
$catagory_result3 = mysqli_query($con, $catagory3) or die (mysqli_error($con));
$row3 = $catagory_result3-> fetch_assoc();

$catagory4 = "SELECT * FROM item_catagory WHERE item_catagory_code='sta004'";
$catagory_result4 = mysqli_query($con, $catagory4) or die (mysqli_error($con));
$row4 = $catagory_result4-> fetch_assoc();

$catagory5 = "SELECT * FROM item_catagory WHERE item_catagory_code='orn005'";
$catagory_result5 = mysqli_query($con, $catagory5) or die (mysqli_error($con));
$row5 = $catagory_result5-> fetch_assoc();

$catagory6 = "SELECT * FROM item_catagory WHERE item_catagory_code='alb006'";
$catagory_result6 = mysqli_query($con, $catagory6) or die (mysqli_error($con));
$row6 = $catagory_result6-> fetch_assoc();

/*-----------------catagory php end-----------------*/


/*----------------flash sale php-------------------*/

$flash_sale = "SELECT * FROM flash_sale LIMIT 8";
$flash_sale_result = mysqli_query($con, $flash_sale) or die (mysqli_error($con));

$flash_sale_details = "SELECT * FROM flash_sale_details LIMIT 1";
$flash_sale__details_result = mysqli_query($con, $flash_sale_details) or die (mysqli_error($con));
$flash_sale_details_row = $flash_sale__details_result-> fetch_assoc();

/*---------------flash sale php end----------------*/


/*---------------all item php--------------------*/

$item = "SELECT * FROM item LIMIT 8";
$item_result = mysqli_query($con, $item) or die (mysqli_error($con));

/*-------------all item php end-----------------*/

/*---------------video box php--------------------*/

$video = "SELECT * FROM index_video LIMIT 1";
$video_result = mysqli_query($con, $video) or die (mysqli_error($con));
$video_row = $video_result-> fetch_assoc();

/*-------------video box php end-----------------*/

/*---------------creator php--------------------*/

$creator = "SELECT * FROM creator LIMIT 6";
$creator_result = mysqli_query($con, $creator) or die (mysqli_error($con));

/*-------------creator php end-----------------*/

/*---------------delivery_company php--------------------*/

$delivery_company = "SELECT * FROM delivery_company LIMIT 5";
$delivery_company_result = mysqli_query($con, $delivery_company) or die (mysqli_error($con));

/*-------------delivery_company php end-----------------*/

/*---------------inster php--------------------*/

$inster = "SELECT * FROM inster LIMIT 6";
$inster_result = mysqli_query($con, $inster) or die (mysqli_error($con));

/*-------------inster php end-----------------*/

/*---------------inster php--------------------*/

$serprise = "SELECT * FROM serprise LIMIT 1";
$serprise_result = mysqli_query($con, $serprise) or die (mysqli_error($con));
$serprise_row = $serprise_result-> fetch_assoc();

/*-------------inster php end-----------------*/



?>


<!-----------flash date pass timer----------------->
<script>
    var flash_time = "<?php echo $flash_sale_details_row['flash_sale_details_date']; ?> 00:00:00";  
</script>
<!----------flash date pass timer end----------------->



<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    

    <!--------------CSS---------------->

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

     <!-----------CSS end---------->

</head>

<body>

<!--------------nav bar------------->

    <header>
        <div class="header-area ">
            <div id="sticky-header" class="main-header-area">
                <div class="container-fluid">
                    <div class="header_bottom_border">
                        <div class="navbuttom">
                            <div class="row align-items-center">
                                <div class="col-xl-2 col-lg-2">
                                    <div class="logo">
                                        <a href="index.php">
                                            <img src="img/logo.png" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="main-menu  d-none d-lg-block">
                                        <nav>
                                            <ul id="navigation">
                                                <li><a class="active" href="index.php">home</a></li>
                                                <li><a href="about.php">About</a></li>
                                                <li><a class="" data-toggle="modal" data-target="#logeModalCenter" href="#">Contact</a></li>
                                                <li><a data-toggle="modal" data-target="#logeModalCenter" href="#">Catogory & All</a>
                                                    <ul class="submenu">
                                                        <li><a data-toggle="modal" data-target="#logeModalCenter" href="#"><?php echo $row1['item_catagory_name']; ?></a></li>
                                                        <li><a data-toggle="modal" data-target="#logeModalCenter" href="#"><?php echo $row2['item_catagory_name']; ?></a></li>
                                                        <li><a data-toggle="modal" data-target="#logeModalCenter" href="#"><?php echo $row3['item_catagory_name']; ?></a></li>
                                                        <li><a data-toggle="modal" data-target="#logeModalCenter" href="#"><?php echo $row4['item_catagory_name']; ?></a></li>
                                                    </ul>
                                                </li>
                                                <li><a href="newacc.php">New Account</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div> 
                                <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                                    <div class="social_wrap d-flex align-items-center justify-content-end">
                                        <div class="login">
                                            <nav>
                                                <ul>
                                                    <a>
                                                        <li><a class="loginlabel" data-toggle="modal" data-target="#logeModalCenter" href="#">Log In</a></li>  
                                                    </a>
                                                </ul>
                                            </nav>
                                        </div>
                                        <div class="number">
                                            <p> <i class="fa fa-phone"></i> <?php echo $serprise_row['serprise_tlp']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="seach_icon">
                                    <a data-toggle="modal" data-target="#exampleModalCenter" href="#">
                                        <i class="fa fa-search"></i>
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

<!------nav bar end------------->

<!-----------slider-------------->

<div id="row">
    <div class="slider_area" id="row">
        <div class="slider_active owl-carousel">
            <div class="single_slider  d-flex align-items-center slider_bg_1 overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-md-12">
                            <div class="slider_text text-center" id="textcont">
                                <h3><?php echo $serprise_row['serprise_name']; ?> </h3>
                                <p>Surprise Your Love  Amazing Paper Creation We Are Bound For You Creat & Surprise</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider  d-flex align-items-center slider_bg_2 overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-md-12">
                            <div class="slider_text text-center" id="textcont">
                                <h3><?php echo $serprise_row['serprise_name']; ?> </h3> </h3>
                                <p>Celebrate You Amazing Moment with paper Creation We Are Bound For Delivery to You door</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider  d-flex align-items-center slider_bg_3 overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-md-12">
                            <div class="slider_text text-center" id="textcont">
                                <h3><?php echo $serprise_row['serprise_name']; ?> </h3> </h3>
                                <p>Join With Us Decorat You Mome Room Party We Plan and Decorate</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="single_slider  d-flex align-items-center slider_bg_4 overlay">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-md-12">
                            <div class="slider_text text-center" id="textcont">
                                <h3><?php echo $serprise_row['serprise_name']; ?> </h3> </h3>
                                <p>Customize Item For Your Choice We Are Bound For contact and Create</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="cat2"></div>

<!-------------------slider end--------------->
   
<!------------catogory 01 --------------------->

    <div class="popular_destination_area" >
        <div class="container">
            <div class="row justify-content-center" >
                <div class="col-lg-6">
                    <div class="section_title text-center mb_70">
                        <h3>Catogory</h3>
                        <p>Your choise and Your easy</p>
                        <hr class="hrone"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                    <div class="single_destination">
                        <div class="thumb">
                            <img src="<?php echo $row1['item_catagory_image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <p class="d-flex align-items-center"><?php echo $row1['item_catagory_name']; ?><a data-toggle="modal" data-target="#logeModalCenter" href="#"> <?php echo $row1['item_catagory_count']; ?> item</a> </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                    <div class="single_destination">
                        <div class="thumb">
                            <img src="<?php echo $row2['item_catagory_image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <p class="d-flex align-items-center"><?php echo $row2['item_catagory_name']; ?><a data-toggle="modal" data-target="#logeModalCenter" href="#"> <?php echo $row2['item_catagory_count']; ?> item</a> </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                    <div class="single_destination">
                        <div class="thumb">
                            <img src="<?php echo $row3['item_catagory_image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <p class="d-flex align-items-center"><?php echo $row3['item_catagory_name']; ?><a data-toggle="modal" data-target="#logeModalCenter" href="#"> <?php echo $row3['item_catagory_count']; ?> item</a> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container" id="fsborder">

<!-------------------catogory 01 end----------------->

<!---------------flash sale--------------------->

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="section_title text-center mb_70">
                <h3><br>Flash Sale</h3>
                <p>Your choise easy price and awesome discount avalebel for limited time Hrury up now</p>
                <p id="demo"></p>
            </div>
        </div>
    </div>

    <!-------------------1st list----------------------->
    <div class="popular_places_area" id="row">
        <div class="container" id="fsborder">
                <?php
                    /*--------------------flash table have item-------------------------*/ 
                    if(mysqli_num_rows($flash_sale_result) > 0){
                        echo '<h1 class="item_cont_heder">Discount '.$flash_sale_details_row['flash_sale_details_diss'].' </h1>';
                        echo '<div class="row" id="row">';
                        while ($row = $flash_sale_result-> fetch_assoc()){
                            $flash_item_id = $row['flash_sale_item_id'];
                            /*---------------reviwe --------------------*/
                            $reviwe = "SELECT COUNT(`flash_shipping_user_id`),flash_shipping_user_id FROM flash_shipping WHERE flash_shipping_item_id = '$flash_item_id' GROUP BY flash_shipping_user_id";
                            $reviwe_result = mysqli_query($con, $reviwe) or die (mysqli_error($con));
                            $reviwe_count =0;
                            while ($reviwe_row = $reviwe_result-> fetch_assoc()){
                                $reviwe_count = $reviwe_count+1;
                            }
                            /*--------------------flash item quantity is 0-------------------------*/
                            if($row['flash_sale_quantity'] == 0){

                                echo '<div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                                <div class="single_place">
                                    <div class="thumb">
                                        <img src="'.$row['flash_sale_image'].'" alt="None">
                                        <a data-toggle="modal" data-target="#logeModalCenter" href="#" class="prise">Rs:'.$row['flash_sale_price'].'</a>';
                                        /*--------------------flash item custom or not-------------------------*/
                                        if($row['flash_sale_custom'] == "yes"){
                                            echo '<a data-toggle="modal" data-target="#logeModalCenter" href="#" class="custom">Custom</a>';
                                        }else{

                                        }
                                    echo '</div>
                                            <div class="place_info">
                                                <a href="#"><h3>'.$row['flash_sale_name'].'</h3></a>
                                                <p>'.$row['flash_sale_discription'].'</p>
                                                <div class="rating_days d-flex justify-content-between">
                                                    <span class="d-flex justify-content-center align-items-center">';
                                                    /*--------------------flash item star rate-------------------------*/
                                                    if($row['flash_sale_rate'] == 0){
                                                    echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                                    }else{
                                                        if($row['flash_sale_rate'] == 1){
                                                            echo '<i class="fa fa-star"></i> ';
                                                        }else{
                                                            if($row['flash_sale_rate'] == 2){
                                                                echo '<i class="fa fa-star"></i> 
                                                                    <i class="fa fa-star"></i>';
                                                            }else{
                                                                if($row['flash_sale_rate'] == 3){
                                                                    echo '<i class="fa fa-star"></i> 
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>';
                                                                }else{
                                                                    if($row['flash_sale_rate'] == 4){
                                                                        echo '<i class="fa fa-star"></i> 
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>';
                                                                    }else{
                                                                        if($row['flash_sale_rate'] == 5){
                                                                            echo '<i class="fa fa-star"></i> 
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>';
                                                                        }else{
                                                                            echo '<i class="fa fa-star"></i> 
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>';
                                
                                                                        }
                            
                                                                    }
                        
                                                                }
                    
                                                            }
                
                                                        }
                                                    }   
                                                    echo '<a id="bad_reat" href="#">(All Sold)</a>
                                                    </span>
                                                    <div class="days">
                                                        <i class="fa fa-clock-o"></i>
                                                        <a href="#">'.$flash_sale_details_row['flash_sale_details_rang'].' Days</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            /*--------------------flash item quantity have one or more-------------------------*/
                            }else{

                                echo '<div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                                    <div class="single_place">
                                        <div class="thumb">
                                            <img src="'.$row['flash_sale_image'].'" alt="None">
                                            <a data-toggle="modal" data-target="#logeModalCenter" href="#" class="prise">Rs:'.$row['flash_sale_price'].'</a>';
                                            /*-------------------------------flash item cutom----------------------------------*/
                                            if($row['flash_sale_custom'] == "yes"){
                                                echo '<a data-toggle="modal" data-target="#logeModalCenter" href="#" class="custom">Custom</a>';
                                            }else{

                                            }
                                        echo '</div>
                                                <div class="place_info">
                                                    <a href="#"><h3>'.$row['flash_sale_name'].'</h3></a>
                                                    <p>'.$row['flash_sale_discription'].'</p>
                                                    <div class="rating_days d-flex justify-content-between">
                                                        <span class="d-flex justify-content-center align-items-center">';
                                                        /*-------------------------------flash item star rate---------------------------*/
                                                        if($row['flash_sale_rate'] == 0){
                                                        echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                                        }else{
                                                            if($row['flash_sale_rate'] == 1){
                                                                echo '<i class="fa fa-star"></i> ';
                                                            }else{
                                                                if($row['flash_sale_rate'] == 2){
                                                                    echo '<i class="fa fa-star"></i> 
                                                                        <i class="fa fa-star"></i>';
                                                                }else{
                                                                    if($row['flash_sale_rate'] == 3){
                                                                        echo '<i class="fa fa-star"></i> 
                                                                            <i class="fa fa-star"></i>
                                                                            <i class="fa fa-star"></i>';
                                                                    }else{
                                                                        if($row['flash_sale_rate'] == 4){
                                                                            echo '<i class="fa fa-star"></i> 
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>
                                                                                <i class="fa fa-star"></i>';
                                                                        }else{
                                                                            if($row['flash_sale_rate'] == 5){
                                                                                echo '<i class="fa fa-star"></i> 
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>';
                                                                            }else{
                                                                                echo '<i class="fa fa-star"></i> 
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>';
                                    
                                                                            }
                                
                                                                        }
                            
                                                                    }
                        
                                                                }
                    
                                                            }
                                                        }   
                                                        echo '<a href="#">('.$reviwe_count.' Review)</a>
                                                        </span>
                                                        <div class="days">
                                                            <i class="fa fa-clock-o"></i>
                                                            <a href="#">'.$flash_sale_details_row['flash_sale_details_rang'].' Days</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                            }

                        }
                    /*--------------------flash table no item-------------------------*/ 
                    }else{
                        echo '<h1 class="tabel_emty_error">No flash sale item </h1>';
                    }
                ?>

            </div>
        </div>
    </div>
    <hr class="hrone1"/>
    </div>

    <!--------------------1st list end--------------------------->

    <!--------------------flash sale end------------------------->


    <!-----------2ed cat ------------------->
    <div class="popular_destination_area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="section_title text-center mb_70">
                        <h3>Catogory</h3>
                        <p>Your choise and Your easy</p>
                        <hr class="hrone"/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                    <div class="single_destination">
                        <div class="thumb">
                            <img src="<?php echo $row4['item_catagory_image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <p class="d-flex align-items-center"><?php echo $row4['item_catagory_name']; ?><a data-toggle="modal" data-target="#logeModalCenter" href="#"> <?php echo $row4['item_catagory_count']; ?> item</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                    <div class="single_destination">
                        <div class="thumb">
                            <img src="<?php echo $row5['item_catagory_image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <p class="d-flex align-items-center"><?php echo $row5['item_catagory_name']; ?><a data-toggle="modal" data-target="#logeModalCenter" href="#"> <?php echo $row5['item_catagory_count']; ?> item</a> </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                    <div class="single_destination">
                        <div class="thumb">
                            <img src="<?php echo $row6['item_catagory_image']; ?>" alt="">
                        </div>
                        <div class="content">
                            <p class="d-flex align-items-center"><?php echo $row6['item_catagory_name']; ?> <a data-toggle="modal" data-target="#logeModalCenter" href="#"> <?php echo $row6['item_catagory_count']; ?> item</a> </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" class="container" id="fsborder">
                <div class="col-lg-6">
                    <div class="section_title text-center mb_70">
                        <h3><br>All Item</h3>
                        <p>We have All items are hear Buy your choice</p>
                    </div>
                </div>
            <div class="cat2"></div>
            <!-----------------2ed cat end---------------->
            <!------------------2ed list ----------------->
            <div class="container">
            <br>
            <div class="popular_places_area" id="nocolor">
                <div class="container" id="item_content">
                        <?php
                            /*----------------search button click-------------------*/ 
                            if(isset($_POST["searchbuton"])){
                                $searchtxt = $con->real_escape_string($_POST['searchtxt']);
                                $search="SELECT * FROM item WHERE item_name LIKE'%$searchtxt%'";
                                $search_result = mysqli_query($con, $search) or die (mysqli_error($con));
                                        /*----------------search item avalabel(0>)-------------------*/
                                        if(mysqli_num_rows($search_result) > 0){
                                            echo'<h1 class="item_cont_heder">You have '.mysqli_num_rows($search_result).' Result</h1>';
                                            echo '<div class="row" id="all_item">';
                                            while ($row = $search_result-> fetch_assoc()){
                                                $item_id = $row['item_id'];
                                                /*---------------reviwe --------------------*/
                                                $reviwe_item = "SELECT COUNT(`item_shipping_user_id`), item_shipping_user_id FROM item_shipping WHERE item_shipping_item_id='$item_id' GROUP BY item_shipping_user_id";
                                                $reviwe_item_result = mysqli_query($con, $reviwe_item) or die (mysqli_error($con));
                                                $reviwe_item_count =0;
                                                while ($reviwe_item_row = $reviwe_item_result-> fetch_assoc()){
                                                    $reviwe_item_count = $reviwe_item_count+1;
                                                }
                                                /*----------------search item quantity no one ro more-------------------*/
                                                if($row['item_quantity'] == 0){
                                                    echo '<div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                                                        <div class="single_place">
                                                            <div class="thumb">
                                                                <img src="'.$row['item_image'].'" alt="None">
                                                                <a class="prise" data-toggle="modal" data-target="#logeModalCenter" href="#">Rs:'.$row['item_price'].'</a>';
                                                                /*----------------search item can custom or not-------------------*/
                                                                if($row['item_custom'] == 'yes'){
                                                                    echo '<a class="custom" data-toggle="modal" data-target="#logeModalCenter" href="#">Custom</a>';
                                                                }else{

                                                                }
                                                            echo '</div>
                                                            <div class="place_info">
                                                                <a href=""><h3>'.$row['item_name'].'</h3></a>
                                                                <p>'.$row['item_discription'].'</p>
                                                                <div class="rating_days d-flex justify-content-between">
                                                                    <span class="d-flex justify-content-center align-items-center">';
                                                                    /*----------------search item check star rate-------------------*/
                                                                    if($row['item_sale_rate'] == 0){
                                                                        echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                                                        }else{
                                                                            if($row['item_sale_rate'] == 1){
                                                                                echo '<i class="fa fa-star"></i> ';
                                                                            }else{
                                                                                if($row['item_sale_rate'] == 2){
                                                                                    echo '<i class="fa fa-star"></i> 
                                                                                        <i class="fa fa-star"></i>';
                                                                                }else{
                                                                                    if($row['item_sale_rate'] == 3){
                                                                                        echo '<i class="fa fa-star"></i> 
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>';
                                                                                    }else{
                                                                                        if($row['item_sale_rate'] == 4){
                                                                                            echo '<i class="fa fa-star"></i> 
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>';
                                                                                        }else{
                                                                                            if($row['item_sale_rate'] == 5){
                                                                                                echo '<i class="fa fa-star"></i> 
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>';
                                                                                            }else{
                                                                                                echo '<i class="fa fa-star"></i> 
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>';
                                                    
                                                                                            }
                                                
                                                                                        }
                                            
                                                                                    }
                                        
                                                                                }
                                    
                                                                            }
                                                                        } 
                                                                        echo '<a href="#" id="bad_reat">(All Sold)</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                /*----------------search item quantity have one ro more-------------------*/
                                                }else{
                                                    echo '<div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                                                        <div class="single_place">
                                                            <div class="thumb">
                                                                <img src="'.$row['item_image'].'" alt="None">
                                                                <a class="prise" data-toggle="modal" data-target="#logeModalCenter" href="#">Rs:'.$row['item_price'].'</a>';
                                                                /*----------------search item can custom or not-------------------*/
                                                                if($row['item_custom'] == 'yes'){
                                                                    echo '<a class="custom" data-toggle="modal" data-target="#logeModalCenter" href="#">Custom</a>';
                                                                }else{

                                                                }
                                                            echo '</div>
                                                            <div class="place_info">
                                                                <a href=""><h3>'.$row['item_name'].'</h3></a>
                                                                <p>'.$row['item_discription'].'</p>
                                                                <div class="rating_days d-flex justify-content-between">
                                                                    <span class="d-flex justify-content-center align-items-center">';
                                                                    /*----------------search item check star rate-------------------*/
                                                                    if($row['item_sale_rate'] == 0){
                                                                        echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                                                        }else{
                                                                            if($row['item_sale_rate'] == 1){
                                                                                echo '<i class="fa fa-star"></i> ';
                                                                            }else{
                                                                                if($row['item_sale_rate'] == 2){
                                                                                    echo '<i class="fa fa-star"></i> 
                                                                                        <i class="fa fa-star"></i>';
                                                                                }else{
                                                                                    if($row['item_sale_rate'] == 3){
                                                                                        echo '<i class="fa fa-star"></i> 
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>';
                                                                                    }else{
                                                                                        if($row['item_sale_rate'] == 4){
                                                                                            echo '<i class="fa fa-star"></i> 
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>
                                                                                                <i class="fa fa-star"></i>';
                                                                                        }else{
                                                                                            if($row['item_sale_rate'] == 5){
                                                                                                echo '<i class="fa fa-star"></i> 
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>';
                                                                                            }else{
                                                                                                echo '<i class="fa fa-star"></i> 
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>
                                                                                                    <i class="fa fa-star"></i>';
                                                    
                                                                                            }
                                                
                                                                                        }
                                            
                                                                                    }
                                        
                                                                                }
                                    
                                                                            }
                                                                        } 
                                                                        echo '<a href="#">('.$reviwe_item_count.' Review)</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';

                                                }
                                            }
                                        /*----------------search item ont avalabel(0>)-------------------*/
                                        }else{
                                            echo '<h1 class="tabel_emty_error">No item in Result </h1>';
                                        }
                            /*----------------search button no click \\ then load all item-------------------*/
                            }else{
                                /*----------------all item tabel avalabel item-------------------*/
                                if(mysqli_num_rows($item_result) > 0){
                                    echo'<h1 class="item_cont_heder">More item for Click More item button</h1>';
                                    echo '<div class="row" id="all_item">';
                                    while ($row = $item_result-> fetch_assoc()){
                                        $item_id = $row['item_id'];
                                        /*---------------reviwe --------------------*/
                                        $reviwe_item = "SELECT COUNT(`item_shipping_user_id`), item_shipping_user_id FROM item_shipping WHERE item_shipping_item_id='$item_id' GROUP BY item_shipping_user_id";
                                        $reviwe_item_result = mysqli_query($con, $reviwe_item) or die (mysqli_error($con));
                                        $reviwe_item_count =0;
                                        while ($reviwe_item_row = $reviwe_item_result-> fetch_assoc()){
                                            $reviwe_item_count = $reviwe_item_count+1;
                                        }
                                         /*----------------all item quantity no one ro more-------------------*/
                                        if($row['item_quantity'] == 0){
                                            
                                            echo '<div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                                                <div class="single_place">
                                                    <div class="thumb">
                                                        <img src="'.$row['item_image'].'" alt="None">
                                                        <a class="prise" data-toggle="modal" data-target="#logeModalCenter" href="#">Rs:'.$row['item_price'].'</a>';
                                                        /*----------------all item can custom-------------------*/
                                                        if($row['item_custom'] == 'yes'){
                                                            echo '<a class="custom" data-toggle="modal" data-target="#logeModalCenter" href="#">Custom</a>';
                                                        }else{

                                                        }
                                                    echo '</div>
                                                    <div class="place_info">
                                                        <a href="#"><h3>'.$row['item_name'].'</h3></a>
                                                        <p>'.$row['item_discription'].'</p>
                                                        <div class="rating_days d-flex justify-content-between">
                                                            <span class="d-flex justify-content-center align-items-center">';
                                                             /*----------------all item star rate-------------------*/
                                                            if($row['item_sale_rate'] == 0){
                                                                echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                                                }else{
                                                                    if($row['item_sale_rate'] == 1){
                                                                        echo '<i class="fa fa-star"></i> ';
                                                                    }else{
                                                                        if($row['item_sale_rate'] == 2){
                                                                            echo '<i class="fa fa-star"></i> 
                                                                                <i class="fa fa-star"></i>';
                                                                        }else{
                                                                            if($row['item_sale_rate'] == 3){
                                                                                echo '<i class="fa fa-star"></i> 
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>';
                                                                            }else{
                                                                                if($row['item_sale_rate'] == 4){
                                                                                    echo '<i class="fa fa-star"></i> 
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>';
                                                                                }else{
                                                                                    if($row['item_sale_rate'] == 5){
                                                                                        echo '<i class="fa fa-star"></i> 
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>';
                                                                                    }else{
                                                                                        echo '<i class="fa fa-star"></i> 
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>';
                                            
                                                                                    }
                                        
                                                                                }
                                    
                                                                            }
                                
                                                                        }
                            
                                                                    }
                                                                } 
                                                                echo '<a href="#" id="bad_reat">(All Sold)</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                                        /*----------------all item quantity have one ro more-------------------*/
                                        }else{

                                            echo '<div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                                                <div class="single_place">
                                                    <div class="thumb">
                                                        <img src="'.$row['item_image'].'" alt="None">
                                                        <a class="prise" data-toggle="modal" data-target="#logeModalCenter" href="#">Rs:'.$row['item_price'].'</a>';
                                                        /*----------------all item can custom-------------------*/
                                                        if($row['item_custom'] == 'yes'){
                                                            echo '<a class="custom" data-toggle="modal" data-target="#logeModalCenter" href="#">Custom</a>';
                                                        }else{

                                                        }
                                                    echo '</div>
                                                    <div class="place_info">
                                                        <a href="#"><h3>'.$row['item_name'].'</h3></a>
                                                        <p>'.$row['item_discription'].'</p>
                                                        <div class="rating_days d-flex justify-content-between">
                                                            <span class="d-flex justify-content-center align-items-center">';
                                                            /*----------------all item star rate-------------------*/
                                                            if($row['item_sale_rate'] == 0){
                                                                echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                                                }else{
                                                                    if($row['item_sale_rate'] == 1){
                                                                        echo '<i class="fa fa-star"></i> ';
                                                                    }else{
                                                                        if($row['item_sale_rate'] == 2){
                                                                            echo '<i class="fa fa-star"></i> 
                                                                                <i class="fa fa-star"></i>';
                                                                        }else{
                                                                            if($row['item_sale_rate'] == 3){
                                                                                echo '<i class="fa fa-star"></i> 
                                                                                    <i class="fa fa-star"></i>
                                                                                    <i class="fa fa-star"></i>';
                                                                            }else{
                                                                                if($row['item_sale_rate'] == 4){
                                                                                    echo '<i class="fa fa-star"></i> 
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>
                                                                                        <i class="fa fa-star"></i>';
                                                                                }else{
                                                                                    if($row['item_sale_rate'] == 5){
                                                                                        echo '<i class="fa fa-star"></i> 
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>';
                                                                                    }else{
                                                                                        echo '<i class="fa fa-star"></i> 
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>
                                                                                            <i class="fa fa-star"></i>';
                                            
                                                                                    }
                                        
                                                                                }
                                    
                                                                            }
                                
                                                                        }
                            
                                                                    }
                                                                } 
                                                                echo '<a href="#">('.$reviwe_item_count.' Review)</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                                        }
                                    }
                                /*----------------all item tabel not avalabel item-------------------*/
                                }else{
                                    echo '<h1 class="tabel_emty_error">No item in here </h1>';
                                }
                            }
                       ?>
                    </div>
                    <hr class="hrone1"/>
                </div>
            </div>
            <!----------2ed list end ------>
            <!--more button -->
            <div class="morebutton">
                <div class="col-lg-12">
                    <div class="more_place_btn text-center">
                        <a class="boxed-btn4" ><div id="load_more_button">More item</div></a>
                    </div>
                </div>
            </div>        
        </div>
    </div>

    <!--giftbox-->
    <div class="travel_variation_area">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="single_travel text-center">
                        <div class="icon">
                            <img class="for" src="img\svg_icon\icon3.png" alt="">
                        </div>
                        <h3>Surprise box</h3>
                        <p id="back_icon_text">Would you like to know your future? If your answer is yes, think again. Not knowing is the greatest life motivator. So enjoy, and put your selected gifts in to our suprise box.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_travel text-center">
                        <div class="icon">
                            <img class="for" src="img\svg_icon\icon1.png" alt="">
                        </div>
                        <h3>Surprise love</h3>
                        <p id="back_icon_text">Some gifts are big. Others are small. But the ones that come from the loved ones are the best gifts of all. Surprise your loved ones with our lovely gifts</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="single_travel text-center">
                        <div class="icon">
                            <img class="for" src="img\svg_icon\icon2.png" alt="">
                        </div>
                        <h3>Surprise delivery</h3>
                        <p id="back_icon_text">Love can be found in unexpected places. You can visit us choose the things what  what you're supposed to have. We are ready to deliver them to your desired places.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <!--video-->
    <div class="vedio">
        <div class="video_area video_bg overlay">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="video_wrap text-center">
                            <h3>creative</h3>
                            <div class="video_icon">
                                <a class="popup-video video_play_button" href="<?php echo $video_row['index_video_url']; ?>">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--creater-->
    <div class="testimonial_area">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="testmonial_active owl-carousel">
                    <?php
                        /*---------------------creator tabel details---------------------*/
                        if(mysqli_num_rows($creator_result) > 0){
                            while ($row = $creator_result-> fetch_assoc()){
                                echo '<div class="single_carousel">
                                        <div class="row justify-content-center">
                                            <div class="col-lg-8">
                                                <div class="single_testmonial text-center">
                                                    <div class="author_thumb">
                                                        <img src="'.$row['creator_image'].'" alt="None creater">
                                                    </div>
                                                    <p>"'.$row['creator_comment'].'"</p>
                                                    <div class="testmonial_author">
                                                        <h3>- '.$row['creator_name'].' -</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }else{
                            echo '<h1 class="tabel_emty_error">no creater comment </h1>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    

    <!--footer-->
    <footer class="footer">
        <div class="footer_top">
            <div class="container">
                <div class="row">
                    <div class="col-xl-4 col-md-6 col-lg-4 ">
                        <div class="footer_widget">
                            <div class="footer_logo">
                                <a href="#">
                                    <img src="img/footer_logo.png" alt="">
                                </a>
                            </div>
                            <!--contac-->
                            <p><?php echo $serprise_row['serprise_addres']; ?> <br> <?php echo $serprise_row['serprise_country_city']; ?> <br>
                                <a href="#"><?php echo $serprise_row['serprise_tlp']; ?></a> <br>
                                <a href="#"><?php echo $serprise_row['serprise_email']; ?></a>
                            </p>
                            <!--social icon-->
                            <div class="socail_links">
                                <ul>
                                    <li>
                                        <a href="#">
                                            <i class="ti-facebook" id="socialicon"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="ti-twitter-alt" id="socialicon"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-instagram" id="socialicon"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-pinterest" id="socialicon"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-youtube-play" id="socialicon"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <!--delivary company-->
                    <div class="col-xl-2 col-md-6 col-lg-2">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Delivary Company
                            </h3>
                            <ul class="links">
                                <?php
                                    /*----------------------Delivary Company details-------------------------*/
                                    if(mysqli_num_rows($delivery_company_result) > 0){
                                        while ($row = $delivery_company_result-> fetch_assoc()){
                                            echo '<li><a href="#">'.$row['delivery_company_name'].'</a></li>';
                                        }
                                    }else{
                                        echo '<div><h1>none company</h1></div>';
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!--popular-->
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Popular Item
                            </h3>
                            <ul class="links double_links">
                                <li><a href="#">I156</a></li>
                                <li><a href="#">card45</a></li>
                                <li><a href="#">card56</a></li>
                                <li><a href="#">box1</a></li>
                                <li><a href="#">box62</a></li>
                                <li><a href="#">thawa</a></li>
                                <li><a href="#">hithala</a></li>
                                <li><a href="#">dapam</a></li>
                            </ul>
                        </div>
                    </div>
                    <!--inster-->
                    <div class="col-xl-3 col-md-6 col-lg-3">
                        <div class="footer_widget">
                            <h3 class="footer_title">
                                Instagram
                            </h3>
                            <div class="instagram_feed">

                            <?php
                                /*-----------------------inster image---------------------------*/
                                if(mysqli_num_rows($inster_result) > 0){
                                    while ($row = $inster_result-> fetch_assoc()){
                                        echo '<div class="single_insta">
                                            <a href="#">
                                                <img src="'.$row['inster_image'].'" alt="">
                                            </a>
                                        </div>';
                                    }
                                }else{
                                    echo '<h1 class="tabel_emty_error">no image</h1>';
                                }
                            ?>   
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--C text-->
        <div class="copy-right_text">
            <div class="container">
                <div class="footer_border"></div>
                <div class="row">
                    <div class="col-xl-12">
                        <p class="copy_right text-center">
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="../serpriseCreater/add.php" target="_blank">Suprisc.lk team </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--search-->
  <div class="modal fade custom_search_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="serch_form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <input type="text" placeholder="Search Your Choice" name="searchtxt">
                <button type="submit" id="search" name="searchbuton"><i class="fa fa-search"></i></button>
            </form>
        </div>
      </div>
    </div>
  </div>
  <!--login-->
  <div class="modal fade custom_search_pop" id="logeModalCenter" tabindex="-1" role="dialog" aria-labelledby="logModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="log">
            <div class="modal-content">
                <form class="logbox" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                    <h1>Login</h1>
                    <div class="newacc_error"><?php echo  $error_log_emty; ?></div>
                    <input type="text" name="username" placeholder="Username">
                    <div class="newacc_error"><?php echo  $error_log_username; ?></div>
                    <input type="password" name="password" placeholder="password">
                    <input type="submit" name="submit" value="Login" >
                    <div class="logbox_p_div">
                        <p>Fogot <a href="#" class="logbox_p_div_a"> password ?</a></p>
                        <p>Creat New  <a href="newacc.php" class="logbox_p_div_a"> Account ?</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>

    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min"></script>
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

    <script>
        // load more button function
        $(document).ready(function(){
            //first count
            var cou=8;
            $(".boxed-btn4").click(function(){
                // pass count
                cou=cou+8;
                // load loademore
                $("#item_content").load("exphp/indexloadmorelog.php",{
                    cou_N:cou
                });
            });
        });
      </script>
    
</body>

</html>