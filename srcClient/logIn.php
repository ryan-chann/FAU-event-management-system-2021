<?php
if (!isset($studentID)) {
    $studentID = '';
}

if (!isset($password)) {
    $password = '';
}

require_once("logIn2.php")
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->


<?php
if (!isset($_SESSION['studentID']) && !isset($_SESSION['email']) && !isset($_SESSION['name']) && !isset($_SESSION['phone']) && !isset($_SESSION['gender']) && !isset($_SESSION['faculty']) && !isset($_SESSION['password'])) {
    ?>
    <html>
        <head>
            <!-- Reference Sources -->
            <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
            <!-- CSS Sources -->
            <link rel="stylesheet" href="../css/layout.css">
            <link rel="stylesheet" href="../css/homepage.css">
            <link rel="stylesheet" href="../css/owl.carousel.css">
            <link rel="stylesheet" href="../ss/owl.theme.default.css">
            <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
            <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
            <link rel="stylesheet" href="../css/bootstrap.min.css">
            <link rel="stylesheet" href="../css/layout.css">

            <!-- Javascript Sources -->
            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/bootstrap.bundle.min.js"></script>
            <script src="../js/bootstrap.esm.min.js"></script>
            <script src="../js/jquery.js"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="sweetalert2.all.min.js"></script>
            <script src="sweetalert2.min.js"></script>
            <link rel="stylesheet" href="sweetalert2.min.css">

            <!-- Special font Source -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

            <!-- Title Name -->
            <title>FAU- Log In</title>

            <!-- Title Icon -->
            <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">


        </head>
        <body>
            <?php
            //Include Header.php
            require_once('header.php');
            ?>

            <!-- Log In form -->
            <form name="logInForm" action="logIn.php" method="POST" class="bg-light bg-gradient pb-5 load">
                <!-- Table for alignment -->
                <table class="px-auto mx-auto">
                    <!-- Table row 1 (Message) -->
                    <tr>
                        <td class = "pb-1 px-auto">
                            <h3 class="text-muted pt-5">Log In</h3>
                        </td>
                    </tr>
                    <!-- Table row 2 (Student ID input field) -->
                    <tr>
                        <td>
                            <div class="form-floating mb-3 mx-auto">
                                <input type="text" class="form-control" name="studentID" id="studentID" maxlength ="10" value="<?php echo htmlspecialchars($studentID) ?>" placeholder=" "/>
                                <label for="floatingInput">Student ID*</label>                     
                            </div>
                        </td>
                    </tr>

                    <!-- Table row 3 (Password input field) -->
                    <tr>
                        <td>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="password" value="<?php echo htmlspecialchars($password) ?>" placeholder=" "/>
                                <label for ="floatingInput" class="col-form-label">Password*</label>
                            </div>
                        </td>
                    <tr>

                        <!-- Table row 4 (Forgot Password Hyperlink) -->
                    <tr>
                        <td class="pb-2"><a href="forgotPassword.php">Forgot password?</a>
                    </tr>

                    <!-- Table row 5 (Sign Up Hyperlink) -->
                    <tr>
                        <td class="pb-3"><a href="signUp.php">Don't have an account?</a>
                    </tr>

                    <!-- Table row 6 (Log In Button) -->
                    <tr>
                        <td>
                            <input type="submit" name="logIn" value="LOG IN" class="btn btn-primary"/>
                        </td>
                    </tr>                    
                </table>     
            </form>

            <?php
            //Include Footer
            require_once('footer.php');
        } else {
            header('location: myProfile.php');
        }
        ?>

    </body>
</html>
