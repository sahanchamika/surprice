<?php include '../conection.php' ?>

<?php 
    session_start();
    /*---login user id-----*/
    $log_user_id = $_SESSION['log_user_id'];
    /*------click buy price-------*/
    if(isset($_POST["submit"])){
        /*------get form data-------*/
        $full_name=$con->real_escape_string($_POST["inputname"]);
        $user_name=$con->real_escape_string($_POST["inputuser"]);
        $password=$con->real_escape_string($_POST["inputpassword"]);
        $card_number=$con->real_escape_string($_POST["inputcard"]);
        $thru_date=$con->real_escape_string($_POST["inputthru"]);
        $sep_name=$con->real_escape_string($_POST["sepname"]);
        $address=$con->real_escape_string($_POST["addres"]);

        /*------form validation-------*/
        if(!empty($full_name) && !empty($user_name) && !empty($password) && !empty($card_number) && !empty($thru_date) && !empty($sep_name) && !empty($address)){
            if(preg_match("/^[a-zA-Z -]+$/",$full_name)){
                if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$password)){
                    if(preg_match("/^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/", $card_number)){
                        if(preg_match("/^[0-9]{3}$/", $thru_date)){
                            /*------get price box group-------*/
                            $box_gr = "SELECT * FROM price_box_group WHERE price_box_group_user_id='$log_user_id'";
                            $box_gr_result = mysqli_query($con, $box_gr) or die (mysqli_error($con));
                            $box_gr_row = $box_gr_result-> fetch_assoc();

                            $date = date("Y-m-d");
                            $box_order_group_f = 1;
                            /*------user first time buy price-------*/
                            if($box_gr_row['price_box_group_user_id'] == ''){
                                /*------add new use row in price box group-------*/
                                $insert_box_group = "INSERT INTO price_box_group (price_box_group_user_id, price_box_group_u_id, price_box_group_date)
                                VALUES('$log_user_id', '$box_order_group_f', '$date')";
                                $insert_box_group_result = mysqli_query($con, $insert_box_group) or die (mysqli_error($con));
                            }else{
                                /*------update date & group id in price box group -------*/
                                $newgroup = ($box_gr_row['price_box_group_u_id'] + 1);
                                $update_box = "UPDATE price_box_group SET price_box_group_u_id='$newgroup', price_box_group_date='$date' WHERE price_box_group_user_id='$log_user_id'";
                                $update_box_result = mysqli_query($con, $update_box) or die (mysqli_error($con));
                            }
                            /*------get price box for display-------*/
                            $box = "SELECT * FROM price_box WHERE box_user_id='$log_user_id'";
                            $box_result = mysqli_query($con, $box) or die (mysqli_error($con));
                            /*------get price box details-------*/
                            $box_detail = "SELECT * FROM price_box_details LIMIT 1";
                            $box_detail_result = mysqli_query($con, $box_detail) or die (mysqli_error($con));
                            $box_detail_row = $box_detail_result-> fetch_assoc();
                            /*------define variabel for calculate discount & total amount-------*/
                            $box_cost = 0;
                            $tot = 0;
                            $weight = 0;
                            $dili_cost = 0;
                            /*------get price box for calculate count-------*/
                            $box_count = "SELECT * FROM price_box WHERE box_user_id='$log_user_id'";
                            $box_count_result = mysqli_query($con, $box_count) or die (mysqli_error($con));
                            while ($row2 = $box_count_result-> fetch_assoc()){
                                /*------calculate total & item weight-------*/
                                $tot = $tot + $row2['box_amount'];
                                $weight = $weight + $row2['box_item_weight'];
                                $dili_cost = $dili_cost + $row2['box_delivary_cost'];
                            }
                            /*------find discount-------*/
                            if($weight < 1){
                                $total_amount = $tot + $box_detail_row['price_box_details_1kg'];;
                                
                            }else{
                                if($weight < 1.5){
                                    $total_amount = $tot + $box_detail_row['price_box_details_1.5kg'];
                                   
                                }else{
                                    if($weight < 2){
                                        $total_amount = $tot + $box_detail_row['price_box_details_2kg'];
                                    }else{
                                        if($weight < 3){
                                            $total_amount = $tot + $box_detail_row['price_box_details_3kg'];
                                        }else{
                                            $total_amount = $tot + $box_detail_row['price_box_details_5kg'];
                                        }
                                    }
                                }
                            }
                            /*------add box item in price box order-------*/
                            while ($row = $box_result-> fetch_assoc()){
                                $box_order_item = $row['box_item_id'];
                                $box_order_deli = $row['box_delivary_com_id'];
                                $date = date("Y-m-d");
                                $box_order_qun = $row['box_quntity'];
                                $box_order_group = $box_gr_row['price_box_group_u_id'];

                                    /*------get price box -------*/
                                    $box_gr1 = "SELECT * FROM price_box_group WHERE price_box_group_user_id='$log_user_id'";
                                    $box_gr1_result = mysqli_query($con, $box_gr1) or die (mysqli_error($con));
                                    $box_gr1_row = $box_gr1_result-> fetch_assoc();

                                    $box_order_group1 = $box_gr1_row['price_box_group_u_id'];
                                    /*------add item price box order -------*/
                                    $insert_box_order = "INSERT INTO price_box_order (price_box_order_item_id, price_box_order_user_id, price_box_order_d_com_id, price_box_order_date, price_box_order_amount, price_box_order_quntity, price_box_order_group_id, price_box_order_deli_cost, price_box_order_name, price_box_order_address)
                                    VALUES('$box_order_item', '$log_user_id', '$box_order_deli', '$date', '$total_amount', '$box_order_qun', '$box_order_group1', '$dili_cost', '$sep_name', '$address')";
                                    $insert_box_order_result = mysqli_query($con, $insert_box_order) or die (mysqli_error($con));
                                    /*------delete price box item-------*/
                                    $delete_box = "DELETE FROM price_box WHERE box_user_id='$log_user_id'";
                                    $delete_box_result = mysqli_query($con, $delete_box) or die (mysqli_error($con));

                            }
                            /*------load sprice box-------*/
                            header('Location:../sepricebox.php');
                        }else{
                            echo "invalid cv";
                        }
                    }else{
                        echo "invalid card number";
                    }
                }else{
                    echo "invalid password";
                }
            }else{
                echo "invalid name";
            }
        }else{

            echo "Please fill all field";

        }

    }
