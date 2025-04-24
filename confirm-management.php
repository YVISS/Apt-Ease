<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username']) || $_SESSION['usertype'] !== 'LANDLORD') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm-btn']) && isset($_POST['ticketID']) && isset($_POST['username'])) {
    $ticketID = $_POST['ticketID'];
    $username = $_POST['username'];

    // Start a transaction
    mysqli_begin_transaction($link);

    try {
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

                    // Step 3: Delete the maintenance request
                    $delete_sql = "DELETE FROM tblmaintenance WHERE ticketID = ? AND username = ?";
                    if ($delete_stmt = mysqli_prepare($link, $delete_sql)) {
                        mysqli_stmt_bind_param($delete_stmt, "ss", $ticketID, $username);
                        mysqli_stmt_execute($delete_stmt);

                        // Commit the transaction
                        mysqli_commit($link);

                        // Redirect with a success message
                        $updatemsg = "Maintenance request confirmed successfully.";
                        header("Location: maintenance-management.php?updatemsg=" . urlencode($updatemsg));
                        exit();
                    } else {
                        throw new Exception("Failed to delete the maintenance request.");
                    }
                } else {
                    throw new Exception("Failed to insert into maintenance logs.");
                }
            } else {
                throw new Exception("Maintenance request not found.");
            }
        } else {
            throw new Exception("Failed to prepare the query.");
        }
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($link);

        // Redirect with an error message
        $errormsg = "Error confirming maintenance request: " . $e->getMessage();
        header("Location: maintenance-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else {
    $errormsg = "Invalid request.";
    header("Location: maintenance-management.php?errormsg=" . urlencode($errormsg));
    exit();
}
?>
