<?PHP include '../conection.php' ?>
<?php
/*----------------get pass id from logindex-------------------*/
$flashid = $_POST['flashid'];

/*----------------item loda-------------------*/
$item_diss = "SELECT * FROM item WHERE item_id='$flashid' LIMIT 1";
$item_diss_result = mysqli_query($con, $item_diss) or die (mysqli_error($con));
$row = $item_diss_result-> fetch_assoc();

/*----------------get item quantity-------------------*/
$qun_it = $row['item_quantity'];

/*----------------get item creator id-------------------*/
$creatorid = $row['item_creator_id'];

/*----------------get creator details-------------------*/
$creator = "SELECT * FROM creator WHERE creator_id ='$creatorid' LIMIT 1";
$creator_result = mysqli_query($con, $creator) or die (mysqli_error($con));
$creator_row = $creator_result-> fetch_assoc();

/*----------------get delivary company-------------------*/
$delivery_company = "SELECT * FROM delivery_company LIMIT 4";
$delivery_company_result = mysqli_query($con, $delivery_company) or die (mysqli_error($con));

/*----------------get deliver cost-------------------*/
$delivery_company0 = "SELECT * FROM delivery_company_cost WHERE company_id ='1' LIMIT 1";
$delivery_company_result0 = mysqli_query($con, $delivery_company0) or die (mysqli_error($con));
$delivery_company_row0 = $delivery_company_result0-> fetch_assoc();

$delivery_company1 = "SELECT * FROM delivery_company_cost WHERE company_id ='2' LIMIT 1";
$delivery_company_result1 = mysqli_query($con, $delivery_company1) or die (mysqli_error($con));
$delivery_company_row1 = $delivery_company_result1-> fetch_assoc();

$delivery_company2 = "SELECT * FROM delivery_company_cost WHERE company_id ='3' LIMIT 1";
$delivery_company_result2 = mysqli_query($con, $delivery_company2) or die (mysqli_error($con));
$delivery_company_row2 = $delivery_company_result2-> fetch_assoc();

$delivery_company3 = "SELECT * FROM delivery_company_cost WHERE company_id ='4' LIMIT 1";
$delivery_company_result3 = mysqli_query($con, $delivery_company3) or die (mysqli_error($con));
$delivery_company_row3 = $delivery_company_result3-> fetch_assoc();

/*----------------find item weigth range = cost-------------------*/
$com_cost0 = 0;
$com_cost1 = 0;
$com_cost2 = 0;
$com_cost3 = 0;

if($row['item_weight'] < 0.25){
    $com_cost0 = $delivery_company_row0['cost_0_250g'];
}else{
    if($row['item_weight'] < 0.5){
        $com_cost0 = $delivery_company_row0['cost_250_500g'];
    }else{
         if($row['item_weight'] < 0.75){
            $com_cost0 = $delivery_company_row0['cost_500_750g'];
        }else{
            if($row['item_weight'] < 1){
                $com_cost0 = $delivery_company_row0['cost_750_1000g'];
            }else{
                if($row['item_weight'] < 1.5){
                    $com_cost0 = $delivery_company_row0['cost_1000_1500g'];
                }else{
                    if($row['item_weight'] < 2){
                        $com_cost0 = $delivery_company_row0['cost_1500_2000g'];
                    }else{
                        if($row['item_weight'] < 3){
                             $com_cost0 = $delivery_company_row0['cost_2000_3000g'];
                        }else{
                            if($row['item_weight'] < 5){
                                $com_cost0 = $delivery_company_row0['cost_3000_5000g'];
                            }else{
                                $com_cost0 = $delivery_company_row0['cost_5000_maxg'];
                             }
                        }

                    }

                }

            }

        }

    }
}

