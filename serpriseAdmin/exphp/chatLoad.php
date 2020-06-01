<?PHP include '../conection.php' ?>
<?PHP
  /*------get pass id-------*/
  $admin_id = $_POST['adid'];

  session_start();

  /*---------------------login user id-----------------------*/
  $log_user_id = $_SESSION['log_admin_id'];

  /*---------------------login admin details-----------------------*/
  $log_user = "SELECT * FROM user WHERE user_id='$admin_id' AND user_status='admin'";
  $log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
  $row = $log_user_result-> fetch_assoc();

    /*---------------------chat -----------------------*/
    $chat_list = "SELECT * FROM chat WHERE (chat_sender='$log_user_id' AND chat_resever='$admin_id') OR (chat_sender='$admin_id' AND chat_resever='$log_user_id') ORDER BY chat_id DESC";
    $chat_list_result = mysqli_query($con, $chat_list) or die (mysqli_error($con));

    /*-----------up date chat state-------------*/
    $update_chat_stae = "UPDATE chat SET chat_state ='see' WHERE chat_sender='$admin_id'";
    $update_chat_stae_result = mysqli_query($con, $update_chat_stae) or die (mysqli_error($con));


    echo '<div class="col-md-12">
    <div class="card">
        <div class="card-header">
        <h4 class="card-title"> '.$row['user_full_name'].'</h4>
        </div>
        <div class="card-body">
        <div class="table-responsive" id="max_tabel_hight">
            <table class="table">
                <thead class=" text-primary">
                    <th>
                    
                    </th>
                    <th class="text-right">
                  
                    </th>
                </thead>
                <tbody>';
            
                    while ($chat_list_row = $chat_list_result-> fetch_assoc()){
                        if($chat_list_row['chat_sender'] == $log_user_id){
                            echo '<tr>
                            <td class="chat_my_mass" id="table_row">
                                '.$chat_list_row['chat_message'].'
                            </td>
                                <td class="text-right" id="table_row">
                                    
                                </td>
                            </tr>';

                        }else{
                            echo '<tr>
                            <td id="table_row">
                                
                            </td>
                            <td class="chat_fre_mass" id="table_row">
                                '.$chat_list_row['chat_message'].'
                            </td>
                            </tr>';

                        }
                    }
                
                echo'</tbody>
            </table>
          </div>
        </div>
          <form action="chat.php" method="post" enctype = "multipart/form-data">
            <div class="col-md-12 pr-8">
                <div class="form-group">
                <input type="text" name="chat_mess" class="form-control" placeholder="Your Massage">
                <input type="hidden" name="resever_id" class="form-control" value="'.$admin_id.'">
                </div>
            </div>
            <div class="row">
              <div class="update ml-auto mr-auto">
                <button type="submit" name="submit" class="btn btn-primary btn-round"><i class="nc-icon nc-send"></i></button>
              </div>
            </div>
          </form>
      </div>
    </div>';
?> 