<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/viewEvent.css">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.theme.default.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <title>FAU - Workshop</title>
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

        <!-- competition event container -->
        <h1 style="background-image: url(../picture/background/background2.jpg);padding:2%;text-align: center;margin: 0px;color: black;"></h1>
        <div style="display: flex; background-image:url('../picture/background/background.jpg')">

            <?php
            parse_str($_SERVER['QUERY_STRING'], $queries);
            require_once('helper.php');
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //connect database
            $sql = "SELECT * FROM event WHERE EventID=" . $queries['id'];  //display detail from database
            if ($result = $con->query($sql)) {
                while ($row = $result->fetch_object()) {
                    echo('
                                <div data-aos="fade-up" style="width:40%">
                                <img src="' . $row->Picture_location . '" style="width: 80%;margin: 10% 0% 10% 20%;border-style: solid;border-color: white;"/>
                                </div>
                                <div data-aos="fade-up" style="width:60%" class="contain">
                                    <p><b>Event: ' . $row->EventName . '</b><br/>Venue:' . $row->Venue . '<br/>Date:' . $row->StartDate . ' - ' . $row->EndDate . '<br/>Time:' . $row->StartTime . ' - ' . $row->EndTime . '<br/>Description: ' . $row->Description . '</p>
                                    <div class="container"><button onclick="linkFunction(\'ticketbooking.php?id=' . $row->EventID . '\');"class="btn">Booking Now</button></div>
                                </div>'
                    );
                }
            }
            ?>            

        </div>

        <!--photo album competition -->
        <div>
            <h1 style="padding: 2%;color:black;margin: 0px;background-image: url('../picture/background/background2.jpg');text-align:center;"></h1>
        </div>  
    </body>

    <!--footer -->
    <footer>
        <div data-aos="fade-up">
            <h1><img src="../picture/icon/phone.png" style="width:30px"/> Contact number:</h1><a href="tel:+60341450240" style="font-size:20px;">+60341450240</a>
            <h1><img src="../picture/icon/email.png" style="width:30px"/> Email:</h1><a href="mailto:@gmail.com" style="font-size:20px;">firstaidtaruc@gmail.com</a>
            <h1>Follow Us At</h1>
            <a href="https://www.instagram.com/taruc_fau/?utm_medium=copy_link" target="_blank"><img src="../picture/icon/instagram.png" style="width:50px;padding: 15px;"/></a><a href="https://www.facebook.com/FirstAidUnitTARUC" target="_blank"><img src="../picture/icon/facebook.png" style="width:50px;padding: 15px;"/></a>
            <article>
                <h5>TARC FIRST AID UNIT &reg</h5>
            </article>
        </div>       
    </footer>

    <!--java script -->
    <script src="../js/jquery.js"></script>
    <script src="../js/owl.carousel.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
                        $(".owl-carousel.slide2").owlCarousel({
                            items: 3,
                            autoplay: true,
                            autoplayTimeout: 3500,
                            loop: true,
                            margin: 10,
                        });

                        function linkFunction(url) {
                            location.href = url;
                        }
                        $(document).ready(function () {
                            AOS.init();
                        });
    </script>
</html>