if($row['item_weight'] < 0.25){
    $com_cost1 = $delivery_company_row1['cost_0_250g'];
}else{
    if($row['item_weight'] < 0.5){
        $com_cost1 = $delivery_company_row1['cost_250_500g'];
    }else{
        if($row['item_weight'] < 0.75){
            $com_cost1 = $delivery_company_row1['cost_500_750g'];
        }else{
            if($row['item_weight'] < 1){
                $com_cost1 = $delivery_company_row1['cost_750_1000g'];
            }else{
                if($row['item_weight'] < 1.5){
                    $com_cost1 = $delivery_company_row1['cost_1000_1500g'];
                }else{
                    if($row['item_weight'] < 2){
                        $com_cost1 = $delivery_company_row1['cost_1500_2000g'];
                    }else{
                        if($row['item_weight'] < 3){
                            $com_cost1 = $delivery_company_row1['cost_2000_3000g'];
                        }else{
                            if($row['item_weight'] < 5){
                                $com_cost1 = $delivery_company_row1['cost_3000_5000g'];
                            }else{
                                $com_cost1 = $delivery_company_row1['cost_5000_maxg'];
                            }
                        }
    
                    }
    
                }
    
            }
    
        }
    
    }
}

if($row['item_weight'] < 0.25){
    $com_cost2 = $delivery_company_row2['cost_0_250g'];
}else{
    if($row['item_weight'] < 0.5){
        $com_cost2 = $delivery_company_row2['cost_250_500g'];
    }else{
        if($row['item_weight'] < 0.75){
            $com_cost2 = $delivery_company_row2['cost_500_750g'];
        }else{
            if($row['item_weight'] < 1){
                $com_cost2 = $delivery_company_row2['cost_750_1000g'];
            }else{
                if($row['item_weight'] < 1.5){
                    $com_cost2 = $delivery_company_row2['cost_1000_1500g'];
                }else{
                    if($row['item_weight'] < 2){
                        $com_cost2 = $delivery_company_row2['cost_1500_2000g'];
                    }else{
                        if($row['item_weight'] < 3){
                            $com_cost2 = $delivery_company_row2['cost_2000_3000g'];
                        }else{
                            if($row['item_weight'] < 5){
                                $com_cost2 = $delivery_company_row2['cost_3000_5000g'];
                            }else{
                                $com_cost2 = $delivery_company_row2['cost_5000_maxg'];
                            }
                        }
        
                    }
        
                }
        
            }
        
        }
        
    }
}

if($row['item_weight'] < 0.25){
    $com_cost3 = $delivery_company_row3['cost_0_250g'];
}else{
    if($row['item_weight'] < 0.5){
        $com_cost3 = $delivery_company_row3['cost_250_500g'];
    }else{
        if($row['item_weight'] < 0.75){
            $com_cost3 = $delivery_company_row3['cost_500_750g'];
        }else{
            if($row['item_weight'] < 1){
                $com_cost3 = $delivery_company_row3['cost_750_1000g'];
            }else{
                if($row['item_weight'] < 1.5){
                    $com_cost3 = $delivery_company_row3['cost_1000_1500g'];
                }else{
                    if($row['item_weight'] < 2){
                        $com_cost3 = $delivery_company_row3['cost_1500_2000g'];
                    }else{
                        if($row['item_weight'] < 3){
                            $com_cost3 = $delivery_company_row3['cost_2000_3000g'];
                        }else{
                            if($row['item_weight'] < 5){
                                $com_cost3 = $delivery_company_row3['cost_3000_5000g'];
                            }else{
                                $com_cost3 = $delivery_company_row3['cost_5000_maxg'];
                            }
                        }
        
                    }
        
                }
        
            }
        
        }
        
    }
}
        
$price = $row['item_price'];
$disc = $row['item_discount'];
$item_id = $row['item_id'];
$item_qun = $row['item_quantity'];
$item_custom = $row['item_custom'];

/*---------------reviwe --------------------*/
$reviwe_item = "SELECT COUNT(`item_shipping_user_id`), item_shipping_user_id FROM item_shipping WHERE item_shipping_item_id='$item_id' GROUP BY item_shipping_user_id";
$reviwe_item_result = mysqli_query($con, $reviwe_item) or die (mysqli_error($con));
$reviwe_item_count =0;
while ($reviwe_item_row = $reviwe_item_result-> fetch_assoc()){
    $reviwe_item_count = $reviwe_item_count+1;
}

