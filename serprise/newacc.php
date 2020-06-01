<!--Suprice.lk-->
<?PHP include 'conection.php' ?>
<?PHP
/*-------------------------------------new account php----------------------------------*/
/*----------------curren date-----------------*/
    $month = date('m');
    $day = date('d');
    $year = date('Y');

    $taday = $year . '-' . $month .'-' . $day;
/*----------------curren date end-----------------*/

    $erroe_emty = '';
    $error_name = '';
    $erroe_selectbox = '';
    $erroe_email = '';
    $erroe_pass = '';
    $erroe_img = '';
    $erroe_user = '';
    /*----------click sign in------------------------*/
    if(isset($_POST["submit"])){
        /*----------get form data------------------------*/
        $full_name = $con->real_escape_string($_POST['name']);
        $provins = $con->real_escape_string($_POST['Provins']);
        $district = $con->real_escape_string($_POST['district']);
        $addres = $con->real_escape_string($_POST['addres']);
        $email = $con->real_escape_string($_POST['email']);
        $birthday = $con->real_escape_string($_POST['Birthday']);
        $gender = $con->real_escape_string($_POST['gender']);
        $username = $con->real_escape_string($_POST['username']);
        $password = $con->real_escape_string($_POST['password']);
        $user_image = $con->real_escape_string('img/user/user'.$_FILES['user_image']['name']);
        /*----------form validation------------------------*/
        if(!empty($full_name) && !empty($provins) && !empty($district) && !empty($addres) && !empty($email) && !empty($birthday) && !empty($gender) && !empty($username) && !empty($password) && !empty($user_image)){
            if (preg_match("/^[a-zA-Z -]+$/",$full_name)) {
                if ($provins != 'Provins' && $district != 'District'){
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$password)){
                            if(preg_match("!image!",$_FILES['user_image']['type'])){
                                /*----------get user------------------------*/
                                $user_name = "SELECT * FROM user WHERE user_username='$username' AND user_status='user'";
                                $user_name_result = mysqli_query($con, $user_name) or die (mysqli_error($con));

                                if(mysqli_num_rows($user_name_result) > 0){
                                    $erroe_user = 'Sorry.. Username already taken'; 
                                    $error_name = 'Opes Invalide data';
                                }else{
                                    /*----------upload image in folder----------*/
                                    if(copy($_FILES['user_image']['tmp_name'], $user_image)){
                                        $md5_password = md5($password);
                                        /*----------add new user------------------------*/
                                        $insert_user = "INSERT INTO user (user_status, user_full_name, user_email, user_province, user_distric, user_address, user_dob, user_gender, user_username, user_password, user_image, user_menber_ship, user_tel_number)
                                        VALUES('user', '$full_name', '$email', '$provins', '$district', '$addres', '$birthday', '$gender', '$username', '$md5_password', '$user_image', 'New', 'Add Tel.number go setting')";
                                        $insert_user_result = mysqli_query($con, $insert_user) or die (mysqli_error($con));

                                        if(mysqli_num_rows($insert_user_result) > 0){
                                            $error_name = 'Can not insert';
                                        }else{
                                            /*--------------load index-------------------*/
                                            header("location: index.php");
                                        }
                                    }else{
                                        $error_name = 'Can not insert image';
                                    }

                                }

                            }else{
                                $erroe_img = 'Select valid image type'; 
                                $error_name = 'Opes Invalide data';
                            }

                        }else{
                            $erroe_pass = 'Enter valid password (8 charcter and lower case , uper case)'; 
                            $error_name = 'Opes Invalide data';
                        }

                    }else{
                        $erroe_email = 'Enter valid email';
                        $error_name = 'Opes Invalide data'; 
                    }

                }else{
                    $erroe_selectbox = 'Invalid province or district';
                    $error_name = 'Opes Invalide data'; 
                }
                    
            }else{
                $erroe_emty = 'Only letters allowed Full name';
                $error_name = 'Opes Invalide data'; 
            }

        }else{
            $error_name = 'Opes All feild fill and submit';
           
        }
    }
