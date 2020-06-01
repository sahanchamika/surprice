<?PHP include '../conection.php' ?>
<?php
    /*-----------get pass value------------*/
    $sort= $_POST['sort_N'];
    /*-------get current month one intiger---------*/
    $current_munth = date("n");
    /*-------------check sort month------------*/
    if($sort == 1){
        /*---------get flash by Revaneu table--------------*/
        $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_1` ASC";
        $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
    }else{
        if($sort == 2){
            /*---------get flash by Revaneu table--------------*/
            $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_2` ASC";
            $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
        }else{
            if($sort == 3){
                /*---------get flash by Revaneu table--------------*/
                $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_3` ASC";
                $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
            }else{
                if($sort == 4){
                    /*---------get flash by Revaneu table--------------*/
                    $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_4` ASC";
                    $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
                }else{
                    if($sort == 5){
                        /*---------get flash by Revaneu table--------------*/
                        $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_5` ASC";
                        $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
                    }else{
                        if($sort == 6){
                            /*---------get flash by Revaneu table--------------*/
                            $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_6` ASC";
                            $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con)); 
                        }else{
                            if($sort == 7){
                                /*---------get flash by Revaneu table--------------*/
                                $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_7` ASC";
                                $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con)); 
                            }else{
                                if($sort == 8){
                                     /*---------get flash by Revaneu table--------------*/
                                     $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_8` ASC";
                                     $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
                                }else{
                                    if($sort == 9){
                                         /*---------get flash by Revaneu table--------------*/
                                         $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_9` ASC";
                                         $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
                                    }else{
                                        if($sort == 10){
                                             /*---------get flash by Revaneu table--------------*/
                                             $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_10` ASC";
                                             $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con));
                                        }else{
                                            if($sort == 11){
                                                 /*---------get flash by Revaneu table--------------*/
                                                 $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_11` ASC";
                                                 $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con)); 
                                            }else{
                                                if($sort == 12){
                                                    /*---------get flash by Revaneu table--------------*/
                                                    $flash_by_revanue = "SELECT * FROM flash_by_revanue ORDER BY `m_12` ASC";
                                                    $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con)); 
                                                }else{
                                                    /*---------get flash by Revaneu table--------------*/
                                                    $flash_by_revanue = "SELECT * FROM flash_by_revanue";
                                                    $flash_by_revanue_result = mysqli_query($con, $flash_by_revanue) or die (mysqli_error($con)); 
                                                } 
                                            }
                                        } 
                                    }
                                }
                            }
                        }
                    }   
                }
            } 
        }
    }
    $countf = 0;
    while ($flash_by_revanue_row = $flash_by_revanue_result-> fetch_assoc()){
    $countf = $countf +1;
    $total_flash_by_rev = 0;
    for($p = 1; $p <= 12; $p++){
        $total_flash_by_rev = $total_flash_by_rev + $flash_by_revanue_row['m_'.$p.''];
    }
    $flash_id = $flash_by_revanue_row['flash_by_revanue_item_id'];
    $creater_id2 = $flash_by_revanue_row['flash_by_revanue_item_creator_id'];
    /*-------------------get flash_sale table----------------*/
    $flash = "SELECT * FROM flash_sale WHERE flash_sale_item_id='$flash_id'";
    $flash_result = mysqli_query($con, $flash) or die (mysqli_error($con));
    $flash_row = $flash_result-> fetch_assoc();

    /*-------------------get creater table----------------*/
    $creater2 = "SELECT * FROM creator WHERE creator_id='$creater_id2'";
    $creater2_result = mysqli_query($con, $creater2) or die (mysqli_error($con));
    $creater2_row = $creater2_result-> fetch_assoc();

    $flash_rev_min = $flash_row['flash_sale_price'] * 3;

    echo '<tr>
            <td>
                '. $countf.'
            </td>
            <td>
                '.$flash_by_revanue_row['flash_by_revanue_item_id'].'
            </td>
            <td>
                '.$flash_row['flash_sale_name'].'
            </td>
            <td>
                Rs: '.$flash_row['flash_sale_price'].'
            </td>
            <td>
                '.$flash_row['flash_sale_discount'].'%
            </td>';
            if($flash_row['flash_sale_quantity'] == 0){
                echo'<td class="exper_table">
                All sold
                </td>';
            }else{
                if($flash_row['flash_sale_quantity'] < 8){
                echo'<td class="exper_table">
                '.$flash_row['flash_sale_quantity'].'
                </td>';
                }else{
                echo'<td>
                    '.$flash_row['flash_sale_quantity'].'
                    </td>';
                }
            }
            
            echo'<td>
                '.$creater2_row['creator_name'].'
            </td>
            <td>
                '.$creater2_row['creator_email'].'
            </td>
            <td>
                '.$flash_by_revanue_row['flash_by_revanue_year'].'
            </td>';
            if($current_munth >= 1){
                if($flash_rev_min >= $flash_by_revanue_row['m_1']){
                if($flash_by_revanue_row['m_1'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_1'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_1'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 2){
                if($flash_rev_min >= $flash_by_revanue_row['m_2']){
                if($flash_by_revanue_row['m_2'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_2'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_2'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 3){
                if($flash_rev_min >= $flash_by_revanue_row['m_3']){
                if($flash_by_revanue_row['m_3'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_3'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_3'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 4){
                if($flash_rev_min >= $flash_by_revanue_row['m_4']){
                if($flash_by_revanue_row['m_4'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_4'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_4'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 5){
                if($flash_rev_min >= $flash_by_revanue_row['m_5']){
                if($flash_by_revanue_row['m_5'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_5'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_5'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 6){
                if($flash_rev_min >= $flash_by_revanue_row['m_6']){
                if($flash_by_revanue_row['m_6'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_6'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_6'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 7){
                if($flash_rev_min >= $flash_by_revanue_row['m_7']){
                if($flash_by_revanue_row['m_7'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_7'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_7'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 8){
                if($flash_rev_min >= $flash_by_revanue_row['m_8']){
                if($flash_by_revanue_row['m_8'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_8'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_8'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 9){
                if($flash_rev_min >= $flash_by_revanue_row['m_9']){
                if($flash_by_revanue_row['m_9'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_9'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_9'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 10){
                if($flash_rev_min >= $flash_by_revanue_row['m_10']){
                if($flash_by_revanue_row['m_10'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_10'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_10'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 11){
                if($flash_rev_min >= $flash_by_revanue_row['m_11']){
                if($flash_by_revanue_row['m_11'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_11'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_11'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            if($current_munth >= 12){
                if($flash_rev_min >= $flash_by_revanue_row['m_12']){
                if($flash_by_revanue_row['m_12'] == NULL){
                    echo '<td class="exper_table">
                        0
                    </td>';
                }else{
                    echo '<td class="exper_table">
                    '.$flash_by_revanue_row['m_12'].'
                    </td>';
                }
                }else{
                echo '<td>
                    '.$flash_by_revanue_row['m_12'].'
                    </td>'; 
                }
            }else{
                echo '<td class="no_exper_table">
                No Update
                </td>'; 
            }
            
            echo'<td class="text-right">
                '.$total_flash_by_rev.'
            </td>
        </tr>';
    }
?>