<?php include '../conection.php' ?>

<?php 
/*----get pass value--------*/
    if(isset($_GET['box_id'])){
        $box_id=$_GET['box_id'];

    }
            /*------get price box-------*/
            $box = "SELECT * FROM price_box WHERE box_id='$box_id'";
            $box_result = mysqli_query($con, $box) or die (mysqli_error($con));
            $box_row = $box_result-> fetch_assoc();
            /*------get item id from price box-------*/
            $item_id = $box_row['box_item_id'];
            /*------get item -------*/
            $item = "SELECT * FROM item WHERE item_id='$item_id'";
            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
            $row = $item_result-> fetch_assoc();
            /*------re add item quntity -------*/
            $newqun = ($row['item_quantity'] + $box_row['box_quntity']);
             /*------update item quntity -------*/
            $update_item = "UPDATE item SET item_quantity='$newqun' WHERE item_id='$item_id'";
            $update_item_result = mysqli_query($con, $update_item) or die (mysqli_error($con));
             /*------delete row in price box -------*/
            $delete_box = "DELETE FROM price_box WHERE box_id='$box_id'";
            $delete_box_result = mysqli_query($con, $delete_box) or die (mysqli_error($con));
             /*------load price box -------*/
            header('Location:../sepricebox.php');
                        

?>
<!-----get pass value use hidden input ----->
<html>
    <body>
        <form role="form" method = "post" action = "remove.php">  
            <input type="hidden" name="s_box_id" <?php echo'value="'.$box_id.'"'; ?>>               
        </form> 
    </body>   
</html>

