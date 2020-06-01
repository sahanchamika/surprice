<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$dist_id_pass=$_GET['disid'];

/*------delete row in distric -------*/
$delete_dis = "DELETE FROM delivery_district WHERE delivery_district_id='$dist_id_pass'";
$delete_dis_result = mysqli_query($con, $delete_dis) or die (mysqli_error($con));

 /*------load shipping.php-------*/
 header('Location: ../setting.php');


?>