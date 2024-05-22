<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if (!isset($_POST['submit'])) {
    $studentId = "";
    $email = "";
    $phone = "";
    $username = "";
    $gender = "";
    $faculty = "";
    $password = "";
    $conPwd = "";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add User Record</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_edit.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            #studentId, #email, #conPwd, #password, #username, #phone, #faculty{
                width: 380px;
                font-size: 16px;
                height: 30px;
                padding-left: 10px;
            }

            .form_container{
                height: 500px;
            }

            form{
                height: 500px;
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
            <div class="header">
                <h3>User Record</h3>
                <nav class="record_nav">
                    <a href="admin_user_record.php" name="view" id="view">View</a>
                    <a href="insert_user.php" name="add" id="add">Add</a>
                    <a href="search_user.php" name="search" id="search">Search</a>
                </nav>
            </div>
            <div class="form_container">
                <?php
                require_once('helper.php');

                $hideForm = false;

                // --> Retrieve Student record based on the passed StudentID.
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    // http://localhost/Practical5/edit-student.php?id=10abc00003
                    // Read query string --> StudentID.
                    $id = strtoupper(trim($_GET['id']));

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $id = $con->real_escape_string($id); // escape those character that sensitive in sql query statement
                    $sql = "SELECT * FROM User WHERE StudentID = '$id'";

                    $result = $con->query($sql);
                    if ($row = $result->fetch_object()) {
                        $id = $row->StudentID;
                        $email = $row->Email;
                        $password = $row->Password;
                        $conPwd = $row->Password;
                        $username = $row->Name;
                        $phone = $row->Phone;
                        $gender = $row->Gender;
                        $faculty = $row->Faculty;
                    } else {
                        echo '
                <div class="error">
                Opps. Record not found.
                [ <a href="admin_user_record.php">Back to list</a> ]
                </div>
                ';

                        $hideForm = true; // Flag, "true" to hide the form.
                    }

                    $result->free();
                    $con->close();
                }
                // --> Update the record.
                else {
                    $id = strtoupper(trim($_POST['id']));
                    $email = trim($_POST['email']);
                    $phone = trim($_POST['phone']);
                    $username = trim($_POST['username']);
                    $gender = $_POST['gender'];
                    $faculty = $_POST['faculty'];

                    // Validations:
                    // ------------
                    // Validation functions are defined at "helper.php".
                    // I don't validate StudentID (PK) as it is not being updated.
                    // Can check the existence of the StudentID if wanted to.

                    if (empty($email)) {
                        $email = $_POST['email'];
                        $email_error = "Please enter Email";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $email_error = "Invalid Email";
                    }

                    if (empty($username)) {
                        $username = $_POST['username'];
                        $username_error = "Please enter Name";
                    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
                        $username_error = "Only characters and spaces allowed";
                    }

                    if (empty($phone)) {
                        $phone = $_POST['phone'];
                        $phone_error = "Please enter Phone Number";
                    } elseif (getPhoneNumberValidation($phone) != NULL) {
                        $phone_error = "Invalid phone number";
                    }

                    if (empty($email_error) && empty($username_error) && empty($phone_error)) {
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = '  
                UPDATE User SET
                Name = ?,
                Email = ?,
                Phone = ?,
                Gender = ?,
                Faculty = ?
                WHERE StudentID = ?
            ';
                        $stm = $con->prepare($sql);
                        $stm->bind_param('ssssss', $username, $email, $phone, $gender, $faculty, $id);


                        if ($stm->execute()) {
                            printf('<script>swal("Edit Successful!", "Record has been edited!", "success", {button: "OK",}).then((value) => {location.href="admin_user_record.php";});;</script>');
                        } else {
                            printf('<script>swal("Edit Failed!", "Opps! Database issues.", "error", {button: "OK",}).then((value) => {location.href="edit_user.php";});;</script>');
                        }

                        $stm->close();
                        $con->close();
                    }
                }
                ?>
                <?php if ($hideForm == false) : // Hide or show the form.    ?>

                    <form action="" method="post">
                        <h3 style="margin-left:110px;">Edit User Record</h3>
                        <label for="id">Student ID :</label></td>

                        <?php echo $id ?>
                        <?php htmlInputHidden('id', $id) // Hidden field.   ?>
                        <br><br>

                        <label for="username">Name :</label></td>
                        <?php htmlInputText('username', $username, 40) ?>
                        <?php
                        if (isset($username_error)) {
                            echo "<div class='alert alert-danger'><strong>$username_error</strong>";
                        }
                        ?>
                        <br><br>
                        <label for="email">Email :</label></td>
                        <?php htmlInputEmail('email', $email) ?>
                        <?php
                        if (isset($email_error)) {
                            echo "<div class='alert alert-danger'><strong>$email_error</strong>";
                        }
                        ?>
                        <br><br>
                        <label for="phone">Phone Number :</label></td>
                        <?php htmlInputPhone('phone', $phone) ?>
                        <?php
                        if (isset($phone_error)) {
                            echo "<div class='alert alert-danger'><strong>$phone_error</strong>";
                        }
                        ?>

                        <br><br>
                        <label for="gender">Gender :</label>
                        <?php htmlRadioList('gender', $GENDER, $gender) ?>
                        <?php
                        if (isset($gender_error)) {
                            echo "<div class='alert alert-danger'>$gender_error</div>";
                        }
                        ?>

                        <br><br>
                        <label for="faculty">Faculty :</label>
                        <?php htmlSelect('faculty', $FACULTY, $faculty) ?><br><br>

                        <br />
                        <input type="submit" id="submit" name="update" value="Update" />
                        <input type="button" id="cancel" value="Cancel" onclick="location = 'admin_user_record.php'" />
                    </form>

                <?php endif ?>
            </div>
            <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>
