<?PHP include '../conection.php' ?>
<?PHP
    session_start();
    /*-------all session remove--------*/
    session_unset();
    /*-------all session distroy--------*/
    session_destroy();
    /*-------load index page--------*/
    header("location: ../../serpriseAdmin/index2.php");
?>