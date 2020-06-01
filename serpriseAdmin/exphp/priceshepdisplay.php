<?PHP include '../conection.php' ?>
<?php

      /*-----------get pass value------------*/
      $month= $_POST['mon_N'];
      /*----------date limit--------------*/
      $def_date=date("Y-m-d",strtotime("-30 day"));
      $date_range_1= date('Y-0'.$month.'-31');
      $date_range_2= date('Y-0'.$month.'-01');
      if( $month== 1){
        /*---------------get price shipping table--------------------*/
        $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
        $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
      }else{
        if( $month== 2){
          /*---------------get price shipping table--------------------*/
          $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
          $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
        }else{
          if( $month== 3){
            /*---------------get price shipping table--------------------*/
            $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
            $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
          }else{
            if( $month==4){
              /*---------------get price shipping table--------------------*/
              $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
              $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
            }else{
              if( $month==5){
                /*---------------get price shipping table--------------------*/
                $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
              }else{
                if( $month==6){
                  /*---------------get price shipping table--------------------*/
                  $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                  $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                }else{
                  if( $month==7){
                    /*---------------get price shipping table--------------------*/
                    $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                    $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                  }else{
                    if( $month==8){
                      /*---------------get price shipping table--------------------*/
                      $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                      $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                    }else{
                      if( $month==9){
                        /*---------------get price shipping table--------------------*/
                        $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                        $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                      }else{
                        if( $month==10){
                          /*---------------get price shipping table--------------------*/
                          $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                          $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                        }else{
                          if( $month==11){
                            /*---------------get price shipping table--------------------*/
                            $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                            $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                          }else{
                            if( $month==12){
                              /*---------------get price shipping table--------------------*/
                              $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date <= '$date_range_1' AND price_shipping_date >= '$date_range_2'";
                              $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
                            }else{
                              /*---------------get price shipping table--------------------*/
                              $price_shipping = "SELECT * FROM price_shipping WHERE price_shipping_date >= '$def_date'";
                              $price_shipping_result = mysqli_query($con, $price_shipping) or die (mysqli_error($con));
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

    /*--------------------price shipping table have item-------------------------*/ 
      if(mysqli_num_rows($price_shipping_result) > 0){
        $number3 = 0;
        /*-------------diaplay price shipping---------------*/
          while ($price_shipping_row = $price_shipping_result-> fetch_assoc()){
            $ship_date =$price_shipping_row['price_shipping_date'];
            $ship_user_id = $price_shipping_row['price_shipping_user_id'];
            $ship_item_id = $price_shipping_row['price_shipping_item_id'];
            $ship_deli_id = $price_shipping_row['price_shipping_deli_id'];

            /*--------------------get user table-------------------------*/
            $ship_item_user = "SELECT * FROM user WHERE user_id='$ship_user_id' AND user_status='user'";
            $ship_item_user_result = mysqli_query($con, $ship_item_user) or die (mysqli_error($con));
            $ship_item_user_row = $ship_item_user_result-> fetch_assoc();

            /*--------------------get item tabel-------------------------*/
            $ship_item = "SELECT * FROM item WHERE item_id='$ship_item_id'";
            $ship_item_result = mysqli_query($con, $ship_item) or die (mysqli_error($con));
            $ship_item_row = $ship_item_result-> fetch_assoc();

              /*--------------------get delivary company table-------------------------*/
              $ship_company = "SELECT * FROM delivery_company WHERE delivery_company_id='$ship_deli_id'";
              $ship_company_result = mysqli_query($con, $ship_company) or die (mysqli_error($con));
              $ship_company_row = $ship_company_result-> fetch_assoc();

              
                $number3 = $number3+1;
                echo '<tr>
                  <td>
                    '.$number3.'
                  </td>
                  <td>
                    '.$price_shipping_row['price_shipping_order_date'].'
                  </td>
                  <td>
                    '.$price_shipping_row['price_shipping_date'].'
                  </td>
                  <td>
                    '.$ship_item_user_row['user_username'].'
                  </td>
                  <td>
                    '.$ship_item_user_row['user_full_name'].'
                  </td>
                  <td>
                    '.$ship_item_user_row['user_province'].'
                  </td>
                  <td>
                    '.$ship_item_user_row['user_distric'].'
                  </td>
                  <td>
                    '.$ship_item_user_row['user_address'].'
                  </td>
                  <td>
                    '.$ship_item_user_row['user_email'].'
                  </td>
                  <td>
                    '.$ship_item_row['item_id'].'
                  </td>
                  <td>
                    '.$ship_item_row['item_name'].'
                  </td>
                  <td>
                    '.$price_shipping_row['price_shipping_quntity'].'
                  </td>
                  <td>
                    '.$ship_company_row['delivery_company_name'].'
                  </td>
                  <td>
                    '.$price_shipping_row['price_shipping_deli_cost'].'
                  </td>
                  <td>
                    '.$price_shipping_row['price_shipping_amount'].'
                  </td>
                  <td>
                    '.$price_shipping_row['price_shipping_admin'].'
                  </td>
                  <td class="text-right">
                    '.$price_shipping_row['price_shipping_group_id'].'
                  </td>
                </tr>';
          
          }
      }else{
        echo'<h2 class="no_error">No Shipping This Month</h2>';
      }
    ?>