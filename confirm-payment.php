<?php
session_start();
require_once "config.php";

// Ensure only landlords can access this page
if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != "LANDLORD") {
    header("Location: login.php");
    exit();
}

// Check if the required POST parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['amount']) && isset($_POST['date'])) {
    $username = $_POST['username'];
    $amount = $_POST['amount'];
    $date = $_POST['date'];

    // Update the payment status in the database
    $sql = "UPDATE tblpayments SET status='Confirmed' WHERE username=? AND amount=? AND date=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $amount, $date);
        if (mysqli_stmt_execute($stmt)) {
            // Redirect back to the payments management page with a success message
            header("Location: payments-management.php?msg=Payment confirmed successfully");
            exit();
        } else {
            echo "<p class='err-msg'>Error confirming payment.</p>";
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "<p class='err-msg'>Error preparing statement.</p>";
    }
} else {
    echo "<p class='err-msg'>Invalid request.</p>";
}
?>
