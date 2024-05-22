<?php
//Start Session
session_start();
?>


<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/ticketbooking.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Metrophobic' rel='stylesheet'>
        <title>FAU - Ticket Booking</title>
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
    </head>
    <?php
    if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
        require_once('header2.php');
        ?>
        <body>

            <!--ticket booking container -->
            <h1 style="text-align: center;background-image: url('../picture/background/background2.jpg');margin: 0px;padding: 2%;">Ticket Booking</h1>
            <div>
                <form method="post" action="ticketresult.php" style="background-image: url('../picture/background/background.jpg');padding-top: 2%;padding-bottom: 2%;margin-bottom: 0px;">
                    <div data-aos="zoom-in-up"  class="container">
                        <h1 style="color:black">Ticket Booking</h1>
                        <p style="color:black">Please select the event to book.</p>
                        <hr>
                        <div class="formDetail">                     
                            <label for="cars"><b>Select Event Type</b></label><br/>                      
                            <select id="user_type" name="event_type" style="margin-top: 1%;padding: 1%;margin-bottom: 3%;font-family: 'Metrophobic';font-size: 20px;">                           
                                <?php
                                parse_str($_SERVER['QUERY_STRING'], $queries);
                                $id = $queries['id'];
                                require_once('helper.php');
                                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                                $sql = '
                                        SELECT EventID,EventName from event
                                        ';
                                if ($result = $con->query($sql)) {
                                    while ($row = $result->fetch_object()) {  //while loop to find the event
                                        echo '
                                        <option value="' . $row->EventID . '" ' . ($id == $row->EventID ? "selected" : "") . '>' . $row->EventName . '</option>
                                        ';
                                    }
                                }
                                $con->close();
                                ?>
                            </select><br/>
                            <label for="quantity"><b>Quantity (Max : 5)</b></label>
                            <input type="number" id="quantity" name="quantity" min="1" max="5" value="1" style="margin-top:2%;padding: 1%;">
                            <h3 style="margin-bottom: 8px;">Do you want to receive notification?<br>We will send you a notification one day before the event. </h3>
                            <label class="switch">                            
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div> 
                        <input class="submit" type="submit" name="submit" value="Submit">  
                    </div>
                </form> 
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
        <script src="../js/jquery.js"></script>
        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
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