/*-----------------------------------------------new account end----------------------------------------------------*/
/*-----------------------------------------------load select----------------------------------------------------*/
$load_select_pro = "SELECT delivery_provins_name FROM delivery_provins";
$load_select_pro_result = mysqli_query($con, $load_select_pro) or die (mysqli_error($con));

$load_select_dis = "SELECT delivery_district_name FROM delivery_district";
$load_select_dis_result = mysqli_query($con, $load_select_dis) or die (mysqli_error($con));

/*-----------------------------------------------load select end----------------------------------------------------*/

?>


<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk/newAccount</title>
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

<body class="newacc_bg">
    <div class="newacc_bg_div">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="log">
                <div class="modal-content">
                    <form class="logbox2" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype = "multipart/form-data">
                        <h1>New Account</h1>
                        <div class="newacc_error"><?php echo  $error_name; ?></div>
                        <input type="text" name="name" placeholder="Full Name">
                        <div class="newacc_error"><?php echo  $erroe_emty; ?></div>
                        <div class="select">
                            <select class="select_pro" name="Provins">
                                <option data-display="Country"value="none">Provins</option>
                                <?php
                                    if(mysqli_num_rows($load_select_pro_result) > 0){
                                        while ($row = $load_select_pro_result-> fetch_assoc()){
                                            echo '<option class="select_option" value="'.$row["delivery_provins_name"].'">'.$row["delivery_provins_name"].'</option>';
                                        }
                                    }else{
                                        echo '<option class="select_option" value="no">none</option>';
                                    }
                                ?>
                                </select>
                                <select class="select_dis" name="district">
                                    <option data-display="Country" value="none">District</option>
                                    <?php
                                        if(mysqli_num_rows($load_select_dis_result) > 0){
                                            while ($row = $load_select_dis_result-> fetch_assoc()){
                                                echo '<option class="select_option" value="'.$row["delivery_district_name"].'">'.$row["delivery_district_name"].'</option>';
                                            }
                                        }else{
                                            echo '<option class="select_option" value="no">none</option>';
                            
                                        }
                                    ?>
                              </select>
                        </div>
                        <div class="newacc_error"><?php echo  $erroe_selectbox; ?></div>
                        <textarea class="address" rows="4" cols="50" name="addres" placeholder="Address"></textarea>
                        <input type="email" name="email" placeholder="Email@gmail.com">
                        <div class="newacc_error"><?php echo  $erroe_email; ?></div>
                        <div>Birthday<input type="date" value="<?PHP echo $taday;?>" max="<?PHP echo $taday;?>" name="Birthday"></div>
                        <div>
                            Gender <br><input type="radio" name="gender" value="Male" checked> Male
                                        <input type="radio" name="gender" value="Female"> Female
                        </div>
                        <input type="text" name="username" placeholder="Username">
                        <div class="newacc_error"><?php echo  $erroe_user; ?></div>
                        <input type="password" name="password" placeholder="password">
                        <div class="newacc_error"><?php echo  $erroe_pass; ?></div>
                        Your Image <input type="file" name="user_image" accept="image/*">
                        <div class="newacc_error"><?php echo  $erroe_img; ?></div>
                        <div> <div>
                        <input type="submit" name="submit" value="Create">
                        <p class="form_link">Already you have <a data-toggle="modal" data-target="#logeModalCenter" href="#" class="form_link_acc">Account?</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade custom_search_pop" id="logeModalCenter" tabindex="-1" role="dialog" aria-labelledby="logModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="log">
                <div class="modal-content">
                    <form class="logbox" action="#" method="post">
                        <h1>Login</h1>
                        <input type="text" name="" placeholder="Username">
                        <input type="password" name="" placeholder="password">
                        <input type="submit" name="" value="Login">
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

</body>

</html>