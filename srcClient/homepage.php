<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../ss/owl.theme.default.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <title>FAU - Homepage</title>
    </head>
    <body>
        <?php
        session_start();
        if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
            require_once('header2.php');
        } else {
            require_once('header.php');
        }
        ?>
        <!--start slider slogan -->
        <div style="width:100%;background-image: url('../picture/background/background2.jpg');background-size: cover;padding: 2%;">
            <div class="owl-carousel slide1" style="border-style: solid;border-color: white;">
                <div>
                    <img src='../picture/slogan/slogan1.jpg' style="width:100%;"/>
                </div>
                <div>
                    <img src='../picture/slogan/slogan2.jpg' style="width:100%"/>
                </div>
                <div>
                    <img src='../picture/slogan/slogan3.jpg' style="width:100%"/>
                </div>
                <div>
                    <img src='../picture/slogan/slogan4.jpg' style="width:100%"/>
                </div>
            </div>
        </div>
        <!-- end slider slogan-->

        <!--welcome container -->
        <div class="welcome">
            <div data-aos="fade-up">

                <h1>Welcome to TARUC First Aid Unit Society</h1><p>First Aid Unit of TARUC is a society that provide first aid service to those casualty in need.<br>If there is any case of Emergency, please call 03-41450240 or reach us at room A017, BangunanTan Sri Khaw Kai Boh(Ground Floor)</p>  <br>
                <h1>History of First Aid Unit :</h1><p>In 1979, a TARC student met with an accident. He lost a lot of blood and thus, needed a blood transfusion urgently to survive. Caring TARC student came forward to donate blood. The incident stimulated fellow TARC student to establish the FIRST AID UNIT in the same year, with the purpose of organizing Blood Donation Campaign. This was how out motto ‘To Serve’ came about, as the unit is the sole provider of first aid service to students and staff in the college. Apart from creating awareness among students of the life-saving virtues of blood donating, FAU Provides opportunities for member to learn first aid knowledge in addition of developing their leadership skills so that they are able to lead and help each other. Presently, FAU stands as one of the most active society in TARUC, its numerous campaigns and activities has received overwhelming support from students and college authorities.</p>              
            </div>

        </div>

        <!--available event container -->
        <div style="background-color:#333333;padding-bottom: 1%;">
            <h1 style="text-align:center;background-image: url('../picture/background/background2.jpg');margin-top: 0px;padding: 2%;">Current Available Event</h1>
            <div style="width:60%;margin:auto;margin-bottom: 4%;margin-top: 4%;" data-aos="fade-up">
                <div class="owl-carousel slide2 owl-theme">
                    <?php
                        require_once('helper.php');
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //connect database
                        $sql="SELECT Picture_location , EventID FROM event";  //display detail from database
                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {
                                echo('
                                    <div class="container">
                                    <img src="'.$row->Picture_location.'" onclick="linkFunction(\'event_detail.php?id='.$row->EventID.'\');"/>
                                    </div>'
                                );
                            } 
                        }
                    ?>                   
                </div>
            </div>
        </div>
    </body>

    <!--footer -->
    <footer>
        <div data-aos="fade-up">
            <h1><img src="../picture/icon/phone.png" style="width:30px"/> Contact number:</h1><a href="tel:+60341450240" style="font-size:20px;">+60341450240</a>
            <h1><img src="../picture/icon/email.png" style="width:30px"/> Email:</h1><a href="mailto:@gmail.com" style="font-size:20px;">firstaidtaruc@gmail.com</a>
            <h1>Follow Us At</h1>
            <a href="https://www.instagram.com/taruc_fau/?utm_medium=copy_link" target="_blank"><img src="../picture/icon/instagram.png" style="width:50px;margin-right: 10px;"/></a><a href="https://www.facebook.com/FirstAidUnitTARUC" target="_blank"><img src="../picture/icon/facebook.png" style="width:50px;"/></a>
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
        $(document).ready(function () {
            $(".owl-carousel.slide1").owlCarousel({
                items: 2,
                autoplay: true,
                autoplayTimeout: 2500,
                loop: true,
                dots: false,
            });
            $(".owl-carousel.slide2").owlCarousel({
                items: 1,
                loop: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 2000,

            });
            AOS.init();
        });

        function linkFunction(url) {
            location.href = url;
        }
    </script>
</html>
