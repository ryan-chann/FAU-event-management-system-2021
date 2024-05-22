<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Search Ticket Record</title>
        <link rel="stylesheet" href="../css/admin_event_search.css">
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_search.css">
        <style>
            .container{
                width: 95%;
                margin-left: 20px;
            }

            td{
                text-align: center;
            }
        </style>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>  

            <div class="header">
                <h3>Ticket Record</h3>
                <nav class="record_nav">
                    <a href="admin_ticket_record.php" name="view" id="view">View</a>
                    <a href="insert_ticketR.php" name="add" id="add">Add</a>
                    <a href="search_ticketR.php" name="search" id="search">Search</a>
                </nav>
            </div>

            <div class="container">
                <form method="POST">
                    <input type="text" id="myInput" onkeyup="myFunction()" name="search" placeholder="Enter Booking ID...." title="Type in a Booking ID">
                </form>

                <table>
                    <thead>
                        <tr>
                            <th style="width:1%;">#</th>
                            <th style="width:35%;">Event</th>
                            <th style="width:5%;">Quantity</th>
                            <th style="width:20%;">Name</th>
                            <th style="width:10%;">Student ID</th>
                            <th style="width:10%;">Gender</th>
                            <th style="width:20%;">Phone</th>
                        </tr>
                    </thead>

                    <?php
                    $bookingID = "";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $bookingID = strtoupper(($_POST["search"])); //store result name
                    }
                    require_once('helper.php');
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //connect database
                    $email = "";
                    $sql = "SELECT * FROM Ticket T, Event E, User U WHERE U.StudentID = T.StudentID AND T.EventID = E.EventID AND T.BookingID = '$bookingID'"; //select from database
                    $i = 0;
                    if ($result = $con->query($sql)) {
                        while ($row = $result->fetch_object()) {  //while loop to find the event
                            $i++;
                            printf('
                                <tr class="display_con">
                                    <td>%d</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                </tr>
                        ',
                                    $row->BookingID,
                                    $row->EventName,
                                    $row->Quantity,
                                    $row->Name,
                                    $row->StudentID,
                                    $row->Gender,
                                    $row->Phone,
                            );
                        }
                    }

                    function test_input($data) {         //check data input
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
                    ?>
                </table>
            </div>
            <!--if got result then display the detail -->
            <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>
