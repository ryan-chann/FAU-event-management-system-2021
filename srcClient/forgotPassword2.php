<?php
include_once('helper.php');
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>FAU - Forgot Password</title>
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body>
        <?php
        if (isset($_POST['fpSubmit'])) {
            /* Forgot Password Variables */
            $email = trim(filter_input(INPUT_POST, 'forgotPassword'));


            //Set connection to phpMyAdmin
            $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

            //Write sql query statement for executing later
            $sql = "SELECT * FROM user 
            WHERE Email = '$email'";

            //Set result to execute "$sql" query statement on "$connection"'s database 
            $result = $connection->query($sql);

            //If there is any rows returned
            if ($result->num_rows > 0) {
                //While Loop to fetch the data
                while ($row = $result->fetch_object()) {
                    //Set password with the data from the database
                    $password = $row->Password;
                }
                $subject = "Forgot Password";
                $headers = "From: TARUC FAU";
                $message = "Your Password is : $password";
                $return = mail($email, $subject, $message, $headers);

                $email = '';

                //Close Connection
                $connection->close();

                echo '
<script>
alert(\'Email sent, If there is no email received please contact us. (Make sure to check your spam too) \');
location.replace(\'logIn.php\');
</script>
';
            } else if (empty($email)) {
                echo '
<script>
alert(\'Please enter email address \');
location.replace(\'forgotPassword.php\');
</script>
';
            } else {
                echo '
<script>
alert(\'There is no account registered with the email given. \');
location.replace(\'forgotPassword.php\');
</script>
';
            }
        }
        ?>
    </body>
</html>
