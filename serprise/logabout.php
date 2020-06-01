<!--logabout.lk-->
<?PHP include 'conection.php' ?>
<?PHP
session_start();

/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_user_id'];

/*---------------------login user details-----------------------*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$row = $log_user_result-> fetch_assoc();

/*--------------catagory ---------------*/

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

/*-----------------catagory  end-----------------*/

/*---------------------seprice details-----------------------*/
$serprice = "SELECT * FROM serprise LIMIT 1";
$serprice_result = mysqli_query($con, $serprice) or die (mysqli_error($con));
$serprice_row = $serprice_result-> fetch_assoc();

/*---------------------item count for newly added item----------------------*/
$item = "SELECT SUM(item_quantity) FROM item";
$item_result = mysqli_query($con, $item) or die (mysqli_error($con));
$item_row = $item_result-> fetch_assoc();

/*---------------------item count for newly added item----------------------*/
$flash_item = "SELECT SUM(flash_sale_quantity) FROM flash_sale";
$flash_item_result = mysqli_query($con, $flash_item) or die (mysqli_error($con));
$flash_item_row = $flash_item_result-> fetch_assoc();

/*---------------------count user-----------------------*/
$count_user = "SELECT COUNT(`user_id`) FROM user WHERE user_status='user'";
$count_user_result = mysqli_query($con, $count_user) or die (mysqli_error($con));
$count_user_row = $count_user_result-> fetch_assoc();

/*---------------delivery_company --------------------*/
$delivery_company = "SELECT * FROM delivery_company LIMIT 5";
$delivery_company_result = mysqli_query($con, $delivery_company) or die (mysqli_error($con));

/*---------------inster --------------------*/
$inster = "SELECT * FROM inster LIMIT 6";
$inster_result = mysqli_query($con, $inster) or die (mysqli_error($con));

$email_error = '';
$name_error = '';
$emty_error = '';
$sucess = '';

