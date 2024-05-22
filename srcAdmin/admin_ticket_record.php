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
        <title>Ticket Record</title>
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
                <h3>Ticket Record</h3>
                <nav class="record_nav">
                    <a href="admin_ticket_record.php" name="view" id="view">View</a>
                    <a href="insert_ticketR.php" name="add" id="add">Add</a>
                    <a href="search_ticketR.php" name="search" id="search">Search</a>
                </nav>
                <table>
                    <thead>
                        <tr>
                            <th style="width:1%;">ID</th>
                            <th style="width:25%;">Event</th>
                            <th style="width:15%;">Name</th>
                            <th style="width:15%;">Email</th>
                            <th style="width:10%;">Gender</th>
                            <th style="width:10%;">Phone</th>
                            <th style="width:5%;">Quantity</th>
                            <th style="width: 5%;"></th>
                            <th style="width: 5%;"></th>
                        </tr>
                    </thead>
                    <?php
                    require_once('helper.php');

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT * FROM Ticket T, Event E, User U WHERE T.EventID = E.EventID AND U.StudentID = T.StudentID ORDER BY BookingID";
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
                        <td style="text-align:center;">%s</td>
                        <td><a href="delete_ticketR.php?id=%s" style="color:white;"><button id="delete">Delete</buttton></a></td>
                        <td></td>
                        </tr>',
                                    $row->BookingID,
                                    $row->EventName,
                                    $row->Name,
                                    $row->Email,
                                    $row->Gender,
                                    $row->Phone,
                                    $row->Quantity,
                                    $row->BookingID);
                        }
                    }
                    printf('
                <tr>
                <td colspan="10">
                    Total: %d record(s).
                </td>
                </tr>',
                            $result->num_rows);

                    $result->free();
                    $con->close();
                    ?>

            </div>
            <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>
