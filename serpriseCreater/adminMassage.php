<?PHP include 'conection.php' ?>
<?PHP
  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['creater_id'];

  /*---------------------login creater details-----------------------*/
  $log_user = "SELECT * FROM creator WHERE creator_id='$log_user_id'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

  /*---------------------user feedback -----------------------*/
  $admin_mass = "SELECT * FROM admin_cre_feed WHERE admin_cre_feed_cre_id='$log_user_id' ORDER BY admin_cre_feed_id DESC";
  $admin_mass_result = mysqli_query($con, $admin_mass) or die (mysqli_error($con));
  
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
          <p id="user_name"> Massage List</p>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <?php
            while ($admin_mass_row = $admin_mass_result-> fetch_assoc()){
              $ab_mass_id =$admin_mass_row['admin_cre_feed_id'];
              if($admin_mass_row['admin_cre_feed_state'] == 'Active'){
                echo'<li class="active" id="fedb_list_active">';
              }else{
                echo'<li id="fedb_list_see">';
              }
                echo'<a data-admassid='.$ab_mass_id.' class="admas">
                  <p>'.$admin_mass_row['admin_cre_feed_subject'].'</p>
                </a>
              </li>';
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
            <a class="navbar-brand" href="">Admin Massage</a>
          </div>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link btn-rotate" href="indexCre.php">
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
            <div class="card card-user" id="admass_deatails"> 
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
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This web site is made by <a href="add.php">Suprisc.lk team </a>
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

            $('.admas').click(function(){
   
                var amid = $(this).data('admassid');
                // pass feedback id
                $.ajax({
                    url: 'exphp/loadmass.php',
                    type: 'post',
                    data: {amid: amid},
                    success: function(response){ 
                        
                        $('#admass_deatails').html(response); 

                    }
                }); 
            });
        }); 
  </script>
</body>

</html>
