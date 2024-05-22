<?php
require_once("helper.php");
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
        <title>FAU - Contact Us</title>
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="sweelalert2-master/src/Sweetalert2.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <?php
        if (isset($_POST['inquiry'])) {
            /* Contact Us Variables */
            $name = trim(filter_input(INPUT_POST, 'name'));
            $contactUsEmail = trim(filter_input(INPUT_POST, 'contactUsEmail'));
            $student = filter_input(INPUT_POST, 'student');
            $inquiry = trim(filter_input(INPUT_POST, 'inquiries'));

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $nameError = getNameError($name);
                $contactUsEmailError = getEmailError($contactUsEmail);
                $student_error = getStudentError($student);
                $inquiry_error = getInquiry_error($inquiry);

                if (empty($nameError) && empty($contactUsEmailError) && empty($student_error) && empty($inquiry_error)) {
                    if ($student == "Yes") {
                        $header = "From: Inquiries from Student $name";
                    } else if ($student == "No") {
                        $header = "From: Inquiries from User $name";
                    }
                    $to = "phpprojectryan@gmail.com";

                    if (mail($to, $contactUsEmail, $inquiry, $header)) {
                        printf('<script>swal.fire("Thank You!!!", "Thank you for reaching out to us.Your inquiry has been recorded, We will get back to you as soon as possible", "success", {button: "OK",}).then((value) => {location.href="homepage.php";});;</script>');
                    }
                    $name = $contactUsEmail = $student = $inquiry = NULL;
                    $nameError = $contactUsEmailError = $student_error = $inquiry_error = NULL;
                } else {
                    include("contactUs.php");
                }
            } else {
                printf('<script>swal.fire("Oh No....!!!", "Something went wrong! Please contact us to resolve this issue.", "error", {button: "OK",}).then((value) => {location.href="contactUs.php";});;</script>');
            }
        } else {
            printf('<script>swal.fire("Oh No....!!!", "Something went wrong! Please contact us to resolve this issue.", "error", {button: "OK",}).then((value) => {location.href="contactUs.php";});;</script>');
        }
        ?>
    </body>
</html>
