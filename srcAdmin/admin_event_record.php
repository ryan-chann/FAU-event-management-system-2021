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
        <title>Event Record</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_recordnav.css">
        <link rel="stylesheet" href="../css/admin_event.css">

    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>                   
            <div class="record_container" style="margin-left: 0;margin-right: 3%">
                <h3>Event Record</h3>
                <nav class="record_nav">
                    <a href="admin_event_record.php" name="view" id="view">View</a>
                    <a href="insert_event.php" name="add" id="add">Add</a>
                    <a href="search_event.php" name="search" id="search">Search</a>
                </nav>
                <table>
                    <tr>
                        <th style="width: 0.5%;text-align: center">No</th>
                        <th style="width: 6%;text-align: center">Event Name</th> 
                        <th style="width: 5%;text-align: center">Event Category</th>
                        <th style="width: 6%;text-align: center">Start Date</th>
                        <th style="width: 6%;text-align: center">End Date</th> 
                        <th style="width: 5%;text-align: center">Start Time</th>
                        <th style="width: 5%;text-align: center">End Time</th>
                        <th style="width: 5%;text-align: center">Venue</th> 
                        <th style="width: 3%;text-align: center">No.Booking</th>
                        <th style="width: 15%;text-align: center">Picture</th>
                        <th style="width: 15%;text-align: center">Description</th>
                        <th style="width: 5%;text-align: center"></th>
                        <th style="width: 5%;text-align: center"></th>
                    </tr>

                    <?php
                    require_once('helper.php');
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);   //connect database
                    $sql = "SELECT * FROM event";     // sql statement

                    if ($result = $con->query($sql)) {
                        $i = 0;
                        while ($row = $result->fetch_object()) {      //while loop to display data from database
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
                            <td>%s</td>
                            <td>%d/%d</td>
                            <td style="width:300px;"><img src="%s" style="width:100%%"/></td>
                            <td style="text-align:justify;">%s</td>
                            <td><button onclick="location.href=\'edit_event.php?id=%s\'">Edit</buttton></td>
                            <td><button style="font-size:15px;background-color:red;"onclick="location.href=\'delete_event.php?id=%s\'">Delete</buttton></td>                                       
                             </tr>',
                                    $i,
                                    $row->EventName,
                                    $row->Category,
                                    $row->StartDate,
                                    $row->EndDate,
                                    $row->StartTime,
                                    $row->EndTime,
                                    $row->Venue,
                                    $row->No_of_Booking,
                                    $row->LimitBooking,
                                    $row->Picture_location,
                                    $row->Description,
                                    $row->EventID,
                                    $row->EventID
                            );
                        }
                    }
                    ?>
                </table>
            </div>
        </body>
        <?php
    } else {
        header('location: admin_login.php');
    }
    ?>
    <?php include 'admin_footer.php'; ?>
</html>