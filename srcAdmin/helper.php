<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'FAU');

function isStudentIDExist($studentId) {
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

function getNameRegex() {
    $nameRegex = "/^[a-zA-Z ]+$/";
    return $nameRegex;
}

function isAdminExist($email) {
    $exist = false;

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $email = $con->real_escape_string($email);
    $sql = "SELECT * FROM Admin WHERE Email = '$email'";

    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            $exist = true;
        }
    }

    $result->free();
    $con->close();

    return $exist;
}

function getFaculties() {
    return array(
        'empty' => "--Select One Faculty--",
        "FAFB" => "Faculty of Accountancy, Finance & Business",
        "FOCS" => "Faculty of Computing And Information Technology",
        "FOAS" => "Faculty of Applied Sciences",
        "FOBE" => "Faculty of Built Environment",
        "FCCI" => "Faculty of Communication And Creative Industries",
        "FOET" => "Faculty of Engineering And Technology",
        "FSSH" => "Faculty of Social Science And Humanities"
    );
}

// Print a <input type="text"> element.
function htmlInputText($name, $value = '', $maxlength = '') {
    printf('<input type="text" name="%s" id="%s" value="%s" maxlength="%s" />' . "\n",
            $name, $name, $value, $maxlength);
}

// Print a <input type="email"> element.
function htmlInputEmail($name, $value = '') {
    printf('<input type="email" name="%s" id="%s" value="%s"/>' . "\n",
            $name, $name, $value);
}

// Print a <input type="phone"> element.
function htmlInputPhone($name, $value = '') {
    printf('<input type="text" name="%s" id="%s" value="%s"/>' . "\n",
            $name, $name, $value);
}

// Print a <input type="number"> element.
function htmlInputNumber($name, $value = '') {
    printf('<input type="number" min="1" name="%s" id="%s" value="%s"/>' . "\n",
            $name, $name, $value);
}

// Print a <input type="password"> element.
function htmlInputPassword($name, $value = '', $maxlength = '') {
    printf('<input type="password" name="%s" id="%s" value="%s" maxlength="%s" />' . "\n",
            $name, $name, $value, $maxlength);
}

// Print a <input type="hidden"> element.
function htmlInputHidden($name, $value = '') {
    printf('<input type="hidden" name="%s" id="%s" value="%s" />' . "\n",
            $name, $name, $value);
}

function getStudent() {
    return array(
        'Yes' => 'Yes',
        'No' => 'No'
    );
}

function getGenders() {
    return array(
        'FEMALE' => 'FEMALE',
        'MALE' => 'MALE'
    );
}

$FACULTY = getFaculties();
$STUDENT = getStudent();
$GENDER = getGenders();

// Print a group of <input type="radio"> elements.
function htmlRadioList($name, $items, $selectedValue = '', $break = false) {
    foreach ($items as $value => $text) {
        printf('
            <input type="radio" name="%s" id="%s" value="%s" %s />
            <label for="%s">%s</label>' . "\n",
                $name, $value, $value,
                $value == $selectedValue ? 'checked="checked"' : '',
                $value, $text);

        if ($break)
            echo "<br /><br>\n";
    }
}

// Print a <textarea> element.
function htmlInputTextArea($name, $value = '') {
    printf('<textarea type="text" name="%s" id="%s" cols="59" rows="12">%s</textarea>' . "\n",
            $name, $name, $value);
}

function htmlSelect($name, $items, $selectedValue = '', $default = '') {
    printf('<select name="%s" id="%s">' . "\n",
            $name, $name);

    if ($default != null) {
        printf('<option value="">%s</option>', $default);
    }

    foreach ($items as $value => $text) {
        printf('<option value="%s" %s>%s</option>' . "\n",
                $value,
                $value == $selectedValue ? 'selected="selected"' : '',
                $text);
    }

    echo "</select>\n";
}

function getEvents($name, $selectedValue = '') {

    printf('<select name="%s" id="%s" >' . "\n",
            $name, $name);

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $sql = "SELECT * FROM Event";

    if ($result = $con->query($sql)) {
        while ($row = $result->fetch_object()) {
            printf('
    <option value="%s" %s>%s</option>',
                    $row->EventID,
                    $selectedValue == $row->EventName ? 'selected="selected"' : '',
                    $row->EventName
            );
        }
    }
}
?>
