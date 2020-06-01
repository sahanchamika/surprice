<?PHP include '../conection.php' ?>
<?php
    /*-----------get pass value------------*/
    $sort= $_POST['sort_N'];
    /*-------get current month one intiger---------*/
    $current_munth = date("n");
    /*-------------check sort month------------*/
    if($sort == 1){
        /*---------get group creater item by Revaneu table--------------*/
        $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_1`) ASC";
        $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
    }else{
        if($sort == 2){
            /*---------get group creater item by Revaneu table--------------*/
            $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_2`) ASC";
            $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
        }else{
            if($sort == 3){
                /*---------get group creater item by Revaneu table--------------*/
                $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_3`) ASC";
                $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
            }else{
                if($sort == 4){
                    /*---------get group creater item by Revaneu table--------------*/
                    $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_4`) ASC";
                    $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                }else{
                    if($sort == 5){
                        /*---------get group creater item by Revaneu table--------------*/
                        $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_5`) ASC";
                        $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                    }else{
                        if($sort == 6){
                            /*---------get group creater item by Revaneu table--------------*/
                            $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_6`) ASC";
                            $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                        }else{
                            if($sort == 7){
                                /*---------get group creater item by Revaneu table--------------*/
                                $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_7`) ASC";
                                $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                            }else{
                                if($sort == 8){
                                    /*---------get group creater item by Revaneu table--------------*/
                                    $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_8`) ASC";
                                    $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                                }else{
                                    if($sort == 9){
                                        /*---------get group creater item by Revaneu table--------------*/
                                        $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_9`) ASC";
                                        $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                                    }else{
                                        if($sort == 10){
                                            /*---------get group creater item by Revaneu table--------------*/
                                            $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_10`) ASC";
                                            $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
                                        }else{
                                            if($sort == 11){
                                                /*---------get group creater item by Revaneu table--------------*/
                                                $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_11`) ASC";
                                                $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con)); 
                                            }else{
                                                if($sort == 12){
                                                    /*---------get group creater item by Revaneu table--------------*/
                                                    $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id ORDER BY SUM(`m_12`) ASC";
                                                    $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con)); 
                                                }else{
                                                    /*---------get group creater item by Revaneu table--------------*/
                                                    $creater_by_revaneu = "SELECT item_by_revanue_item_creator_id, item_by_revanue_year, SUM(`m_1`), SUM(`m_2`), SUM(`m_3`), SUM(`m_4`), SUM(`m_5`), SUM(`m_6`), SUM(`m_7`), SUM(`m_8`), SUM(`m_9`), SUM(`m_10`), SUM(`m_11`), SUM(`m_12`) FROM item_by_revanue GROUP BY item_by_revanue_item_creator_id";
                                                    $creater_by_revaneu_result = mysqli_query($con, $creater_by_revaneu) or die (mysqli_error($con));
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
    $count = 0;
    /*----------display creater by revanue--------------*/
    while ($creater_by_revaneu_row =  $creater_by_revaneu_result-> fetch_assoc()){
      $creator_id = $creater_by_revaneu_row['item_by_revanue_item_creator_id'];
      /*-------------------get creater table----------------*/
      $creater = "SELECT * FROM creator WHERE creator_id='$creator_id'";
      $creater_result = mysqli_query($con, $creater) or die (mysqli_error($con));
      $creater_row = $creater_result-> fetch_assoc();
      /*----------------calculate total creater revanue------------------*/
      $total_creater_by_rev = 0;
      for($i = 1; $i <= 12; $i++){
        $total_creater_by_rev = $total_creater_by_rev + $creater_by_revaneu_row['SUM(`m_'.$i.'`)'];
      }
      /*------number count------------*/
      $count = $count +1;
      echo '<tr>
              <td>
                '.$count.'
              </td>
              <td>
                '.$creater_row['creator_name'].'
              </td>
              <td>
                '.$creater_row['creator_email'].'
              </td>
              <td>
                '.$creater_row['creator_tel'].'
              </td>';
              if($creater_row['creator_item'] == 0){
                echo'<td class="exper_table">
                  All Sold
                </td>';
              }else{
                if($creater_row['creator_item'] <= 10){
                  echo'<td class="exper_table">
                    '.$creater_row['creator_item'].'
                  </td>';
                }else{
                  echo'<td>
                    '.$creater_row['creator_item'].'
                  </td>';
                }
              }
              if($creater_row['creator_sold_iem'] <= 10){
                echo'<td class="exper_table">
                  '.$creater_row['creator_sold_iem'].'
                </td>';
              }else{
                echo'<td>
                  '.$creater_row['creator_sold_iem'].'
                </td>';
              }
              echo'<td>
                '.$creater_row['creator_total_item'].'
              </td>
              <td>
               '.$creater_by_revaneu_row['item_by_revanue_year'].'
              </td>';
              if($current_munth >= 1){
                if(500 >= $creater_by_revaneu_row['SUM(`m_1`)']){
                  if($creater_by_revaneu_row['SUM(`m_1`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_1`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_1`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 2){
                if(500 >= $creater_by_revaneu_row['SUM(`m_2`)']){
                  if($creater_by_revaneu_row['SUM(`m_2`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_2`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_2`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 3){
                if(500 >= $creater_by_revaneu_row['SUM(`m_3`)']){
                  if($creater_by_revaneu_row['SUM(`m_3`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_3`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_3`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 4){
                if(500 >= $creater_by_revaneu_row['SUM(`m_4`)']){
                  if($creater_by_revaneu_row['SUM(`m_4`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_4`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_4`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 5){
                if(500 >= $creater_by_revaneu_row['SUM(`m_5`)']){
                  if($creater_by_revaneu_row['SUM(`m_5`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_5`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_5`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 6){
                if(500 >= $creater_by_revaneu_row['SUM(`m_6`)']){
                  if($creater_by_revaneu_row['SUM(`m_6`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_6`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_6`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }if($current_munth >= 7){
                if(500 >= $creater_by_revaneu_row['SUM(`m_7`)']){
                  if($creater_by_revaneu_row['SUM(`m_7`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_7`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_7`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 8){
                if(500 >= $creater_by_revaneu_row['SUM(`m_8`)']){
                  if($creater_by_revaneu_row['SUM(`m_8`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_8`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_8`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 9){
                if(500 >= $creater_by_revaneu_row['SUM(`m_9`)']){
                  if($creater_by_revaneu_row['SUM(`m_9`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_9`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_9`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 10){
                if(500 >= $creater_by_revaneu_row['SUM(`m_10`)']){
                  if($creater_by_revaneu_row['SUM(`m_10`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_10`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_10`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 11){
                if(500 >= $creater_by_revaneu_row['SUM(`m_11`)']){
                  if($creater_by_revaneu_row['SUM(`m_11`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_11`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_11`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              if($current_munth >= 12){
                if(500 >= $creater_by_revaneu_row['SUM(`m_12`)']){
                  if($creater_by_revaneu_row['SUM(`m_12`)'] == NULL){
                    echo '<td class="exper_table">
                        0
                      </td>';
                  }else{
                    echo '<td class="exper_table">
                      '.$creater_by_revaneu_row['SUM(`m_12`)'].'
                      </td>';
                  }
                }else{
                  echo '<td>
                    '.$creater_by_revaneu_row['SUM(`m_12`)'].'
                    </td>'; 
                }
              }else{
                echo '<td class="no_exper_table">
                  No Update
                </td>'; 
              }
              echo'<td class="text-right">
                  '.$total_creater_by_rev.'
              </td>
          </tr>';
    }
  ?>