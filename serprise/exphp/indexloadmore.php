<?PHP include '../conection.php' ?>
<?php
/*------get pass count-------*/
$cou_N= $_POST['cou_N'];
            /*------get item-------*/
              $item="SELECT * FROM item LIMIT $cou_N";
              $item_result = mysqli_query($con, $item) or die (mysqli_error($con));

              echo'<h1 class="item_cont_heder">More item for Click More item button</h1>';
              echo '<div class="row" id="all_item">';
              /*------check item emty-------*/
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
                        echo '<a data-itemid='.$item_id.' class="item"><div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
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
                                    <a data-itemid='.$item_id.' class="item"><h3>'.$row['item_name'].'</h3></a>
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

                        echo '<a data-itemid='.$item_id.' class="item"><div class="col-lg-41 col-md-6" data-toggle="modal" data-target="#logeModalCenter" href="#">
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
                                    <a data-itemid='.$item_id.' class="item"><h3>'.$row['item_name'].'</h3></a>
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


<!--item discription content-->
  <div class="modal fade custom_search_pop" id="itemeModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
    <div class="modal-dialog" id="model_d" role="document">
        <div class="model_body">
        </div>
    </div>
  </div>

  <script type='text/javascript'>
            //load item description
            $(document).ready(function(){
   
               $('.item').click(function(){
      
                   var flashid = $(this).data('itemid');
                    //load loaditemdis.php & pass item id
                   $.ajax({
                       url: 'exphp/loaditemdis.php',
                       type: 'post',
                       data: {flashid: flashid},
                       success: function(response){ 
                           
                           $('.model_body').html(response); 
   
                           $('#itemeModalCenter').modal('show'); 
                       }
                   }); 
               });
           });   
 </script>