/*----------------get sold Quntity-------------------*/
$sold_item_qun = "SELECT SUM(`item_shipping_quntity`) FROM item_shipping WHERE item_shipping_item_id = '$item_id'";
$sold_item_qun_result = mysqli_query($con, $sold_item_qun) or die (mysqli_error($con));
$sold_item_qun_row = $sold_item_qun_result-> fetch_assoc();

?>
   <form  action="exphp/loaditemdis.php" method="post" >
                <?php
                 echo '<div class="item_ditails">
                    <div class="item_ditails_left_div">
                        <img class="item_ditails_img" src="'.$row['item_image'].'">
                        <div>
                            <h1 class="item_ditails_left_div_name">'.$row['item_name'].'</h1>
                            <p class="item_ditails_left_div_dis">'.$row['item_discription'].'</p>
                            <table>
                                <tr>
                                    <td><p class="item_ditails_left_div_cre">Creator</p></td>
                                    <td>'.$creator_row['creator_name'].'</td>
                                </tr>
                                <tr>
                                    <td><p class="item_ditails_left_div_email">Creator Email</p></td>
                                    <td>'.$creator_row['creator_email'].'</td>
                                </tr>
                                <tr>
                                    <td><div class="item_ditails_left_div_cret" id="star">';
                                    /*----------------star rate------------------*/
                                    if($row['item_sale_rate'] == 0){
                                        echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                        }else{
                                            if($row['item_sale_rate'] == 1){
                                                echo '<i class="fa fa-star"></i> ';
                                            }else{
                                                if($row['item_sale_rate'] == 2){
                                                    echo '<i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i>';
                                                }else{
                                                    if($row['item_sale_rate'] == 3){
                                                        echo '<i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>';
                                                    }else{
                                                        if($row['item_sale_rate'] == 4){
                                                            echo '<i class="fa fa-star"></i> 
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>';
                                                        }else{
                                                            if($row['item_sale_rate'] == 5){
                                                                echo '<i class="fa fa-star"></i> 
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>';
                                                            }else{
                                                                echo '<i class="fa fa-star"></i> 
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>';
                    
                                                            }
                
                                                        }
            
                                                    }
        
                                                }
    
                                            }
                                        }
                                        echo '<a id="revi">('.$reviwe_item_count.' Review)</a></td>';
                                        /*----------------avalabel or not------------------*/
                                        if($row['item_quantity'] == 0){
                                            echo '<td><p class="avalabel" id="bad_reat">All Sold</p><td>';
                                        }else{
                                            echo '<td><p class="avalabel" id="bad_reat">Avalebal</p><td>';
                                        }
                                    echo '</div>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="item_ditails_right_div">
                        <img class="item_ditails_img2" src="'.$row['item_image'].'" alt="">
                        <img class="item_ditails_img2" src="'.$row['item_image'].'" alt="">
                        <img class="item_ditails_img2" src="'.$row['item_image'].'" alt="">
                        <img class="item_ditails_img2" src="'.$row['item_image'].'" alt="">
                        <div>
                            <table>
                                <tr>
                                    <th><p>Sold</p></th>
                                    <th><p class="discrip">'.$sold_item_qun_row['SUM(`item_shipping_quntity`)'].' Item</p></th>
                                </tr>
                                <tr>
                                    <th><p class="">unit price</p></th>
                                    <th><p class="discrip">Rs: '.$row['item_price'].'</p></th>
                                </tr>
                                <tr>
                                    <th><p class="">Discount avalabel</p></th>';
                                    /*----------------discount------------------*/
                                    if($row['item_discount'] == 0){
                                        echo '<th><p class="discrip">No Discount</p></th>';
                                    }else{
                                        echo '<th><p class="discrip">'.$row['item_discount'].'%</p></th>';
                                    }
                                echo '</tr>
                                <tr>
                                    <th>
                                        <p class="">Select Quantity</p>
                                    </th>
                                    <th>
                                    <select class="tem_ditails_right_select" id="quantity">';
                                    /*----------------quantity------------------*/
                                    if($row['item_quantity'] == '0'){
                                        echo '<option class="discrip" value="">All Sold</option>';
                                    }else{
                                        if($row['item_quantity'] == '1'){
                                            echo '<option class="" value="1">1</option>';
                                        }else{
                                            if($row['item_quantity'] == '2'){
                                                echo '<option class="" value="1">1</option>
                                                    <option class="" value="2">2</option>';
                                            }else{
                                                if($row['item_quantity'] == '3'){
                                                    echo '<option class="" value="1">1</option>
                                                        <option class="" value="2">2</option>
                                                        <option class="" value="3">3</option>';
                                                }else{
                                                    if($row['item_quantity'] == '4'){
                                                        echo '<option class="" value="1">1</option>
                                                            <option class="" value="2">2</option>
                                                            <option class="" value="3">3</option>
                                                            <option class="" value="4">4</option>';
                                                    }else{
                                                        echo '<option class="" value="1">1</option>
                                                            <option class="" value="2">2</option>
                                                            <option class="" value="3">3</option>
                                                            <option class="" value="4">4</option>
                                                            <option class="" value="5">5</option>';
                                                    }
                                                }
                                            }
                                        }
                                    }
                                echo '</select>
                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        <p class="">Select Delivary company</p>
                                    </th>
                                    <th>
                                        <select class="tem_ditails_right_select" name="select_company" id="select_company">';
                                        /*--------------------company select-----------------*/
                                        if(mysqli_num_rows($delivery_company_result) > 0){
                                            while ($row = $delivery_company_result-> fetch_assoc()){
                                                echo '<option class="" value="'.$row['delivery_company_id'].'">'.$row['delivery_company_name'].'</option>';
                                            }
                                        }else{
                                            echo '<option class="" value="">No company</option>';
                                        }
                                        echo '</select>
                                    </th>
                                </tr>
                            </table>
                            <div class="item_ditails_total" name="tot" onclick="GetSelectedValue()">
                                <table>
                                    <tr>
                                        <th><p class="Amount">Amount</p></th>
                                        <th><p id="quantity_result" class="tot_dis"></p></th>
                                    </tr> 
                                    <tr>
                                        <th><p class="dc">Delivary Cost</p></th>
                                        <th><p id="select_company_result" class="tot_dis"></p></th>
                                    </tr>
                                    <tr>
                                        <th><p class="total">Total</p></th>
                                        <th><p id="total_result" class="tot_dis"></p></th>
                                    </tr>  
                                </table>
                            </div>
                            <div>
                            <p id="messag" class="messages"></p>
                                <table>
                                    <tr>';
                                        if($item_custom == 'no'){
                                            echo '<th><button type="button" class="item_ditails_button" id="b1">Can\'t Custom</button></th>';
                                        }else{
                                            echo '<th><button type="button" class="item_ditails_button" id="b1">Custom</button></th>';
                                        }
                                        echo '<th><button type="button" class="item_ditails_button" id="b2" onclick="addprice()" >Prize box</button></th>
                                    </tr>
                                    <tr>
                                        <th><button type="button" class="item_ditails_button" id="b3" onclick="addCart()" >Add Cart</button></th>';

                                        if($qun_it == 0){
                                            echo '<th><button type="button" class="item_ditails_button" id="b4">Can\'t Buy</button></th>';
                                        }else{
                                            echo '<th><button type="button" class="item_ditails_button" id="b4" onclick="buynow()">Buy Now</button></th>';
                                        }
        
                                    echo '</tr>  
                                </table>
                            </div>
                        </div>
                    </div>
                </div>';
            ?>
        </form>

