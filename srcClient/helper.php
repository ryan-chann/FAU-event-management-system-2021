<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'fau');

//Get Faculties from array
function getFaculties() {
    return array(
        "empty" => "--Select One Faculty--",
        "FAFB" => "Faculty of Accountancy, Finance & Business",
        "FOCS" => "Faculty of Computing And Information Technology",
        "FOAS" => "Faculty of Applied Sciences",
        "FOBE" => "Faculty of Built Environment",
        "FCCI" => "Faculty of Communication And Creative Industries",
        "FOET" => "Faculty of Engineering And Technology",
        "FSSH" => "Faculty of Social Science And Humanities"
    );
}

//Get Genders from array
function getGenders() {
    return array(
        "empty" => "--Select Genders--",
        "MALE" => "Male",
        "FEMALE" => "Female"
    );
}

function getStdIDRegex() {
    $stdIDRegex = "/^\d{2}[A-Z]{3}\d{5}$/";
    return $stdIDRegex;
}

function getPasswordRegex($number) {
    $passwordRegex = array();
    $passwordRegex[0] = "#[0-9]+#";
    $passwordRegex[1] = "#[A-Z]+#";
    $passwordRegex[2] = "#[a-z]+#";

    if ($number >= 0 && $number < count($passwordRegex)) {
        return $passwordRegex[$number];
    } else {
        return "Unknown Code Detected";
    }
}

function getPhoneNumberRegex($number) {
    $phoneNumRegex = array();
    $phoneNumRegex[0] = "/^[0][1]\d{1}-\d{3}-\d{4}$/";
    $phoneNumRegex[1] = "/^[0][1]\d{1}-\d{4}-\d{4}$/";
    $phoneNumRegex[2] = "/^[0][1]\d{8}$/";
    $phoneNumRegex[3] = "/^[0][1]\d{9}$/";
    $phoneNumRegex[4] = "/^[0][1]\d{1}-\d{7}$/";
    $phoneNumRegex[5] = "/^[0][1]\d{1}-\d{8}$/";

    if ($number >= 0 && $number < count($phoneNumRegex)) {
        return $phoneNumRegex[$number];
    } else {
        return "Unknown Code Detected";
    }
}

function getNameRegex() {
    $nameRegex = "/^[a-zA-Z ]+$/";
    return $nameRegex;
}

//Validate Getters
function getNameError($name) {
    if (empty($name)) {
        $name_error = "Fill in Name";
    } elseif (!preg_match(getNameRegex(), $name)) {
        $name_error = "Name should not contain Symbolic and Numeric characters";
    }

    if (isset($name_error)) {
        return $name_error;
    }
}

function getEmailError($email) {
    if (empty($email)) {
        $email_error = "Fill in Email";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid Email";
    }

    if (isset($email_error)) {
        return $email_error;
    }
}

function getStudentIDError($studentID) {
    if (empty($studentID)) {
        $studentID_error = "Fill in Student ID";
    } elseif (preg_match(getStdIDRegex(), "$studentID") == 0) {
        $studentID_error = "Invalid Student ID";
    }

    if (isset($studentID_error)) {
        return $studentID_error;
    }
}

function getPasswordValidation($requirement, $password) {
    $numberPass = preg_match(getPasswordRegex(0), "$password");
    $uppercasePass = preg_match(getPasswordRegex(1), "$password");
    $lowercasePass = preg_match(getPasswordRegex(2), "$password");

    if (strcmp($requirement, "number") == 0) {
        if (empty($password)) {
            $password_error = "Password is required";
        } elseif (!$numberPass || strlen($password) < 8) {
            $password_error = "Password must contain at least a number and not less than 8 characters";
        }
    } else if (strcmp($requirement, "uppercase") == 0) {
        if (empty($password)) {
            $password_error = "Password is required";
        } elseif (!$uppercasePassPass || strlen($password) < 8) {
            $password_error = "Password must contain at least an uppercase letter and not less than 8 characters";
        }
    } else if (strcmp($requirement, "lowercase") == 0) {
        if (empty($password)) {
            $password_error = "Password is required";
        } elseif (!$lowercasePass || strlen($password) < 8) {
            $password_error = "Password must contain at least a lowercase letter and not less than 8 characters";
        }
    } else if (strcmp($requirement, "all") == 0) {
        if (empty($password)) {
            $password_error = "Password is required";
        } elseif (!$uppercasePass || !$lowercasePass || !$numberPass || strlen($password) < 8) {
            $password_error = "Password must contain uppercase letter, lowercase letter, number and not less than 8 characters";
        }
    }

    if (isset($password_error)) {
        return $password_error;
    }
}

