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
        <title>User Record</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_recordnav.css">
        <style>
            #edit{
                background-color: #4CAF50;
                border: white;
                width: 60px;
                height: 30px;
                color: white;
                font-size: 16px;
            }

            #delete{
                background-color: red;
                border: white;
                width: 60px;
                height: 30px;
                color: white;
                font-size: 16px;
            }
        </style>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>
            <div class="record_container">
                <h3>User Record</h3>
                <nav class="record_nav">
                    <a href="admin_user_record.php" name="view" id="view">View</a>
                    <a href="insert_user.php" name="add" id="add">Add</a>
                    <a href="search_user.php" name="search" id="search">Search</a>
                </nav>
                <table class="table" id="user_table">
                    <thead>
                        <tr>
                            <th style="width:1%;">#</th>
                            <th style="width:10%;">Student ID</th>
                            <th style="width:15%;">Name</th>
                            <th style="width:20%;">Email</th>
                            <th style="width:10%;">Phone</th>
                            <th style="width:7%;">Gender</th>
                            <th style="width:10%;">Faculty</th>
                            <th style="width: 35%;"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        <?php
                        require_once('helper.php');

                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT * FROM User";
                        $i = 0;
                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {
                                $i++;
                                printf('
                        <tr>
                        <td>%d</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td>%s</td>
                        <td><a href="edit_user.php?id=%s" style="color:white;"><button id="edit">Edit</buttton></a>
                        <a href="delete_user.php?id=%s" style="color:white;"><button id="delete">Delete</buttton></a></td>
                        </tr>',
                                        $i,
                                        $row->StudentID,
                                        $row->Name,
                                        $row->Email,
                                        $row->Phone,
                                        $row->Gender,
                                        $row->Faculty,
                                        $row->StudentID,
                                        $row->StudentID);
                            }
                        }
                        printf('
                <tr>
                <td colspan="8">
                    Total: %d record(s).
                </td>
                </tr>',
                                $result->num_rows);

                        $result->free();
                        $con->close();
                        ?>
                    </tbody>
                </table>
            </div>
            <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>