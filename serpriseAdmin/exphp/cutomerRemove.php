<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$cus_id_pass=$_GET['cusid'];

/*------delete row in user -------*/
$delete_cus = "DELETE FROM user WHERE user_id='$cus_id_pass'";
$delete_cus_result = mysqli_query($con, $delete_cus) or die (mysqli_error($con));

 /*------load shipping.php-------*/
 header('Location: ../customer.php');


?>