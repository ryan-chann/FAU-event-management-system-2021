<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Fjalla+One|Libre+Baskerville">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.theme.default.css">
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <title>FAU - Search</title>
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

        <div style="text-align: center;background-image: url('../picture/background/background2.jpg');margin: 0px;padding: 0.7%;">
            <!--search event -->
            <form method="post" action="search.php">
                <input type="text" id="search" name="search" placeholder="Search for events..." title="Type in a name" style="padding: 1%;margin-left: 74%;width: 14%;">
            </form>
            <div>
                <?php
                $name = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = strtoupper(test_input($_POST["search"])); //store result name
                }
                echo "<h1 style='text-align: center;'>Result of \"" . $name . "\"</h1>";  //display search result
                ?>
                <div style="display:flex;flex-wrap:wrap;margin:auto;background-image: url(../picture/background/background.jpg)">
                    <?php
                    require_once('helper.php');
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //connect database
                    $sql = "SELECT EventID,EventName,Picture_location FROM event WHERE UPPER(EventName) LIKE '%" . $name . "%'"; //select from database
                    if ($result = $con->query($sql)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_object()) {  //while loop to find the event
                                $url = "event_detail.php?id=" . $row->EventID;
                                printf('
                                        <div style="flex:40%%;margin:5%%;max-width:40%%">
                                            <div style="color:white;text-align: center;font-size:30px;margin:2%%;">
                                            %s
                                            </div> 
                                            <div>
                                                <a href="%s">
                                                    <img src="%s" style="width:100%%";/>
                                                </a>
                                            </div>
                                        </div>', $row->EventName, $url, $row->Picture_location
                                );
                            }
                        } else {
                            print('<div style="padding:10%;background-color="black"></div>');
                        }
                    }

                    function test_input($data) {         //check data input
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }
                    ?>
                </div>
            </div>
            <div style=";padding: 2%;margin-top: 0px;background-image: url('picture/background/background2.jpg')"></div>
        </div>
    </body>

    <!--footer -->
    <footer>
        <h1><img src="../picture/icon/phone.png" style="width:30px"/> Contact number:</h1><a href="tel:+60341450240" style="font-size:20px;">+60341450240</a>
        <h1><img src="../picture/icon/email.png" style="width:30px"/> Email:</h1><a href="mailto:@gmail.com" style="font-size:20px;">firstaidtaruc@gmail.com</a>
        <h1>Follow Us At</h1>
        <a href="https://www.instagram.com/taruc_fau/?utm_medium=copy_link" target="_blank"><img src="../picture/icon/instagram.png" style="width:80px;padding: 15px;"/></a><a href="https://www.facebook.com/FirstAidUnitTARUC" target="_blank"><img src="../picture/icon/facebook.png" style="width:80px;padding: 15px;"/></a>
        <article>
            <h5>TARC FIRST AID UNIT &reg</h5>
        </article>
    </footer>
    <script src="../js/jquery.js"></script>
    <script>
        function linkFunction(url) {
            location.href = url;
        }
    </script>
</html>