<script>

    var price = "<?php echo $price ?>";
    var disec = "<?php echo $disc ?>";
    var item_id = "<?php echo $item_id ?>";
    var com_cost0 = "<?php echo $com_cost0 ?>";
    var com_cost1 = "<?php echo $com_cost1 ?>";
    var com_cost2 = "<?php echo $com_cost2 ?>";
    var com_cost3 = "<?php echo $com_cost3 ?>";
    var item_qun = "<?php echo $item_qun ?>";

    

    function GetSelectedValue(){

            //get quantity
            var e = document.getElementById("quantity");
            var result = e.options[e.selectedIndex].value;
            
            //get select_company
            var b = document.getElementById("select_company");
            var result1 = b.options[b.selectedIndex].value;
                
                if (item_qun > 0) {
                    //discount cal
                    if (disec != 0) {
                        var discount = (price / 100) * disec; 
                        var amount = result * price;
                        var netprice = amount - discount;
                        var netprice_re = "Rs:" + netprice;
                        document.getElementById("quantity_result").innerHTML = netprice_re;
                        // no discount
                    } else {
                        var netprice = result * price;
                        var netprice_re = "Rs:" + netprice;
                        document.getElementById("quantity_result").innerHTML = netprice_re;
                    }

                    //find company
                    if (result1 == 1) {
                        var tot_cost = result * com_cost0;
                        var tot_cost_re = "Rs:" + tot_cost;
                        document.getElementById("select_company_result").innerHTML = tot_cost_re;
                    } else {
                        if (result1 == 2) {
                            var tot_cost = result * com_cost1;
                            var tot_cost_re = "Rs:" + tot_cost;
                            document.getElementById("select_company_result").innerHTML = tot_cost_re;
                        } else {
                            if (result1 == 3) {
                                var tot_cost = result * com_cost2;
                                var tot_cost_re = "Rs:" + tot_cost;
                                document.getElementById("select_company_result").innerHTML = tot_cost_re;
                            } else {
                                var tot_cost = result * com_cost3;
                                var tot_cost_re = "Rs:" + tot_cost;
                                document.getElementById("select_company_result").innerHTML = tot_cost_re;
                            }
                        
                        }
                        
                    }
                    // tatal amount
                    var total = tot_cost + netprice;
                    var total_re = "Rs:" + total;
                    document.getElementById("total_result").innerHTML = total_re;
                }else{
                    document.getElementById("total_result").innerHTML = 'Sorry No Item';
                    document.getElementById("select_company_result").innerHTML = 'Sorry No Item';
                    document.getElementById("quantity_result").innerHTML = 'Sorry No Item';
                }
    }
    // add cart
    function addCart() {

        //get quantity
        var e = document.getElementById("quantity");
        var result = e.options[e.selectedIndex].value;
    
        //get select_company
        var b = document.getElementById("select_company");
        var result1 = b.options[b.selectedIndex].value;

        if (item_id.length == 0) {
            document.getElementById("messag").innerHTML = "No Item";
            return;
        } else {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("messag").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "exphp/addcart.php?item=" + item_id + "&qun=" + result + "&com=" + result1 + "&cos0=" + com_cost0 + "&cos1=" + com_cost1 + "&cos2=" + com_cost2 + "&cos3=" + com_cost3, true);
            xmlhttp.send();

        }

    }

