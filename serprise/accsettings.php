
<!--Account settings.lk-->
<?PHP include 'conection.php' ?>
<?PHP
session_start();
/*---login user id-----*/
$log_user_id = $_SESSION['log_user_id'];

/*---error massage-----*/
$emty_error = '';
$erroe_pass = '';
$current_pass_error = '';
$re_pass_error = '';
$pw_succses = '';
$username_emty_error = '';
$username_invalid_error = '';
$email_emty_error = '';
$invalid_email_error = '';
$invalid_card_error = '';
$card_emty_error = '';
$card_type_emty_error = '';
$profile_emty_error = '';
$invalid_image_type = '';
$can_not_image_errror = '';
$invalid_number_error = '';
$number_error = '';
$address_emty_error = '';
$pro_dis_emty_error = '';



/*---login user details-----*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$row = $log_user_result-> fetch_assoc();

/*---------------inster --------------------*/
$inster = "SELECT * FROM inster LIMIT 6";
$inster_result = mysqli_query($con, $inster) or die (mysqli_error($con));

/*---------------delivery_company --------------------*/
$delivery_company = "SELECT * FROM delivery_company LIMIT 5";
$delivery_company_result = mysqli_query($con, $delivery_company) or die (mysqli_error($con));

/*---------------serprise --------------------*/
$serprise = "SELECT * FROM serprise LIMIT 1";
$serprise_result = mysqli_query($con, $serprise) or die (mysqli_error($con));
$serprise_row = $serprise_result-> fetch_assoc();

/*-------load select------*/
$load_select_pro = "SELECT delivery_provins_name FROM delivery_provins";
$load_select_pro_result = mysqli_query($con, $load_select_pro) or die (mysqli_error($con));

$load_select_dis = "SELECT delivery_district_name FROM delivery_district";
$load_select_dis_result = mysqli_query($con, $load_select_dis) or die (mysqli_error($con));
/*----------click change----------*/
if(isset($_POST["password_submit"])){
    /*----------get form password ditails----------*/
    $current_pass = $con->real_escape_string($_POST['passcurrent']);
    $new_pass_1 = $con->real_escape_string($_POST['passnew1']);
    $new_pass_2 = $con->real_escape_string($_POST['passnew2']);
    /*----------form validation----------*/
    if(!empty($current_pass) && !empty($new_pass_1) && !empty($new_pass_2)){
        $md5_current_pass = md5($current_pass);
        /*----------check current password same enter password----------*/
        if($row['user_password'] == $md5_current_pass){
            if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$new_pass_1) && preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$new_pass_2)){
                if($new_pass_1 == $new_pass_2){
                    /*----------update password----------*/
                    $update_new_pass_md5 = md5($new_pass_1);
                    $update_pass = "UPDATE user SET user_password='$update_new_pass_md5' WHERE user_id='$log_user_id' AND user_status='user'";
                    $update_pass_result = mysqli_query($con, $update_pass) or die (mysqli_error($con));
                    /*----------display massage----------*/
                    $pw_succses = 'Change Password';
                }else{
                    $re_pass_error = 'Not Match Conform Password ';
                }
            }else{
                $erroe_pass = 'Enter valid for new (8 charcter and lower case , uper case)';
            }
        }else{
            $current_pass_error = 'Not Match You Current Password Eenter Correct Password';
        }
    }else{
        $emty_error = 'Fill All Field and Submit';
    }
}

/*----------click update user name----------*/
if(isset($_POST["username_submit"])){
    /*----------get form username----------*/
    $user_name = $con->real_escape_string($_POST['u_name']);
    if(!empty($user_name)){
        $user_name_check = "SELECT * FROM user WHERE user_username='$user_name' AND user_status='user'";
        $user_name_check_result = mysqli_query($con, $user_name_check) or die (mysqli_error($con));
        if(mysqli_num_rows($user_name_check_result) <= 0){
            $update_u_name = "UPDATE user SET user_username='$user_name' WHERE user_id='$log_user_id' AND user_status='user'";
            $update_u_name_result = mysqli_query($con, $update_u_name) or die (mysqli_error($con));
            /*----------refresh page----------*/
            header("location: accsettings.php");
    /*----------display massage----------*/
        }else{
            $username_invalid_error ='Sorry.. Username already taken';
        }
    }else{
        $username_emty_error = 'Enter User Name';
    }
}

