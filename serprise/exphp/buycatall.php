<?php include '../conection.php' ?>

<?php 
    session_start();
    /*---login user id-----*/
    $log_user_id = $_SESSION['log_user_id'];
    /*------click cart buy -------*/
    if(isset($_POST["submit"])){
        /*------get form data-------*/
        $full_name=$con->real_escape_string($_POST["inputname"]);
        $user_name=$con->real_escape_string($_POST["inputuser"]);
        $password=$con->real_escape_string($_POST["inputpassword"]);
        $card_number=$con->real_escape_string($_POST["inputcard"]);
        $thru_date=$con->real_escape_string($_POST["inputthru"]);
        /*------form validation-------*/
        if(!empty($full_name) && !empty($user_name) && !empty($password) && !empty($card_number) && !empty($thru_date)){
            if(preg_match("/^[a-zA-Z -]+$/",$full_name)){
                if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/",$password)){
                    if(preg_match("/^[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}$/", $card_number)){
                        if(preg_match("/^[0-9]{3}$/", $thru_date)){
                            /*------get cart-------*/
                            $cart = "SELECT * FROM cart WHERE cart_user_id='$log_user_id'";
                            $cart_result = mysqli_query($con, $cart) or die (mysqli_error($con));
                            /*------add order item all row in cart-------*/
                            while ($row = $cart_result-> fetch_assoc()){
                                $order_item = $row['cart_item_id'];
                                $order_user = $row['cart_user_id'];
                                $order_deli = $row['cart_delivery_company_id'];
                                $date = date("Y-m-d");
                                $order_tot = $row['cart_total_amount'];
                                $order_qun = $row['cart_quntity'];
                                $dil_cost = $row['cart_delivery_cost'];
                                    /*------add order item -------*/
                                    $insert_order = "INSERT INTO order_item (order_item_id, order_user_id, order_dilivary_com_id, order_date, order_amount, order_quntity, order_delivary_cost)
                                    VALUES('$order_item', '$order_user', '$order_deli', '$date', '$order_tot', '$order_qun', '$dil_cost')";
                                    $insert_order_result = mysqli_query($con, $insert_order) or die (mysqli_error($con));
                                    /*------delete all row in cart-------*/
                                    $delete_cart = "DELETE FROM cart WHERE cart_user_id='$log_user_id'";
                                    $delete_cart_result = mysqli_query($con, $delete_cart) or die (mysqli_error($con));
                            }
                            /*------load cart-------*/
                            header('Location:../cart.php');
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
                    <form role="form" method = "post" action = "buycatall.php">
                        <div class="div8">
                            <div class="div9">
                                <div class="div10">
                                    <label class="buy_label">FULL NAME :</label></br>
                                        <input class="buy_input" type="text" name="inputname" class="form-control" placeholder="Your Name" />
                                </div>
                            </div>
                        </div>
                        <div class="div11">
                            <div class="div12">
                                <div class="div13">
                                    <label class="buy_label"><span class="visible-xs-inline">USER</span> NAME :</label></br>
                                    <input class="buy_input" type="text" name="inputuser" class="form-control" placeholder="Valid Card Number" />
                                </div>
                            </div>
                            <div class="div14">
                                <div class="div15">
                                    <label class="buy_label">PASSWORD :</label></br>
                                    <input class="buy_input" type="password" name="inputpassword" class="form-control" placeholder="Password" />
                                </div>
                            </div>
                        </div>
                        <div class="div16">
                            <div class="div17">
                                <div class="div18">
                                    <label class="buy_label">CARD NUMBER :</label></br>
                                    <input class="buy_input" type="text" name="inputcard" class="form-control" placeholder="Card Owner Name" />
                                </div>
                            </div>
                        </div>
                        <div class="div19">
                            <div class="div20">
                                <div class="div21">
                                    <label class="buy_label">CV CODE :</label></br>
                                    <input class="buy_input" type="text" name="inputthru" class="form-control" placeholder="Cv Code" />
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

