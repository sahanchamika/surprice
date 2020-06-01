<?php include '../conection.php' ?>
<?php 
/*------get pass value -------*/
$item_id=$_GET['itemid'];


    /*------delete row in item -------*/
    $delete_item = "DELETE FROM item WHERE item_id='$item_id'";
    $delete_item_result = mysqli_query($con, $delete_item) or die (mysqli_error($con));

    /*------load item.php-------*/
    header('Location: ../item.php');


?>