/*----------click update email----------*/
if(isset($_POST["email_submit"])){
    /*----------get form email----------*/
    $user_email = $con->real_escape_string($_POST['u_email']);
    if(!empty($user_email)){
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $update_email = "UPDATE user SET user_email='$user_email' WHERE user_id='$log_user_id' AND user_status='user'";
            $update_email_result = mysqli_query($con, $update_email) or die (mysqli_error($con));
            /*----------refresh page----------*/
            header("location: accsettings.php");
        /*----------display massage----------*/
        }else{
            $invalid_email_error = 'Invalid Email Enter valid email';
        }
    }else{
        $email_emty_error = 'Fild Emty Enter Valid Email';
    }
}

/*----------click update pement type----------*/
if(isset($_POST["card_submit"])){
    /*----------get form card details----------*/
    $card_type = $con->real_escape_string($_POST['u_card_type']);
    $card_number = $con->real_escape_string($_POST['u_card']);
    if($card_type != 'no'){
        if(!empty($card_number)){
            if(preg_match("/^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/", $card_number)) {
                $update_card = "UPDATE user SET user_payment_type='$card_type', user_card_number='$card_number' WHERE user_id='$log_user_id' AND user_status='user'";
                $update_card_result = mysqli_query($con, $update_card) or die (mysqli_error($con));
                /*----------refresh page----------*/
                header("location: accsettings.php");
            /*----------display massage----------*/
            }else{
                $invalid_card_error = 'Invalid Card Number Enter valid Card Number';
            }
        }else{
            $card_emty_error = 'Fild Emty Enter Valid Card Number';
        }
    }else{
        $card_type_emty_error = 'Select Valid Card Type';
    }
}

/*----------click update profile pic----------*/
if(isset($_POST["profile_submit"])){
    /*----------get form profile ditails----------*/
    $user_image = $con->real_escape_string('img/user/user'.$_FILES['u_prof']['name']);
    if(!empty($user_image)){
        if(preg_match("!image!",$_FILES['u_prof']['type'])){
            /*----------upload image in folder----------*/
            if(copy($_FILES['u_prof']['tmp_name'], $user_image)){
                $update_image = "UPDATE user SET user_image='$user_image' WHERE user_id='$log_user_id' AND user_status='user'";
                $update_image_result = mysqli_query($con, $update_image) or die (mysqli_error($con));
                /*----------refresh page----------*/
                header("location: accsettings.php");
            /*----------display massage----------*/
            }else{
                $can_not_image_errror = 'Can Not Add Image';
            }
        }else{
            $invalid_image_type = 'Invalid Image Type Select valid image';
        }
    }else{
        $profile_emty_error = 'First Select You Image';
    }
}

/*----------click update number----------*/
if(isset($_POST["number_submit"])){
    /*----------get form tel number----------*/
    $tel_number = $con->real_escape_string($_POST['u_number']);
    if(!empty($tel_number)){
        if(preg_match("/^[0-9]{3} [0-9]{7}$/", $tel_number)) {
            $update_number = "UPDATE user SET user_tel_number='$tel_number' WHERE user_id='$log_user_id' AND user_status='user'";
            $update_number_result = mysqli_query($con, $update_number) or die (mysqli_error($con));
            /*----------refresh page----------*/
            header("location: accsettings.php");
            /*----------display massage----------*/
        }else{
            $invalid_number_error = 'Invalid Number Enter Valid Number'; 
        }
    }else{
        $number_error = 'Emty Number Enter Valid Number';
    }
}

