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
        <title>Dashboard</title>
        <link rel="stylesheet" href="../css/admin_layout.css"/>
        <link rel="stylesheet" href="../css/admin_dashboard.css"/>
    </head>
    <body>
        <?php if (isset($_SESSION['AdminID'])) { ?>
            <?php include 'admin_nav.php'; ?>
            <div class="dashboard_container">
                <h2>Dashboard</h2>
                <div class="amount_container" style="display: flex;flex-direction: row;">
                    <div class="user_container" style="flex: 5">
                        <h5>TOTAL USERS</h5>
                        <?php
                        require_once('helper.php');

                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT * FROM User";

                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {
                                
                            }
                        }
                        printf('
                    <h5>%s</h5>',
                                $result->num_rows);

                        $result->free();
                        $con->close();
                        ?>

                    </div>

                    <div class="event_container" style="flex: 5">
                        <h5>TOTAL EVENTS</h5>
                        <?php
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT * FROM Event";

                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {
                                
                            }
                        }
                        printf('
                    <h5>%s</h5>',
                                $result->num_rows);

                        $result->free();
                        $con->close();
                        ?>
                    </div>
                </div>

                <div class="active_container">
                    <h1>Active Events</h1>
                    <table>
                        <tr>
                            <th>Event</th>
                            <th>Date</th>
                        </tr>
                        <?php
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = "SELECT * FROM event WHERE StartDate > NOW() ORDER BY StartDate ASC";

                        if ($result = $con->query($sql)) {
                            while ($row = $result->fetch_object()) {
                                printf('
                        <tr>
                        <td>%s</td>
                        <td>%s</td>
                        </tr>',
                                        $row->EventName,
                                        $row->StartDate);
                            }
                        }

                        $result->free();
                        $con->close();
                        ?>
                    </table>
                </div>
            <?php
            } else {
                header('location: admin_login.php');
            }
            ?>
            <?php include 'admin_footer.php'; ?>
