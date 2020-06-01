<?PHP include '../conection.php' ?>
<?PHP
  /*------get pass id-------*/
  $feedb_id = $_POST['fdid'];

  /*------------update feedback states------------*/
  $update_fdb_s = "UPDATE user_feedback SET user_feedback_state='See' WHERE user_feedback_id = '$feedb_id'";
  $update_fdb_s_result = mysqli_query($con, $update_fdb_s) or die (mysqli_error($con));
  
   /*---------------------user feedback -----------------------*/
   $user_fedb_det = "SELECT * FROM user_feedback WHERE user_feedback_id = '$feedb_id'";
   $user_fedb_det_result = mysqli_query($con, $user_fedb_det) or die (mysqli_error($con));
   $user_fedb_det_row = $user_fedb_det_result-> fetch_assoc();
   $fdb_user_id = $user_fedb_det_row['user_feedback_user_id'];

   /*---------------user tabel--------------------*/
   $fdb_user = "SELECT * FROM user WHERE user_id= '$fdb_user_id'";
   $fdb_user_result = mysqli_query($con, $fdb_user) or die (mysqli_error($con));
   $fdb_user_row = $fdb_user_result-> fetch_assoc();
?>
<div class="card-header">
    <h5 class="card-title"><?php echo $user_fedb_det_row['user_feedback_name'] ; ?></h5>
</div>
            <div class="card-body">
                <form>
                  <div class="row">
                    <div class="col-md-12 pl-4">
                      <div class="form-group">
                        <p><?php echo $user_fedb_det_row['user_feedback_message'] ; ?></p>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Account Owner Name</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo  $fdb_user_row['user_full_name'] ; ?>">
                      </div>
                    </div>
                    <div class="col-md-6 pl-1">
                      <div class="form-group">
                        <label>Feedback Email</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo $user_fedb_det_row['user_feedback_email'] ; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="" value="<?php echo  $fdb_user_row['user_address'] ; ?>">
                      </div>
                    </div>
                  </div>
                </form>
            </div>
        