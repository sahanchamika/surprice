<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$new_request_item_id=$_GET['nirqid'];

/*------------update creater new item request------------*/
$update_new_item_req = "UPDATE cerator_item_new_req SET cerator_item_new_req_state='Remove' WHERE cerator_item_new_req_id='$new_request_item_id'";
$update_new_item_req_result = mysqli_query($con, $update_new_item_req) or die (mysqli_error($con));

 /*------load createrItem.php-------*/
 header('Location: ../createrItem.php');


?>