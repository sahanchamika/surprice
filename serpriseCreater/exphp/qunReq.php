<?PHP include '../conection.php' ?>
<?php
        session_start();
        /*---------------------login user id-----------------------*/
        $log_user_id = $_SESSION['creater_id'];
                     
                /*---------------------creater new iten request list-----------------------*/
                $qun_req_item = "SELECT * FROM cerator_qun_req WHERE cerator_qun_req_cre_id='$log_user_id' ORDER BY cerator_qun_req_id DESC";
                $qun_req_item_result = mysqli_query($con, $qun_req_item) or die (mysqli_error($con));
     
                     $number2 = 0;
                     while ($qun_req_item_row = $qun_req_item_result-> fetch_assoc()){
                       $number2 = $number2 +1;
                      
                       $qun_req_item_id = $qun_req_item_row['cerator_qun_req_item_id'];
                       /*-------------------get item table----------------*/
                       $item = "SELECT * FROM item WHERE item_id = '$qun_req_item_id'";
                       $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
                       $item_row = $item_result-> fetch_assoc();

                       $item_catagory = $item_row['item_catagory_code'];
                       /*-------------------get catagory table----------------*/
                       $catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$item_catagory'";
                       $catagory_result = mysqli_query($con, $catagory) or die (mysqli_error($con));
                       $catagory_row = $catagory_result-> fetch_assoc();
                        echo'<tr>
                          <td>
                            '.$number2.'
                          </td>
                          <td>
                          '.$item_row['item_name'].'
                          </td>
                          <td>
                            Rs: '.$qun_req_item_row['cerator_qun_req_price'].'
                          </td>
                          <td>
                            '.$qun_req_item_row['cerator_qun_req_qun'].'
                          </td>
                          <td>
                            '.$catagory_row['item_catagory_name'].'
                          </td>
                          <td>
                            '.$qun_req_item_row['cerator_qun_req_weight'].' Kg
                          </td>
                          <td>
                            '.$qun_req_item_row['cerator_qun_req_custom'].'
                          </td>';
                          if($qun_req_item_row['cerator_qun_req_satate'] == "Active"){
                            echo'<td class="text-right" id="cre_req_pen">
                              Pending..
                            </td>';
                          }else{
                            if($qun_req_item_row['cerator_qun_req_satate'] == "Acsept"){
                              echo'<td class="text-right" id="cre_req_acs">
                                Acsept
                              </td>';
                            }else{
                              echo'<td class="text-right" id="cre_req_rem">
                                Sorry,No Acsept
                              </td>';
                            }
                          }
                        echo'</tr>';
                     }
                    ?> 
    