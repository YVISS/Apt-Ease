<?php
require_once "config.php";
include "sessionchecker.php";


// Ensure only landlords can access this page
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != "LANDLORD") {
    header("Location: login.php");
    exit();
}

// Check if the required POST parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm-btn']) && isset($_POST['username'])) {
    $username = $_POST['username'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    // Update the payment status in the database
    $sql = "UPDATE tblpayments SET status='Confirmed' WHERE username=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss",$_SESSION['username'], $username);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the payments management page with a success message
            $updatemsg = "Payment confirmed successfully";
            header("Location: payments-management.php?updatemsg=" . urlencode($updatemsg));
            exit();
        } else {
            $errormsg = "Error confirming payment";
            header("Location: payments-management.php?updatemsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        $errormsg = "Error preparing statement";
        header("Location: payments-management.php?updatemsg=" . urlencode($errormsg));
        exit();
    }
} else {
    $errormsg = "Invalid request";
        header("Location: payments-management.php?updatemsg=" . urlencode($errormsg));
        exit();
}
?>
