<?php
require_once ('helper.php');
require_once ('dataHandling.php');

if (!isset($newStudentName)) {
    $newStudentName = '';
}

if (!isset($newConfirmPassword)) {
    $newConfirmPassword = '';
}

if (!isset($newPassword)) {
    $newPassword = '';
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

        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../ss/owl.theme.default.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/layout.css">
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/bootstrap.esm.min.js"></script>
        <script src="../js/jquery.js"></script>  
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


        <title>FAU - My Profile</title>

        <style>
            .welcome-msg{
                font-family: sans-serif;
                font-weight: bold;
                font-size: 34px;
            }

            .information-msg-bold{
                font-family: Helvetica;
                font-weight: bold;
                font-size:22px;
            }

            .information-msg{
                font-family:Franklin Gothic;
                font-size:22px;
            }


        </style>
    </head>
    <body>
        <!-- Form to capture submit button input -->
        <form method="POST"> 

            <?php
            if (isset($_SESSION['studentID']) && isset($_SESSION['email']) && isset($_SESSION['name']) && isset($_SESSION['phone']) && isset($_SESSION['gender']) && isset($_SESSION['faculty']) && isset($_SESSION['password'])) {
                require_once('header2.php');
                ?>

                <!-- Welcome Message -->
                <section class="pb-1 pt-5"> 
                    <div class="d-flex flex-column">
                        <p class="welcome-msg mx-auto">Welcome Back, Student <?php echo $_SESSION['studentID']; ?></p>
                    </div>
                </section>

                <!-- Break line after the Welcome Message -->
                <hr class="w-75 mx-auto">

                <!-- Section to display out the student's information -->
                <section class="container px-5 py-5">
                    <!--First row to display the student's name -->
                    <div class="d-flex flex-row mt-3 justify-content-center">
                        <p class="mt-2 py-2 information-msg-bold" style="padding:0px 150px 0px 0px;">Name :</p>
                        <p class="p-2 mt-2 information-msg flex-grow-1"> <?php echo $_SESSION['name']; ?></p>
                        <button type="button" class="btn btn-outline-success my-2 align-items-center fw-bold" style="padding:0px 88px 0px 88px;" data-bs-toggle="modal" data-bs-target="#editName">Edit Name</button>

                        <!-- Bootstrap Modal (Edit Name) -->
                        <div class="modal fade" id="editName" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editName" ModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editNameModalLabel">Edit New Name</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                    </div>
                                    <!-- Modal Body -->
                                    <form method="post" name="editNameForm">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="newName" class="col-form-label">Enter New Name: </label>
                                                <input type="text" class="form-control" id="newName" name="newName">
                                            </div>
                                        </div>
                                        <!-- Modal Footer -->
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <input type="submit" name="changeName" value="Save Changes" class="btn btn-primary" onclick="location = '<?php echo $_SERVER['PHP_SELF']; ?>'"/>
                                    </form>
                                </div> 
                            </div> 
                        </div> 
                    </div>
                    </div>

                    <!-- Display Student ID -->
                    <div class="d-flex flex-row mt-3 justify-content-center">
                        <p class="mt-2 py-2 information-msg-bold" style="padding:0px 100px 0px 0px;">Student ID :</p>
                        <p class="p-2 mt-2 information-msg flex-grow-1"> <?php echo $_SESSION['studentID']; ?></p>
                        <button type="button" class="btn btn-outline-success my-2 align-items-center fw-bold" style="padding:0px 65px 0px 65px;" onclick="contactAdmin()">Edit Student ID</button>
                    </div>

                    <!-- Display Email Address -->
                    <div class="d-flex flex-row mt-3 justify-content-center">
                        <p class="py-2 mt-2 information-msg-bold" style="padding:0px 60px 0px 0px;">Email Address :</p>
                        <p class="p-2 mt-2 information-msg flex-grow-1">  <?php echo $_SESSION['email']; ?></p>
                        <button type="button" class="btn btn-outline-success my-2 align-items-center fw-bold" style="padding:0px 90px 0px 89px;" onclick="contactAdmin()">Edit Email</button>
                    </div>

                    <!-- Display Faculty -->
                    <div class="d-flex flex-row mt-3 justify-content-center">
                        <p class="py-2 mt-2 information-msg-bold" style="padding:0px 135px 0px 0px;"> Faculty :</p>
                        <p class="p-2 mt-2 information-msg flex-grow-1"> <?php echo $_SESSION['faculty']; ?></p>
                        <button type="button" class="btn btn-outline-success my-2 align-items-center fw-bold" style="padding:0px 82px 0px 81px;" data-bs-toggle="modal" data-bs-target="#editFaculty">Edit Faculty</button>
                    </div>   

                    <!-- Bootstrap Modal (Edit Faculty) -->
                    <div class="modal fade" id="editFaculty" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editFaculty" ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editNameModalLabel">Edit Faculty</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                </div>

                                <!--Modal Body-->
                                <form method="post" name="editNameForm">
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <select id="faculties" name="newFaculty" class="form-select mb-3">
                                                <?php
                                                $faculty = getFaculties();

                                                foreach ($faculty as $key => $value) {
                                                    echo
                                                    "<option value='$key'>$value</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!--Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" name="changeFaculty" value="Save Changes" class="btn btn-primary" onclick="location = '<?php echo $_SERVER['PHP_SELF']; ?>'"/>
                                </form>
                            </div> 
                        </div> 
                    </div> 
                    </div>    

                    <!-- Display Phone Number -->
                    <div class="d-flex flex-row mt-3 justify-content-center">
                        <p class="py-2 mt-2 information-msg-bold" style="padding:0px 55px 0px 0px;"> Phone Number :</p>
                        <p class="p-2 mt-2 information-msg flex-grow-1"> <?php echo $_SESSION['phone']; ?></p>
                        <button type="button" class="btn btn-outline-success my-2 align-items-center fw-bold" style="padding:0px 48px 0px 47px;" onclick="contactAdmin()">Edit Phone Number</button>
                    </div>   

                    <!-- Display Gender -->
                    <div class="d-flex flex-row mt-3 justify-content-center">
                        <p class="py-2 mt-2 information-msg-bold" style="padding:0px 135px 0px 0px;"> Gender :</p>
                        <p class="p-2 mt-2 information-msg flex-grow-1"> <?php echo $_SESSION['gender']; ?></p>
                        <button type="button" class="btn btn-outline-success my-2 align-items-center fw-bold" style="padding:0px 81px 0px 82px;" onclick="contactAdmin()">Edit Gender</button>
                    </div>  

                    <section class="mt-5">
                        <div class="d-flex flex-row mt-5 justify-content-center">
                            <button type="button" class="btn btn-lg btn-primary justify-content-center" data-bs-toggle="modal" data-bs-target="#editPassword">Change Password</button>
                            <!-- Modal -->
                            <div class="modal fade" id="editPassword" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editPasswordModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editPasswordModalLabel">Change Password</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
                                        </div>
                                        <form class="container" method="post">
                                            <div class="modal-body">
                                                <div class="mb-3 row">
                                                    <label for="newPassword" class="col-form-label">Enter New Password :</label>
                                                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                                                </div>
                                                <div class="row">
                                                    <label for="confirmNewPassword" class="col-form-label">Enter Confirm Password :</label>
                                                    <input type="password" class="form-control" id="confirmNewPassword" name="newConfirmPassword">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <input type="submit" name="changePassword" value="Save Changes" class="btn btn-primary" onclick="location = '<?php echo $_SERVER['PHP_SELF']; ?>'" />
                                            </div> 
                                        </form>
                                    </div> 
                                </div> 
                            </div>
                        </div>
                        <div class="d-flex flex-row mt-4 justify-content-center">
                            <input type="submit" name="logOut" value="Log Out" class="btn btn-danger" onclick="location = '<?php echo $_SERVER['PHP_SELF']; ?>'"/>
                        </div>
                    </section>
                </section>   
            </form>
            <?php
        } else {
            header('location: logIn.php');
        }
        ?>

        <?php
        require_once('footer.php');
        ?>
    </body>
    <script>
        function contactAdmin(){
            alert('Please contact the admin to change the data field requested');
        }
    </script>

</html>
