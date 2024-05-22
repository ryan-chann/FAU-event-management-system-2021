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
        <title>Delete Ticket Record</title>
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
                <h3>Ticket Record</h3>
                <nav class="record_nav">
                    <a href="admin_ticket_record.php" name="view" id="view">View</a>
                    <a href="insert_ticketR.php" name="add" id="add">Add</a>
                    <a href="search_ticketR.php" name="search" id="search">Search</a>
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
                    $sql = "SELECT * FROM Ticket T, Event E, User U WHERE T.BookingID = '$id' AND T.EventID = E.EventID AND U.StudentID = T.StudentID ";

                    $result = $con->query($sql);
                    if ($row = $result->fetch_object()) {
                        // Record found. Read field values.
                        $id = $row->BookingID;
                        $event = $row->EventName;
                        $eventId = $row->EventID;
                        $name = $row->Name;
                        $email = $row->Email;
                        $gender = $row->Gender;
                        $phoneNumber = $row->Phone;
                        $quantity = $row->Quantity;

                        printf('
                <h3 style="margin-left:200px;">Delete Ticket Record</h3>
                <table border="1" cellpadding="5" cellspacing="0" style="margin-left: 170px; margin-bottom:30px;">
                    <tr>
                        <td>Event :</td>
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
                        <td>Gender :</td>
                        <td>%s</td>
                    </tr>
                    <tr>
                        <td>Phone Number :</td>
                        <td>%s</td>
                    </tr>
                    <tr>
                        <td>Quantity :</td>
                        <td>%s</td>
                    </tr>
                </table>
                <form action="" method="post">
                    <input type="hidden" name="event" value="%s" />
                    <input type="hidden" name="event_type" value="%s" />
                    <input type="hidden" name="name" value="%s" />
                    <input type="hidden" name="email" value="%s" />
                    <input type="hidden" name="gender" value="%s" />
                    <input type="hidden" name="phoneNumber" value="%s" />
                    <input type="hidden" name="quantity" value="%s" />
                    <input type="submit" name="submit" id="submit" value="Delete" />
                    <input type="button" value="Cancel" id="cancel"
                           onclick="location=\'admin_ticket_record.php\'" />
                </form>',
                                $event, $name, $email, $gender, $phoneNumber, $quantity,
                                $event, $eventId, $name, $email, $gender, $phoneNumber, $quantity);
                    } else {
                        echo '
                <div class="error">
                Opps. Record not found.
                [ <a href="admin_ticket_record.php">Back to list</a> ]
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
                    $id = strtoupper(trim($_GET['id']));
                    $event = trim($_POST['event']);
                    $selected_val = trim($_POST['event_type']);
                    $name = trim($_POST['name']);
                    $email = trim($_POST['email']);
                    $gender = trim($_POST['gender']);
                    $phoneNumber = trim($_POST['phoneNumber']);
                    $quantity = trim($_POST['quantity']);

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    $sql1 = "
                        SELECT EventName,No_Of_Booking, LimitBooking from event WHERE EventID= '" . $selected_val . "'
                    ";
                    if ($result1 = $con->query($sql1)) {
                        while ($row = $result1->fetch_object()) {  //while loop to find the event
                            $name = $row->EventName;
                            $no_of_booking = $row->No_Of_Booking;
                            $limitBooking = $row->LimitBooking;
                        }
                    }

                    $sql = '
                        DELETE FROM Ticket
                        WHERE BookingID = ?
                        ';
                    $stm = $con->prepare($sql);
                    $stm->bind_param('s', $id);
                    $sql2 = '
                        UPDATE event
                        SET No_of_Booking = ?
                        WHERE EventID = ?;
                        ';
                    $total = $no_of_booking - $quantity;
                    $stm2 = $con->prepare($sql2);
                    $stm2->bind_param('ds', $total, $selected_val);

                    $stm->execute();
                    $stm2->execute();

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
                <a href="admin_ticket_record.php"><button id="back">Back to list</button></a>
                </div>',
                                $id);
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


