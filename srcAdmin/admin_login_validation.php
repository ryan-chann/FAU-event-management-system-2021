<header>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Administrator Log In</title>
</header>
<?php
session_start();
require_once('helper.php');
if (isset($_POST['submit'])) {

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $emailipt = $_POST['email'];
    $passwordipt = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE Email = '$emailipt' AND Password = '$passwordipt' ";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            //Set SESSION array with the data
            $_SESSION['AdminID'] = $row->AdminID;
            $_SESSION['AdEmail'] = $row->Email;
            $_SESSION['AdName'] = $row->Name;
            $_SESSION['AdPhone'] = $row->Contact;
            $_SESSION['AdPassword'] = $row->Password;
        }
        header('location: admin_dashboard.php');
    } else if (empty($emailipt && $passwordipt)) {
        $email_error = "Please enter Email";
        $password_error = "Please enter Password";
        ?>
        <script>
            swal({
                title: "Log In Failed!",
                text: "Failed to log in!",
                icon: "error",
                button: "OK"
            });
        </script>
        <?php
    } else {
        $emailipt = '';
        $passwordipt = '';
        $email_error = "Invalid Email";
        $password_error = "Invalid Password";
        ?>
        <script>
            swal({
                title: "Log In Failed!",
                text: "Failed to log in!",
                icon: "error",
                button: "OK",
            });
        </script>
        <?php
    }

    $con->close();
}
?>
