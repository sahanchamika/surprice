<?PHP include '../conection.php' ?>
<?php
        session_start();
        /*---------------------login user id-----------------------*/
        $log_user_id = $_SESSION['creater_id'];
                     
                /*---------------------creater new iten request list-----------------------*/
                $new_qun_req_item = "SELECT * FROM cerator_item_new_req WHERE cerator_item_new_req_cre_id='$log_user_id' ORDER BY cerator_item_new_req_id DESC";
                $new_qun_req_item_result = mysqli_query($con, $new_qun_req_item) or die (mysqli_error($con));
     
                     $number2 = 0;
                     while ($new_qun_req_item_row = $new_qun_req_item_result-> fetch_assoc()){
                       $number2 = $number2 +1;
                      
                       $qun_req_item_catagory = $new_qun_req_item_row['cerator_item_new_req_cata'];

                       /*-------------------get catagory table----------------*/
                       $catagory = "SELECT * FROM item_catagory WHERE item_catagory_code='$qun_req_item_catagory'";
                       $catagory_result = mysqli_query($con, $catagory) or die (mysqli_error($con));
                       $catagory_row = $catagory_result-> fetch_assoc();
                        echo'<tr>
                          <td>
                            '.$number2.'
                          </td>
                          <td>
                          '.$new_qun_req_item_row['cerator_item_new_req_item_name'].'
                          </td>
                          <td>
                            Rs: '.$new_qun_req_item_row['cerator_item_new_req_price'].'
                          </td>
                          <td>
                            '.$new_qun_req_item_row['cerator_item_new_req_qun'].'
                          </td>
                          <td>
                            '.$catagory_row['item_catagory_name'].'
                          </td>
                          <td>
                            '.$new_qun_req_item_row['cerator_item_new_req_weight'].' Kg
                          </td>
                          <td>
                            '.$new_qun_req_item_row['cerator_item_new_req_custom'].'
                          </td>';
                          if($new_qun_req_item_row['cerator_item_new_req_state'] == "Active"){
                            echo'<td class="text-right" id="cre_req_pen">
                              Pending..
                            </td>';
                          }else{
                            if($new_qun_req_item_row['cerator_item_new_req_state'] == "Acsept"){
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
    