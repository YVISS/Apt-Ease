<?php
require_once "config.php";
include "sessionchecker.php";

// Check if the required POST parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm-btn']) && isset($_POST['username']) && isset($_POST['amount'])) {
    $username = $_POST['username'];
    $amount = $_POST['amount'];

    // Update the payment status in the database
    $sql = "UPDATE tblpayments SET status = 'Confirmed' WHERE username = ? AND amount = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $amount);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the payments management page with a success message
            $updatemsg = "Payment confirmed successfully.";
            header("Location: payments-management.php?updatemsg=" . urlencode($updatemsg));
            exit();
        } else {
            $errormsg = "Error confirming payment.";
            header("Location: payments-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        $errormsg = "Error preparing statement.";
        header("Location: payments-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else {
    $errormsg = "Invalid request.";
    header("Location: payments-management.php?errormsg=" . urlencode($errormsg));
    exit();
}
?>
