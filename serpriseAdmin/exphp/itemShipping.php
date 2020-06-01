<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$order_id_pass=$_GET['orid'];

session_start();

/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_admin_id'];

/*-------------------get order item table----------------*/
$order_item = "SELECT * FROM order_item WHERE order_id='$order_id_pass'";
$order_item_result = mysqli_query($con, $order_item) or die (mysqli_error($con));
$row = $order_item_result-> fetch_assoc();

$order_id = $row['order_id'];
$order_item_id = $row['order_item_id'];
$order_user_id = $row['order_user_id'];
$order_dili_id = $row['order_dilivary_com_id'];
$order_date = $row['order_date'];
$order_quntity = $row['order_quntity'];
$order_delivary_cost = $row['order_delivary_cost'];
$order_amount = $row['order_amount'] - $row['order_delivary_cost'];
$order_ship_date = date("Y-m-d");
/*------add shipping item shipping item table -------*/
$insert_shipp = "INSERT INTO item_shipping (item_shipping_user_id, item_shipping_item_id, item_shipping_deli_id, item_shipping_date, item_shipping_quntity, item_shipping_deli_cost, item_shipping_amount, item_shipping_order_date, item_shipping_order_id, item_shipping_admin)
VALUES('$order_user_id', '$order_item_id', '$order_dili_id', '$order_ship_date', '$order_quntity', '$order_delivary_cost', '$order_amount', '$order_date', '$order_id','$log_user_id')";
$insert_shipp_result = mysqli_query($con, $insert_shipp) or die (mysqli_error($con));
/*------delete row in order -------*/
$delete_order = "DELETE FROM order_item WHERE order_id='$order_id_pass'";
$delete_order_result = mysqli_query($con, $delete_order) or die (mysqli_error($con));

 /*------load shipping.php-------*/
 header('Location: mainAdminShip.php');

?>
    
