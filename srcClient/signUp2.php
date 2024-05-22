<?php
require_once('helper.php');
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
        <title>FAU - Sign Up</title>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
    </head>
    <body>

        <?php
        if (isset($_POST['signUp'])) {
            //Sign Up Variables (Get from user input)
            //Trim used to remove unnecessary spaces
            //Filter_input default filters INPUT_POST(Get from POST method) input with name
            $email = trim(filter_input(INPUT_POST, 'EmailAddress'));
            $firstName = trim(filter_input(INPUT_POST, 'FirstName'));
            $lastName = trim(filter_input(INPUT_POST, 'LastName'));
            $studentID = filter_input(INPUT_POST, 'studentID');
            $password = filter_input(INPUT_POST, 'password');
            $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');
            $phoneNumber = trim(filter_input(INPUT_POST, 'phoneNumber'));
            $faculty = filter_input(INPUT_POST, 'faculties');
            $genders = filter_input(INPUT_POST, 'genders');


            //The page is accessed with POST method
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                //Get input errors from helper.php functions
                $email_error = getEmailError($email);
                $studentID_error = getStudentIDError($studentID);
                $firstName_error = getNameError($firstName);
                $phoneNumber_error = getPhoneNumberValidation($phoneNumber);
                $faculty_error = getFacultyError($faculty);
                $genders_error = getGendersError($genders);
                $password_error = getPasswordValidation("all", $password);
                $confirmPassword_error = getPasswordValidation("all", $password);

                //Password must be same with confirm password
                if (strcmp($password, $confirmPassword) != 0) {
                    $password_error = "Password must match with confirm password";
                    $confirmPassword_error = "Password must match with confirm password";
                }

                //If there is no errors
                if (empty($studentID_error) && empty($email_error) && empty($password_error) && empty($confirmPassword_error) && empty($firstName_error) && empty($phoneNumber_error) && empty($faculty_error) && empty($genders_error)) {
                    //Combine first name and last name 
                    $name = $firstName . " " . $lastName;

                    //Set connection
                    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    //Define sql Insert statement into variable
                    $sql = '
                        INSERT INTO user (StudentID, Email, Password, Name, Phone, Gender, Faculty)
                        VALUES (?, ?, ?, ?, ?, ?, ?)
                    ';

                    //Set statement to database with sql statement preparation
                    $statement = $connection->prepare($sql);

                    // Bind Parameters
                    $statement->bind_param('sssssss', $studentID, $email, $password, $name, $phoneNumber, $genders, $faculty);

                    //Execute Statement
                    $statement->execute();

                    //If statement have any affected rows
                    if ($statement->affected_rows > 0) {

                        //Execute alert box to indicate successfully registered the account
                        printf('<script>swal.fire("Congratulations!!", "You have successfully signed up an account", "success", {button: "OK",}).then((value) => {location.href="logIn.php";});;</script>');
                    } else {
                        printf('<script>swal.fire("Oh No....!!!", "Something went wrong! Please contact us to resolve this issue.", "error", {button: "OK",}).then((value) => {location.href="contactUs.php";});;</script>');
                    }
                    //If there is errors include sign up php with error messages
                } else {
                    include('signUp.php');
                }
            } else {
                include('signUp.php');
            }
        } else {
            printf('<script>swal.fire("Oh No....!!!", "Something went wrong! Unexpected way to access sign up page", "error", {button: "OK",}).then((value) => {location.href="signUp.php";});;</script>');
    }
    ?>      
</body>
</html>
