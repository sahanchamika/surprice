<?PHP include '../conection.php' ?>
<?php
    /*---------get item by quntity table--------------*/
    $item_by_quntity = "SELECT * FROM item_by_quntity ORDER BY item_by_quntity_qun ASC";
    $item_by_quntity_result = mysqli_query($con, $item_by_quntity) or die (mysqli_error($con));
    $count3 = 0;
    while ($item_by_quntity_row = $item_by_quntity_result-> fetch_assoc()){
        $count3 = $count3 +1;
        $quntity_item_id = $item_by_quntity_row['item_by_quntity_item_id'];
        $quntity_creater_id = $item_by_quntity_row['item_by_quntity_creter_id'];
        /*-------------------get item table----------------*/
        $item = "SELECT * FROM item WHERE item_id='$quntity_item_id'";
        $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
        $item_row = $item_result-> fetch_assoc();
        /*-------------------get creater table----------------*/
        $creater = "SELECT * FROM creator WHERE creator_id='$quntity_creater_id'";
        $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
        $creater_row = $creater_result-> fetch_assoc();
        /*-------------check item quntity lowest -------------*/
        if($item_by_quntity_row['item_by_quntity_qun'] >= 100){
            echo'<tr class="no_exper_table">
            <td>
            '.$count3.'
            </td>
            <td>
                '.$item_by_quntity_row['item_by_quntity_item_id'].'
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
                '.$item_by_quntity_row['item_by_quntity_year'].'
            </td>
            <td>
                '.$item_row['item_quantity'].'
            </td>
            <td class="text-right">
                '.$item_by_quntity_row['item_by_quntity_qun'].'
            </td>
            </tr>';
        }else{
            if($item_by_quntity_row['item_by_quntity_qun'] <= 10){
            echo'<tr class="exper_table">
                <td>
                '.$count3.'
                </td>
                <td>
                '.$item_by_quntity_row['item_by_quntity_item_id'].'
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
                '.$item_by_quntity_row['item_by_quntity_year'].'
                </td>
                <td>
                '.$item_row['item_quantity'].'
                </td>
                <td class="text-right">
                '.$item_by_quntity_row['item_by_quntity_qun'].'
                </td>
            </tr>';
            }else{
            echo'<tr>
                <td>
                '.$count3.'
                </td>
                <td>
                '.$item_by_quntity_row['item_by_quntity_item_id'].'
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
                '.$item_by_quntity_row['item_by_quntity_year'].'
                </td>
                <td>
                '.$item_row['item_quantity'].'
                </td>
                <td class="text-right">
                '.$item_by_quntity_row['item_by_quntity_qun'].'
                </td>
            </tr>';
            }
        }
    } 
?>