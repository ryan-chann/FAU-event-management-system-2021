<?php
if (!isset($forgotPassword)) {
    $forgotPassword = '';
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
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="../css/homepage.css">
        <link rel="stylesheet" href="../css/owl.carousel.css">
        <link rel="stylesheet" href="../ss/owl.theme.default.css">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="icon" href="../picture/icon/titleIcon.jpg" type="image" sizes="16x16">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/bootstrap-grid.min.css">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/layout.css">
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/bootstrap.bundle.min.js"></script>
        <script src="../js/bootstrap.esm.min.js"></script>
        <script src="../js/jquery.js"></script>  
        <title>FAU - Forgot Password</title>
    </head>
    <body>
        <?php
        include('header.php');
        require_once('header.php');
        ?>

        <section>
            <form method="post" action="forgotPassword2.php" name="fpEmailAddress" class="bg-light bg-gradient pb-5">
                <table class="px-auto mx-auto load">
                    <tr>
                        <td>
                            <h3 class="text-muted pt-5">Enter Your Email Address: </h3>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-floating mx-auto">
                                <input type="text" class="form-control" name="forgotPassword" id="forgotPassword" value="<?php echo htmlspecialchars($forgotPassword) ?>" placeholder="name@example.com"/>  
                                <label for="floatingInput">Email Address</label>
                            </div>
                        </td>
                        <td>
                            <?php
                            if (isset($email_error)) {
                                echo "<div class='alert alert-danger'><strong>$email_error</strong>";
                            } else if (!isset($email_error) && !empty($email)) {
                                ?>
                                <i class="material-icons" style="font-size:48px; color:green">done</i>
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="col text-center">
                            <input type="submit" name="fpSubmit" value="Enter" class="btn btn-primary px-5 mt-3 text-center" onclick="location = '<?php echo $_SERVER['PHP_SELF']; ?>'"/> 
                        </td>
                    </tr>
                </table>
            </form>
        </section>


        <?php
        include('footer.php');
        require_once('footer.php');
        ?> 
    </body>
</html>