function addprice() {

    //get quantity
    var e = document.getElementById("quantity");
    var result = e.options[e.selectedIndex].value;

    //get select_company
    var b = document.getElementById("select_company");
    var result1 = b.options[b.selectedIndex].value;

    if (item_id.length == 0) {
        document.getElementById("messag").innerHTML = "No Item";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("messag").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "exphp/addpricebox.php?item=" + item_id + "&qun=" + result + "&com=" + result1 + "&cos0=" + com_cost0 + "&cos1=" + com_cost1 + "&cos2=" + com_cost2 + "&cos3=" + com_cost3, true);
        xmlhttp.send();

    }

}

function buynow(){

//get quantity
var e = document.getElementById("quantity");
var result = e.options[e.selectedIndex].value;

//get select_company
var b = document.getElementById("select_company");
var result1 = b.options[b.selectedIndex].value;
    
    
        //discount cal
        if (disec != 0) {
            var discount = (price / 100) * disec; 
            var amount = result * price;
            var netprice = amount - discount;
           
            // no discount
        } else {
            var netprice = result * price;
           
        }

        //find company
        if (result1 == 1) {
            var tot_cost = result * com_cost0;
           
        } else {
            if (result1 == 2) {
                var tot_cost = result * com_cost1;
                
            } else {
                if (result1 == 3) {
                    var tot_cost = result * com_cost2;
                    
                } else {
                    var tot_cost = result * com_cost3;
                    
                }
            
            }
            
        }
        // tatal amount
        var total = tot_cost + netprice;
        
        location.replace("exphp/buy.php?item=" + item_id + "&qun=" + result + "&com=" + result1 + "&tot=" +total + "&dil=" +tot_cost, true);
   
}
			
</script>