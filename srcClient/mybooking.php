<?php
//Start Session
session_start();
?>


<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/mybooking.css">
        <link href='https://fonts.googleapis.com/css?family=Mitr' rel='stylesheet'>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <title>FAU - Bookings</title>

    </head>
    <?php
    if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
        require_once('header2.php');
        ?>
        <body>
            <!--booking container -->
            <h1 style="text-align: center;background-image: url('../picture/background/background2.jpg');margin: 0px;padding: 2%;">My Booking</h1>
            <div class="flex-container">
                <div style="display: flex;flex-direction: column">
                    <?php
                    require_once('helper.php');
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = '
                            SELECT E.Picture_location,E.Venue,E.StartDate,E.EventName,E.StartTime,E.EndTime,T.BookingID,T.Quantity from event E,ticket T,user U WHERE E.eventId=T.eventid AND U.studentid = T.studentid AND T.studentid = "' . $_SESSION['studentID'] . '" ORDER BY T.BookingID DESC
                            ';

                    if ($result = $con->query($sql)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_object()) {  //while loop to find the event
                                echo '
                                    <div style="display: flex;margin:2%">
                                    <div data-aos="fade-up" style="flex: 3">
                                        <img style="width:108%;margin-top: 5%;margin-left: 4%;" src="' . $row->Picture_location . '"/>
                                     </div>
                                    <div  data-aos="fade-up" style="display:flex;flex: 7;flex-direction: row; background-color: white;border-style: dashed;margin-left: 6%;">
                                        <div style="flex: 5">
                                            <p style="line-height: 40px">Booking ID : #' . substr(str_repeat(0, 5) . $row->BookingID, - 5) . '<br/>Event Name: ' . $row->EventName . ' <br/>Time: ' . $row->StartTime . '-' . $row->EndTime . ' <br/>Date: ' . $row->StartDate . '<br/>Venue: ' . $row->Venue . '<br/>Quantity: ' . $row->Quantity . '</p>
                                        </div>
                                        <div style="flex:2"><img id="barcode" src="https://api.qrserver.com/v1/create-qr-code/?data=HelloWorld&amp;size=100x100" /></div>
                                        <img src="../picture/icon/remove.png" style="width:45px;height:45px;float: right;margin-right: 3%;margin-top: 2%;" onclick="alert()"/> 
                                     </div>
                                     </div>
                                ';
                            }
                        } else {
                            print('<div style="padding:10%;background-color="black"></div>');
                        }
                    }
                    $con->close();
                    ?>                  
                </div>
            </div> 
        </body>

        <!--java script -->
        <script src="../js/jquery.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script>
            function alert() {
                swal({
                    text : "Please contact FAU admin to delete your booking.",
                })
            }
            $(document).ready(function () {
                AOS.init();
            });
            function linkFunction(url) {
                location.href = url;
            }
        </script>
    </html>
    <?php
    //Include Footer
    require_once('footer.php');
} else {
    header('location: logIn.php');
}
?>





