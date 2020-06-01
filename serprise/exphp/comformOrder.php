<?PHP include '../conection.php' ?>
<?php

session_start();

/*---login user id-----*/
$log_user_id = $_SESSION['log_user_id'];

/*---login user details-----*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$log_user_row = $log_user_result-> fetch_assoc();

/*---item shipping table-----*/
$item_shipping = "SELECT * FROM item_shipping WHERE item_shipping_user_id = '$log_user_id'";
$item_shipping_result = mysqli_query($con, $item_shipping) or die (mysqli_error($con));

/*---flash shipping table-----*/
$flash_shipping = "SELECT * FROM flash_shipping WHERE flash_shipping_user_id = '$log_user_id'";
$flash_shipping_result = mysqli_query($con, $flash_shipping) or die (mysqli_error($con));

/*---price shipping table-----*/
$price_shipping = "SELECT *, SUM(`price_shipping_quntity`) FROM price_shipping WHERE price_shipping_user_id = '$log_user_id' GROUP BY price_shipping_group_id";
$price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));

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
                    <td ><p class="p_space">'.$item_shipping_row['item_shipping_date'].'</p></td>
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
                    <td ><p class="p_space">'.$flash_shipping_row['flash_shipping_date'].'</p></td>
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
                    <td ><p class="p_space">'.$price_shipping_row['price_shipping_date'].'</p></td>
                    <td ><p class="p_space">Price Box</p></td>
                </tr>';
        }  
    /*--------no order price--------*/
    }else{
        
    }

?>