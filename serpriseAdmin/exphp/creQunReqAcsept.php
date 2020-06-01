<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$quntiy_req_id=$_GET['qunrqid'];

/*------------update creater new item request------------*/
$update_quntiy_req = "UPDATE cerator_qun_req SET cerator_qun_req_satate='Acsept' WHERE cerator_qun_req_id='$quntiy_req_id'";
$update_quntiy_req_result = mysqli_query($con, $update_quntiy_req) or die (mysqli_error($con));

 /*------load createrItem.php-------*/
 header('Location: ../createrItem.php');


?>