<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$com_id_pass=$_GET['comid'];

/*------delete row in company -------*/
$delete_com = "DELETE FROM delivery_company WHERE delivery_company_id='$com_id_pass'";
$delete_com_result = mysqli_query($con, $delete_com) or die (mysqli_error($con));

/*------delete row in company cost -------*/
$delete_com = "DELETE FROM delivery_company_cost WHERE company_id='$com_id_pass'";
$delete_com_result = mysqli_query($con, $delete_com) or die (mysqli_error($con));

 /*------load delicom.php-------*/
 header('Location: ../deliCom.php');


?>