<?PHP include '../conection.php' ?>
<?PHP
  /*------get pass id-------*/
  $admin_mass_id = $_POST['amid'];

  /*------------update admin massage states------------*/
  $update_ad_mass = "UPDATE admin_cre_feed SET admin_cre_feed_state='See' WHERE admin_cre_feed_id = '$admin_mass_id'";
  $update_ad_mass_result = mysqli_query($con, $update_ad_mass) or die (mysqli_error($con));
  
   /*---------------------user feedback -----------------------*/
   $admin_mass_d = "SELECT * FROM admin_cre_feed WHERE admin_cre_feed_id = '$admin_mass_id'";
   $admin_mass_d_result = mysqli_query($con, $admin_mass_d) or die (mysqli_error($con));
   $admin_mass_d_row = $admin_mass_d_result-> fetch_assoc();
   $mas_admin_id = $admin_mass_d_row['admin_cre_feed_admin'];

   /*---------------user tabel--------------------*/
   $mass_admin = "SELECT * FROM user WHERE user_id= '$mas_admin_id' AND user_status='admin'";
   $mass_admin_result = mysqli_query($con, $mass_admin) or die (mysqli_error($con));
   $mass_admin_row = $mass_admin_result-> fetch_assoc();
?>
<div class="card-header">
    <h5 class="card-title"><?php echo $admin_mass_d_row['admin_cre_feed_subject'] ; ?></h5>
</div>
            <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-md-12 pl-4">
                      <div class="form-group">
                        <p><?php echo $admin_mass_d_row['admin_cre_feed_massage'] ; ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Admin Name</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo  $mass_admin_row['user_full_name'] ; ?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label>Massage Date</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo $admin_mass_d_row['admin_cre_feed_date'] ; ?>">
                      </div>
                    </div>
                  </div>
                </form>
            </div>
        