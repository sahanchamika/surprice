<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$price_group_id=$_GET['pgrid'];
$price_user_id=$_GET['pusid'];

session_start();

/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_admin_id'];

/*-------------------get order item table----------------*/
$price_item = "SELECT * FROM price_box_order WHERE price_box_order_group_id='$price_group_id' AND price_box_order_user_id='$price_user_id'";
$price_item_result = mysqli_query($con, $price_item) or die (mysqli_error($con));

while ($row = $price_item_result-> fetch_assoc()){
    $order_id = $row['price_box_order_id'];
    $order_item_id = $row['price_box_order_item_id'];
    $order_user_id = $row['price_box_order_user_id'];
    $order_dili_id = $row['price_box_order_d_com_id'];
    $order_date = $row['price_box_order_date'];
    $order_quntity = $row['price_box_order_quntity'];
    $order_delivary_cost = $row['price_box_order_deli_cost'];
    $order_amount = $row['price_box_order_amount'] - $row['price_box_order_deli_cost'];
    $order_ship_date = date("Y-m-d");
    $price_group_id = $row['price_box_order_group_id'];
    /*------add shipping item shipping item table -------*/
    $insert_shipp = "INSERT INTO price_shipping (price_shipping_user_id, price_shipping_item_id, price_shipping_deli_id, price_shipping_date, price_shipping_quntity, price_shipping_deli_cost, price_shipping_amount, price_shipping_order_date, price_shipping_order_id, price_shipping_group_id, price_shipping_admin)
    VALUES('$order_user_id', '$order_item_id', '$order_dili_id', '$order_ship_date', '$order_quntity', '$order_delivary_cost', '$order_amount', '$order_date', '$order_id', '$price_group_id', '$log_user_id')";
    $insert_shipp_result = mysqli_query($con, $insert_shipp) or die (mysqli_error($con));
    /*------delete row in order -------*/
    $delete_order = "DELETE FROM price_box_order WHERE price_box_order_id='$order_id'";
    $delete_order_result = mysqli_query($con, $delete_order) or die (mysqli_error($con));
}
 /*------load shipping.php-------*/
 header('Location: mainAdminShip.php');

?>