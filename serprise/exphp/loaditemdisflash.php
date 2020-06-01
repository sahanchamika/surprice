<?PHP include '../conection.php' ?>
<?php
/*------get pass id-------*/
$flashid = $_POST['flashid'];
/*------get flash sale-------*/
$item_diss = "SELECT * FROM flash_sale WHERE flash_sale_id='$flashid' LIMIT 1";
$item_diss_result = mysqli_query($con, $item_diss) or die (mysqli_error($con));
$row = $item_diss_result-> fetch_assoc();
/*----------------get item creator id-------------------*/
$creatorid = $row['flash_sale_creator_id'];
/*----------------get creator details-------------------*/
$creator = "SELECT * FROM creator WHERE creator_id ='$creatorid' LIMIT 1";
$creator_result = mysqli_query($con, $creator) or die (mysqli_error($con));
$creator_row = $creator_result-> fetch_assoc();

$flash_item_id = $row['flash_sale_item_id'];
/*---------------reviwe --------------------*/
$reviwe = "SELECT COUNT(`flash_shipping_user_id`),flash_shipping_user_id FROM flash_shipping WHERE flash_shipping_item_id = '$flash_item_id' GROUP BY flash_shipping_user_id";
$reviwe_result = mysqli_query($con, $reviwe) or die (mysqli_error($con));
$reviwe_count =0;
while ($reviwe_row = $reviwe_result-> fetch_assoc()){
    $reviwe_count = $reviwe_count+1;
}

/*----------------get sold Quntity-------------------*/
$sold_qun = "SELECT SUM(`flash_shipping_quntity`) FROM flash_shipping WHERE flash_shipping_item_id = '$flash_item_id'";
$sold_qun_result = mysqli_query($con, $sold_qun) or die (mysqli_error($con));
$sold_qun_row = $sold_qun_result-> fetch_assoc();

