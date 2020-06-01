<?PHP include '../conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $log_user_row = $log_user_result-> fetch_assoc();


   /*---------------update creater sold & avalbel item-------------------*/
   $creater_item = "SELECT * FROM creator";
   $creater_item_result = mysqli_query($con, $creater_item) or die (mysqli_error($con));
   while ($creater_item_row = $creater_item_result-> fetch_assoc()){
     $creater_id = $creater_item_row['creator_id'];
     /*-----------------get creater total avalebel quntity-----------------*/
     $avalebel_quntity = "SELECT SUM(`item_quantity`) FROM item WHERE item_creator_id = '$creater_id'";
     $avalebel_quntity_result = mysqli_query($con, $avalebel_quntity) or die (mysqli_error($con));
     $avalebel_quntity_row = $avalebel_quntity_result-> fetch_assoc();

     /*-----------------get creater total avalebel quntity flash-----------------*/
     $avalebel_flash_quntity = "SELECT SUM(`flash_sale_quantity`) FROM flash_sale WHERE flash_sale_item_id = '$creater_id'";
     $avalebel_flash_quntity_result = mysqli_query($con, $avalebel_flash_quntity) or die (mysqli_error($con));
     $avalebel_flash_quntity_row = $avalebel_flash_quntity_result-> fetch_assoc();


     $avalebel_item_quntity = $avalebel_quntity_row['SUM(`item_quantity`)'] + $avalebel_flash_quntity_row['SUM(`flash_sale_quantity`)'];

     /*-----------up date creater avalebel quntity------------*/
     $update_avalebel_quntity = "UPDATE creator SET creator_item='$avalebel_item_quntity' WHERE creator_id='$creater_id'";
     $update_avalebel_quntity_result = mysqli_query($con, $update_avalebel_quntity) or die (mysqli_error($con));
     
   }



   /*-------------------create cart exper date calculate and cart exper----------------*/
   $cart_expire_date=date("Y-m-d",strtotime("-30 day"));
   $cart_worning_date=date("Y-m-d",strtotime("-27 day"));

   /*---------------cart exper -------------------*/
   $cart_ex = "SELECT * FROM cart  WHERE cart_date < '$cart_expire_date'";
   $cart_ex_result = mysqli_query($con, $cart_ex) or die (mysqli_error($con));
   while ($cart_ex_row = $cart_ex_result-> fetch_assoc()){
     $cart_ex_item_id = $cart_ex_row['cart_item_id'] ;
     $cart_id = $cart_ex_row['cart_id'] ;

     /*-------------------get item table----------------*/
     $item = "SELECT * FROM item WHERE item_id='$cart_ex_item_id'";
     $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
     $item_row = $item_result-> fetch_assoc();
    /*---------calculate quntity---------------*/
     $cart_item_quntity = $item_row['item_quantity'] + $cart_ex_row['cart_quntity'];

    /*------------update remove cart item quntity in item table------------*/
     $update_item_q = "UPDATE item SET item_quantity='$cart_item_quntity' WHERE item_id = '$cart_ex_item_id'";
     $update_item_q_result = mysqli_query($con, $update_item_q) or die (mysqli_error($con));

    /*------delete row in cart -------*/
    $delete_cart = "DELETE FROM cart WHERE cart_id = '$cart_id'";
    $delete_cart_result = mysqli_query($con, $delete_cart) or die (mysqli_error($con));

   }

   /*-----------cart Exper wornig------------*/
   $update_cart_exp = "UPDATE cart SET cart_state='Exper' WHERE cart_date < '$cart_worning_date'";
   $update_cart_exp_result = mysqli_query($con, $update_cart_exp) or die (mysqli_error($con));




   /*-------------------create price box exper date calculate and box exper----------------*/
   $p_box_expire_date=date("Y-m-d",strtotime("-20 day"));
   
  /*---------------price box exper item-------------------*/
  $box_ex = "SELECT * FROM price_box  WHERE box_date < '$p_box_expire_date'";
  $box_ex_result = mysqli_query($con, $box_ex) or die (mysqli_error($con));
   while ($box_ex_row = $box_ex_result-> fetch_assoc()){
     $box_ex_item_id = $box_ex_row['box_item_id'] ;
     $box_id = $box_ex_row['box_id'] ;

     /*-------------------get item table----------------*/
     $item = "SELECT * FROM item WHERE item_id='$box_ex_item_id'";
     $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
     $item_row = $item_result-> fetch_assoc();
     /*---------calculate quntity---------------*/
     $box_item_quntity = $item_row['item_quantity'] + $box_ex_row['box_quntity'];

     /*------------update remove price box item quntity in item table------------*/
     $update_item_q = "UPDATE item SET item_quantity='$box_item_quntity' WHERE item_id = '$box_ex_item_id'";
     $update_item_q_result = mysqli_query($con, $update_item_q) or die (mysqli_error($con));

    /*------delete row in price box -------*/
    $delete_box = "DELETE FROM price_box WHERE box_id = '$box_id'";
    $delete_box_result = mysqli_query($con, $delete_box) or die (mysqli_error($con));

   }



  /*---------------creater all item -------------------*/
  $cre_all_item = "SELECT * FROM creator";
  $cre_all_item_result = mysqli_query($con, $cre_all_item) or die (mysqli_error($con));
   while ($cre_all_item_row = $cre_all_item_result-> fetch_assoc()){
    $creater_id = $cre_all_item_row['creator_id'];
    $creater_total_qun = $cre_all_item_row['creator_sold_iem'] + $cre_all_item_row['creator_item'];
    /*------------update creater avalebel item quntity------------*/
    $update_cre_ava_q = "UPDATE creator SET creator_total_item='$creater_total_qun' WHERE creator_id = '$creater_id'";
    $update_cre_ava_q_result = mysqli_query($con, $update_cre_ava_q) or die (mysqli_error($con));
   }

  /*---------------catagory by item -------------------*/
  $catagory_qun = "SELECT item_catagory_code, SUM(`item_quantity`) FROM item GROUP BY item_catagory_code";
  $catagory_qun_result = mysqli_query($con, $catagory_qun) or die (mysqli_error($con));
   while ($catagory_qun_row = $catagory_qun_result-> fetch_assoc()){
    $catagory_code = $catagory_qun_row['item_catagory_code'];
    $catagory_total_qun = $catagory_qun_row['SUM(`item_quantity`)'];
    /*------------update creater avalebel item quntity------------*/
    $update_cata_q = "UPDATE item_catagory SET item_catagory_count='$catagory_total_qun' WHERE item_catagory_code = '$catagory_code'";
    $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
   }



  /*-------------------item rate calculate----------------*/
  $item_rate_ex_date=date("Y-m-d",strtotime("-30 day"));
  /*---------------item rate-------------------*/
  $item_rate = "SELECT * FROM item";
  $item_rate_result = mysqli_query($con, $item_rate) or die (mysqli_error($con));
  while ($item_rate_row = $item_rate_result-> fetch_assoc()){
    $item_quntity = $item_rate_row['item_quantity'];
    $item_rate_id = $item_rate_row['item_id'];

    $item_sold_q = "SELECT SUM(`item_shipping_quntity`) FROM item_shipping WHERE item_shipping_item_id = '$item_rate_id'";
    $item_sold_q_result = mysqli_query($con, $item_sold_q) or die (mysqli_error($con));
    $item_sold_q_row = $item_sold_q_result-> fetch_assoc();
    $item_sold_quntity = $item_sold_q_row['SUM(`item_shipping_quntity`)'];
  
    if($item_rate_row['item_add_date'] <= $item_rate_ex_date && $item_sold_quntity == NULL){
      /*------------update item sale rate------------*/
      $update_cata_q = "UPDATE item SET item_sale_rate='0' WHERE item_id = '$item_rate_id'";
      $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
    }else{
       if($item_sold_quntity == NULL || $item_sold_quntity <= 1){
          /*------------update item sale rate------------*/
          $update_cata_q = "UPDATE item SET item_sale_rate='1' WHERE item_id = '$item_rate_id'";
          $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
       }else{
        if($item_sold_quntity <= 5){
          /*------------update item sale rate------------*/
          $update_cata_q = "UPDATE item SET item_sale_rate='2' WHERE item_id = '$item_rate_id'";
          $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
        }else{
          if($item_sold_quntity <= 10){
            /*------------update item sale rate------------*/
            $update_cata_q = "UPDATE item SET item_sale_rate='3' WHERE item_id = '$item_rate_id'";
            $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
         }else{
          if($item_sold_quntity <= 30){
            /*------------update item sale rate------------*/
            $update_cata_q = "UPDATE item SET item_sale_rate='4' WHERE item_id = '$item_rate_id'";
            $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
          }else{
            /*------------update item sale rate------------*/
            $update_cata_q = "UPDATE item SET item_sale_rate='5' WHERE item_id = '$item_rate_id'";
            $update_cata_q_result = mysqli_query($con, $update_cata_q) or die (mysqli_error($con));
          }
         }
       }
      }
    }
  }



 /*---------------user member ship-------------------*/
 $user_membership = "SELECT * FROM user WHERE user_status ='user'";
 $user_membership_result = mysqli_query($con, $user_membership) or die (mysqli_error($con));
 while ($user_membership_row = $user_membership_result-> fetch_assoc()){
  $user_id = $user_membership_row['user_id'];

  $user_rev = "SELECT SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_user_id = '$user_id'";
  $user_rev_result = mysqli_query($con, $user_rev) or die (mysqli_error($con));
  $user_rev_row = $user_rev_result-> fetch_assoc();
  $user_revanue = $user_rev_row['SUM(`item_shipping_amount`)'];

  if($user_revanue == NULL){
      /*------------update user membership------------*/
      $update_user_m = "UPDATE user SET user_menber_ship='New' WHERE user_id = '$user_id'";
      $update_user_m_result = mysqli_query($con, $update_user_m) or die (mysqli_error($con));
  }else{
    if($user_revanue < 10000){
      /*------------update user membership------------*/
      $update_user_m = "UPDATE user SET user_menber_ship='Low' WHERE user_id = '$user_id'";
      $update_user_m_result = mysqli_query($con, $update_user_m) or die (mysqli_error($con));
    }else{
      if($user_revanue < 50000){
        /*------------update user membership------------*/
        $update_user_m = "UPDATE user SET user_menber_ship='Silver' WHERE user_id = '$user_id'";
        $update_user_m_result = mysqli_query($con, $update_user_m) or die (mysqli_error($con));
      }else{
        if($user_revanue < 99000){
          /*------------update user membership------------*/
          $update_user_m = "UPDATE user SET user_menber_ship='Gold' WHERE user_id = '$user_id'";
          $update_user_m_result = mysqli_query($con, $update_user_m) or die (mysqli_error($con));
        }else{
          /*------------update user membership------------*/
          $update_user_m = "UPDATE user SET user_menber_ship='Platinum' WHERE user_id = '$user_id'";
          $update_user_m_result = mysqli_query($con, $update_user_m) or die (mysqli_error($con));
        }
      }
    }
  }

 }

  echo '('.date("h:ia").')';

  ?>