<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$pro_id_pass=$_GET['proid'];

/*------delete row in provins -------*/
$delete_pro = "DELETE FROM delivery_provins WHERE delivery_provins_id='$pro_id_pass'";
$delete_pro_result = mysqli_query($con, $delete_pro) or die (mysqli_error($con));

 /*------load shipping.php-------*/
 header('Location: ../setting.php');


?>