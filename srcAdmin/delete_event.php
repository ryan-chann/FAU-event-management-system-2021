<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Event Record</title>
        <link rel="stylesheet" href="../css/admin_dltevent.css">
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_delete.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>                  
            <div class="header">
                <h3>Event Record</h3>
                <nav class="record_nav">
                    <a href="admin_event_record.php" name="view" id="view">View</a>
                    <a href="insert_event.php" name="add" id="add">Add</a>
                    <a href="search_event.php" name="search" id="search">Search</a>
                </nav>
            </div>

            <?php
            require_once('helper.php');
            if (!empty($_POST)) { // Something posted back. 
                $id = trim($_POST['eventID']);     //store the value to variable
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = 'DELETE FROM event WHERE EventID = ?';
                $stm = $con->prepare($sql);
                $stm->bind_param('d', $id);
                $stm->execute();
                if ($stm->affected_rows > 0) {
                    printf('<script>swal("Good job!", "You have successfully delete an event!", "success", {button: "Aww yiss!",}).then((value) => {location.href="admin_event_record.php";});;</script>');
                } else {
                    if (empty($stm->error)) {
                        printf('<script>swal("Good job!", "You have successfully delete an event!", "success", {button: "Aww yiss!",}).then((value) => {location.href="admin_event_record.php";});;</script>');
                    } else {
                        printf('<script>swal("Sorry!", "There was an error delete the event.This event has been booked by students.", "error", {button: false,}).then((value) => {location.href="admin_event_record.php";});;</script>');
                    }
                }
                $stm->close();
                $con->close();
            }
            ?>

            <?php
            require_once('helper.php');
            $eventName = '';
            $end_date = '';
            $start_date = '';
            $start_time = '';
            $end_time = '';
            $seat = '';
            $description = '';
            $eventId = '';
            $venue = '';
            $eventType = '';

            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                $id = strtoupper(trim($_GET['id']));
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $id = $con->real_escape_string($id);
                $sql = "SELECT * FROM event WHERE EventID = '$id'";
                $result = $con->query($sql);
                if ($result = $con->query($sql)) {
                    while ($row = $result->fetch_object()) {  //while loop to find the event
                        $eventName = $row->EventName;
                        $end_date = $row->EndDate;
                        $start_date = $row->StartDate;
                        $start_time = $row->StartTime;
                        $end_time = $row->EndTime;
                        $seat = $row->LimitBooking;
                        $description = $row->Description;
                        $eventId = $row->EventID;
                        $venue = $row->Venue;
                        $eventType = $row->Category;
                    }
                }
            }
            ?>

            <div class="container">
                <form action="" method="post">
                    <h1 style="text-align: center">Delete Event Record</h1>
                    <div class="row">
                        <div class="col-25">
                            <label for="event_name">Event Name:</label>
                        </div>
                        <div class="col-75">
                            <p> <?php echo $eventName ?> </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="event_type">Event type:</label>
                        </div>
                        <div class="col-75">
                            <p> <?php echo $eventType ?> </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="event_venue">Event Venue:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $venue ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="startDate">Start Date:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $start_date ?> </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="endDate">End Date:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $end_date ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">Start time:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $start_time ?></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">End time:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $end_time ?> </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">Seat Availability:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $seat ?> </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="description">Description:</label>
                        </div>
                        <div class="col-75">
                            <p><?php echo $description ?> </p>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" name="eventID" value="<?php echo $eventId ?>"/>
                        <input class="button" style="color: white" type="button" value="Delete" id="delete" onclick="alert();">
                        <input id="submit" style="display:none" type="submit" value="Delete" id="delete">
                    </div>

                </form>
            </div>
        </body>  
    <?php include 'admin_footer.php'; ?>
        <script src="./../js/jquery.js"></script>
        <script>
                            var slider = document.getElementById("range");
                            var output = document.getElementById("value");
                            output.innerHTML = slider.value;
                            slider.oninput = function () {
                                output.innerHTML = this.value;
                            }

                            function alert() {
                                swal({
                                    title: "Are you sure?",
                                    text: "Once deleted, you will not be able to recover this event!",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                })
                                        .then((willDelete) => {
                                            if (willDelete) {
                                                $("#submit").click();
                                            } else {
                                                swal("Your event is safe!");
                                            }
                                        });
                            }
        </script>
    <?php
} else {
    header('location: admin_login.php');
}
?>
</html>    
