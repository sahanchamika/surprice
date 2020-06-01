<?PHP include '../conection.php' ?>
<?php
    /*-----------get pass value------------*/
    $sort= $_POST['sort_N'];
    /*-------get current month one intiger---------*/
    $current_munth = date("n");
    /*-------------check sort month------------*/
    if($sort == 1){
        /*---------get item by Revaneu table--------------*/
        $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_1` ASC";
        $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
    }else{
        if($sort == 2){
            /*---------get item by Revaneu table--------------*/
            $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_2` ASC";
            $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
        }else{
            if($sort == 3){
                /*---------get item by Revaneu table--------------*/
                $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_3` ASC";
                $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
            }else{
                if($sort == 4){
                    /*---------get item by Revaneu table--------------*/
                    $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_4` ASC";
                    $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                }else{
                    if($sort == 5){
                        /*---------get item by Revaneu table--------------*/
                        $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_5` ASC";
                        $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                    }else{
                        if($sort == 6){
                            /*---------get item by Revaneu table--------------*/
                            $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_6` ASC";
                            $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                        }else{
                            if($sort == 7){
                                /*---------get item by Revaneu table--------------*/
                                $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_7` ASC";
                                $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                            }else{
                                if($sort == 8){
                                    /*---------get item by Revaneu table--------------*/
                                    $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_8` ASC";
                                    $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                                }else{
                                    if($sort == 9){
                                        /*---------get item by Revaneu table--------------*/
                                        $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_9` ASC";
                                        $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                                    }else{
                                        if($sort == 10){
                                            /*---------get item by Revaneu table--------------*/
                                            $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_10` ASC";
                                            $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                                        }else{
                                            if($sort == 11){
                                                /*---------get item by Revaneu table--------------*/
                                                $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_11` ASC";
                                                $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                                            }else{
                                                if($sort == 12){
                                                    /*---------get item by Revaneu table--------------*/
                                                    $item_by_revaneu = "SELECT * FROM item_by_revanue ORDER BY `m_12` ASC";
                                                    $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
                                                }else{
                                                    /*---------get item by Revaneu table--------------*/
                                                    $item_by_revaneu = "SELECT * FROM item_by_revanue";
                                                    $item_by_revaneu_result = mysqli_query($con, $item_by_revaneu) or die (mysqli_error($con)); 
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
    /*------------------display number count-------------------*/
    $count = 0;
    /*-------------------display item_by_revaneu table row--------------*/
    while ($item_by_revaneu_row = $item_by_revaneu_result-> fetch_assoc()){
        $count = $count +1;
        /*-----------------calculate total item revanue in year--------------*/
        $total_item_by_rev = 0;
        for($i = 1; $i <= 12; $i++){
            $total_item_by_rev = $total_item_by_rev + $item_by_revaneu_row['m_'.$i.''];
        }
        /*---------------get item id & creater id item_by_revaneu table---------------------*/
        $item_id = $item_by_revaneu_row['item_by_revanue_item_id'];
        $creater_id = $item_by_revaneu_row['item_by_revanue_item_creator_id'];
        /*-------------------get item table----------------*/
        $item = "SELECT * FROM item WHERE item_id='$item_id'";
        $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
        $item_row = $item_result-> fetch_assoc();

        /*-------------------get creater table----------------*/
        $creater = "SELECT * FROM creator WHERE creator_id='$creater_id'";
        $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
        $creater_row = $creater_result-> fetch_assoc();
        /*-----------cutout of revanue ------------------*/
        $item_rev_min = $item_row['item_price'] * 3;
        /*--------------display table--------------------*/
        echo '<tr>
                <td>
                    '. $count.'
                </td>
                <td>
                    '.$item_by_revaneu_row['item_by_revanue_item_id'].'
                </td>
                <td>
                    '.$item_row['item_name'].'
                </td>
                <td>
                    Rs: '.$item_row['item_price'].'
                </td>
                <td>
                    '.$item_row['item_discount'].'%
                </td>';
                /*-----------check all item sold-----------*/
                if($item_row['item_quantity'] == 0){
                    echo'<td class="exper_table">
                    All sold
                    </td>';
                }else{
                    /*-----------check minimam item quntity--------*/
                    if($item_row['item_quantity'] < 10){
                    echo'<td class="exper_table">
                    '.$item_row['item_quantity'].'
                    </td>';
                    }else{
                    echo'<td>
                        '.$item_row['item_quantity'].'
                        </td>';
                    }
                }
                
                echo'<td>
                    '.$creater_row['creator_name'].'
                </td>
                <td>
                    '.$creater_row['creator_email'].'
                </td>
                <td>
                    '.$item_by_revaneu_row['item_by_revanue_year'].'
                </td>';
                /*---------check null or cutout revanue , month--------------*/
                if($current_munth >= 1){
                    if($item_rev_min >= $item_by_revaneu_row['m_1']){
                        if($item_by_revaneu_row['m_1'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_1'].'
                            </td>';
                    }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_1'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 2){
                    if($item_rev_min >= $item_by_revaneu_row['m_2']){
                        if($item_by_revaneu_row['m_2'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_2'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_2'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 3){
                    if($item_rev_min >= $item_by_revaneu_row['m_3']){
                        if($item_by_revaneu_row['m_3'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_3'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_3'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 4){
                    if($item_rev_min >= $item_by_revaneu_row['m_4']){
                        if($item_by_revaneu_row['m_4'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_4'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_4'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 5){
                    if($item_rev_min >= $item_by_revaneu_row['m_5']){
                        if($item_by_revaneu_row['m_5'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_5'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_5'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 6){
                    if($item_rev_min >= $item_by_revaneu_row['m_6']){
                        if($item_by_revaneu_row['m_6'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_6'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_6'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 7){
                    if($item_rev_min >= $item_by_revaneu_row['m_7']){
                        if($item_by_revaneu_row['m_7'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_7'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_7'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 8){
                    if($item_rev_min >= $item_by_revaneu_row['m_8']){
                        if($item_by_revaneu_row['m_8'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_8'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_8'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 9){
                    if($item_rev_min >= $item_by_revaneu_row['m_9']){
                        if($item_by_revaneu_row['m_9'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_9'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_9'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 10){
                    if($item_rev_min >= $item_by_revaneu_row['m_10']){
                        if($item_by_revaneu_row['m_10'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_10'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_10'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 11){
                    if($item_rev_min >= $item_by_revaneu_row['m_11']){
                        if($item_by_revaneu_row['m_11'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_11'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_11'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                if($current_munth >= 12){
                    if($item_rev_min >= $item_by_revaneu_row['m_12']){
                        if($item_by_revaneu_row['m_12'] == NULL){
                            echo '<td class="exper_table">
                                0
                            </td>';
                        }else{
                            echo '<td class="exper_table">
                            '.$item_by_revaneu_row['m_12'].'
                            </td>';
                        }
                    }else{
                    echo '<td>
                        '.$item_by_revaneu_row['m_12'].'
                        </td>'; 
                    }
                }else{
                    echo '<td class="no_exper_table">
                    No Update
                    </td>'; 
                }
                
                echo'<td class="text-right">
                    '.$total_item_by_rev.'
                </td>
            </tr>';
    }
?>