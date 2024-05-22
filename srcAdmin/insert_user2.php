<header>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Add User Record</title>
</header>

<?php
require_once 'helper.php';
$studentId = trim(strtoupper($_POST['studentId']));
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$gender = $_POST['gender'];
$faculty = $_POST['faculty'];
$password = trim($_POST['password']);
$conPwd = trim($_POST['conPwd']);

if (isset($_POST['submit'])) {
    $stdIDRegex = "/^\d{2}[A-Z]{3}\d{5}$/";

    $passwordRegex1 = "#[0-9]+#";
    $passwordRegex2 = "#[A-Z]+#";
    $passwordRegex3 = "#[a-z]+#";

    $numberPass = preg_match($passwordRegex1, "$password");
    $uppercasePass = preg_match($passwordRegex2, "$password");
    $lowercasePass = preg_match($passwordRegex3, "$password");

    function isStudentID($studentId) {
        $exist = false;

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $studentId = $con->real_escape_string($studentId);
        $sql = "SELECT * FROM User WHERE StudentID = '$studentId'";

        if ($result = $con->query($sql)) {
            if ($result->num_rows > 0) {
                $exist = true;
            }
        }

        $result->free();
        $con->close();

        return $exist;
    }

    if (empty($studentId)) {
        $studentId = $_POST['studentId'];
        $studentId_error = "Please enter Student ID";
    } elseif (preg_match($stdIDRegex, "$studentId") == 0) {
        $studentId_error = "Invalid Student ID";
    } elseif (isStudentID($studentId)) {
        $studentId_error = "Student ID already exits!";
    }

    if (empty($username)) {
        $username = $_POST['username'];
        $username_error = "Please enter Name";
    } elseif (!preg_match("/^[a-zA-Z-' ]*$/", $username)) {
        $username_error = "Only characters and spaces allowed";
    }

    function isEmailExist($email) {
        $exist = false;

        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $email = $con->real_escape_string($email);
        $sql = "SELECT * FROM User WHERE Email = '$email'";

        if ($result = $con->query($sql)) {
            if ($result->num_rows > 0) {
                $exist = true;
            }
        }

        $result->free();
        $con->close();

        return $exist;
    }

    if (empty($email)) {
        $email = $_POST['email'];
        $email_error = "Please enter Email";
    } elseif (strlen($email) > 60) {
        $email_error = "Email should not more than 60 letters";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid Email";
    } elseif (isEmailExist($email)) {
        $email_error = "Email has been registered.";
    }


    if (empty($phone)) {
        $phone = $_POST['phone'];
        $phone_error = "Please enter Phone Number";
    } elseif (getPhoneNumberValidation($phone) != NULL) {
        $phone_error = "Invalid phone number";
    }

    if (empty($password)) {
        $password = $_POST['password'];
        $password_error = "Please enter Password";
    } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($password) < 8) {
        $password_error = "Must contain uppercase letter, lowercase letter, number and not less than 8 characters";
    }

    if (empty($conPwd)) {
        $conPwd = $_POST['conPwd'];
        $conPwd_error = "Please Re-Enter Password";
    } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($conPwd) < 8) {
        $conPwd_error = "Must contain uppercase letter, lowercase letter, number and not less than 8 characters";
    }

    if (strcmp($password, $conPwd) != 0) {
        $conPwd_error = "Must match with Password";
    }


    if (empty($studentId_error) && empty($email_error) && empty($password_error) && empty($conPwd_error) && empty($name_error) && empty($phone_error)) {
        
    } else {
        include 'insert_user.php';
    }
} else {
    include 'insert_user.php';
}

if (!empty($_POST)) { // Something posted back.
    if ((empty($studentId_error)) && (empty($email_error)) && (empty($password_error)) && (empty($conPwd_error) && empty($name_error) && empty($phone_error))) { // If no error.
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $sql = '
                        INSERT INTO User (StudentID, Name, Email, Phone, Gender, Faculty, Password)
                        VALUES (?, ?, ?, ?, ?, ?, ?)
                    ';
        $stm = $con->prepare($sql);
        $stm->bind_param('sssssss', $studentId, $username, $email, $phone, $gender, $faculty, $password);
        $stm->execute();
        if ($stm->affected_rows > 0) {
            printf('<script>swal("Add Successful!", "Record has been added!", "success", {button: "OK",}).then((value) => {location.href="admin_user_record.php";});;</script>');
        } else {
            printf('<script>swal("Add Failed!", "Opps! Database issues.", "error", {button: "OK",}).then((value) => {location.href="edit_user.php";});;</script>');
        }

        $stm->close();
        $con->close();
        ///////////////////////////////////////////////////////////////////
        include 'insert_user.php';
    }
}
?>

