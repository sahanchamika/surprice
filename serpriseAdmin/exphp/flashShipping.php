<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$order_id_pass=$_GET['forid'];

session_start();

/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_admin_id'];

/*-------------------get order item table----------------*/
$flash_item = "SELECT * FROM flash_order WHERE flash_order_id='$order_id_pass'";
$flash_item_result = mysqli_query($con, $flash_item) or die (mysqli_error($con));
$row = $flash_item_result-> fetch_assoc();

$order_id = $row['flash_order_id'];
$order_item_id = $row['flash_order_item_id'];
$order_user_id = $row['flash_order_user_id'];
$order_dili_id = $row['flash_order_deli_com_id'];
$order_date = $row['flash_order_date'];
$order_quntity = $row['flash_order_quntity'];
$order_delivary_cost = $row['flash_order_deliy_cost'];
$order_amount = $row['flash_order_amount'] - $row['flash_order_deliy_cost'];
$order_ship_date = date("Y-m-d");
/*------add shipping item shipping item table -------*/
$insert_shipp = "INSERT INTO flash_shipping (flash_shipping_user_id, flash_shipping_item_id, flash_shipping_deli_id, flash_shipping_date, flash_shipping_quntity, flash_shipping_deli_cost, flash_shipping_amount, flash_shipping_order_date, flash_shipping_order_id, flash_shipping_admin)
VALUES('$order_user_id', '$order_item_id', '$order_dili_id', '$order_ship_date', '$order_quntity', '$order_delivary_cost', '$order_amount', '$order_date', '$order_id', '$log_user_id')";
$insert_shipp_result = mysqli_query($con, $insert_shipp) or die (mysqli_error($con));
/*------delete row in order -------*/
$delete_order = "DELETE FROM flash_order WHERE flash_order_id='$order_id_pass'";
$delete_order_result = mysqli_query($con, $delete_order) or die (mysqli_error($con));
 /*------load shipping.php-------*/
 header('Location: mainAdminShip.php');

?>
    