/*----------click update address----------*/
if(isset($_POST["address_submit"])){
    /*----------get form tel number----------*/
    $address = $con->real_escape_string($_POST['u_address']);
    if(!empty($address)){
        $update_address = "UPDATE user SET user_address='$address' WHERE user_id='$log_user_id' AND user_status='user'";
        $update_address_result = mysqli_query($con, $update_address) or die (mysqli_error($con));
        /*----------refresh page----------*/
        header("location: accsettings.php");
        /*----------display massage----------*/
    }else{
        $address_emty_error = 'Emty Adress Enter Adress';
    }
}

/*----------click update province distric----------*/
if(isset($_POST["pro_dis_submit"])){
    /*----------get form tel number----------*/
    $province = $con->real_escape_string($_POST['u_province']);
    $distric = $con->real_escape_string($_POST['u_distric']);
    if(($province != 'no') && ($distric != 'no')){
        $update_pro_dis = "UPDATE user SET user_province='$province', user_distric='$distric' WHERE user_id='$log_user_id' AND user_status='user'";
        $update_pro_dis_result = mysqli_query($con, $update_pro_dis) or die (mysqli_error($con));
        /*----------refresh page----------*/
        header("location: accsettings.php");
        /*----------display massage----------*/
    }else{
        $pro_dis_emty_error = 'Select Province and Distric';
    }
}

