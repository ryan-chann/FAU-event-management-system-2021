<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Admin Profile</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_edit.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            .form_container{
                height: 500px;
                width: 450px;
            }

            form{
                height: 500px;
                width: 450px;
                margin: 50px 0px 0px 350px;
            }

            #name, #password, #conPwd, #contact{
                width: 430px;
                font-size: 16px;
                height: 30px;
                margin-bottom: 10px;
                padding-left: 10px;
            }

            #cancel{
                margin-left: 70px;
                height: 35px;
                margin-top: 10px;
                font-size: 18px;
                width: 100px;
                border: none;
                color: white;
                background-color: rgb(230, 149, 106);
            }

            #cancel:hover{
                background-color: rgba(230, 149, 106, 0.7);
            }
        </style>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>
            <?php
            require_once('helper.php');

            $hideForm = false;

            // --> Retrieve Student record based on the passed AdminID.
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                // Read query string --> AdminID.
                $id = strtoupper(trim($_GET['id']));

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $id = $con->real_escape_string($id); // escape those character that sensitive in sql query statement
                $sql = "SELECT * FROM Admin WHERE AdminID = '$id'";

                $result = $con->query($sql);
                if ($row = $result->fetch_object()) {
                    $id = $row->AdminID;
                    $name = $row->Name;
                    $email = $row->Email;
                    $contact = $row->Contact;
                    $password = $row->Password;
                    $conPwd = $row->Password;
                } else {
                    echo '
                <div class="error">
                Opps. Record not found.
                [ <a href="admin_profile.php">Back to Profile</a> ]
                </div>
                ';

                    $hideForm = true; // Flag, "true" to hide the form.
                }

                $result->free();
                $con->close();
            }
            // --> Update the record.
            else {
                $id = strtoupper(trim($_GET['id']));
                $name = trim($_POST['name']);
                $contact = trim($_POST['contact']);
                $password = trim($_POST['password']);
                $conPwd = trim($_POST['conPwd']);

                // Validations:
                // ------------
                // Validation functions are defined at "helper.php".
                // I don't validate StudentID (PK) as it is not being updated.
                // Can check the existence of the StudentID if wanted to.

                /* Regex Variables */
                $passwordRegex1 = "#[0-9]+#";
                $passwordRegex2 = "#[A-Z]+#";
                $passwordRegex3 = "#[a-z]+#";

                /* Sign Up variables */
                $name = $_POST['name'];
                $contact = $_POST['contact'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['conPwd'];

                /* Preg_match variables */
                $numberPass = preg_match($passwordRegex1, "$password");
                $uppercasePass = preg_match($passwordRegex2, "$password");
                $lowercasePass = preg_match($passwordRegex3, "$password");

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

                if (empty($password)) {
                    $password = $_POST['password'];
                    $password_error = "Please enter Password";
                } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($password) < 8) {
                    $password_error = "Must contain uppercase letter, lowercase letter, number and not less than 8 characters";
                }

                if (empty($conPwd)) {
                    $conPwd = $_POST['conPwd'];
                    $conPwd_error = "Please Re-enter Password";
                } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($confirmPassword) < 8) {
                    $conPwd_error = "Must contain uppercase letter, lowercase letter, number and not less than 8 characters";
                }

                if (strcmp($password, $conPwd) != 0) {
                    $conPwd_error = "Must match with Password";
                }

                if (empty($name_error) && empty($contact_error) && empty($password_error) && empty($conPwd_error)) {
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = '  
                UPDATE Admin SET
                Name = ?, Contact = ?, Password = ?
                WHERE AdminID = ?
            ';
                    $stm = $con->prepare($sql);
                    $stm->bind_param('ssss', $name, $contact, $password, $id);

                    if ($stm->execute()) {
                        if ($stm->execute()) {
                            printf('<script>swal("Edit Successful!", "Record has been edited, \n Please log out and log in again to view changes", "success", {button: "OK",}).then((value) => {location.href="admin_profile.php";});;</script>');
                        } else {
                            printf('<script>swal("Edit failed!", "Oops! Database issues", "error", {button: "OK",}).then((value) => {location.href="admin_profile.php";});;</script>');
                        }
                    }

                    $stm->close();
                    $con->close();
                }
            }
            ?>
            <?php if ($hideForm == false) : // Hide or show the form.   ?>

                <form action="" method="post">
                    <h3 style="margin-left:80px;">Edit Admin Account</h3>

                    <label for="name">Name :</label></td><br>
                <?php htmlInputText('name', $name, 40) ?><br>
                <?php
                if (isset($name_error)) {
                    echo "<div class='alert alert-danger'><strong>$name_error</strong>";
                }
                ?>
                <br>
                <label for="contact">Contact :</label><br>
                <?php htmlInputText('contact', $contact, 40) ?><br>
                <?php
                if (isset($contact_error)) {
                    echo "<div class='alert alert-danger'><strong>$contact_error</strong>";
                }
                ?>
                <br>
                <label for="password">Password :</label><br>
                <?php htmlInputPassword('password', $password, 30) ?><br>
                <?php
                if (isset($password_error)) {
                    echo "<div class='alert alert-danger'><strong>$password_error</strong>";
                }
                ?>
                <br>
                <label for="conPwd">Re-Enter Password :</label><br>
                <?php htmlInputPassword('conPwd', $conPwd, 30) ?><br>
                <?php
                if (isset($conPwd_error)) {
                    echo "<div class='alert alert-danger'><strong>$conPwd_error</strong>";
                }
                ?>
                <br><br>

                <br />
                <input type="submit" id="submit" name="update" value="Update" />
                <input type="button" id="cancel" value="Cancel" onclick="location = 'admin_profile.php'" />
            </form>
        <?php endif ?>
    </div>
    <?php
} else {
    header('location: admin_login.php');
}
?>
<?php include 'admin_footer.php'; ?>
