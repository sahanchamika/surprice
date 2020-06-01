<?PHP include '../conection.php' ?>
<?php
    /*---------get flash by quntity table--------------*/
    $flash_by_quntity = "SELECT * FROM flash_by_quntity ORDER BY flash_by_quntity_qun ASC";
    $flash_by_quntity_result = mysqli_query($con, $flash_by_quntity) or die (mysqli_error($con));
    $count3 = 0;
    while ($flash_by_quntity_row = $flash_by_quntity_result-> fetch_assoc()){
        $count3 = $count3 +1;
        $quntity_flash_id = $flash_by_quntity_row['flash_by_quntity_item_id'];
        $quntity_creater_id = $flash_by_quntity_row['flash_by_quntity_creater_id'];
        /*-------------------get item table----------------*/
        $item = "SELECT * FROM item WHERE item_id='$quntity_flash_id'";
        $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
        $item_row = $item_result-> fetch_assoc();
        /*-------------------get creater table----------------*/
        $creater = "SELECT * FROM creator WHERE creator_id='$quntity_creater_id'";
        $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
        $creater_row = $creater_result-> fetch_assoc();
        /*-------------check flash quntity lowest -------------*/
        if($flash_by_quntity_row['flash_by_quntity_qun'] >= 100){
            echo'<tr class="no_exper_table">
                <td>
                '.$count3.'
                </td>
                <td>
                    '.$flash_by_quntity_row['flash_by_quntity_item_id'].'
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
                    '.$flash_by_quntity_row['flash_by_quntity_year'].'
                </td>
                <td>
                    '.$item_row['item_quantity'].'
                </td>
                <td class="text-right">
                    '.$flash_by_quntity_row['flash_by_quntity_qun'].'
                </td>
            </tr>';
        }else{
            if($flash_by_quntity_row['flash_by_quntity_qun'] <= 10){
                echo'<tr class="exper_table">
                    <td>
                    '.$count3.'
                    </td>
                    <td>
                        '.$flash_by_quntity_row['flash_by_quntity_item_id'].'
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
                        '.$flash_by_quntity_row['flash_by_quntity_year'].'
                    </td>
                    <td>
                        '.$item_row['item_quantity'].'
                    </td>
                    <td class="text-right">
                        '.$flash_by_quntity_row['flash_by_quntity_qun'].'
                    </td>
                </tr>';
            }else{
                echo'<tr">
                    <td>
                    '.$count3.'
                    </td>
                    <td>
                        '.$flash_by_quntity_row['flash_by_quntity_item_id'].'
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
                        '.$flash_by_quntity_row['flash_by_quntity_year'].'
                    </td>
                    <td>
                        '.$item_row['item_quantity'].'
                    </td>
                    <td class="text-right">
                        '.$flas_by_quntity_row['flash_by_quntity_qun'].'
                    </td>
                </tr>';
            }
        }
    } 
?>