?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk</title>
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
                                                    <div class="acc-details-btn-2"><a class="prise" href="accsettings">Setting</a></div>
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

    <div><h1 class="acc_set_head">Account Settings</h1></div>
    <div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
            <!------right div------> 
            <div class="div_right">
                <!------change password div------> 
                <div>   
                    <div><h1 class="acc_set_up_pro">Change Password</h1></div>
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $erroe_pass, $current_pass_error, $emty_error, $re_pass_error, $pw_succses ; ?></p></div>
                    <table class="acc_set_pro_up_tabel">
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="password" name="passcurrent" placeholder=" Enter current password"></td>
                            <td></td>
                        </tr>
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="password" name="passnew1" placeholder=" Enter new password"></td>
                            <td></td>
                        </tr>
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="password" name="passnew2" placeholder=" Enter Conform Password"></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="password_submit" value="Change"></td>
                        </tr>
                    </table>
                </div>
                <!------update username, email------> 
                <div>    
                    <div><h1 class="acc_set_u_e">Update User Name And Email</h1></div>
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $username_emty_error, $username_invalid_error, $invalid_email_error, $email_emty_error ; ?></p></div>
                    <table class="acc_set_pro_up_tabel">
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="text" name="u_name" placeholder=" <?php echo $row["user_username"] ; ?>"></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="username_submit" value="Update"></td>
                        </tr>
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="email" name="u_email" placeholder=" <?php echo $row["user_email"] ; ?>"></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="email_submit" value="Update"></td>
                        </tr>
                    </table>
                </div>
                <!------update pament type------> 
                <div>    
                    <div><h1 class="acc_set_u_e">Update Pament Type</h1></div>
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $invalid_card_error, $card_emty_error, $card_type_emty_error ; ?></p></div>
                    <table class="acc_set_pro_up_tabel">
                        <tr class="acc_set_u_e_row">
                            <td><select class="acc_set_select" name="u_card_type">
                                <?php
                                    /*-------display payment type--------*/
                                    if($row["user_payment_type"] == 'Visa'){
                                            echo '<option  value="Visa">Visa</option>
                                            <option  value="Master">Master</option> 
                                            <option  value="Credit Card">Credit Card</option>';
                                    }else{
                                        if($row["user_payment_type"] == 'Master'){
                                            echo '<option  value="Master">Master</option> 
                                            <option  value="Visa">Visa</option>
                                            <option  value="Credit Card">Credit Card</option>';
                                        }else{
                                            if($row["user_payment_type"] == 'Credit Card'){
                                                echo '<option  value="Credit Card">Credit Card</option>
                                                <option  value="Master">Master</option> 
                                                <option  value="Visa">Visa</option>
                                                ';
                                            }else{
                                                echo '<option class="select_option" value="no">No Aded Now</option>
                                                <option  value="Credit Card">Credit Card</option>
                                                <option  value="Master">Master</option> 
                                                <option  value="Visa">Visa</option>';
                                            }
                                        }
                                    }
                               ?>
                            </select></td>
                            <td></td>
                        </tr>
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="text" name="u_card" placeholder=" <?php echo $row["user_card_number"] ; ?>"></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="card_submit" value="Update"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <!------left div------>
            <div class="div_left">
                <!------update profile------>
                <div>    
                    <div><h1 class="acc_set_up_pro">Update Profile Picture</h1></div>
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $profile_emty_error, $invalid_image_type, $can_not_image_errror ; ?></p></div>
                    <table class="acc_set_pro_up_tabel">
                        <tr class="acc_set_pro_up_row">
                            <td><img class="acc_set_profile" src="<?php echo $row["user_image"]; ?>" alt=""><input  class="acc_set_pro_add" type="file" name="u_prof" accept="image/*"></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="profile_submit" value="Update"></td>
                        </tr>
                    </table>
                </div>
                <!------update phone number & addres------>
                <div>    
                    <div><h1 class="acc_set_u_e">Update Phone Number & Adress</h1></div>
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $invalid_number_error, $number_error, $address_emty_error ; ?></p></div>
                    <table class="acc_set_pro_up_tabel">
                        <tr class="acc_set_u_e_row">
                            <td><input class="acc_set_input" type="text" name="u_number" placeholder=" <?php echo $row["user_tel_number"]; ?>"></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="number_submit" value="Update"></td>
                        </tr>
                        <tr class="acc_set_u_e_row">
                            <td><textarea class="acc_set_address" rows="4" cols="35" name="u_address" placeholder=" <?php echo $row["user_address"]; ?>"></textarea></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="address_submit" value="Update"></td>
                        </tr>
                    </table>
                </div>
                <!------update province & distric------>
                <div>    
                    <div><h1 class="acc_set_u_e">Update Province & Distric</h1></div>
                    <!------display error message------>
                    <div><p class="acc_set_error"><?php  echo $pro_dis_emty_error ; ?></p></div>
                    <table class="acc_set_pro_up_tabel">
                        <tr class="acc_set_u_e_row">
                            <td><select class="acc_set_select" name="u_province">
                                <option value="no">Provins</option>
                                <?php
                                    if(mysqli_num_rows($load_select_pro_result) > 0){
                                        while ($row = $load_select_pro_result-> fetch_assoc()){
                                            echo '<option class="select_option" value="'.$row["delivery_provins_name"].'">'.$row["delivery_provins_name"].'</option>';
                                        }
                                    }else{
                                        echo '<option value="no">none</option>';
                                    }
                                ?>
                            </select></td>
                            <td></td>
                        </tr>
                        <tr class="acc_set_u_e_row">
                            <td><select class="acc_set_select" name="u_distric">
                                <option value="no">District</option>
                                    <?php
                                        if(mysqli_num_rows($load_select_dis_result) > 0){
                                            while ($row = $load_select_dis_result-> fetch_assoc()){
                                                echo '<option class="select_option" value="'.$row["delivery_district_name"].'">'.$row["delivery_district_name"].'</option>';
                                            }
                                        }else{
                                            echo '<option value="no">none</option>';
                                        }
                                    ?>
                            </select></td>
                            <td><input class="acc_set_pro_up_submit" type="submit" name="pro_dis_submit" value="Update"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </div>
    <div id="setting_div"></div>
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

    <script src="js/main.js"></script>
    
</body>

</html>