<?PHP include '../conection.php' ?>
<?PHP
session_start();

/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_user_id'];

/*---------------------login user details-----------------------*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$row = $log_user_result-> fetch_assoc();

/*---------------all item --------------------*/

$item = "SELECT * FROM item WHERE item_catagory_code='alb006' LIMIT 8";
$item_result = mysqli_query($con, $item) or die (mysqli_error($con));

/*---------------creator --------------------*/

$creator = "SELECT * FROM creator LIMIT 6";
$creator_result = mysqli_query($con, $creator) or die (mysqli_error($con));

?>

<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Surprise.lk/catagory.html</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    

    <!-- CSS-->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/flaticon.css">
    <link rel="stylesheet" href="css/gijgo.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slicknav.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css">

    <link rel="stylesheet" href="css/style.css">


</head>

<body>
    <div class="sub_cat_dev">
            <div class="sub_cat_head">
                <h1>Surprise Album</h1>
            </div>
            <div class="sub_cat_seach">
                    <input id="inputer" type="text" name="" placeholder="Seach All" onkeyup="search(this.value)">
                    <i class="fa fa-search"></i>
            </div>
            <div class="container">
                <div class="popular_places_area" id="nocolor">
                    <div class="container" id="item_content">
                        <?php
                            /*----------------all item tabel avalabel item-------------------*/
                                if(mysqli_num_rows($item_result) > 0){
                                    echo'<h1 class="item_cont_heder">More item for Click More item button</h1>';
                                    echo '<div class="row" id="all_item">';
                                    while ($row = $item_result-> fetch_assoc()){
                                        $item_id = $row['item_id'];
                                        /*---------------reviwe --------------------*/
                                        $reviwe_item = "SELECT COUNT(`item_shipping_user_id`), item_shipping_user_id FROM item_shipping WHERE item_shipping_item_id='$item_id' GROUP BY item_shipping_user_id";
                                        $reviwe_item_result = mysqli_query($con, $reviwe_item) or die (mysqli_error($con));
                                        $reviwe_item_count =0;
                                        while ($reviwe_item_row = $reviwe_item_result-> fetch_assoc()){
                                            $reviwe_item_count = $reviwe_item_count+1;
                                        }
                                         /*----------------all item quantity no one ro more-------------------*/
                                        if($row['item_quantity'] == 0){
                                            
                                            echo '<a data-itemid='.$item_id.' class="item"><div class="col-lg-41 col-md-6" >
                                                <div class="single_place">
                                                    <div class="thumb">
                                                        <img src="'.$row['item_image'].'" alt="None">
                                                        <a class="prise" >Rs:'.$row['item_price'].'</a>';
                                                        /*----------------all item can custom-------------------*/
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
                                                             /*----------------all item star rate-------------------*/
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
                                        /*----------------all item quantity have one ro more-------------------*/
                                        }else{

                                            echo '<a data-itemid='.$item_id.' class="item"><div class="col-lg-41 col-md-6" href="exphp/itemdiss.php">
                                                <div class="single_place">
                                                    <div class="thumb">
                                                        <img src="'.$row['item_image'].'" alt="None">
                                                        <a class="prise" >Rs:'.$row['item_price'].'</a>';
                                                        /*----------------all item can custom-------------------*/
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
                                                            /*----------------all item star rate-------------------*/
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
                                /*----------------all item tabel not avalabel item-------------------*/
                                }else{
                                    echo '<h1 class="tabel_emty_error">No item in here </h1>';
                                }
                       ?>
                    </div>
                    <hr class="hrone1"/>
                </div>
            </div>
                <!--more button -->
                <div class="morebutton">
                    <div class="col-lg-12">
                        <div class="more_place_btn text-center">
                            <a class="boxed-btn4" ><div id="load_more_button">More item</div></a>
                        </div>
                    </div>
                </div>             
            </div>
        </div>
    </div>

    <!--item discription-->
    <div class="modal fade custom_search_pop" id="itemeModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
        <div class="modal-dialog" id="model_d" role="document">
            <div class="model_body">
            </div>
        </div>
    </div>

<script src="js/vendor/modernizr-3.5.0.min.js"></script>
<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/isotope.pkgd.min.js"></script>
<script src="js/ajax-form.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/imagesloaded.pkgd.min.js"></script>
<script src="js/scrollIt.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/nice-select.min.js"></script>
<script src="js/jquery.slicknav.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/plugins.js"></script>
<script src="js/gijgo.min.js"></script>
<script src="js/slick.min.js"></script>

<script src="js/contact.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/mail-script.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script type='text/javascript'>
    // load more button function
    $(document).ready(function(){
            // first count
            var cou=8;
            $(".boxed-btn4").click(function(){
                //pass count
                cou=cou+8;
                $("#item_content").load("exphp/albemloadmore.php",{
                    cou_N:cou
                });
            });
        });

    function search(str) {
        if (str.length==0) {
            document.getElementById("item_content").innerHTML="";
        
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else {  // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
            document.getElementById("item_content").innerHTML=this.responseText
            }
        }
        xmlhttp.open("GET","exphp/albemsearch.php?search="+str,true);
        xmlhttp.send();
    }

    // load item details
    $(document).ready(function(){

        $('.item').click(function(){

            var flashid = $(this).data('itemid');
            // pass item id
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

</body>

</html>