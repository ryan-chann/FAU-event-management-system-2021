<?php
session_start();

if (!isset($_POST['submit'])) {
    $name = "";
    $contact = "";
    $password = "";
    $confirmPassword = "";
    $email = "";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator Profile</title>
        <link rel="stylesheet" href="../css/admin_layout.css"/>
        <link rel="stylesheet" href="../css/admin_createAcc.css"/>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            input{
                height: 35px;
            }
        </style>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>
            <div class="form_container" >
                <form action="admin_createAcc2.php" method="POST">
                    <div class="profile_title">
                        <h4>Create Admin Account</h4>
                    </div>
                    <div class="form_group g1">
                        <label for="name">Name:</label><br>
                        <input type="text" id="name" name="name" value="<?php echo $name ?>"><br>
                        <?php
                        if (isset($name_error)) {
                            echo "<div class='alert alert-danger'>$name_error</div>";
                        }
                        ?>
                    </div>
                    <div class="form_group g2">
                        <label for="email">Email:</label><br>
                        <input type="email" id="email" name="email" placeholder="abc@student.tarc.edu.my" value="<?php echo $email ?>"><br>
                        <?php
                        if (isset($email_error)) {
                            echo "<div class='alert alert-danger'>$email_error</div>";
                        }
                        ?>
                    </div>
                    <div class="form_group g3">
                        <label for="contact">Contact Number:</label><br>
                        <input type="tel" id="contact" name="contact" placeholder="0123456789" value="<?php echo $contact ?>"><br>
                        <?php
                        if (isset($contact_error)) {
                            echo "<div class='alert alert-danger'>$contact_error</div>";
                        }
                        ?>
                    </div>
                    <div class="form_group g4">
                        <label for="password1">Password:</label><br>
                        <input type="password" id="password1" name="password1" value="<?php $password ?>"><br>
                        <?php
                        if (isset($password_error)) {
                            echo "<div class='alert alert-danger'>$password_error</div>";
                        }
                        ?>
                    </div>
                    <div class="form_group g5">
                        <label for="password2">Re-Enter Password:</label><br>
                        <input type="password" id="password2" name="password2" value="<?php $confirmPassword ?>"><br>
                        <?php
                        if (isset($confirmPassword_error)) {
                            echo "<div class='alert alert-danger'>$confirmPassword_error</div>";
                        }
                        ?>
                    </div>

                    <div class="button_group">
                        <input type="submit" id="submit" value="Submit" name="submit" location = "<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="reset" id="cancel" value="Cancel" onclick = "redirect1()">
                    </div>
                </form>
            </div>
        <script>
            function redirect1(){
                location.replace("admin_profile.php");
            }
        </script>
        <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>

