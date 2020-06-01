<?php include '../conection.php' ?>

<?php 
    /*------get pass cart id-------*/
    if(isset($_GET['cart_id'])){
        $cart_id=$_GET['cart_id'];

    }
            /*------get cart-------*/
            $cart = "SELECT * FROM cart WHERE cart_id='$cart_id'";
            $cart_result = mysqli_query($con, $cart) or die (mysqli_error($con));
            $cart_row = $cart_result-> fetch_assoc();

            $item_id = $cart_row['cart_item_id'];
            /*------get item-------*/
            $item = "SELECT * FROM item WHERE item_id='$item_id'";
            $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
            $row = $item_result-> fetch_assoc();
            /*------update item quntity-------*/
            $newqun = ($row['item_quantity'] + $cart_row['cart_quntity']);
            $update_item = "UPDATE item SET item_quantity='$newqun' WHERE item_id='$item_id'";
            $update_item_result = mysqli_query($con, $update_item) or die (mysqli_error($con));
            /*------dlete cart item-------*/
            $delete_cart = "DELETE FROM cart WHERE cart_id='$cart_id'";
            $delete_cart_result = mysqli_query($con, $delete_cart) or die (mysqli_error($con));
            /*------load cart-------*/
            header('Location:../cart.php');
                        

?>
<!-------pass value get hidden input------->
<html>
    <body>
        <form role="form" method = "post" action = "remove.php">  
            <input type="hidden" name="pass_id" <?php echo'value="'.$cart_id.'"'; ?>>               
        </form> 
    </body>   
</html>

