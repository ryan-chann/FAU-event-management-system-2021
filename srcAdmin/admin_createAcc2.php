<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Create New Account</title>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <?php
        require_once 'helper.php';
        /* Regex Variables */
        $passwordRegex1 = "#[0-9]+#";
        $passwordRegex2 = "#[A-Z]+#";
        $passwordRegex3 = "#[a-z]+#";

        /* Sign Up variables */
        $name = $_POST['name'];
        $contact = $_POST['contact'];
        $password = $_POST['password1'];
        $confirmPassword = $_POST['password2'];
        $email = $_POST['email'];

        /* Preg_match variables */
        $numberPass = preg_match($passwordRegex1, "$password");
        $uppercasePass = preg_match($passwordRegex2, "$password");
        $lowercasePass = preg_match($passwordRegex3, "$password");

        if (isset($_POST['submit'])) {
            if (empty($name)) {
                $name = $_POST['name'];
                $name_error = "Please enter Name";
            } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
                $name_error = "Only characters and spaces allowed";
            }

            if (empty($contact)) {
                $contact = $_POST['contact'];
                $contact_error = "Please enter Phone Number";
            } elseif (!preg_match('/^[0-9]{10,11}\z/', $contact)) {
                $contact_error = "Invalid phone number";
            }

            function isEmailExist($email) {
                $exist = false;

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $email = $con->real_escape_string($email);
                $sql = "SELECT * FROM Admin WHERE Email = '$email'";

                if ($result = $con->query($sql)) {
                    if ($result->num_rows > 0) {
                        $exist = true;
                    }
                }

                $result->free();
                $con->close();

                return $exist;
            }

            if (empty($email)) {
                $email = $_POST['email'];
                $email_error = "Please enter Email";
            } elseif (strlen($email) > 40) {
                $email_error = "Email should not more than 40 letters";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_error = "Invalid Email";
            } elseif (isEmailExist($email)) {
                $email_error = "Email has been registered.";
            }

            if (empty($password)) {
                $password = $_POST['password1'];
                $password_error = "Please enter Password";
            } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($password) < 8) {
                $password_error = "Must contain uppercase letter, lowercase letter, number and not less than 8 characters";
            }

            if (empty($confirmPassword)) {
                $confirmPassword = $_POST['password2'];
                $confirmPassword_error = "Please Re-enter Password";
            } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($confirmPassword) < 8) {
                $confirmPassword_error = "Must contain uppercase letter, lowercase letter, number and not less than 8 characters";
            }

            if (strcmp($password, $confirmPassword) != 0) {
                $confirmPassword_error = "Must match with Password";
            }

            if (empty($name_error) && empty($contact_error) && empty($email_error) && empty($password_error) && empty($confirmPassword_error)) {
                
            } else {
                require_once('admin_createAcc.php');
            }
        } else {
            require_once 'admin_createAcc.php';
        }

        require_once('helper.php');

        if (!empty($_POST)) { // Something posted back.
            if ((empty($name_error)) && (empty($contact_error)) && (empty($password_error)) && (empty($confirmPassword_error) && empty($email_error))) { // If no error.
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = '
                        INSERT INTO Admin (Name, Email, Contact, Password)
                        VALUES (?, ?, ?, ?)
                    ';
                $stm = $con->prepare($sql);
                $stm->bind_param('ssss', $name, $email, $contact, $password);
                $stm->execute();
                if ($stm->affected_rows > 0) {
                    printf('<script>swal("Create Successful!", "New account has been created", "success", {button: "OK",}).then((value) => {location.href="admin_profile.php";});;</script>');
                    // Reset fields.
                    $name = $email = $password = $confirmPassword = $contact = null;
                } else {
                    // Something goes wrong.
                    printf('<script>swal("Create Failed!", "Failed to create new account!", "error", {button: "OK",}).then((value) => {location.href="admin_createAcc.php";});;</script>');
                }

                $stm->close();
                $con->close();
                ///////////////////////////////////////////////////////////////////
                require_once 'admin_createAcc.php';
            }
        }
        ?>
    </body>
</html>