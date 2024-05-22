<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Event Record</title>
        <link rel="stylesheet" href="../css/admin_insert.css">
        <link rel="stylesheet" href="../css/admin_event_insert.css">
        <link rel="stylesheet" href="../css/admin_layout.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            form{
                width: 90%;
                margin-left: 70px;
                height: 950px;
                margin-bottom: 50px;
            }
        </style>
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

            <div class="container">
                <?php
                require_once('helper.php');
                if (!empty($_POST)) { // Something posted back.
                    $event_name = '';      //create variable to store value
                    $event_type = '';
                    $start_date = '';
                    $end_date = '';
                    $start_time = '';
                    $end_time = '';
                    $seat = '';
                    $description = '';

                    $event_name = trim($_POST['name']);     //store the value to variable
                    $event_type = trim($_POST['event']);
                    $start_date = trim($_POST['start_Date']);
                    $end_date = trim($_POST['end_Date']);
                    $start_time = trim($_POST['start_time']);
                    $end_time = trim($_POST['end_time']);
                    $seat = trim($_POST['range']);
                    $description = trim($_POST['subject']);
                    $venue = trim($_POST['venue']);
                    $start = new DateTime($start_date . " " . $start_time);    //calculate start time and date
                    $end = new DateTime($end_date . " " . $end_time);          //calculate end time and date
                    //Add picture to the correct file if user has upload picture
                    if ($event_type == "Charity Event") {
                        $target_dir = "../picture/charity/";
                    } else if ($event_type == "Competitions") {
                        $target_dir = "../picture/competition/";
                    } else if ($event_type == "Workshop") {
                        $target_dir = "../picture/workshop/";
                    } else if ($event_type == "Volunteering") {
                        $target_dir = "../picture/volunteering/";
                    } else if ($event_type == "Blood Donation") {
                        $target_dir = "../picture/blood_donation/";
                    }
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    //Check event name
                    if (empty($event_name)) {
                        printf('<script>swal("Sorry!", "Event name cannot be empty.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }

                    //Check event venue
                    else if (empty($venue)) {
                        printf('<script>swal("Sorry!", "Event venue cannot be empty.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    } else if ($_FILES["fileToUpload"]["size"] == 0) {
                        printf('<script>swal("Sorry!", "Image cannot be empty.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    } else if (file_exists($target_file)) {
                        printf('<script>swal("Sorry!", "File already exists.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }
                    // Check file size
                    else if ($_FILES["fileToUpload"]["size"] > 10000000) {
                        printf('<script>swal("Sorry!", "Your file is too large.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }
                    // Allow certain file formats
                    else if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        printf('<script>swal("Sorry!", "Only JPG, JPEG, PNG & GIF files are allowed.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }

                    //Check date
                    else if ($end <= $start) {
                        printf('<script>swal("Sorry!", "Date invalid.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }

                    //Check seat
                    else if (empty($seat)) {
                        printf('<script>swal("Sorry!", "Seat availability cannot be empty.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }

                    //Check description
                    else if (empty($description)) {
                        printf('<script>swal("Sorry!", "Description cannot be empty.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }

                    // Check if file already exists
                    else if ($_FILES["fileToUpload"]["size"] != 0) {
                        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                        if ($check !== false) {
                            $uploadOk = 1;
                        }
                    }
                    // Check if $uploadOk is set to 0 by an error
                    if ($uploadOk != 0) {
                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                            $sql = 'INSERT INTO event (EventName, Category, StartDate, EndDate, StartTime, EndTime, Venue, LimitBooking, Picture_location, Description)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
                            $stm = $con->prepare($sql);
                            $stm->bind_param('sssssssdss', $event_name, $event_type, $start_date, $end_date, $start_time, $end_time, $venue, $seat, $target_file, $description);
                            $stm->execute();
                            if ($stm->affected_rows > 0) {
                                printf('<script>swal("Good job!", "You have successfully add an event!", "success", {button: "Aww yiss!",}).then((value) => {location.href="admin_event_record.php";});;</script>');
                            } else {
                                printf("Error: %s.\n", $stm->error);
                                // Something goes wrong.
                                printf('<script>swal("Sorry!", "There was an error insert to database.", "error", {button: false,});;</script>');
                            }
                            $stm->close();
                            $con->close();
                        } else {
                            printf('<script>swal("Sorry!", "There was an error uploading your file.", "error", {button: false,});;</script>');
                        }
                    }
                }
                ?>

                <form method="post" action="" enctype="multipart/form-data">
                    <h1 style="text-align: center">Add Event Record</h1>
                    <div class="row">
                        <div class="col-25">
                            <label for="event_name">Event Name:</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" placeholder="Event Name">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="event_type">Event type:</label>
                        </div>
                        <div class="col-75">
                            <select id="event" name="event">
                                <option value="Charity Event">Charity Event</option>
                                <option value="Competitions">Competitions</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Volunteering">Volunteering</option>
                                <option value="Blood Donation">Blood Donation</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="event_venue">Event Venue:</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="venue" name="venue" placeholder="Event Venue">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="img">Select image:</label>
                        </div>
                        <div class="col-75">
                            <input type="file" name="fileToUpload" id="fileToUpload" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="startDate">Start Date:</label>
                        </div>
                        <div class="col-75">
    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $date = date("Y-m-d");
    ?>
                            <input type="date" id="start_Date" value="<?php echo $date; ?>" name="start_Date" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="endDate">End Date:</label>
                        </div>
                        <div class="col-75">
    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $date = date("Y-m-d");
    ?>
                            <input type="date" id="end_Date" value="<?php echo $date; ?>" name="end_Date" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">Start time:</label>
                        </div>
                        <div class="col-75">
    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $time = date("H:i");
    ?>
                            <input type="time" id="start_time" value="<?php echo $time; ?>" name="start_time" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">End time:</label>
                        </div>
                        <div class="col-75">
    <?php
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $time = date("H:i");
    ?>
                            <input type="time" id="end_time" value="<?php echo $time; ?>" name="end_time" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">Seat Availability:</label>
                        </div>
                        <div class="col-75">
                            <input type="range" min="1" max="100" value="50" class="slider" id="range" name="range" style="margin-top: 20px;">
                            <p>Value: <span id="value"></span></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="description">Description:</label>
                        </div>
                        <div class="col-75">
                            <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px;margin-top: 10px;"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <input type="submit" value="Submit">
                    </div>

                </form>
            </div>
        </body>
    <?php
} else {
    header('location: admin_login.php');
}
?>
    <?php include 'admin_footer.php'; ?>
    <script>
        var slider = document.getElementById("range");
        var output = document.getElementById("value");
        output.innerHTML = slider.value;

        slider.oninput = function () {
            output.innerHTML = this.value;
        }
        function alert() {
            swal("Good job!", "You have successfully add an event!", "success", {
                button: "Aww yiss!",
            });
        }
    </script>
</html>
