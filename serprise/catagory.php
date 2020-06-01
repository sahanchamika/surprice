
<?PHP include 'conection.php' ?>
<?PHP
session_start();

/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_user_id'];

/*------get pass page-------*/
$select_page = $_GET["page"];

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

/*---------------delivery_company --------------------*/

$delivery_company = "SELECT * FROM delivery_company LIMIT 5";
$delivery_company_result = mysqli_query($con, $delivery_company) or die (mysqli_error($con));

/*-------------delivery_company  end-----------------*/

/*---------------inster --------------------*/

$inster = "SELECT * FROM inster LIMIT 6";
$inster_result = mysqli_query($con, $inster) or die (mysqli_error($con));

/*-------------inster  end-----------------*/

/*---------------serprise --------------------*/

$serprise = "SELECT * FROM serprise LIMIT 1";
$serprise_result = mysqli_query($con, $serprise) or die (mysqli_error($con));
$serprise_row = $serprise_result-> fetch_assoc();

/*-------------serprise end-----------------*/

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk/catagory.html</title>
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

<body class="catbody">
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
                                                <li><a href="newacc.php">New Account</a></li>
                                                <li><a href="order.php">Order</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                                
                                <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                                    <div class="social_wrap d-flex align-items-center justify-content-end">
                                        <div class="social_links d-none d-xl-block">
                                            <ul>
                                                <li><a href="cart.php"> <i class="fa fa-shopping-cart" id="nav_cat"></i> </a></li>
                                                <li><a href="sepricebox.php"> <i class="fa fa-gift" id="nav_cat"></i> </a></li>
                                            </ul>
                                        </div>
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
                                                    <div class="acc-details-btn-1"><a href="exphp/logout.php" class="prise">Log out</a></div>
                                                    <div class="acc-details-btn-2"><a class="prise" href="accsettings.php">Setting</a></div>
                                                </div>
                                            </div>
                                        </div>
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
<section class="test_my">
    <div id="ftr">

    </div>
</section>
    <div>
        <input type="checkbox" id="check">
        <label for="check">
            <i class="fa fa-bars" id="btn"></i>
            <i class="fa fa-times" id="cancel"></i>
        </label>
        <div class="sidebar">
            <header>
                <div class="menu_head">
                    <a href="catagory.php?page=all">
                        <h4>All Catagory</h4>
                    </a>
                </div>
            </header>
            <ul>
                <li><a class="allitem" href="#" id="all"><i class="fab fa-dropbox" id="icon_cat"></i>All</a></li>
                <li><a class="carditem" href="#" id="all2"><i class="fa fa-envelope" id="icon_cat"></i>Card</a></li>
                <li><a class="boxlitem" href="#" id="all3"><i class="fa fa-gift" id="icon_cat"></i>Box</a></li>
                <li><a class="wallitem" href="#" id="all4"><i class="fa fa-image" id="icon_cat"></i>Wol art</a></li>
                <li><a class="staturitem" href="#" id="all5"><i class="fas fa-dove" id="icon_cat"></i>Statue</a></li>
                <li><a class="ornamentitem" href="#" id="all6"><i class="fas fa-ring" id="icon_cat"></i>Ornament</a></li>
                <li><a class="albemitem" href="#" id="all7"><i class="fas fa-book" id="icon_cat"></i>Albem</a></li>
                <li><a class="freamtitem" href="#" id="all8"><i class="fas fa-cog" id="icon_cat"></i>Fream</a></li>
                <li><a class="price_renge" href="#" id="all9"><i class="fas fa-balance-scale-left" id="icon_cat"></i></i>Price Range</a></li>
                <li><a href="logabout.php" id="all10"><i class="fa fa-question-circle" id="icon_cat"></i>Feedback</a></li>
                <li><a href="#" ><i class="fa fa-question-circle" id="icon_cat"></i></a></li>
            </ul>
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
                            <a href="logindex.php">
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
                                        <i class="fab fa-instagram" id="socialicon"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-pinterest" id="socialicon"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fab fa-youtube" id="socialicon"></i>
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
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<?PHP

if($select_page == 'all'){
    echo"<script>
            $(document).ready(function(){
                $('#ftr').load('catagorysub/all.php');
            });
        </script>";
}else{
    if($select_page == 'card'){
        echo"<script>
                $(document).ready(function(){
                    $('#ftr').load('catagorysub/card.php');
                });
            </script>";
    }else{
        if($select_page == 'box'){
            echo"<script>
                    $(document).ready(function(){
                        $('#ftr').load('catagorysub/box.php');
                    });
                </script>";
        }else{
            if($select_page == 'albem'){
                echo"<script>
                        $(document).ready(function(){
                            $('#ftr').load('catagorysub/albem.php');
                        });
                    </script>";
            }else{
                if($select_page == 'fream'){
                    echo"<script>
                            $(document).ready(function(){
                                $('#ftr').load('catagorysub/fream.php');
                            });
                        </script>";
                }else{
                    if($select_page == 'ornament'){
                        echo"<script>
                                $(document).ready(function(){
                                    $('#ftr').load('catagorysub/ornament.php');
                                });
                            </script>";
                    }else{
                        if($select_page == 'pricerange'){
                            echo"<script>
                                    $(document).ready(function(){
                                        $('#ftr').load('catagorysub/pricerange.php');
                                    });
                                </script>";
                        }else{
                            if($select_page == 'statur'){
                                echo"<script>
                                        $(document).ready(function(){
                                            $('#ftr').load('catagorysub/statur.php');
                                        });
                                    </script>";
                            }else{
                                if($select_page == 'wallart'){
                                    echo"<script>
                                            $(document).ready(function(){
                                                $('#ftr').load('catagorysub/wallart.php');
                                            });
                                        </script>";
                                }else{
                                    echo"<script>
                                            $(document).ready(function(){
                                                $('#ftr').load('catagorysub/card.php');
                                            });
                                        </script>";
                                }      
                            }     
                        }     
                    }   
                }  
            }
        }
    }
}

?>

<script>
    
    $(document).ready(function(){
        $('.allitem').click(function(){
            $('#ftr').load('catagorysub/all.php');
        });
    });

    $(document).ready(function(){
        $('.carditem').click(function(){
            $('#ftr').load('catagorysub/card.php');
        });
    });

    $(document).ready(function(){
        $('.wallitem').click(function(){
            $('#ftr').load('catagorysub/wallart.php');
        });
    });

     $(document).ready(function(){
        $('.boxlitem').click(function(){
            $('#ftr').load('catagorysub/box.php');
        });
    });
    
    $(document).ready(function(){
        $('.albemitem').click(function(){
            $('#ftr').load('catagorysub/albem.php');
        });
    });
    
    $(document).ready(function(){
        $('.price_renge').click(function(){
            $('#ftr').load('catagorysub/pricerange.php');
        });
    });
    
    $(document).ready(function(){
        $('.staturitem').click(function(){
            $('#ftr').load('catagorysub/statur.php');
        });
    });

    $(document).ready(function(){
        $('.ornamentitem').click(function(){
            $('#ftr').load('catagorysub/ornament.php');
        });
    });

    $(document).ready(function(){
        $('.freamtitem').click(function(){
            $('#ftr').load('catagorysub/fream.php');
        });
    });
</script>


</body>

</html>