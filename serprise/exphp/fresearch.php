<?PHP include '../conection.php' ?>
<?php
/*------get pass search string-------*/
$searchtxt = $con->real_escape_string($_GET["search"]);

            /*------get item-------*/
              $item="SELECT * FROM item WHERE item_catagory_code='fre007' AND item_name LIKE'%$searchtxt%' LIMIT 25";
              $item_result = mysqli_query($con, $item) or die (mysqli_error($con));
              /*------check item emty-------*/
              echo'<h1 class="item_cont_heder">You have '.mysqli_num_rows($item_result).' Result</h1>';
              echo '<div class="row" id="all_item">';
              if(mysqli_num_rows($item_result) > 0){
                /*------display item-------*/
                while ($row = $item_result-> fetch_assoc()){
                    $item_id = $row['item_id'];
                    /*---------------reviwe --------------------*/
                    $reviwe_item = "SELECT COUNT(`item_shipping_user_id`), item_shipping_user_id FROM item_shipping WHERE item_shipping_item_id='$item_id' GROUP BY item_shipping_user_id";
                    $reviwe_item_result = mysqli_query($con, $reviwe_item) or die (mysqli_error($con));
                    $reviwe_item_count =0;
                    while ($reviwe_item_row = $reviwe_item_result-> fetch_assoc()){
                        $reviwe_item_count = $reviwe_item_count+1;
                    }
                    /*------check item have-------*/
                    if($row['item_quantity'] == 0){
                        /*------dispay all sold item-------*/
                        echo '<a href="catsearchdiss.php?item_id='.$item_id.'" ><div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                            <div class="single_place">
                                <div class="thumb">
                                    <img src="'.$row['item_image'].'" alt="None">
                                    <a class="prise">Rs:'.$row['item_price'].'</a>';
                                    /*------check can custom or not-------*/
                                    if($row['item_custom'] == 'yes'){
                                        echo '<a class="custom"  href="#">Custom</a>';
                                    }else{

                                    }
                                echo '</div>
                                <div class="place_info">
                                    <a href="catsearchdiss.php?item_id='.$item_id.'" ><h3>'.$row['item_name'].'</h3></a>
                                    <p>'.$row['item_discription'].'</p>
                                    <div class="rating_days d-flex justify-content-between">
                                        <span class="d-flex justify-content-center align-items-center">';
                                        /*------check star rate-------*/
                                        if($row['item_sale_rate'] == 0){
                                            echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                            }else{
                                                if($row['item_sale_rate'] == 1){
                                                    echo '<i class="fa fa-star"></i> ';
                                                }else{
                                                    if($row['item_sale_rate'] == 2){
                                                        echo '<i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i>';
                                                    }else{
                                                        if($row['item_sale_rate'] == 3){
                                                            echo '<i class="fa fa-star"></i> 
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>';
                                                        }else{
                                                            if($row['item_sale_rate'] == 4){
                                                                echo '<i class="fa fa-star"></i> 
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>';
                                                            }else{
                                                                if($row['item_sale_rate'] == 5){
                                                                    echo '<i class="fa fa-star"></i> 
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>';
                                                                }else{
                                                                    echo '<i class="fa fa-star"></i> 
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>';
                        
                                                                }
                    
                                                            }
                
                                                        }
            
                                                    }
        
                                                }
                                            } 
                                            echo '<a href="#" id="bad_reat">(All Sold)</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </a>';
                    /*------load avalabel item-------*/
                    }else{

                        echo '<a href="catsearchdiss.php?item_id='.$item_id.'" ><div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
                            <div class="single_place">
                                <div class="thumb">
                                    <img src="'.$row['item_image'].'" alt="None">
                                    <a class="prise" >Rs:'.$row['item_price'].'</a>';
                                    /*------check can custom or not-------*/
                                    if($row['item_custom'] == 'yes'){
                                        echo '<a class="custom" href="#">Custom</a>';
                                    }else{

                                    }
                                echo '</div>
                                <div class="place_info">
                                    <a href="catsearchdiss.php?item_id='.$item_id.'" ><h3>'.$row['item_name'].'</h3></a>
                                    <p>'.$row['item_discription'].'</p>
                                    <div class="rating_days d-flex justify-content-between">
                                        <span class="d-flex justify-content-center align-items-center">';
                                        /*------star rate-------*/
                                        if($row['item_sale_rate'] == 0){
                                            echo '<i id="bad_reat" class="fa fa-star"></i> ';
                                            }else{
                                                if($row['item_sale_rate'] == 1){
                                                    echo '<i class="fa fa-star"></i> ';
                                                }else{
                                                    if($row['item_sale_rate'] == 2){
                                                        echo '<i class="fa fa-star"></i> 
                                                            <i class="fa fa-star"></i>';
                                                    }else{
                                                        if($row['item_sale_rate'] == 3){
                                                            echo '<i class="fa fa-star"></i> 
                                                                <i class="fa fa-star"></i>
                                                                <i class="fa fa-star"></i>';
                                                        }else{
                                                            if($row['item_sale_rate'] == 4){
                                                                echo '<i class="fa fa-star"></i> 
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>
                                                                    <i class="fa fa-star"></i>';
                                                            }else{
                                                                if($row['item_sale_rate'] == 5){
                                                                    echo '<i class="fa fa-star"></i> 
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>';
                                                                }else{
                                                                    echo '<i class="fa fa-star"></i> 
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>
                                                                        <i class="fa fa-star"></i>';
                        
                                                                }
                    
                                                            }
                
                                                        }
            
                                                    }
        
                                                }
                                            } 
                                            echo '<a href="#">('.$reviwe_item_count.' Review)</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>';

                    }
                }
            }
            
  ?> 
  