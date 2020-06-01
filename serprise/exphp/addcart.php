
<?PHP include '../conection.php'; ?>
<?PHP
session_start();
/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_user_id'];
/*---------------------pass data get-----------------------*/
$item_id = $_GET["item"];
$quntity = $_GET["qun"];
$comp_id = $_GET["com"];
$comp_cost0 = $_GET["cos0"];
$comp_cost1 = $_GET["cos1"];
$comp_cost2 = $_GET["cos2"];
$comp_cost3 = $_GET["cos3"];

/*---------------------item get-----------------------*/
$item = "SELECT * FROM item WHERE item_id='$item_id' LIMIT 1";
$item_result = mysqli_query($con, $item) or die (mysqli_error($con));
$row = $item_result-> fetch_assoc();

/*---------------------quantity > 0-----------------------*/
if($item_id > 0){
    if($row['item_quantity'] > 0){
        /*---------find deliwary cost-------------------*/
        if($comp_id == 1){
            $d_cost = $comp_cost0 * $quntity;
            
        }else{
            if($comp_id == 2){
                $d_cost = $comp_cost1 * $quntity;
                
            }else{
                if($comp_id == 3){
                    $d_cost = $comp_cost2 * $quntity;
                    
                }else{
                    $d_cost = $comp_cost3 * $quntity;
                    
                }
            }
        }
         /*--------- discount------------*/
        if ($row['item_discount'] != 0) {
            /*---------find discount------------*/
            $discount = ($row['item_price'] / 100) * $row['item_discount']; 
            $amount = $quntity * $row['item_price'];
            $netprice = $amount - $discount;

        /*---------no discount------------*/
        } else {
            /*---------find discount------------*/
            $netprice = $quntity * $row['item_price'];
            
        }
        /*---------total amount------------*/
        $tot_amount = $netprice + $d_cost;

        /*---------get current date------------*/
        $today = date("Y-m-d");

        /*---------item quntity updete------------*/
        $newqun = ($row['item_quantity'] - $quntity);
        $update_item = "UPDATE item SET item_quantity='$newqun' WHERE item_id='$item_id'";
        $update_item_result = mysqli_query($con, $update_item) or die (mysqli_error($con));

        /*---------item quntity updete thru------------*/
        if($update_item_result == TRUE){
            /*---------add cart-----------*/
            $insert_cart = "INSERT INTO cart (cart_user_id, cart_item_id, cart_quntity, cart_date, cart_state, cart_delivery_company_id, cart_delivery_cost, cart_amount, cart_total_amount)
            VALUES('$log_user_id', '$item_id', '$quntity', '$today', 'Active', '$comp_id', '$d_cost', '$netprice', '$tot_amount')";
            $insert_cart_result = mysqli_query($con, $insert_cart) or die (mysqli_error($con));

                /*---------add cart thru-----------*/
                if($insert_cart_result == TRUE){
                    echo 'Succsess Fully Add Cart';
                }else{
                    echo 'Can Not Insert cart'; 
                }
        }else{
            echo 'Can Not Insert cart'; 
        }

    }else{
        echo 'Sorry All Item Sold';
    }
}else{
    echo 'No item Sorry';
    
}

?> 



