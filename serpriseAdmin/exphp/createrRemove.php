<?php include '../conection.php' ?>
<?php 
/*------get pass value -------*/
$cre_id_pass=$_GET['creid'];

/*-------------------get item table----------------*/
$item = "SELECT * FROM item WHERE item_creator_id='$cre_id_pass'";
$item_result = mysqli_query($con, $item) or die (mysqli_error($con));
$item_row = $item_result-> fetch_assoc();

if(mysqli_num_rows($item_result) > 0){
    /*--------can't delete creater have item------------*/
    /*------load shipping.php-------*/
    header('Location: ../customer.php');
}else{

    /*------delete row in user -------*/
    $delete_cre = "DELETE FROM creator WHERE creator_id='$cre_id_pass'";
    $delete_cre_result = mysqli_query($con, $delete_cre) or die (mysqli_error($con));

    /*------load shipping.php-------*/
    header('Location: ../customer.php');
}

?>