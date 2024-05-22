<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/eventpage.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Libre+Baskerville">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.theme.default.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <title>FAU - Event Page</title>
    </head>
    <body>
        <!--navigation bar-->
        <?php
        session_start();
        if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
            require_once('header2.php');
        } else {
            require_once('header.php');
        }
        ?>
        
        <div style="text-align: center;background-image: url('../picture/background/background2.jpg');margin: 0px;padding: 0.7%;">

            <!--search event -->
            <form method="post" action="search.php">
                <input type="text" id="search" name="search" placeholder="Search for events..." title="Type in a name" style="padding: 1%;margin-left: 74%;width: 14%;"></div>
            </form>

            <!-- event category container -->
            <div style="display: flex;flex-wrap: wrap; background-image: url('../picture/background/background.jpg')">
                <div style="background-image: url('../picture/background/event.jpg');border-style: solid;border-color: gold;" class="category" onclick="linkFunction('charityevent.php');" data-aos="fade-up">
                    CHARITY EVENT
                </div>
                <div style="background-image: url('../picture/background/competition.jpg');border-style: solid;border-color: gold;" class="category" onclick="linkFunction('competition.php');" data-aos="fade-up">
                    COMPETITIONS
                </div>
                <div style="background-image: url('../picture/background/workshop.jpg');border-style: solid;border-color: gold;" class="category" onclick="linkFunction('workshop.php');" data-aos="fade-up">    
                    WORKSHOP
                </div>
                <div style="background-image: url('../picture/background/volunteering.jpg');border-style: solid;border-color: gold;" class="category" onclick="linkFunction('volunteering.php');" data-aos="fade-up">
                    VOLUNTEERING
                </div>
                <div style="background-image: url('../picture/background/blood_donation.jpg');border-style: solid;border-color: gold;" class="category" onclick="linkFunction('blooddonation.php');" data-aos="fade-up">
                    BLOOD DONATION
                </div>
                <div style="background-image: url('../picture/background/comingsoon.jpg');border-style: solid;border-color: gold;" class="category" data-aos="fade-up">
                </div>
            </div>

            <div style=";padding: 2%;margin-top: 0px;background-image: url('../picture/background/background2.jpg')"></div>
    </body>

    <!--footer -->
    <footer>
        <div data-aos="fade-up">
            <h1><img src="../picture/icon/phone.png" style="width:30px"/> Contact number:</h1><a href="tel:+60341450240" style="font-size:20px;">+60341450240</a>
            <h1><img src="../picture/icon/email.png" style="width:30px"/> Email:</h1><a href="mailto:@gmail.com" style="font-size:20px;">firstaidtaruc@gmail.com</a>
            <h1>Follow Us At</h1>
            <a href="https://www.instagram.com/taruc_fau/?utm_medium=copy_link" target="_blank"><img src="../picture/icon/instagram.png" style="width:80px;padding: 15px;"/></a><a href="https://www.facebook.com/FirstAidUnitTARUC" target="_blank"><img src="../picture/icon/facebook.png" style="width:80px;padding: 15px;"/></a>
            <article>
                <h5>TARC FIRST AID UNIT &reg</h5>
            </article>
        </div>
    </footer>

    <!--java script -->
    <script src="../js/jquery.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
                    $(document).ready(function () {
                        AOS.init();
                    });
                    function myFunction() {
                        var input, filter, ul, li, a, i, txtValue;
                        input = document.getElementById("myInput");
                        filter = input.value.toUpperCase();
                        ul = document.getElementById("myUL");
                        li = ul.getElementsByTagName("li");
                        for (i = 0; i < li.length; i++) {
                            a = li[i].getElementsByTagName("a")[0];
                            txtValue = a.textContent || a.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                li[i].style.display = "";
                            } else {
                                li[i].style.display = "none";
                            }
                        }
                    }

                    function linkFunction(url) {
                        location.href = url;
                    }
    </script>

</html>

