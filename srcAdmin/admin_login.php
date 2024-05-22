<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'admin_login_validation.php';

$email = "";
$password = "";
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator Log In</title>
        <link rel="stylesheet" href="../css/admin_login.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            body{
                background-image: url(../photo/admin_login_background.jpg);
                background-repeat: none-repeat;
                background-size: cover;
            }

            .alert{
                font-family:Trebuchet MS, sans-serif;
                color: rgb(247, 92, 92);
                font-size: 16px;
                margin-top: 20px;
                width: 400px;
            }
        </style>
    </head>
        <body>
            <section>
                <div class="login_form">
                    <form method="post">';
                        <div class="login_title">
                            <h4 class="login_title">Administrator Log In</h4>
                        </div>
                        <div class="form_group g1">
                            <label for="email">Email:</label><br>
                            <input type="email" id="email" name="email" value="<?php echo $email ?>"><br><br><br>
                        </div>
                        <?php
                        if (isset($email_error)) {
                            echo "<div class='alert'>$email_error</div>";
                        }
                        ?>
                        <div class="form_group g2">
                            <label for="password">Password:</label><br>
                            <input type="password" id="password" name="password" value="<?php echo $password ?>"><br><br>
                        </div>
                        <?php
                        if (isset($password_error)) {
                            echo "<div class='alert'>$password_error</div>";
                        }
                        ?>
                        <div class="button_group">
                            <input type="submit" name="submit" id="login" value="Log In" ><br><br>
                            <input type="reset" id="cancel" value="Cancel">
                        </div>
                    </form>

                </div>
            </section>
        </body>
       
</html>
