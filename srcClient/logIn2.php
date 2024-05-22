
<?php
//Start the session (if any)
session_start();

//Include helper.php
require_once 'helper.php';

//If User pressed log in button
if (isset($_POST['logIn'])) {

    //Get User's Student ID and Password
    $studentID = $_POST['studentID'];
    $password = $_POST['password'];


    //Set connection to phpMyAdmin
    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //Write sql query statement for executing later
    $sql = "SELECT * FROM user 
            WHERE StudentID= '$studentID'
            AND Password ='$password'";


    //Set result to execute "$sql" query statement on "$connection"'s database 
    $result = $connection->query($sql);

    //If there is any rows returned
    if ($result->num_rows > 0) {

        //Clear the forms
        $studentID = '';
        $password = '';

        //While Loop to fetch the data
        while ($row = $result->fetch_object()) {
            //Set SESSION array with the data
            $_SESSION['studentID'] = $row->StudentID;
            $_SESSION['email'] = $row->Email;
            $_SESSION['name'] = $row->Name;
            $_SESSION['phone'] = $row->Phone;
            $_SESSION['gender'] = $row->Gender;
            $_SESSION['faculty'] = $row->Faculty;
            $_SESSION['password'] = $row->Password;
        }

        //Directs user to myProfile.php
        header('location: myProfile.php');

        //Close Connection
        $connection->close();
    }
    //If User does not input any field 
    else if (empty($studentID && $password)) {
        //Clear the forms
        $studentID = '';
        $password = '';

        //Display Error Message
        echo '
            <script>
                setTimeout("alert(\'Please Fill in Student ID and Password!\')",100);
            </script>
        ';
    }
    //If unsuccessful retrieve data from the database
    else {
        //Clear the forms
        $studentID = '';
        $password = '';

        //Display Error Message
        echo '
            <script>
                setTimeout("alert(\'Incorrect Student ID and Password!\')",100);
            </script>
        ';

        require_once 'logIn.php';
    }
}
?>

