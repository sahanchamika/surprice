<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$request_id=$_GET['rqid'];

/*------------update new_creater_add states------------*/
$update_cre_req = "UPDATE new_creater_add SET new_creater_add_state='Acsept' WHERE new_creater_add_id = '$request_id'";
$update_cre_req_result = mysqli_query($con, $update_cre_req) or die (mysqli_error($con));

 /*------load createrItem.php-------*/
 header('Location: ../createrItem.php');


?>