/*----------click send---------------*/
if(isset($_POST["submit_feedback"])){
    $message = $con->real_escape_string($_POST['message']);
    $name = $con->real_escape_string($_POST['name']);
    $email = $con->real_escape_string($_POST['email']);
    $subject = $con->real_escape_string($_POST['subject']);
    $username = $row['user_username'];
    /*----------form validation------------------------*/
    if(!empty($message) && !empty($name) && !empty($email) && !empty($subject)){
        if(preg_match("/^[a-zA-Z -]+$/",$name)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $insert_feedback = "INSERT INTO user_feedback (user_feedback_user_id, user_feedback_subject, user_feedback_message, user_feedback_user_name, user_feedback_name, user_feedback_email, user_feedback_state)
                VALUES('$log_user_id', '$subject', '$message', '$username', '$name', '$email', 'Active')";
                $insert_feedback_result = mysqli_query($con, $insert_feedback) or die (mysqli_error($con));
                $sucess = 'Thanks For Your Feedback!';
            }else{
                $email_error = 'Invaid Email Enter Valid Email';
            }
        }else{
            $name_error = 'Invalid Enter You Real Name';
        }
    }else{
        $emty_error = 'Fill All Feild and Send';
    }
}

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk/about</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
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
                                            <li><a href="logabout.php">About</a></li>
                                            <li><a class="" href="contact.php">Contact</a></l/li>
                                            <li><a href="catagory.php?page=all">Catogory & All</a>
                                                <ul class="submenu">
                                                    <li><a href="catagory.php?page=card"><?php echo $row1['item_catagory_name']; ?></a></li>
                                                    <li><a href="catagory.php?page=box"><?php echo $row2['item_catagory_name']; ?></a></li>
                                                    <li><a href="catagory.php?page=wallart"><?php echo $row3['item_catagory_name']; ?></a></li>
                                                    <li><a href="catagory.php?page=statur"><?php echo $row4['item_catagory_name']; ?></a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            
                            <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                                <div class="social_wrap d-flex align-items-center justify-content-end">
                                    <div class="number">
                                        <p> <i class="fa fa-phone"></i> <?php echo $serprice_row['serprise_tlp']; ?> </p>
                                    </div>
                                </div>
                            </div>
                            <div class="seach_icon">
                                <a href="#">
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
    

    <!-- bradcam_area  -->
    <div class="bradcam_area bradcam_bg_3">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="bradcam_text text-center">
                        <h3>About Us</h3>
                        <p>Our Story, Who Us And What We Do For You, How Seprice You And Your Love!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ bradcam_area  -->
    
    <div class="about_story">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="story_heading">
                        <h3>Our Story</h3>
                    </div>
                    <div class="row">
                        <div class="col-lg-11 offset-lg-1">
                            <div class="story_info">
                                <div class="row">
                                    <div class="col-lg-9">
                                        <p><?php echo $serprice_row['serprise_about_story']; ?></p>
                                        <p><?php echo $serprice_row['serprise_about_story2']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="story_thumb">
                                <div class="row">
                                    <div class="col-lg-5 col-md-6">
                                        <div class="thumb padd_1">
                                            <img src="<?php echo $serprice_row['serprise_about_img1']; ?>" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="thumb">
                                            <img src="<?php echo $serprice_row['serprise_about_img2']; ?>" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="counter_wrap">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single_counter text-center">
                                            <h3  class="counter"><?php echo $item_row['SUM(item_quantity)']; ?></h3>
                                            <p>Add Newly Item</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single_counter text-center">
                                            <h3 class="counter"><?php echo $flash_item_row['SUM(flash_sale_quantity)']; ?></h3>
                                            <p>Today Flash Sale</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="single_counter text-center">
                                            <h3 class="counter"><?php echo $count_user_row['COUNT(`user_id`)']; ?></h3>
                                            <p>Happy Clients</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section">
        <div class="container">
            <div class="row_new">
            <div class="row">
                <div class="col-12">
                    <h2 class="contact-title">Feedback</h2>
                </div>
                <div class="col-lg-8">
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $email_error, $name_error, $emty_error, $sucess ; ?></p></div>
                    <form class="form-contact contact_form" action="logabout.php" method="post"  >
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="name" id="name" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control valid" name="email" id="email" type="email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" placeholder="Email">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <input class="form-control" name="subject" id="subject" type="text" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'" placeholder="Enter Subject">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="submit" class="feed_button" name="submit_feedback" value="Send">
                        </div>
                    </form>
                </div>
                <div class="col-lg-3 offset-lg-1">
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-home"></i></span>
                        <div class="media-body">
                            <h3><?php echo $serprice_row['serprise_addres']; ?></h3>
                            <p><?php echo $serprice_row['serprise_country_city']; ?></p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-tablet"></i></span>
                        <div class="media-body">
                            <h3><?php echo $serprice_row['serprise_tlp']; ?></h3>
                            <p><?php echo $serprice_row['serprise_open_time']; ?></p>
                        </div>
                    </div>
                    <div class="media contact-info">
                        <span class="contact-info__icon"><i class="ti-email"></i></span>
                        <div class="media-body">
                            <h3><?php echo $serprice_row['serprise_email']; ?></h3>
                            <p>Send us your like Anytime!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

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
                            <p><?php echo $serprice_row['serprise_addres']; ?> <br> <?php echo $serprice_row['serprise_country_city']; ?> <br>
                                <a href="#"><?php echo $serprice_row['serprise_tlp']; ?></a> <br>
                                <a href="#"><?php echo $serprice_row['serprise_email']; ?></a>
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
 

  
  <!--contact js-->
  <script src="js/contact.js"></script>
  <script src="js/jquery.ajaxchimp.min.js"></script>
  <script src="js/jquery.form.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/mail-script.js"></script>


  <script src="js/main.js"></script>
  <script>
      $('#datepicker').datepicker({
          iconsLibrary: 'fontawesome',
          icons: {
           rightIcon: '<span class="fa fa-caret-down"></span>'
       }
      });
  </script>
</body>

</html>