?>

<html>
<head>
<link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
</head>
<body>   
<div class="div1">
    <div class="div2">
        <div class="div3">
            <div class="div4">
                <div class="div5">
                    <div class="div6">
                        <h3 class="h1">Payment Details</h3>
                            <div class="buy_icon">
                                <i class="fab fa-cc-paypal"></i>
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fas fa-credit-card"></i>
                            </div>
                    </div>
                </div>
                <div class="div7">
                    <form role="form" method = "post" action = "buypricebox.php">
                        <div class="div8">
                            <div class="div9">
                                <div class="div10">
                                    <label class="buy_label">SERPRISE NAME :</label></br>
                                        <input class="buy_input" type="text" name="sepname" class="form-control" placeholder=" He or She Name" />
                                </div>
                            </div>
                        </div>
                        <div class="div8">
                            <div class="div9">
                                <div class="div10">
                                    <label class="buy_label">SERPRISE ADDRESS :</label></br>
                                        <textarea class="buy_input" rows="4" cols="20" name="addres" placeholder=" He or She Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="div8">
                            <div class="div9">
                                <div class="div10">
                                    <label class="buy_label">FULL NAME :</label></br>
                                        <input class="buy_input" type="text" name="inputname" class="form-control" placeholder=" Your Name" />
                                </div>
                            </div>
                        </div>
                        <div class="div11">
                            <div class="div12">
                                <div class="div13">
                                    <label class="buy_label"><span class="visible-xs-inline">USER</span> NAME :</label></br>
                                    <input class="buy_input" type="text" name="inputuser" class="form-control" placeholder=" Valid Card Number" />
                                </div>
                            </div>
                            <div class="div14">
                                <div class="div15">
                                    <label class="buy_label">PASSWORD :</label></br>
                                    <input class="buy_input" type="password" name="inputpassword" class="form-control" placeholder=" Password" />
                                </div>
                            </div>
                        </div>
                        <div class="div16">
                            <div class="div17">
                                <div class="div18">
                                    <label class="buy_label">CARD NUMBER :</label></br>
                                    <input class="buy_input" type="text" name="inputcard" class="form-control" placeholder=" Card Owner Name" />
                                </div>
                            </div>
                        </div>
                        <div class="div19">
                            <div class="div20">
                                <div class="div21">
                                    <label class="buy_label">CV CODE :</label></br>
                                    <input class="buy_input" type="text" name="inputthru" class="form-control" placeholder=" Cv Code" />
                                </div>
                            </div>
                        </div>
                    
                </div>
                <div class="div22">
                    <div class="div23">
                        <div class="div24">
                            <button type="submit" name="submit" class="btn1">Payment</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

