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
        <title>Edit Event Record</title>
        <link rel="stylesheet" href="../css/admin_event_edit.css">
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_edit.css">
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

            <?php
            require_once('helper.php');
            if (!empty($_POST)) {       // Something posted back.
                $event_name = '';      // Create variable to store value
                $event_category = '';
                $start_date = '';
                $end_date = '';
                $start_time = '';
                $end_time = '';
                $seat = '';
                $venue = '';
                $description = '';
                $picture = '';
                $haspicture = false;
                parse_str($_SERVER['QUERY_STRING'], $queries);

                $event_name = trim($_POST['name']);     //store the value to variable
                $event_category = trim($_POST['event']);
                $start_date = trim($_POST['start_Date']);
                $end_date = trim($_POST['end_Date']);
                $start_time = trim($_POST['start_time']);
                $end_time = trim($_POST['end_time']);
                $seat = trim($_POST['range']);
                $description = trim($_POST['subject']);
                $venue = trim($_POST['venue']);
                $picture = trim($_POST['oldImgUrl']);
                $start = new DateTime($start_date . " " . $start_time);    //calculate start time and date
                $end = new DateTime($end_date . " " . $end_time);          //calculate end time and date
                //Add picture to the correct file if user has upload picture
                if ($event_category == "Charity Event") {    //
                    $target_dir = "../picture/charity/";
                } else if ($event_category == "Competitions") {
                    $target_dir = "../picture/competition/";
                } else if ($event_category == "Workshop") {
                    $target_dir = "../picture/workshop/";
                } else if ($event_category == "Volunteering") {
                    $target_dir = "../picture/volunteering/";
                } else if ($event_category == "Blood Donation") {
                    $target_dir = "../picture/blood_donation/";
                }
                $uploadOk = 1;

                //Check event name
                if (empty($event_name)) {
                    printf('<script>swal("Sorry!", "Event name cannot be empty.", "error", {button: false,});;</script>');
                    $uploadOk = 0;
                }

                //Check event venue
                if (empty($venue)) {
                    printf('<script>swal("Sorry!", "Event venue cannot be empty.", "error", {button: false,});;</script>');
                    $uploadOk = 0;
                }

                // Check if image file is a actual image or fake image
                else if ($_FILES["fileToUpload"]["size"] != 0) {
                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                    if ($check !== false) {
                        $uploadOk = 1;
                    }
                    // Check if file already exists
                    else if (file_exists($target_file)) {
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
                    } else {
                        printf('<script>swal("Sorry!", "File is not an image.", "error", {button: false,});;</script>');
                        $uploadOk = 0;
                    }
                }

                //Check start date
                else if (empty($start_date)) {
                    printf('<script>swal("Sorry!", "Start Date cannot be empty.", "error", {button: false,});;</script>');
                    $uploadOk = 0;
                }

                //Check end date
                else if (empty($end_date)) {
                    printf('<script>swal("Sorry!", "End Date cannot be empty.", "error", {button: false,});;</script>');
                    $uploadOk = 0;
                }
                //Check end date
                else if (empty($start_time)) {
                    printf('<script>swal("Sorry!", "Start Time cannot be empty.", "error", {button: false,});;</script>');
                    $uploadOk = 0;
                }
                //Check end date
                else if (empty($end_time)) {
                    printf('<script>swal("Sorry!", "End Time cannot be empty.", "error", {button: false,});;</script>');
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
                } else {
                    $target_file = $picture;    //no changes for picture
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk != 0) {
                    if ($picture == $target_file || move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = 'UPDATE event SET EventName = ? ,Category = ?, StartDate = ?, EndDate = ?, StartTime = ?, EndTime = ?,Venue = ?, Description = ?, LimitBooking = ? ,Picture_location =? WHERE EventID = ?';
                        $stm = $con->prepare($sql);
                        $stm->bind_param('ssssssssssd', $event_name, $event_category, $start_date, $end_date, $start_time, $end_time, $venue, $description, $seat, $target_file, $queries['id']);
                        $stm->execute();
                        if ($stm->affected_rows > 0) {
                            printf('<script>swal("Good job!", "You have successfully edit an event!", "success", {button: "Aww yiss!",}).then((value) => {location.href="admin_event_record.php";});;</script>', $event_name);
                        } else {
                            if (empty($stm->error)) {
                                printf('<script>swal("Good job!", "You have successfully edit an event!", "success", {button: "Aww yiss!",}).then((value) => {location.href="admin_event_record.php";});;</script>', $event_name);
                            } else {
                                printf('<script>swal("Sorry!", "There was an error insert to database.", "error", {button: false,});;</script>');
                            }
                        }
                        $stm->close();
                        $con->close();
                    }
                }
            }
            ?>

            <div class="container">
                <form method="post" enctype="multipart/form-data" style="height: 1000px;">
            <?php
            if (empty($_SERVER['QUERY_STRING'])) {
                echo '<script>swal("Sorry!", "There was an error insert to database.", "error", {button: false,}).then((value) => {location.href="admin_event_record.php";});;</script>';
                $eventName = '';
                $end_date = '';
                $start_date = '';
                $start_time = '';
                $end_time = '';
                $seat = '';
                $description = '';
                $eventId = '';
                $venue = '';
                $picture = '';
            } else {
                parse_str($_SERVER['QUERY_STRING'], $queries);
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); //connect database
                $eventName = "";
                $sql = "SELECT * FROM event where EventID = " . $queries['id'];

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
                        $picture = $row->Picture_location;
                    }
                }
            }
            ?>

                    <h1 style="text-align: center">Edit Event Record</h1>
                    <div class="row">
                        <div class="col-25">
                            <label for="event_name">Event Name:</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="name" name="name" placeholder="Event Name" value="<?php echo $eventName ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="event_type">Event type:</label>
                        </div>
                        <div class="col-75">
                            <select id="event" name="event">
                                <option value="Charity Event" <?php if ($eventType == "Charity Event") echo "selected='selected'"; ?>>Charity Event</option>
                                <option value="Competitions"  <?php if ($eventType == "Competitions") echo "selected='selected'"; ?>>Competitions</option>
                                <option value="Workshop"<?php if ($eventType == "Workshop") echo "selected='selected'"; ?>>Workshop</option>
                                <option value="Volunteering" <?php if ($eventType == "Volunteering") echo "selected='selected'"; ?>>Volunteering</option>
                                <option value="Blood Donation" <?php if ($eventType == "Blood Donation") echo "selected='selected'"; ?>>Blood Donation</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="event_venue">Event Venue:</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="venue" name="venue" value="<?php echo $venue ?>" placeholder="Event Venue">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="img">Select image:</label>
                        </div>
                        <div class="col-75">
                            <img style="width:20%;"src="<?php echo $picture; ?>"/>
                            <input type="hidden" value = "<?php echo $picture; ?>" name="oldImgUrl"/>
                            <br/><input type="file" name="fileToUpload" id="fileToUpload" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="startDate">Start Date:</label>
                        </div>
                        <div class="col-75">
                            <input type="date" id="start_Date" name="start_Date" value="<?php echo $start_date ?>" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="endDate">End Date:</label>
                        </div>
                        <div class="col-75">
                            <input type="date" id="end_Date" name="end_Date" value="<?php echo $end_date ?>" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">Start time:</label>
                        </div>
                        <div class="col-75">
                            <input type="time" id="start_time" name="start_time" value="<?php echo $start_time ?>" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">End time:</label>
                        </div>
                        <div class="col-75">
                            <input type="time" id="end_time" name="end_time" value="<?php echo $end_time ?>" style="margin-top: 10px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="appt">Seat Availability:</label>
                        </div>
                        <div class="col-75">
                            <input type="range" min="1" max="100" value="<?php echo $seat ?>" class="slider" id="range" name="range" style="margin-top: 20px;">
                            <p>Value: <span id="value"></span></p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-25">
                            <label for="description">Description:</label>
                        </div>
                        <div class="col-75">
                            <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px;margin-top: 10px;"><?php echo $description ?> </textarea>
                        </div>
                    </div>

                    <div class="row">
                        <input type="Submit" value="Submit" id="submit" ;>
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
            swal("Good job!", "You have successfully modify an event!", "success", {
                button: "Aww yiss!",
            }).then(() => {
                location.href = "admin_event_record.php"
            });
        }
    </script>
</html>    