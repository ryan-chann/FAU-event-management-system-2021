<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

if (!isset($_POST['submit'])) {
    $studentId = "";
    $quantity = "";
    $event = "";
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Add Ticket Record</title>
        <link rel="stylesheet" href="../css/admin_layout.css">
        <link rel="stylesheet" href="../css/admin_insert.css">
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <style>
            .form_container{
                height: 400px;
            }

            form{
                height: 400px;
            }

            #studentId,#qty, #event{
                width: 380px;
                font-size: 16px;
                height: 30px;
                margin-bottom: 10px;
                padding-left: 10px;
            }
        </style>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>
            <div class="header">
                <h3>Ticket Record</h3>
                <nav class="record_nav">
                    <a href="admin_ticket_record.php" name="view" id="view">View</a>
                    <a href="insert_ticketR.php" name="add" id="add">Add</a>
                    <a href="search_ticketR.php" name="search" id="search">Search</a>
                </nav>
            </div>
            <div class="form_container">
                <form action="insert_ticketR2.php" method="post">
                    <h3 style="margin-left: 70px;">Add Ticket Record</h3>
                    <label for="studentId">Student ID:</label><br>
                    <input type="text" name="studentId" id="studentId" placeholder="00XXX00000" value="<?php echo $studentId ?>">
                    <?php
                    if (isset($studentId_error)) {
                        echo "<div class='alert alert-danger'><strong>$studentId_error</strong>";
                    }
                    ?>
                    <br><br>

                    <label for="event">Event:</label><br>
                    <select style="width:397px;"name="event" id="event" value="<?php echo $event ?>">
                        <?php
                        parse_str($_SERVER['QUERY_STRING'], $queries);
                        $id = $queries['id'];
                        require_once('helper.php');
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = '
                                        SELECT EventID,EventName from event
                                        ';
                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {  //while loop to find the event
                                echo '
                                        <option value="' . $row->EventID . '" ' . ($id == $row->EventID ? "selected" : "") . '>' . $row->EventName . '</option>
                                        ';
                            }
                        }
                        
                        $con->close();
                        ?>
                    </select>
                    <?php
                    if (isset($event_error)) {
                        echo "<div class='alert alert-danger'>$event_error</div>";
                    }
                    ?>
                    <br><br>
                    <label for="qty">Quantity:</label>
                    <input type="number" name="qty" id="qty" min="1" max="100" value="<?php echo $qty ?>">
                    <?php
                    if (isset($qty_error)) {
                        echo "<div class='alert alert-danger'>$qty_error</div>";
                    }
                    ?>
                    <br><br>
                    <input type="submit" name="submit" id="submit">
                    <input type="reset" name="reset" id="reset" value="Cancel">
                </form>
            </div>
            <?php
        } else {
            header('location: admin_login.php');
        }
        ?>
        <?php include 'admin_footer.php'; ?>