function getPhoneNumberValidation($phoneNumber) {
    $phoneNumberValidation = array();
    $phoneNumberValidation[0] = preg_match(getPhoneNumberRegex(0), $phoneNumber);
    $phoneNumberValidation[1] = preg_match(getPhoneNumberRegex(1), $phoneNumber);
    $phoneNumberValidation[2] = preg_match(getPhoneNumberRegex(2), $phoneNumber);
    $phoneNumberValidation[3] = preg_match(getPhoneNumberRegex(3), $phoneNumber);
    $phoneNumberValidation[4] = preg_match(getPhoneNumberRegex(4), $phoneNumber);
    $phoneNumberValidation[5] = preg_match(getPhoneNumberRegex(5), $phoneNumber);

    if (empty($phoneNumber)) {
        $phoneNumber_error = "Fill In Phone Number";
    } elseif (!$phoneNumberValidation[0] && !$phoneNumberValidation[1] && !$phoneNumberValidation[2] && !$phoneNumberValidation[3] && !$phoneNumberValidation[4] && !$phoneNumberValidation[5]) {
        $phoneNumber_error = "Phone Number format: xxx-xxx-xxxx)";
    }

    if (isset($phoneNumber_error)) {
        return $phoneNumber_error;
    }
}

function getFacultyError($faculty) {
    if ($faculty == "empty") {
        $faculty_error = "Please select faculty";
    } else if (!array_key_exists($faculty, getFaculties())) {
        $faculty_error = "Invalid <strong>Faculty</strong> code detected.";
    }

    if (isset($faculty_error)) {
        return $faculty_error;
    }
}

function getGendersError($genders) {
    if ($genders == "empty") {
        $genders_error = "Please select genders";
    } else if (!array_key_exists($genders, getGenders())) {
        $genders_error = "Invalid <strong>Genders</strong> code detected.";
    }

    if (isset($genders_error)) {
        return $genders_error;
    }
}

function getErrorAlert($errorMessage) {
    printf('<script>swal("Sorry!", "' . $errorMessage . '", "error", {button: false, });;</script>');
}

function getIconInvalid() {
    echo '<i class="material-icons" style="font-size:48px; color:red">highlight_off</i>';
}

function getIconValid() {
    echo '<i class="material-icons" style="font-size:48px; color:green">done</i>';
}

function getStudentError($student) {
    if ($student == NULL) {
        $student_error = "Please state if you are a TARUC student or no";
    }

    if (isset($student_error)) {
        return $student_error;
    }
}

function getInquiry_error($inquiry) {
    if ($inquiry == NULL) {
        $inquiry_error = "Please state your inquiries";
    } elseif (strlen($inquiry) < 10 && $inquiry != NULL) {
        $inquiry_error = "Must have at least 10 letters for inquiries";
    } else if (strlen($inquiry) > 238) {
        $inquiry_error = "Exceeded the limit of characters for inquiries";
    }

    if (isset($inquiry_error)) {
        return $inquiry_error;
    }
}

function modalForProfileEdits($modalID, $modalTitle, $request, $inputLabel) {
    echo'
<div class="modal fade" id="' . $modalID . '" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="' . $modalID . '" ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="' . $modalID . 'ModalLabel">' . $modalTitle . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="new.' . $request . '" class="col-form-label">' . $inputLabel . '</label>
                        <input type="text" class="form-control" id="new' . $request . '">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> 
        </div> 
    </div> 
</div>
';
}

function deleteAlertBox() {
    echo '
Swal.fire({
title: \'Are you sure?\',
text: \'You won\'t be able to revert this!\',
icon: \'warning\',
showCancelButton: true,
confirmButtonColor: \'#3085d6\',
cancelButtonColor: \'#d33\',
confirmButtonText: \'Yes, delete it!\'
})
';
}

function logOutFE() {
    unset($_SESSION["studentID"]);
    unset($_SESSION["email"]);
    unset($_SESSION["name"]);
    unset($_SESSION["phone"]);
    unset($_SESSION["gender"]);
    unset($_SESSION["faculty"]);
    unset($_SESSION["password"]);
}
?>
