<header>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>Add Ticket Record</title>
</header>
<?php
$studentId = trim(strtoupper($_POST['studentId']));
$quantity = trim($_POST['qty']);
$event = $_POST['event'];

if (isset($_POST['submit'])) {
    require_once 'helper.php';

    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $selected_val = $_POST["event"];
    $quantity = $_POST["qty"];
    $sql = "
            SELECT EventName,No_Of_Booking, LimitBooking from event WHERE EventID= '" . $selected_val . "'
    ";
    if ($result = $con->query($sql)) {
        while ($row = $result->fetch_object()) {  //while loop to find the event
            $name = $row->EventName;
            $no_of_booking = $row->No_Of_Booking;
            $limitBooking = $row->LimitBooking;
        }
    }

    if ($no_of_booking + $quantity >= $limitBooking) {
        $qty_error = "Quantity over seat availability.";
    }

    $stdIDRegex = "/^\d{2}[A-Z]{3}\d{5}$/";

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
    } elseif (!isStudentID($studentId)) {
        $studentId_error = "Student ID cannot be found. Please register.";
    }

    if (empty($event)) {
        $event = $_POST['event'];
        $event_error = "Please choose Event";
    }

    if (empty($quantity)) {
        $quantity = $_POST['qty'];
        $qty_error = "Please enter Quantity";
    }

    if (empty($event_error) && empty($studentId_error) && empty($qty_error)) {
        
    } else {
        include 'insert_ticketR.php';
    }
} else {
    include 'insert_ticketR.php';
}

if (!empty($_POST)) { // Something posted back.
    if (empty($event_error) && empty($studentId_error) && empty($qty_error)) { // If no error.
        $sql = '
                        INSERT INTO ticket (StudentID,EventID, Quantity)
                        VALUES (?, ?, ?);
                        ';
        $stm = $con->prepare($sql);
        $stm->bind_param('ssd', $studentId, $selected_val, $quantity);
        $sql2 = '
                        UPDATE event
                        SET No_of_Booking = ?
                        WHERE EventID = ?;
                        ';
        $total = $no_of_booking + $quantity;
        $stm2 = $con->prepare($sql2);
        $stm2->bind_param('ds', $total, $selected_val);

        $stm->execute();
        $stm2->execute();
        if ($stm->affected_rows > 0) {
            ?>
            <script>
                swal({
                    title: "Add Successful!",
                    text: "New record has been added!",
                    icon: "success",
                    button: "OK"
                });
            </script>
            <?php
            // Reset fields.
            $event = $studentId = $quantity = null;
        } else {
            // Something goes wrong.
            ?>
            <script>
                swal({
                    title: "Add Failed!",
                    text: "Failed to add new record!",
                    icon: "error",
                    button: "OK"
                });
            </script>
            <?php
        }

        $stm->close();
        $con->close();
        
        include 'insert_ticketR.php';
    }
    ///////////////////////////////////////////////////////////////////
}
?>
