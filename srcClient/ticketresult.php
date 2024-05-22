
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/ticketresult.css">
        <link rel="stylesheet" href="../css/ticketbooking.css">
        <title>FAU - Ticket</title>
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
    </head>
    <body>
        <!--navigation bar -->
        <?php
        session_start();
        if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
            require_once('header2.php');
        } else {
            require_once('header.php');
        }
        ?>

        <!--ticket result container -->
        <h1 style="text-align: center;background-image: url(../picture/background/background2.jpg);margin: 0px;padding: 2%;"></h1>
        <div style="background-image: url('../picture/background/background.jpg');padding-top: 2%;padding-bottom: 2%;">
            <div class="container">
                <h1 style="background-color: black;padding: 2%;">Ticket Booking</h1>            
                <?php
                require_once('helper.php');
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);  //get user id from user
                ///////////////////////////////////////////////////
                $studentId = $_SESSION['studentID'];
                $selected_val = "";
                $quantity = "";
                $no_of_booking = 0;
                $limitBooking = 0;
                $success = true;
                //////////////////////////////////////////////////////


                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $selected_val = $_POST["event_type"];
                    $quantity = $_POST["quantity"];
                    $sql = "
                            SELECT EventName,No_Of_Booking, LimitBooking from event WHERE EventID= '" . $selected_val . "'
                            ";
                    if ($result = $con->query($sql)) {
                        while ($row = $result->fetch_object()) {  //while loop to find the event
                            $name = $row->EventName;
                            $no_of_booking = $row->No_Of_Booking;
                            $limitBooking = $row->LimitBooking;
                        }
                    }
                }

                function test_input($data) {         //check data input
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                if ($no_of_booking + $quantity <= $limitBooking) {
                    $sql = '
                        INSERT INTO ticket (StudentID,EventID, Quantity)
                        VALUES (?, ?, ?);
                        ';
                    $stm = $con->prepare($sql);
                    $stm->bind_param('ssd', $studentId, $selected_val, $quantity);
                    $sql2 = '
                        UPDATE event
                        SET No_of_Booking = ?
                        WHERE EventID = ?;
                        ';
                    $total = $no_of_booking + $quantity;
                    $stm2 = $con->prepare($sql2);
                    $stm2->bind_param('ds', $total, $selected_val);

                    $stm->execute();
                    $stm2->execute();
                    if ($stm->affected_rows > 0 && $stm2->affected_rows > 0) {
                        echo"<h2 style='text-align:center;'>You have successfully booked: <br/>" . $name . "</h2>";
                        /* Dispplay selected event image */
                        if ($selected_val == "First Aid Talk") {
                            echo '<img style="width:100%;" src="../picture/workshop/event1.jpeg"/>';
                        } else if ($selected_val == "OCTOBER 2021 Blood Donation Campaign") {
                            echo '<img style="width:100%;" src="../picture/blood_donation/event1.jpeg"/>';
                        } else if ($selected_val == "First Aid Common Sense Competition") {
                            echo '<img style="width:100%;" src="../picture/competition/event1.jpg"/>';
                        } else if ($selected_val == "Fundraising For Mercy Malaysia") {
                            echo '<img style="width:100%;" src="../picture/charity/event1.jpg"/>';
                        } else if ($selected_val == "Volunteer in Nursing Home") {
                            echo '<img style="width:100%;" src="../picture/volunteering/event1.jpg"/>';
                        }
                        echo '<p style="text-align:center;font-size:25px;">See You Soon!</p>';
                        echo '<button style="background-color: #008CBA;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;margin-left: 43%;"onclick="location.href=\'myBooking.php\'">Okay</button>';
                    } else {
                        echo "error";
                    }
                    $stm->close();
                    $con->close();
                } else {
                    $success = false;
                }
                ?>   
            </div>
        </div>   
    </body>

    <!--footer -->
    <footer>
        <h1><img src="../picture/icon/phone.png" style="width:30px"/> Contact number:</h1><a href="tel:+60341450240" style="font-size:20px;">+60341450240</a>
        <h1><img src="../picture/icon/email.png" style="width:30px"/> Email:</h1><a href="mailto:@gmail.com" style="font-size:20px;">firstaidtaruc@gmail.com</a>
        <h1>Follow Us At</h1>
        <a href="https://www.instagram.com/taruc_fau/?utm_medium=copy_link" target="_blank"><img src="../picture/icon/instagram.png" style="width:50px;padding: 15px;"/></a><a href="https://www.facebook.com/FirstAidUnitTARUC" target="_blank"><img src="../picture/icon/facebook.png" style="width:50px;padding: 15px;"/></a>
        <article>
            <h5>TARC FIRST AID UNIT &reg</h5>
        </article>
    </footer>

    <!--java script -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
<?php
if ($success) {
    echo "swal({
                    title: \"Thank You!\",
                    text: \"You have successfully book this event!\",
                    icon: \"success\",
                    button: \"Aww yiss!\",
                    });";
} else {
    echo "swal({
                    title: \"Fail\",
                    text: \"The booking limit has been reached for this event.\",
                    icon: \"warning\",
                    button: \"Okay\",
                    }).then(function() {
                    location = 'ticketBooking.php';
                    });";
}
?>


                        function linkFunction(url) {
                            location.href = url;
                        }
    </script>   

</html>







