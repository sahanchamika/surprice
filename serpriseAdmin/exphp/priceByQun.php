<?PHP include '../conection.php' ?>
<?php
    /*---------get price by quntity table--------------*/
    $price_by_quntity = "SELECT * FROM price_by_quntity ORDER BY price_by_quntity_qun ASC";
    $price_by_quntity_result = mysqli_query($con, $price_by_quntity) or die (mysqli_error($con));
    $count3 = 0;
    while ($price_by_quntity_row = $price_by_quntity_result-> fetch_assoc()){
        $count3 = $count3 +1;
        $quntity_price_id = $price_by_quntity_row['price_by_quntity_item_id'];
        $quntity_creater_id = $price_by_quntity_row['price_by_quntity_creater_id'];
        /*-------------------get item table----------------*/
        $item = "SELECT * FROM item WHERE item_id='$quntity_price_id'";
        $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
        $item_row = $item_result-> fetch_assoc();
        /*-------------------get creater table----------------*/
        $creater = "SELECT * FROM creator WHERE creator_id='$quntity_creater_id'";
        $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
        $creater_row = $creater_result-> fetch_assoc();
        /*-------------check price quntity lowest -------------*/
        if($price_by_quntity_row['price_by_quntity_qun'] >= 10){
            echo'<tr class="no_exper_table">
                <td>
                '.$count3.'
                </td>
                <td>
                    '.$price_by_quntity_row['price_by_quntity_item_id'].'
                </td>
                <td>
                    '.$item_row['item_name'].'
                </td>
                <td>
                    '.$item_row['item_price'].'
                </td>
                <td>
                    '.$creater_row['creator_name'].'
                </td>
                <td>
                    '.$creater_row['creator_email'].'
                </td>
                <td>
                    '.$price_by_quntity_row['price_by_quntity_year'].'
                </td>
                <td>
                    '.$item_row['item_quantity'].'
                </td>
                <td class="text-right">
                    '.$price_by_quntity_row['price_by_quntity_qun'].'
                </td>
            </tr>';
        }else{
            if($price_by_quntity_row['price_by_quntity_qun'] <= 3){
                echo'<tr class="exper_table">
                    <td>
                    '.$count3.'
                    </td>
                    <td>
                        '.$price_by_quntity_row['price_by_quntity_item_id'].'
                    </td>
                    <td>
                        '.$item_row['item_name'].'
                    </td>
                    <td>
                        '.$item_row['item_price'].'
                    </td>
                    <td>
                        '.$creater_row['creator_name'].'
                    </td>
                    <td>
                        '.$creater_row['creator_email'].'
                    </td>
                    <td>
                        '.$price_by_quntity_row['price_by_quntity_year'].'
                    </td>
                    <td>
                        '.$item_row['item_quantity'].'
                    </td>
                    <td class="text-right">
                        '.$price_by_quntity_row['price_by_quntity_qun'].'
                    </td>
                </tr>';
            }else{
                echo'<tr">
                    <td>
                    '.$count3.'
                    </td>
                    <td>
                        '.$price_by_quntity_row['price_by_quntity_item_id'].'
                    </td>
                    <td>
                        '.$item_row['item_name'].'
                    </td>
                    <td>
                        '.$item_row['item_price'].'
                    </td>
                    <td>
                        '.$creater_row['creator_name'].'
                    </td>
                    <td>
                        '.$creater_row['creator_email'].'
                    </td>
                    <td>
                        '.$price_by_quntity_row['price_by_quntity_year'].'
                    </td>
                    <td>
                        '.$item_row['item_quantity'].'
                    </td>
                    <td class="text-right">
                        '.$flas_by_quntity_row['price_by_quntity_qun'].'
                    </td>
                </tr>';
            }
        }
    } 
?>