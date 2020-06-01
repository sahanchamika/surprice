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
        /*---------discount------------*/
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
        /*---------find total amount------------*/
        $tot_amount = $netprice + $d_cost;

        /*---------get item weight------------*/
        $weight = $row['item_weight'];
        /*---------get current date------------*/
        $today = date("Y-m-d");
        /*---------set item quntity------------*/
        $newqun = ($row['item_quantity'] - $quntity);

        /*---------check price box have 5 item------------*/
        $price_box = "SELECT * FROM price_box WHERE box_user_id = '$log_user_id'";
        $price_box_result = mysqli_query($con, $price_box) or die (mysqli_error($con));
        if(mysqli_num_rows($price_box_result) < 5){
            /*---------update item quntity------------*/
            $update_item = "UPDATE item SET item_quantity='$newqun' WHERE item_id='$item_id'";
            $update_item_result = mysqli_query($con, $update_item) or die (mysqli_error($con));
            /*---------update item quntity thru------------*/
            if($update_item_result == TRUE){
                 /*---------add cart------------*/
                $insert_box = "INSERT INTO price_box (box_user_id, box_item_id, box_delivary_com_id, box_delivary_cost, box_amount, box_date, box_quntity, box_item_weight)
                VALUES('$log_user_id', '$item_id', '$comp_id', '$d_cost', ' $tot_amount', '$today', '$quntity', '$weight')";
                $insert_box_result = mysqli_query($con, $insert_box) or die (mysqli_error($con));
                    /*---------add cart thru------------*/
                    if($insert_box_result == TRUE){
                        echo 'Succsess Fully Add Box';
                    }else{
                        echo 'Can Not Insert Box'; 
                    }
            }else{
                echo 'Can Not Insert Box'; 
            }
        }else{
            echo 'Sorry Box is Full Now Buy it';
        }

    }else{
        echo 'Sorry All Item Sold';
    }
}else{
    echo 'No item Sorry';
    
}

?> 



