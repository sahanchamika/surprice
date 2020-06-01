<?php include '../conection.php' ?>

<?php 
/*------get pass value -------*/
$cata_id=$_GET['caid'];

/*------delete row in catagory -------*/
$delete_cata = "DELETE FROM item_catagory WHERE item_catagory_id='$cata_id'";
$delete_cata_result = mysqli_query($con, $delete_cata) or die (mysqli_error($con));


 /*------load setting.php-------*/
 header('Location: ../setting.php');


?>