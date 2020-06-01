<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  if(isset($_GET['chatid'])){
    /*------get pass id-------*/
    $chat_id = $_GET['chatid'];
  }
  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------user feedback -----------------------*/
  $chat_admi = "SELECT * FROM user WHERE  user_status='admin' AND user_id != '$log_user_id'";
  $chat_admi_result = mysqli_query($con, $chat_admi) or die (mysqli_error($con));

  if(isset($_POST["submit"])){
    /*----------get form data------------------------*/
    $message = $con->real_escape_string($_POST['chat_mess']);
    $resever_id = $con->real_escape_string($_POST['resever_id']);
    if(!empty($message)){
      /*-----------insert message-------------*/
      $today = date("Y-m-d");
      $insert_mess = "INSERT INTO chat (chat_date, chat_sender, chat_resever, chat_message, chat_state)
      VALUES('$today', '$log_user_id', '$resever_id', '$message', 'Active')";
      $insert_mess_result = mysqli_query($con, $insert_mess) or die (mysqli_error($con));
    }else{
     
    }
  }
  
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="favicon" sizes="76x76" href="img/favicon.png.png">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>Surprise.lk/admin/user</title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="css/style.css" rel="stylesheet" />
  <link href="demo/demo.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a href="" class="simple-text logo-normal">
          <p id="user_name">Admin List</p>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <?php
            while ($chat_admi_row = $chat_admi_result-> fetch_assoc()){
              $admin_id =$chat_admi_row['user_id'];
              /*--------------------- admin chat-----------------------*/
              $chat = "SELECT COUNT(`chat_id`) FROM chat WHERE chat_sender='$admin_id' AND chat_resever='$log_user_id' AND chat_state = 'Active'";
              $chat_result = mysqli_query($con, $chat) or die (mysqli_error($con));
              $chat_row = $chat_result-> fetch_assoc();
              if($chat_row['COUNT(`chat_id`)'] >= 1){
                echo'<li class="active" id="fedb_list_active">
                  <a data-adminid='.$admin_id.' class="adminlist">
                    <div class="avatar">
                      <img src="'.$chat_admi_row['user_image'].'" alt="" class="img-circle img-no-padding img-responsive" id="admin_chat_img"> ' .$chat_admi_row['user_username'].'
                    </div>
                  </a>
                </li>';
              }else{
                echo'<li id="fedb_list_see">
                <a data-adminid='.$admin_id.' class="adminlist">
                  <div class="avatar">
                    <img src="'.$chat_admi_row['user_image'].'" alt="" class="img-circle img-no-padding img-responsive" id="admin_chat_img"> ' .$chat_admi_row['user_username'].'
                  </div>
                </a>
              </li>';
              }
            }
          ?>
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <a class="navbar-brand" href="">Admin Chat </a>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="dashboard.php">
                  <i class="nc-icon nc-minimal-left"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card card-user" id="cahatdetails"> 
              <i class="nc-icon nc-satisfied" id="fedb_con"></i>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer footer-black  footer-white ">
        <div class="container-fluid">
          <div class="row">
            <div class="credits ml-auto">
              <span class="copyright">
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="../serpriseCreater/add.php">Suprisc.lk team </a>
              </span>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!--   js   -->
  <script src="js/core/jquery.min.js"></script>
  <script src="js/core/popper.min.js"></script>
  <script src="js/core/bootstrap.min.js"></script>
  <script src="js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="js/plugins/chartjs.min.js"></script>
  <script src="js/plugins/bootstrap-notify.js"></script>
  <script src="js/paper-dashboard.min.js?v=2.0.0" type="text/javascript"></script>
  <script src="demo/demo.js"></script>
  <script type='text/javascript'>
        // load feedback details
         $(document).ready(function(){

            $('.adminlist').click(function(){
   
                var adid = $(this).data('adminid');
                // pass feedback id
                $.ajax({
                    url: 'exphp/chatLoad.php',
                    type: 'post',
                    data: {adid: adid},
                    success: function(response){ 
                        
                        $('#cahatdetails').html(response); 

                    }
                }); 
            });
        }); 

</script>
<script type='text/javascript'>
        // load feedback details
         $(document).ready(function(){

                var adid = <?php echo $resever_id; ?>;
                // pass feedback id
                $.ajax({
                    url: 'exphp/chatLoad.php',
                    type: 'post',
                    data: {adid: adid},
                    success: function(response){ 
                        
                        $('#cahatdetails').html(response); 

                    }
                }); 
        }); 

  </script>
  <script type='text/javascript'>
        // load feedback details
         $(document).ready(function(){

                var adid = <?php echo $chat_id; ?>;
                // pass feedback id
                $.ajax({
                    url: 'exphp/chatLoad.php',
                    type: 'post',
                    data: {adid: adid},
                    success: function(response){ 
                        
                        $('#cahatdetails').html(response); 

                    }
                }); 
        }); 

  </script>
</body>

</html>
