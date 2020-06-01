<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$qun_req_id=$_GET['qunrqid'];

/*------------update creater item quntity request------------*/
$update_qun_req = "UPDATE cerator_qun_req SET cerator_qun_req_satate='Remove' WHERE cerator_qun_req_id='$qun_req_id'";
$update_qun_req_result = mysqli_query($con, $update_qun_req) or die (mysqli_error($con));

 /*------load createrItem.php-------*/
 header('Location: ../createrItem.php');


?>