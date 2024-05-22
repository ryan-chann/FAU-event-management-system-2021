<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if (!isset($_POST['submit'])) {
    $name = "";
    $contact = "";
    $password = "";
    $confirmPassword = "";
    $email = "";
}
if (empty($_SESSION["AdminID"])) {
    $_SESSION["AdName"] = " ";
    $_SESSION["AdEmail"] = " ";
    $_SESSION["AdPassword"] = " ";
    $_SESSION["AdPhone"] = " ";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Administrator Profile</title>
        <link rel="stylesheet" href="../css/admin_layout.css"/>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            .form_container{
                margin-left: 100px;
                margin-top: 50px;
                font-family:Noto Sans, sans-serif;
            }

            .button_group{
                margin-top: 20px;
            }

            .profile_title{
                font-size: 24px;
            }

            #logout, #create, #edit{
                width: 100px;
                height: 35px;
                margin-left: 10px;
                margin-top: 40px;
                font-size: 18px;
                border: none;
                color: white;
                background-color: rgb(207, 74, 74);
            }

            #edit{
                margin-top: 10px;
                margin-bottom: 20px;
                background-color: rgb(232, 164, 118);
            }

            #edit:hover{
                background-color: rgba(232, 164, 118, 0.7);
            }

            #create{
                width: 150px;
            }

            #logout:hover, #create:hover{
                background-color: rgba(207, 74, 74, 0.7);
            }

            tr{
                height: 70px;
                width: 430px;
                font-size: 22px;
                margin-bottom: 20px;
                font-family: Trebuchet MS, sans-serif;
            }

            td{
                padding-left: 50px;
            }
        </style>
    </head>

    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>
            <?php
            require_once('helper.php');
            
            ?>
            <div class="form_container" >
                <div class="profile_title">
                    <h4>Admin Account</h4>
                </div>
                <div class="button_group">
                    <?php
                    if (isset($_SESSION['AdminID'])) {
                        $adminId = $_SESSION['AdminID'];

                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT * FROM Admin WHERE AdminID = '$adminId'";
                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {
                                printf('
                        <a href="edit_profile.php?id=%s" style="color:white; text-decoration: none;"><button id="edit">Edit</buttton></a>
                        ',
                                        $row->AdminID);
                            }
                        }
                    }
                    ?>
                </div>
                <table>
                    <tr>
                        <td>Name:</td>
                        <td> <?php
                            if (isset($_SESSION["AdName"])) {
                                echo $_SESSION['AdName'];
                            }
                            ?></td>                        
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td> <?php
                            if (isset($_SESSION["AdEmail"])) {
                                echo $_SESSION['AdEmail'];
                            }
                            ?> </td>
                    </tr>
                    <tr>
                        <td>Contact Number:</td>
                        <td> <?php
                            if (isset($_SESSION["AdPhone"])) {
                                echo $_SESSION['AdPhone'];
                            }
                            ?></td>
                    </tr>
                </table>
                <a href="admin_logout.php"><button id="logout" name="logout">Log Out</button></a>
                <a href="admin_createAcc.php"><button name="create" id="create">Create Account</button></a>
            </div>
        </div>
        <?php
    } else {
        header('location: admin_login.php');
    }
    ?>
    <?php include 'admin_footer.php'; ?>

