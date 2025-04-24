<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'LANDLORD') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['btnconfirm'])) {
    $ticketID = $_POST['ticketID'];
    $username = $_POST['username']; // Pass username from the form too

    // Step 1: Fetch specific maintenance request
    $sql = "SELECT ticketID, username, description, dateSubmitted FROM tblmaintenance WHERE ticketID = ? AND username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $ticketID, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
            // Step 2: Insert into logs
            $insert_sql = "INSERT INTO tblmaintenancelogs (ticketID, username, description, dateSubmitted, dateConfirmed) VALUES (?, ?, ?, ?, NOW())";
            if ($insert_stmt = mysqli_prepare($link, $insert_sql)) {
                mysqli_stmt_bind_param($insert_stmt, "ssss", $row['ticketID'], $row['username'], $row['description'], $row['dateSubmitted']);
                mysqli_stmt_execute($insert_stmt);

                // Step 3: Delete only this user's ticket
                $delete_sql = "DELETE FROM tblmaintenance WHERE ticketID = ? AND username = ?";
                if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
                    mysqli_stmt_bind_param($delete_stmt, "ss", $ticketID, $username);
                    mysqli_stmt_execute($delete_stmt);
                }

                header("Location: maintenance-management.php?updatemsg=" . urlencode("Maintenance confirmed."));
                exit();
            }
        } else {
            header("Location: maintenance-management.php?errormsg=" . urlencode("Request not found."));
            exit();
        }
    }
}
?>
