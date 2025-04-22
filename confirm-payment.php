<?php
require_once "config.php";
include "sessionchecker.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm-btn']) && isset($_POST['username']) && isset($_POST['amount'])) {
    $username = $_POST['username'];
    $amount = $_POST['amount'];

    // Start a transaction
    mysqli_begin_transaction($link);

    try {
        // Update the payment status in tblpayments
        $sqlUpdate = "UPDATE tblpayments SET status = 'Confirmed' WHERE username = ? AND amount = ?";
        if ($stmt = mysqli_prepare($link, $sqlUpdate)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $amount);
            mysqli_stmt_execute($stmt);
        }

        // Move the record to tblpaymentslog
        $sqlMove = "INSERT INTO tblpaymentslogs (username, amount, paymentmethod, date, status)
                    SELECT username, amount, paymentMethod, date, status
                    FROM tblpayments
                    WHERE username = ? AND amount = ?";
        if ($stmt = mysqli_prepare($link, $sqlMove)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $amount);
            mysqli_stmt_execute($stmt);
        }

        // Delete the record from tblpayments
        $sqlDelete = "DELETE FROM tblpayments WHERE username = ? AND amount = ?";
        if ($stmt = mysqli_prepare($link, $sqlDelete)) {
            mysqli_stmt_bind_param($stmt, "ss", $username, $amount);
            mysqli_stmt_execute($stmt);
        }

        // Commit the transaction
        mysqli_commit($link);

        // Redirect back with a success message
        $updatemsg = "Payment confirmed and moved to log successfully.";
        header("Location: payments-management.php?updatemsg=" . urlencode($updatemsg));
        exit();
    } catch (Exception $e) {
        // Rollback the transaction on error
        mysqli_rollback($link);
        $errormsg = "Error confirming payment: " . $e->getMessage();
        header("Location: payments-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else {
    $errormsg = "Invalid request.";
    header("Location: payments-management.php?errormsg=" . urlencode($errormsg));
    exit();
}
?>