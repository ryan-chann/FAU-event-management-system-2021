<?php
//Include Helper.php to move in functions
require_once('helper.php');



//If input field = NULL, Clear the fields
if (!isset($email)) {
    $email = '';
}

if (!isset($firstName)) {
    $firstName = '';
}

if (!isset($lastName)) {
    $lastName = '';
}

if (!isset($phoneNumber)) {
    $phoneNumber = '';
}

if (!isset($studentID)) {
    $studentID = '';
}

if (!isset($password)) {
    $password = '';
}

if (!isset($confirmPassword)) {
    $confirmPassword = '';
}

if (!isset($gender)) {
    $gender = '';
}
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <!-- Reference Sources -->
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <!-- CSS Sources -->
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../css/owl.theme.default.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/layout.css">

        <!-- Javascript Sources -->
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/bootstrap.esm.min.js"></script>
        <script src="../js/jquery.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <!-- Special font Source -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Link Bar Design -->
        <title>FAU - Sign Up</title>
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">

    </head>
    <body>
        <!-- Insert Header -->
        <?php
        session_start();
        if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
            require_once('header2.php');
        } else {
            require_once('header.php');
        }
        ?>

        <!-- Section to have different parts of the design -->
        <section>

            <!-- Start the form to allow input from user -->
            <form method="post" action="signUp2.php" name="signUpForm" class="bg-light bg-gradient pb-5">

                <!-- Table to align items in rows and columns -->
                <table class="px-auto mx-auto">

                    <!--Table Row 1 (Message)-->
                    <tr>
                        <!-- Column 1 for Row 1 -->
                        <td>
                            <h2 class="text-muted pt-5 h2">Sign Up</h2>
                            <p class="text-muted">Sign up an account with us to get the latest updates from the TARUC FAU Society!!</p>
                        </td>
                    </tr>
                    <!-- End Row 1 -->


                    <!--Table Row 2 (Student ID Form)-->
                    <tr>
                        <!-- Column 1 for Row 2 -->
                        <td>
                            <div class="form-floating mb-3 mx-auto">
                                <input type="text" class="form-control" name="studentID" id="studentID" maxlength ="10" value="<?php echo htmlspecialchars($studentID) ?>" placeholder="20WMD01878"/>
                                <label for="floatingInput">Student ID*</label>                     
                            </div>
                        </td>

                        <!-- Column 2 for Row 2 (Validation) -->
                        <td>
                            <!-- If there is any error -->
                            <?php
                            if (isset($studentID_error)) {
                                getErrorAlert($studentID_error);
                                getIconInvalid();
                            } else if (!isset($studentID_error) && !empty($studentID)) {
                                getIconValid();
                            }
                            ?>
                        </td>
                    </tr>
                    <!--End Row 2-->

                    <!--Table Row 3 (First Name)-->
                    <tr>
                        <td>
                            <div class="form-floating mb-3 mx-auto">
                                <input type="text" class="form-control" name="FirstName" id="FirstName" maxlength="15" placeholder="Ryan" value="<?php echo htmlspecialchars($firstName) ?>"/>
                                <label for="floatingInput">First Name*</label>
                            </div>
                        </td>
                        <td>
                            <?php
                            if (isset($firstName_error)) {
                                getErrorAlert($firstName_error);
                                getIconInvalid();
                            } else if (!isset($firstName_error) && !empty($firstName)) {
                                getIconValid();
                            }
                            ?>
                        </td>
                    </tr>
                    <!-- End Row 3 -->


                    <!--Table Row 4 (Last Name)-->
                    <tr>
                        <td>
                            <div class="form-floating mb-3 mx-auto">
                                <input type="text" class="form-control" name="LastName" id="LastName" maxlength="15" placeholder="Chan" value="<?php echo htmlspecialchars($lastName) ?>"/>
                                <label for="floatingInput">Last Name</label>
                            </div>
                        </td>
                    </tr>
                    <!-- End Row 4 -->

                    <!-- Table Row 5 (Phone Number)-->
                    <tr>
                        <td>
                            <div class="form-floating mb-3 mx-auto">
                                <input type="text" class="form-control" name="phoneNumber" id="phoneNumber" maxlength="15" placeholder="xxx-xxx-xxxx" value="<?php echo htmlspecialchars($phoneNumber) ?>"/>
                                <label for="floatingInput">Phone Number*</label>
                            </div>
                        </td>
                        <td>
                            <?php
                            if (isset($phoneNumber_error)) {
                                getErrorAlert($phoneNumber_error);
                                getIconInvalid();
                            } else if (!isset($phoneNumber_error) && !empty($phoneNumber)) {
                                getIconValid();
                            }
                            ?>
                        </td>                    
                    </tr>
                    <!-- End Row 5 -->




                    <!--Table Row 7 (Email Address)-->
                    <tr>
                        <!-- Column 1 for Row 7 -->
                        <td>
                            <div class="form-floating mb-3">
                                <input type="text" name="EmailAddress" class="form-control" id="emailAddress" value="<?php echo htmlspecialchars($email) ?>" placeholder="name@example.com"/>
                                <label for="floatingInput">Email Address*</label> 
                            </div>
                        </td>

                        <!-- Column 2 for Row 7 -->
                        <td>
                            <!-- If there is any error -->
                            <?php
                            if (isset($email_error)) {
                                getErrorAlert($email_error);
                                getIconInvalid();
                            } else if (!isset($email_error) && !empty($email)) {
                                getIconValid();
                            }
                            ?>                     
                        </td>
                    </tr>
                    <!-- End Row 7 -->

                    <!--Table Row 6 (Gender) -->
                    <tr>
                        <td>
                            <select id="genders" name="genders" class="form-select mb-3">
                                <?php
                                $genders = getGenders();

                                foreach ($genders as $key => $value) {
                                    echo
                                    "<option value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <?php
                            if (isset($genders_error)) {
                                getErrorAlert($genders_error);
                                getIconInvalid();
                            }
                            ?>                      
                        </td>
                    </tr>
                    <!-- End Row 6 -->

                    <!--Table Row 10 (Faculties)-->
                    <tr>
                        <!-- Column 1 for Row 10 -->
                        <td>
                            <select id="faculties" name="faculties" class="form-select mb-3">
                                <?php
                                $faculty = getFaculties();

                                foreach ($faculty as $key => $value) {
                                    echo
                                    "<option value='$key'>$value</option>";
                                }
                                ?>
                            </select>
                        </td>

                        <!-- Column 2 for Row 10 -->
                        <td>
                            <?php
                            if (isset($faculty_error)) {
                                getErrorAlert($faculty_error);
                                getIconInvalid();
                            }
                            ?>                      
                        </td>
                    </tr>
                    <!-- End Row 10 -->


                    <!--Table Row 8 (Password) -->
                    <tr>
                        <!-- Column 1 for Row 8 -->
                        <td>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="password" value="<?php echo htmlspecialchars($password) ?>" placeholder="Abcd1234"/>
                                <label for ="floatingInput" class="col-form-label">Password*</label>
                            </div>
                        </td>

                        <!-- Column 2 for Row 8 -->
                        <td>
                            <!-- If there is any error -->
                            <?php
                            if (isset($password_error)) {
                                getErrorAlert($password_error);
                                getIconInvalid();
                            } else if (!isset($password_error) && !empty($password)) {
                                getIconValid();
                            }
                            ?>                     
                        </td>
                    </tr>
                    <!-- End Row 8 -->


                    <!--Table Row 9 (Confirm Password)-->
                    <tr>
                        <!-- Column 1 for Row 9 -->
                        <td>
                            <div class="form-floating mb-3">
                                <input type="password" name="confirmPassword" class="form-control" id="confirmPassword" value="<?php echo htmlspecialchars($confirmPassword) ?>" placeholder="Abcd1234" />
                                <label for ="floatingInput" class="col-form-label">Retype Password*</label>
                            </div>
                        </td>

                        <!-- Column 2 for Row 9 -->
                        <td>
                            <!-- If there is any error -->
                            <?php
                            if (isset($confirmPassword_error)) {
                                getErrorAlert($confirmPassword_error);
                                getIconInvalid();
                            } else if (!isset($confirmPassword_error) && !empty($confirmPassword)) {
                                getIconValid();
                            }
                            ?>
                        </td>
                    </tr>
                    <!-- End Row 9 -->




                    <!-- Table Row 11 (Hyperlink "Already Have An Account?")-->
                    <tr>
                        <!-- Column 1 for Row 11-->
                        <td class="pb-3"><a href="logIn.php">Already have an account? </a>
                    </tr>
                    <!-- End Row 11 -->

                    <!-- Table Row 12 (Submit Button) -->
                    <tr>
                        <!-- Column 1 for Row 12-->
                        <td>
                            <!-- Button to submit the data entered by user 
                                $_SERVER is an array hence this button will trigger index "PHP_SELF"
                                Which will return the filename of the currently executing script -->        
                            <input type="submit" name="signUp" value="SIGN UP" class="btn btn-primary" onclick="location = '<?php echo $_SERVER['PHP_SELF']; ?>'"/>
                        </td>
                    <tr>
                        <!-- End Row 12 -->


                </table>
                <!-- End Table -->
        </section>
        <?php
        require_once('footer.php');
        ?>
    </body>
</html>
