<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$request_id=$_GET['rqid'];

/*------delete row in creater request -------*/
$delete_req = "DELETE FROM new_creater_add WHERE new_creater_add_id='$request_id'";
$delete_req_result = mysqli_query($con, $delete_req) or die (mysqli_error($con));

 /*------load createrItem.php-------*/
 header('Location: ../createrItem.php');


?>