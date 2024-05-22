<?php
require_once("helper.php");
session_start();
if (!isset($name)) {
    $name = '';
}

if (!isset($contactUsEmail)) {
    $contactUsEmail = '';
}

if (!isset($student)) {
    $student = '';
}

if (!isset($inquiry)) {
    $inquiry = "";
}
?>
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
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/layout.css">
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/bootstrap.esm.min.js"></script>
        <script src="../js/jquery.js"></script>  
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <title>FAU - Contact Us</title>
        <style>
            mark{
                background-color: rgba(0,0,0,0.277);
                color:white;
            }
            .contact-section-bg{
                background-image : url("../picture/contact-us-bg.png");
            }

            .font-helvetica{
                font-family: Helverica;
                font-weight: bold;
                font-size:45px;
                color:white;               
            }

            .font-consolas{
                font-family: Consolas;
                font-weight:bold;
                font-size: 20px;
                color:black;
            }

            .font-consolas-14{
                font-family: Consolas;
                font-weight:bold;
                font-size: 18px;
                color:black;                
            }

            input[type=radio]{
                width:20px;
                height:20px;
            }

        </style>
    </head>
    <body>
        <?php
        if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
            require_once('header2.php');
        } else {
            require_once('header.php');
        }
        ?>
        <section class="contact-section-bg">
            <div class="container py-5">
                <div class="row text-center mb-3 mt-5">
                    <h3 class="font-helvetica"><mark>Have any questions?</mark></h3>
                </div>
                <div class="row text-center pb-4">
                    <p class="font-consolas">
                        <mark>TARUC FAU Society members always welcome to hear from you.</mark>
                    </p>                
                </div>
            </div>
        </section>
        <div class="bg-light bg-gradient py-5">
            <section class="container">
                <form class="row" method="post" action="contactUs2.php" name="contactUsForm">
                    <div class="row mx-auto">
                        <div class="col-9 form-floating mb-4">
                            <input type="text" name="name" id="name" class="form-control mx-2" maxLength="30" placeholder="Ryan Chan Joon Yew" value="<?php echo htmlspecialchars($name) ?>"/>
                            <label for="floatingInput" class="mx-3">Name (As Per NRIC)</label>
                        </div>
                        <div class="col-1">
                            <?php
                            if (isset($nameError)) {
                                getErrorAlert($nameError);
                                getIconInvalid();
                            } else if (!isset($nameError) && !empty($name)) {
                                getIconValid();
                            }
                            ?>
                        </div>             
                    </div>
                    <div class="row mx-auto">
                        <div class="col-9 form-floating mb-4">
                            <input type="text" name="contactUsEmail" id="contactUsEmail" class="form-control mx-2" maxLength="80" placeholder="ryancjy-wm20@student.tarc.edu.my" value="<?php echo htmlspecialchars($contactUsEmail) ?>"/>
                            <label for="floatingInput" class="mx-3">Email</label>
                        </div>
                        <div class="col-1">
                            <?php
                            if (isset($contactUsEmailError)) {
                                getErrorAlert($contactUsEmailError);
                                getIconInvalid();
                            } else if (!isset($contactUsEmailError) && !empty($contactUsEmail)) {
                                getIconValid();
                            }
                            ?>                           
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col mb-3 mx-3">
                            <p class="font-consolas-14">Are you a TARUC student :<p>
                        </div>
                        <div class="col">
                            <div class="form-check mx-auto form-check-inline">
                                <input type="radio" class="form-check-input" name="student" id="studentY" <?php
                            if (isset($student) && $student == "yes") {
                                echo "checked";
                            }
                            ?> value="Yes"/>
                                <label class="form-class-label font-consolas" for="studentY">Yes</label>
                            </div>
                        </div>                           
                        <div class="col mb-3 form-check-inline form-check">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" name="student" id="studentN" 
                                <?php
                                if (isset($student) && $student == "no") {
                                    echo "checked";
                                }
                                ?>value="No"/>
                                <label class="form-class-label font-consolas" for="studentN">No</label>
                            </div>
                        </div>
                        <?php
                        if (isset($student_error)) {
                            getErrorAlert($student_error);
                        }
                        ?>
                    </div>
                    <div class="row mx-2 mb-4">
                        <div class="form-floating">  
                            <textarea class="form-control w-75" placeholder="Inquires" id="inquiry" name="inquiries" style="height:175px"></textarea>
                            <label for="floatingTextarea" class="mx-3">Comments</label>
                        </div> 
                        <?php
                        if (isset($inquiry_error)) {
                            getErrorAlert($inquiry_error);
                        }
                        ?>
                    </div>
                    <div class="row mx-4 mb-3 w-25">
                        <input type="submit" name="inquiry" value="Submit" class="btn btn-primary" onclick="location = '<?php echo $_SERVER['PHP_SELF'] ?>'"/>
                    </div>                   
                </form>
        </div>
    </section>
    <?php
    require_once ('footer.php');
    ?>

</html>
