<?PHP include '../conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $log_user_row = $log_user_result-> fetch_assoc();
  /*-----------get current year-----------*/
  $this_year=date("Y");
  /*----------12 month revanu calculate & update---------------*/
  for($x = 1; $x <= 12; $x++){
    /*---------------get 12 month item shipping revanue--------------------*/
    $item_revanue = "SELECT SUM(`item_shipping_amount`) FROM item_shipping WHERE item_shipping_date >= '$this_year-0$x-01' AND item_shipping_date <= '$this_year-0$x-31'";
    $item_revanue_result = mysqli_query($con, $item_revanue) or die (mysqli_error($con));
    $item_revanue_row =  $item_revanue_result-> fetch_assoc();
    $item_month = 0 + $item_revanue_row['SUM(`item_shipping_amount`)'];
    /*-----------up date revanue table-------------*/
    $update_month_rev_item = "UPDATE revanue SET m_$x='$item_month' WHERE revanue_year='$this_year' AND revanue_type='item'";
    $update_month_rev_item_result = mysqli_query($con, $update_month_rev_item) or die (mysqli_error($con));

    /*---------------get 12 month flash shipping revanue--------------------*/
    $flash_revanue = "SELECT SUM(`flash_shipping_amount`) FROM flash_shipping WHERE flash_shipping_date >= '$this_year-0$x-01' AND flash_shipping_date <= '$this_year-0$x-31'";
    $flash_revanue_result = mysqli_query($con, $flash_revanue) or die (mysqli_error($con));
    $flash_revanue_row =  $flash_revanue_result-> fetch_assoc();
    $flash_month = 0 + $flash_revanue_row['SUM(`flash_shipping_amount`)'];
    /*-----------up date revanue table-------------*/
    $update_month_rev_flash = "UPDATE revanue SET m_$x='$flash_month' WHERE revanue_year='$this_year' AND revanue_type='flash'";
    $update_month_rev_flash_result = mysqli_query($con, $update_month_rev_flash) or die (mysqli_error($con));

    /*---------------get 12 month price shipping revanue--------------------*/
    $price_revanue = "SELECT price_shipping_amount FROM price_shipping WHERE price_shipping_date >= '$this_year-0$x-01' AND price_shipping_date <= '$this_year-0$x-31' GROUP BY price_shipping_group_id";
    $price_revanue_result = mysqli_query($con, $price_revanue) or die (mysqli_error($con));
    $price_month = 0;
    while ($price_revanue_row = $price_revanue_result-> fetch_assoc()){
      $price_month = $price_month + $price_revanue_row['price_shipping_amount'];
    }
    /*-----------up date revanue table-------------*/
    $update_month_rev_price = "UPDATE revanue SET m_$x='$price_month' WHERE revanue_year='$this_year' AND revanue_type='price'";
    $update_month_rev_price_result = mysqli_query($con, $update_month_rev_price) or die (mysqli_error($con));

    /*---------------get 12 month total shipping revanue--------------------*/
    $total_revanue = "SELECT SUM(`m_$x`) FROM revanue WHERE revanue_type != 'total' AND revanue_year = '$this_year'";
    $total_revanue_result = mysqli_query($con, $total_revanue) or die (mysqli_error($con));
    $total_revanue_row =  $total_revanue_result-> fetch_assoc();
    $total_month = 0 + $total_revanue_row['SUM(`m_'.$x.'`)'];
    /*-----------up date revanue table-------------*/
    $update_month_rev_total = "UPDATE revanue SET m_$x='$total_month' WHERE revanue_year='$this_year' AND revanue_type='total'";
    $update_month_rev_total_result = mysqli_query($con, $update_month_rev_total) or die (mysqli_error($con));
    
  }
  /*----------12 month item individual revanu calculate & update---------------*/
  for($i = 1; $i <= 12; $i++){
    /*---------------item flash price individual item vise revanue------------------------*/
    /*---------------update item & creater individual revanue--------------------*/
    $indi_revanue_item = "SELECT SUM(`item_shipping_amount`), item_shipping_item_id FROM item_shipping WHERE item_shipping_date >= '$this_year-0$i-01' AND item_shipping_date <= '$this_year-0$i-31' GROUP BY item_shipping_item_id";
    $indi_revanue_item_result = mysqli_query($con, $indi_revanue_item) or die (mysqli_error($con));
    while ($indi_revanue_item_row = $indi_revanue_item_result-> fetch_assoc()){
      $rev_item = $indi_revanue_item_row['item_shipping_item_id'];
      /*---------------------get creator id-----------------------*/
      $item = "SELECT * FROM item WHERE item_id='$rev_item'";
      $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
      $item_row = $item_result-> fetch_assoc();
      $item_creater = $item_row['item_creator_id'];
      /*-----------------get item_by_revanue table this item id-----------------*/
      $revanue_item_id = "SELECT * FROM item_by_revanue WHERE item_by_revanue_item_id	='$rev_item' AND item_by_revanue_year='$this_year'";
      $revanue_item_id_result = mysqli_query($con, $revanue_item_id) or die (mysqli_error($con));
      $revanue_item_id_row = $revanue_item_id_result-> fetch_assoc();
      /*-----------------check this item  now avalabel or not-----------------*/
      if(mysqli_num_rows($revanue_item_id_result) > 0){
        $curren_item_rev = $indi_revanue_item_row['SUM(`item_shipping_amount`)'];
        /*-----------up date item_by_revanue table-------------*/
        $update_indi_revanue_item = "UPDATE item_by_revanue SET item_by_revanue_item_creator_id='$item_creater', m_$i='$curren_item_rev' WHERE item_by_revanue_item_id='$rev_item' AND item_by_revanue_year='$this_year'";
        $update_indi_revanue_item_result = mysqli_query($con, $update_indi_revanue_item) or die (mysqli_error($con));
      }else{
        $curren_item_rev = $indi_revanue_item_row['SUM(`item_shipping_amount`)'];
        /*------------------insert new item revanue----------------------*/
        $insert_indi_revanue_item = "INSERT INTO item_by_revanue (item_by_revanue_item_creator_id, item_by_revanue_item_id, m_$i, item_by_revanue_year)
        VALUES('$item_creater', '$rev_item', '$curren_item_rev', '$this_year')";
        $insert_indi_revanue_item_result = mysqli_query($con, $insert_indi_revanue_item) or die (mysqli_error($con));
      }
    }

    /*---------------update flash & creater individual revanue--------------------*/
    $indi_revanue_flash = "SELECT SUM(`flash_shipping_amount`), flash_shipping_item_id FROM flash_shipping WHERE flash_shipping_date >= '$this_year-0$i-01' AND flash_shipping_date <= '$this_year-0$i-31' GROUP BY flash_shipping_item_id";
    $indi_revanue_flash_result = mysqli_query($con, $indi_revanue_flash) or die (mysqli_error($con));
    while ($indi_revanue_flash_row = $indi_revanue_flash_result-> fetch_assoc()){
      $rev_flash_item = $indi_revanue_flash_row['flash_shipping_item_id'];
      /*---------------------get creator id-----------------------*/
      $item = "SELECT * FROM item WHERE item_id='$rev_flash_item'";
      $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
      $item_row = $item_result-> fetch_assoc();
      $item_creater = $item_row['item_creator_id'];
      /*-----------------get flash_by_revanue table this item id-----------------*/
      $revanue_flash_id = "SELECT * FROM flash_by_revanue WHERE flash_by_revanue_item_id	='$rev_flash_item' AND flash_by_revanue_year='$this_year'";
      $revanue_flash_id_result = mysqli_query($con, $revanue_flash_id) or die (mysqli_error($con));
      $revanue_flash_id_row = $revanue_flash_id_result-> fetch_assoc();
      /*-----------------check this flash  now avalabel or not-----------------*/
      if(mysqli_num_rows($revanue_flash_id_result) > 0){
        $curren_flash_rev = $indi_revanue_flash_row['SUM(`flash_shipping_amount`)'];
        /*-----------up date flash by_revanue table-------------*/
        $update_indi_revanue_flash = "UPDATE flash_by_revanue SET flash_by_revanue_item_creator_id='$item_creater', m_$i='$curren_flash_rev' WHERE flash_by_revanue_item_id='$rev_flash_item' AND flash_by_revanue_year='$this_year'";
        $update_indi_revanue_flash_result = mysqli_query($con, $update_indi_revanue_flash) or die (mysqli_error($con));
      }else{
        $curren_flash_rev = $indi_revanue_flash_row['SUM(`flash_shipping_amount`)'];
        /*------------------insert new flash item revanue----------------------*/
        $insert_indi_revanue_flash = "INSERT INTO flash_by_revanue (flash_by_revanue_item_creator_id, flash_by_revanue_item_id, m_$i, flash_by_revanue_year)
        VALUES('$item_creater', '$rev_flash_item', '$curren_flash_rev', '$this_year')";
        $insert_indi_revanue_flash_result = mysqli_query($con, $insert_indi_revanue_flash) or die (mysqli_error($con));
      }
    }   
  }

 /*---------------update item by quntity-------------------*/
 $item_by_qunt = "SELECT SUM(`item_shipping_quntity`), item_shipping_item_id FROM item_shipping GROUP BY item_shipping_item_id";
 $item_by_qunt_result = mysqli_query($con, $item_by_qunt) or die (mysqli_error($con));
 while ($item_by_qunt_row = $item_by_qunt_result-> fetch_assoc()){
   $item_id_qun = $item_by_qunt_row['item_shipping_item_id'];
   $item_quntity = $item_by_qunt_row['SUM(`item_shipping_quntity`)'];
   /*---------------------get creator id-----------------------*/
   $item = "SELECT * FROM item WHERE item_id='$item_id_qun'";
   $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
   $item_row = $item_result-> fetch_assoc();
   $item_creater = $item_row['item_creator_id'];
   /*-----------------get flash_by_quntity table this item id-----------------*/
   $item_by_qun_get = "SELECT * FROM item_by_quntity WHERE item_by_quntity_item_id ='$item_id_qun' AND item_by_quntity_year='$this_year'";
   $item_by_qun_get_result = mysqli_query($con, $item_by_qun_get) or die (mysqli_error($con));
   $item_by_qun_get_row = $item_by_qun_get_result-> fetch_assoc();
    /*-----------------check this flash  now avalabel or not-----------------*/
    if(mysqli_num_rows($item_by_qun_get_result) > 0){
       /*-----------up date item by_quntity table-------------*/
       $update_item_quntity = "UPDATE item_by_quntity SET item_by_quntity_creter_id='$item_creater', item_by_quntity_qun='$item_quntity' WHERE item_by_quntity_item_id='$item_id_qun' AND item_by_quntity_year='$this_year'";
       $update_item_quntity_result = mysqli_query($con, $update_item_quntity) or die (mysqli_error($con));
    }else{
       /*------------------insert new item item quntity----------------------*/
       $insert_item_quntity = "INSERT INTO item_by_quntity (item_by_quntity_item_id, item_by_quntity_creter_id, item_by_quntity_qun, item_by_quntity_year)
       VALUES('$item_id_qun', '$item_creater', '$item_quntity', '$this_year')";
       $insert_item_quntity_result = mysqli_query($con, $insert_item_quntity) or die (mysqli_error($con));
    }
 }

 /*---------------update flash by quntity-------------------*/
 $flash_by_qunt = "SELECT SUM(`flash_shipping_quntity`), flash_shipping_item_id FROM flash_shipping GROUP BY flash_shipping_item_id";
 $flash_by_qunt_result = mysqli_query($con, $flash_by_qunt) or die (mysqli_error($con));
 while ($flash_by_qunt_row = $flash_by_qunt_result-> fetch_assoc()){
   $flash_id_qun = $flash_by_qunt_row['flash_shipping_item_id'];
   $flash_quntity = $flash_by_qunt_row['SUM(`flash_shipping_quntity`)'];
   /*---------------------get creator id-----------------------*/
   $item = "SELECT * FROM item WHERE item_id='$flash_id_qun'";
   $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
   $item_row = $item_result-> fetch_assoc();
   $item_creater = $item_row['item_creator_id'];
   /*-----------------get flash_by_quntity table this item id-----------------*/
   $flash_by_qun_get = "SELECT * FROM flash_by_quntity WHERE flash_by_quntity_item_id ='$flash_id_qun' AND flash_by_quntity_year='$this_year'";
   $flash_by_qun_get_result = mysqli_query($con, $flash_by_qun_get) or die (mysqli_error($con));
   $flash_by_qun_get_row = $flash_by_qun_get_result-> fetch_assoc();
    /*-----------------check this flash  now avalabel or not-----------------*/
    if(mysqli_num_rows($flash_by_qun_get_result) > 0){
       /*-----------up date flash by_quntity table-------------*/
       $update_flash_quntity = "UPDATE flash_by_quntity SET flash_by_quntity_creater_id ='$item_creater', flash_by_quntity_qun='$flash_quntity' WHERE flash_by_quntity_item_id ='$flash_id_qun' AND flash_by_quntity_year='$this_year'";
       $update_flash_quntity_result = mysqli_query($con, $update_flash_quntity) or die (mysqli_error($con));
    }else{
       /*------------------insert new flash item quntity----------------------*/
       $insert_flash_quntity = "INSERT INTO flash_by_quntity (flash_by_quntity_item_id, flash_by_quntity_creater_id, flash_by_quntity_qun, flash_by_quntity_year)
       VALUES('$flash_id_qun', '$item_creater', '$flash_quntity', '$this_year')";
       $insert_flash_quntity_result = mysqli_query($con, $insert_flash_quntity) or die (mysqli_error($con));
    }
 }

  /*---------------update price by quntity-------------------*/
  $price_by_qunt = "SELECT SUM(`price_shipping_quntity`), price_shipping_item_id FROM price_shipping GROUP BY price_shipping_item_id";
  $price_by_qunt_result = mysqli_query($con, $price_by_qunt) or die (mysqli_error($con));
  while ($price_by_qunt_row = $price_by_qunt_result-> fetch_assoc()){
    $price_id_qun = $price_by_qunt_row['price_shipping_item_id'];
    $price_quntity = $price_by_qunt_row['SUM(`price_shipping_quntity`)'];
    /*---------------------get creator id-----------------------*/
    $item = "SELECT * FROM item WHERE item_id='$price_id_qun'";
    $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
    $item_row = $item_result-> fetch_assoc();
    $item_creater = $item_row['item_creator_id'];
    /*-----------------get price_by_quntity table this item id-----------------*/
    $price_by_qun_get = "SELECT * FROM price_by_quntity WHERE price_by_quntity_item_id ='$price_id_qun' AND price_by_quntity_year='$this_year'";
    $price_by_qun_get_result = mysqli_query($con, $price_by_qun_get) or die (mysqli_error($con));
    $price_by_qun_get_row = $price_by_qun_get_result-> fetch_assoc();
     /*-----------------check this price  now avalabel or not-----------------*/
     if(mysqli_num_rows($price_by_qun_get_result) > 0){
        /*-----------up date price by_quntity table-------------*/
        $update_price_quntity = "UPDATE price_by_quntity SET price_by_quntity_creater_id ='$item_creater', price_by_quntity_qun='$price_quntity' WHERE price_by_quntity_item_id ='$price_id_qun' AND price_by_quntity_year='$this_year'";
        $update_price_quntity_result = mysqli_query($con, $update_price_quntity) or die (mysqli_error($con));
     }else{
        /*------------------insert new price item quntity----------------------*/
        $insert_price_quntity = "INSERT INTO price_by_quntity (price_by_quntity_item_id, price_by_quntity_creater_id, price_by_quntity_qun, price_by_quntity_year)
        VALUES('$price_id_qun', '$item_creater', '$price_quntity', '$this_year')";
        $insert_price_quntity_result = mysqli_query($con, $insert_price_quntity) or die (mysqli_error($con));
     }
  }

  /*---------------update creater sold & avalbel item-------------------*/
  $creater_item = "SELECT * FROM creator";
  $creater_item_result = mysqli_query($con, $creater_item) or die (mysqli_error($con));
  while ($creater_item_row = $creater_item_result-> fetch_assoc()){
    $creater_id = $creater_item_row['creator_id'];
    /*-----------------get creater total quntity of item-----------------*/
    $item_creater_quntity = "SELECT SUM(`item_by_quntity_qun`) FROM item_by_quntity WHERE item_by_quntity_creter_id = '$creater_id' AND item_by_quntity_year='$this_year'";
    $item_creater_quntity_result = mysqli_query($con, $item_creater_quntity) or die (mysqli_error($con));
    $item_creater_quntity_row = $item_creater_quntity_result-> fetch_assoc();

    /*-----------------get creater total quntity of flash-----------------*/
    $flash_creater_quntity = "SELECT SUM(`flash_by_quntity_qun`) FROM flash_by_quntity WHERE flash_by_quntity_creater_id = '$creater_id' AND flash_by_quntity_year='$this_year'";
    $flash_creater_quntity_result = mysqli_query($con, $flash_creater_quntity) or die (mysqli_error($con));
    $flash_creater_quntity_row = $flash_creater_quntity_result-> fetch_assoc();

    /*-----------------get creater total quntity of price-----------------*/
    $price_creater_quntity = "SELECT SUM(`price_by_quntity_qun`) FROM price_by_quntity WHERE price_by_quntity_creater_id = '$creater_id' AND price_by_quntity_year='$this_year'";
    $price_creater_quntity_result = mysqli_query($con, $price_creater_quntity) or die (mysqli_error($con));
    $price_creater_quntity_row = $price_creater_quntity_result-> fetch_assoc();
    
    $sold_cre_item = $price_creater_quntity_row['SUM(`price_by_quntity_qun`)'] + $flash_creater_quntity_row['SUM(`flash_by_quntity_qun`)'] + $item_creater_quntity_row['SUM(`item_by_quntity_qun`)'];

    /*-----------up date creater sold item-------------*/
    $update_sold_quntity = "UPDATE creator SET creator_sold_iem='$sold_cre_item' WHERE creator_id='$creater_id'";
    $update_sold_quntity_result = mysqli_query($con, $update_sold_quntity) or die (mysqli_error($con));

    /*-----------------get creater total avalebel quntity-----------------*/
    $avalebel_quntity = "SELECT SUM(`item_quantity`) FROM item WHERE item_creator_id = '$creater_id'";
    $avalebel_quntity_result = mysqli_query($con, $avalebel_quntity) or die (mysqli_error($con));
    $avalebel_quntity_row = $avalebel_quntity_result-> fetch_assoc();

    $avalebel_item_quntity = $avalebel_quntity_row['SUM(`item_quantity`)'];

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
  
  header("location: ../dashboard.php");


  ?>