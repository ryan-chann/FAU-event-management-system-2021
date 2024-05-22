<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
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
        <title>Delete User Record</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_delete.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            .info{
                text-align: center;
                font-family: Trebuchet MS, sans-serif;
                font-size: 18px;
            }

            #back{
                background-color: rgb(207, 39, 39);
                height: 35px;
                margin-top: 10px;
                font-size: 18px;
                width: 130px;
                border: none;
                color: white;
            }

            #back:hover{
                background-color: rgba(207, 39, 39, 0.7);
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

                // --> Retrieve Student record based on the passed StudentID.
                if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                    $id = strtoupper(trim($_GET['id']));

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $id = $con->real_escape_string($id);
                    $sql = "SELECT * FROM User WHERE StudentID = '$id'";

                    $result = $con->query($sql);
                    if ($row = $result->fetch_object()) {
                        // Record found. Read field values.
                        $id = $row->StudentID;
                        $email = $row->Email;
                        $password = $row->Password;
                        $conPwd = $row->Password;
                        $username = $row->Name;
                        $phone = $row->Phone;
                        $gender = $row->Gender;
                        $faculty = $row->Faculty;

                        printf('
                <h3 style="margin-left:200px;">Delete User Record</h3>
                <table border="1" cellpadding="5" cellspacing="0" style="margin-left: 170px; margin-bottom:30px;">
                    <tr>
                        <td>Student ID :</td>
                        <td>%s</td>
                    </tr>                    
                    <tr>
                        <td>Name :</td>
                        <td>%s</td>
                    </tr>
                    <tr>
                        <td>Email :</td>
                        <td>%s</td>
                    </tr>
                    <tr>
                        <td>Phone Number :</td>
                        <td>%s</td>
                    </tr>
                    <tr>
                        <td>Gender :</td>
                        <td>%s</td>
                    </tr>
                    <tr>
                        <td>Faculty:</td>
                        <td>%s</td>
                    </tr>
                </table>
                <form action="" method="post">
                    <input type="hidden" name="id" value="%s" />
                    <input type="hidden" name="username" value="%s" />
                    <input type="hidden" name="email" value="%s" />
                    <input type="hidden" name="phone" value="%s" />
                    <input type="hidden" name="gender" value="%s" />
                    <input type="hidden" name="faculty" value="%s" />
                    <input type="hidden" name="password" value="%s" />
                    <input type="submit" name="submit" id="submit" value="Delete" />
                    <input type="button" value="Cancel" id="cancel"
                           onclick="location=\'admin_user_record.php\'" />
                </form>',
                                $id, $username, $email, $phone, $gender, $faculty,
                                $id, $username, $email, $phone, $gender, $faculty, $password);
                    } else {
                        echo '
                <div class="error">
                Opps. Record not found.
                [ <a href="admin_user_record.php">Back to list</a> ]
                </div>
                ';
                    }

                    $result->free();
                    $con->close();
                    ///////////////////////////////////////////////////////////////////////
                }
                // POST METHOD ////////////////////////////////////////////////////////////
                // --> Update the record.   
                else {
                    $id = strtoupper(trim($_POST['id']));
                    $email = trim($_POST['email']);
                    $phone = trim($_POST['phone']);
                    $username = trim($_POST['username']);
                    $gender = $_POST['gender'];
                    $faculty = $_POST['faculty'];
                    $password = $_POST['password'];

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    // SELECT * FROM
                    // INSERT INTO
                    // UPDATE TABLE
                    // DELETE FROM

                    $sql = '
            DELETE FROM User
            WHERE StudentID = ?
        ';
                    $stm = $con->prepare($sql);
                    $stm->bind_param('s', $id);
                    $stm->execute();

                    if ($stm->affected_rows > 0) {
                        ?>
                        <script>
                            swal({
                                title: "Delete Successful!",
                                text: "Record has been deleted!",
                                icon: "success",
                                button: "OK"
                            });
                        </script>
                        <?php
                        printf('
                <div class="info">
                Record has been deleted.<br>
                <a href="admin_user_record.php"><button id="back">Back to list</button></a>
                </div>');
                    } else {
                        ?>
                        <script>
                            swal({
                                title: "Delete Failed!",
                                text: "Oops! Database issues.",
                                icon: "error",
                                button: "OK"
                            });
                        </script>
                        <?php
                    }

                    $stm->close();
                    $con->close();
                }
                ?>
                <?php
            } else {
                header('location: admin_login.php');
            }
            ?>
            <?php include 'admin_footer.php'; ?>