$price = $row['flash_sale_price'];
$disc = $row['flash_sale_discount'];
$item_qun = $row['flash_sale_quantity'];
$diliary_cos = $row['flash_sale_delivary_cost'];
    /*------display item details-------*/
    echo '<form  action="loaditemdis.php" method="post">
                <div class="item_ditails" id="item_ditails">
                    <div class="item_ditails_left_div">
                        <img class="item_ditails_img" src="'.$row['flash_sale_image'].'">
                        <div>
                        <h1 class="item_ditails_left_div_name">'.$row['flash_sale_name'].'</h1>
                        <p class="item_ditails_left_div_dis">'.$row['flash_sale_discription'].'</p>
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
                                if($row['flash_sale_rate'] == 0){
                                    echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                    }else{
                                        if($row['flash_sale_rate'] == 1){
                                            echo '<i class="fa fa-star"></i> ';
                                        }else{
                                            if($row['flash_sale_rate'] == 2){
                                                echo '<i class="fa fa-star"></i> 
                                                        <i class="fa fa-star"></i>';
                                            }else{
                                                if($row['flash_sale_rate'] == 3){
                                                    echo '<i class="fa fa-star"></i> 
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>';
                                                }else{
                                                    if($row['flash_sale_rate'] == 4){
                                                        echo '<i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>
                                                            <i class="fa fa-star"></i>';
                                                    }else{
                                                        if($row['flash_sale_rate'] == 5){
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
                                    echo '<a id="revi">('.$reviwe_count.' Review)</a></td>';
                                    /*----------------avalabel or not------------------*/
                                    if($row['flash_sale_quantity'] == 0){
                                        echo '<td><p class="avalabel" id="bad_reat">All Sold</p></td>';
                                    }else{
                                        echo '<td><p class="avalabel" id="bad_reat">Avalebal</p></td>';
                                    }
                                echo '</div>
                            </tr>
                        </table>
                        </div>
                    </div>
                    <div class="item_ditails_right_div">
                        <img class="item_ditails_img2" src="'.$row['flash_sale_image'].'" alt="">
                        <img class="item_ditails_img2" src="'.$row['flash_sale_image'].'" alt="">
                        <img class="item_ditails_img2" src="'.$row['flash_sale_image'].'" alt="">
                        <img class="item_ditails_img2" src="'.$row['flash_sale_image'].'" alt="">
                    <div>
                        <table>
                            <tr>
                                <th><p>Sold</p></th>
                                <th><p class="discrip">'.$sold_qun_row['SUM(`flash_shipping_quntity`)'].' Item</p></th>
                            </tr>
                            <tr>
                                <th><p class="">unit price</p></th>
                                <th><p class="discrip">Rs: '.$row['flash_sale_price'].'</p></th>
                            </tr>
                            <tr>
                                <th><p class="">Discount avalabel</p></th>';
                                /*----------------discount------------------*/
                                if($row['flash_sale_discount'] == '0'){
                                    echo '<th><p class="discrip">No Discount</p></th>';
                                }else{
                                    echo '<th><p class="discrip">'.$row['flash_sale_discount'].'%</p></th>';
                                }
                            echo '</tr>
                            <tr>
                                <th>
                                    <p class="">Select Quantity</p>
                                </th>
                                <th>
                                <select class="tem_ditails_right_select" id="quantity">';
                                /*----------------quantity------------------*/
                                if($row['flash_sale_quantity'] == '0'){
                                    echo '<option class="discrip" value="">All Sold</option>';
                                }else{
                                    if($row['flash_sale_quantity'] == '1'){
                                        echo '<option class="" value="1">1</option>';
                                    }else{
                                        if($row['flash_sale_quantity'] == '2'){
                                            echo '<option class="" value="1">1</option>
                                                <option class="" value="2">2</option>';
                                        }else{
                                            echo '<option class="" value="1">1</option>
                                                <option class="" value="2">2</option>
                                                <option class="" value="3">3</option>';
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
                                    if($row['flash_sale_dilivary_com_id'] == 1){
                                        echo '<option class="" value="1">DHL</option>';
                                    }else{
                                        if($row['flash_sale_dilivary_com_id'] == 2){
                                            echo '<option class="" value="2">Kapruka.lk</option>';
                                        }else{
                                            if($row['flash_sale_dilivary_com_id'] == 3){
                                                echo '<option class="" value="3">Speed delivery</option>';
                                            }else{
                                                echo '<option class="" value="4">Mydelivery</option>';
                                            }
                                        }
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
                                <tr>
                                    <th><button type="button" class="item_ditails_button" id="b3" >Custom</button></th>';
                                    /*------check flash quntity-------*/
                                    if($row['flash_sale_quantity'] == 0){
                                        echo '<th><button type="button" class="item_ditails_button" id="b4">Can\'t Buy</button></th>';
                                    }else{
                                        echo '<th><button type="button" class="item_ditails_button" id="b4" onclick="buynow()">Buy Now</button></th>';
                                    }
                               echo '</tr>  
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </form>';

?>

<script>

    var fl_id = "<?php echo $flashid ?>"
    var price = "<?php echo $price ?>";
    var disec = "<?php echo $disc ?>";
    var item_qun = "<?php echo $item_qun ?>";
    var diliary_cos = "<?php echo $diliary_cos ?>";
    

    function GetSelectedValue(){

            //get quantity
            var e = document.getElementById("quantity");
            var result = e.options[e.selectedIndex].value;
            
            //get select_company
            var b = document.getElementById("select_company");
            var result1 = b.options[b.selectedIndex].value;
                //discount cal
                if (item_qun > 0) {
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

                    if (diliary_cos > 0) {
                        var tot_cost = result * diliary_cos;
                        var tot_cost_re = "Rs:" + tot_cost;
                        document.getElementById("select_company_result").innerHTML = tot_cost_re;
                    }else{
                        document.getElementById("select_company_result").innerHTML = "Free Delivary";
                        var tot_cost = 0;
                    }
                    
                    // tatal amount
                    var total = tot_cost + netprice;
                    var total_re = "Rs:" + total;
                    document.getElementById("total_result").innerHTML = total_re;
                }else{
                    document.getElementById("total_result").innerHTML = 'Sorry No Item';
                    document.getElementById("select_company_result").innerHTML = "Sorry No Item";
                    document.getElementById("quantity_result").innerHTML = "Sorry No Item";
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
            if (item_qun > 0) {
                if (disec != 0) {
                    var discount = (price / 100) * disec; 
                    var amount = result * price;
                    var netprice = amount - discount;
                    
                    // no discount
                } else {
                    var netprice = result * price;
                   
                }
                // check dilivary cost have or not
                if (diliary_cos > 0) {
                    var tot_cost = result * diliary_cos;
                    
                }else{
                    
                    var tot_cost = 0;
                }
                
                // tatal amount
                var total = tot_cost + netprice;
                
            }else{
               
            }
            // load flash buy
            location.replace("exphp/flashbuy.php?flitem=" + fl_id + "&qun=" + result + "&com=" + result1 + "&tot=" +total, true);
    }
        
</script>