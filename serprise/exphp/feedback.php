<?PHP include 'conection.php' ?>
<?PHP
session_start();
/*---------------------login user id-----------------------*/
$log_user_id = $_SESSION['log_user_id'];

/*---------------------login user details-----------------------*/
$log_user = "SELECT * FROM user WHERE user_id='$log_user_id' AND user_status='user'";
$log_user_result = mysqli_query($con, $log_user) or die (mysqli_error($con));
$row = $log_user_result-> fetch_assoc();
$username = $row['user_username'];
    /*----------click send---------------*/
    if(isset($_POST["submit_feedback"])){
        $message = $con->real_escape_string($_POST['message']);
        $name = $con->real_escape_string($_POST['name']);
        $email = $con->real_escape_string($_POST['email']);
        $subject = $con->real_escape_string($_POST['subject']);
        /*----------form validation------------------------*/
        if(!empty($message) && !empty($name) && !empty($email) && !empty($subject)){
            if(preg_match("/^[a-zA-Z -]+$/",$name)){
                if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $insert_feedback = "INSERT INTO user_feedback (user_feedback_user_id, user_feedback_subject, user_feedback_message, user_feedback_user_name, user_feedback_name, user_feedback_email, user_feedback_state)
                    VALUES('$log_user_id', '$subject', '$message', '$username', '$name', '$email', 'Active')";
                    $insert_feedback_result = mysqli_query($con, $insert_feedback) or die (mysqli_error($con));
                }else{

                }
            }else{

            }
        }else{

        }
    }
?>