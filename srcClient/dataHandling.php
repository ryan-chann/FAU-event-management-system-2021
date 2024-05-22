<!-- 
    Logged In database related instructions
-->

<?php
//Start Session
session_start();

//Include Helper
require_once('helper.php');

//Set Connection To Database
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

//If Connection Fail
if ($connection == false) {
    echo "not connected";
}

//If User Pressed Log Out
if (isset($_POST['logOut'])) {
    //Untie All SESSION Arrays
    logOutFE();
}


//If User Pressed the Change Name Button
if (isset($_POST['changeName'])) {
    //Get User New Name Input
    $newStudentName = trim($_POST['newName']);
    $newName_Error = getNameError($newStudentName);

    if (empty($newName_Error)) {
        //Get User's Student ID
        $editStudentID = $_SESSION["studentID"];

        //SQL query to update user's name
        $sql = 'UPDATE user 
            SET Name = ?
            WHERE StudentID = ?';

        //$statement to prepare $sql query on $connection database
        $statement = $connection->prepare($sql);

        //Bind Parameters with the user input and account
        $statement->bind_param('ss', $newStudentName, $_SESSION["studentID"]);

        //Execute Statement
        $statement->execute();

        //If there is any changes
        if ($statement->affected_rows > 0) {
            //Display Success Message
            echo '<script>
          setTimeout("alert(\'Successfully Updated!! Please log out and log in again to view the changes.\')",100);
          </script>';
        } else {
            echo '<script>
          setTimeout("alert(\'Error! Same name as before were assigned.\')",100);
          </script>';
        }
    } else {
        echo '<script>
          setTimeout("alert(\'' . $newName_Error . '\')",100);
          </script>';
    }
}


//If user pressed the change Faculty Button
if (isset($_POST['changeFaculty'])) {
    //Capture Users Input and store into variable
    $newFaculty = $_POST['newFaculty'];
    $newFaculty_Error = getFacultyError($newFaculty);

    if (empty($newFaculty_Error)) {
        //Prepare Update Faculty SQL statement
        $sql = 'UPDATE user 
            SET Faculty = ?
            WHERE StudentID = ?';

        //Bind $statement to connection and prepare $sql query
        $statement = $connection->prepare($sql);

        //Bind Parameters to $sql statement with user input and account details
        $statement->bind_param('ss', $newFaculty, $_SESSION['studentID']);

        //Execute statement
        $statement->execute();

        //If there is any updates
        if ($statement->affected_rows > 0) {

            //Display Success Message
            echo '<script>
                setTimeout("alert(\'Edit Successful, Please Log out and log in again to view changes!\')",100);
          </script>';
        } else {
            echo '<script>
                setTimeout("alert(\'No changes were made.\')",100);
          </script>';
        }
    } else {
        echo '<script>
          setTimeout("alert(\'' . $newFaculty_Error . '\')",100);
          </script>';
    }
}

if (isset($_POST['changePassword'])) {

    $newPassword = $_POST['newPassword'];
    $newConfirmPassword = $_POST['newConfirmPassword'];

    $newPassword_error = getPasswordValidation("all", $newPassword);
    $newConfirmPassword_error = getPasswordValidation("all", $newConfirmPassword);

    //Password must be same with confirm password
    if (strcmp($newPassword, $newConfirmPassword) != 0) {
        $newPassword_error = "Password must match with confirm password";
        $newConfirmPassword_error = "Password must match with confirm password";
    }

    if (empty($newPassword_error) && empty($newConfirmPassword_error)) {
        //Prepare Update Faculty SQL statement
        $sql = 'UPDATE user 
            SET Password = ?
            WHERE StudentID = ?';

        //Bind $statement to connection and prepare $sql query
        $statement = $connection->prepare($sql);

        //Bind Parameters to $sql statement with user input and account details
        $statement->bind_param('ss', $newPassword, $_SESSION['studentID']);

        //Execute statement
        $statement->execute();

        //If there is any updates
        if ($statement->affected_rows > 0) {
            //Display Success Message
            echo '<script>
          setTimeout("alert(\'Successfully Updated!! Please log out and log in again to view the changes.\')",100);
          </script>';
        } else {
            echo '<script>
          setTimeout("alert(\'Error,same password as before were entered.\')",100);
          </script>';
        }
    } else {
        $newPassword = '';
        $newConfirmPassword = '';

        echo '<script>
          setTimeout("alert(\'' . $newPassword_error . '\')",100);
          </script>';
    }
}
?>