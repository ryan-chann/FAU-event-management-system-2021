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
        <title>Search Event Record</title>
        <link rel="stylesheet" href="../css/admin_event_search.css">
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_search.css">
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>      
            <div class="header">
                <h3>Event Record</h3>
                <nav class="record_nav">
                    <a href="admin_event_record.php" name="view" id="view">View</a>
                    <a href="insert_event.php" name="add" id="add">Add</a>
                    <a href="search_event.php" name="search" id="search">Search</a>
                </nav>
            </div>

            <div class="container">
                <form method="POST">
                    <input type="text" id="myInput" onkeyup="myFunction()" name="search" placeholder="Enter Event Name..." title="Type in a name">
                </form>
                <?php

                function test_input($data) {         //check data input
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                $name = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = strtoupper(test_input($_POST["search"])); //store result name
                    require_once('helper.php');
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //connect database
                    $formDisplay = false;
                    $sql = "SELECT EventName,Category,StartDate,EndDate,StartTime,EndTime,Venue,No_Of_Booking,Picture_location,LimitBooking,Description FROM event WHERE UPPER(EventName) LIKE '%" . $name . "%'"; //select from database
                    if ($result = $con->query($sql)) {
                        printf('<h1 style="font-size:20px;text-align:center">%s</h1>', "Result");
                        while ($row = $result->fetch_object()) {  //while loop to find the event
                            $eventName = $row->EventName;         //store variable name
                            $eventType = $row->Category;
                            $eventVenue = $row->Venue;
                            $image = $row->Picture_location;
                            $startDate = $row->StartDate;
                            $endDate = $row->EndDate;
                            $startTime = $row->StartTime;
                            $endTime = $row->EndTime;
                            $seat = $row->LimitBooking;
                            $description = $row->Description;
                            $formDisplay = true;

                            printf(' 
                        <div style="flex:40%%;padding:5%%;border-style:solid;border-width:10px;border-color:white;">   
                            <div class="row">
                                <div class="col-25">
                                    <label for="event_name">Event Name:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="event_type">Event type:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="event_venue">Event Venue:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="img">Select image:</label>
                                </div>
                                <div class="col-75">
                                    <img style="width:50%%" src="%s"/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-25">
                                    <label for="startDate">Start Date:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="endDate">End Date:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="appt">Start time:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="appt">End time:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="appt">Seat Availibility:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-25">
                                    <label for="description">Description:</label>
                                </div>
                                <div class="col-75">
                                    %s
                                </div>
                            </div>
                            
                        </div>
                        <hr/>', $eventName, $eventType, $eventVenue, $image, $startDate, $endDate, $startTime, $endTime, $seat, $description);
                        }
                    }
                }
                ?>
            </div>
        </body>
        <?php
    } else {
        header('location: admin_login.php');
    }
    ?>
<?php include 'admin_footer.php'; ?>
</html>        


