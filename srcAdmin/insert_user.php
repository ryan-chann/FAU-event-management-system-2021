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
    $username = "";
    $email = "";
    $phone = "";
    $gender = "";
    $password = "";
    $conPwd = "";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add User Record</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_insert.css">
        <style>
            .form_container{
                height: 750px;
            }

            form{
                height: 750px;
            }

            #studentId, #email, #conPwd, #password, #username, #phone, #faculty{
                width: 380px;
                font-size: 16px;
                height: 30px;
                margin-bottom: 10px;
                padding-left: 10px;
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
                <form action="insert_user2.php" method="post">
                    <h3 style="margin-left:70px;">Add User Record</h3>
                    <label for="studentId">Student ID:</label><br>
                    <input type="text" name="studentId" id="studentId" placeholder="00XXX00000" value="<?php echo $studentId ?>">
                    <?php
                    if (isset($studentId_error)) {
                        echo "<div class='alert alert-danger'><strong>$studentId_error</strong>";
                    }
                    ?>
                    <br><br>
                    <label for="username">Name:</label><br>
                    <input type="text" name="username" id="username" value="<?php echo $username ?>">
                    <?php
                    if (isset($username_error)) {
                        echo "<div class='alert alert-danger'>$username_error</div>";
                    }
                    ?>
                    <br><br>
                    <label for="email">Email:</label><br>
                    <input type="text" name="email" id="email" placeholder="abc@student.tarc.edu.my" value="<?php echo $email ?>">
                    <?php
                    if (isset($email_error)) {
                        echo "<div class='alert alert-danger'><strong>$email_error</strong>";
                    }
                    ?>
                    <br><br>
                    <label for="phone">Phone Number:</label><br>
                    <input type="text" name="phone" id="phone" placeholder="0123456789" value="<?php echo $phone ?>">
                    <?php
                    if (isset($phone_error)) {
                        echo "<div class='alert alert-danger'>$phone_error</div>";
                    }
                    ?>
                    <br><br>
                    <label for="gender">Gender:</label>
                    <input type="radio" name="gender" id="male" value="MALE" checked>
                    <label for="male">Male</label>
                    <input type="radio" name="gender" id="female" value="FEMALE">
                    <label for="female">Female</label>
                    <?php
                    if (isset($gender_error)) {
                        echo "<div class='alert alert-danger'>$gender_error</div>";
                    }
                    ?>
                    <br><br>
                    <label for="faculty">Faculty:</label><br>
                    <select name="faculty" id="faculty" value="<?php echo $faculty ?>">
                        <option value="FAFB">Faculty of Accountancy, Finance & Business</option>
                        <option value="FOCS">Faculty of Computing And Information Technology</option>
                        <option value="FOAS">Faculty of Applied Sciences</option>
                        <option value="FOBE">Faculty of Built Environment</option>
                        <option value="FCCI">Faculty of Communication And Creative Industries</option>
                        <option value="FOET">Faculty of Engineering And Technology</option>
                        <option value="FSSH">Faculty of Social Science And Humanities</option>
                    </select>
                    <br><br>
                    <label for="password">Password:</label><br>
                    <input type="password" name="password" id="password" value="<?php echo $password ?>">
                    <?php
                    if (isset($password_error)) {
                        echo "<div class='alert alert-danger'><strong>$password_error</strong>";
                    }
                    ?>
                    <br><br>
                    <label for="conPwd">Re-Enter Password:</label><br>
                    <input type="password" name="conPwd" id="conPwd" value="<?php echo $conPwd ?>">
                    <?php
                    if (isset($conPwd_error)) {
                        echo "<div class='alert alert-danger'><strong>$conPwd_error</strong>";
                    }
                    ?>
                    <br>
                    <input type="submit" name="submit" id="submit">
                    <input type="reset" name="reset" id="reset" value="Cancel">
                </form>
            </div>
            <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>