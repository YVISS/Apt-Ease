<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['usertype']) || $_SESSION['usertype'] != "LANDLORD") {
    header("Location: login.php");
    exit();
}

if (isset($_GET['username']) && isset($_GET['amount']) && isset($_GET['date'])) {
    $username = $_GET['username'];
    $amount = $_GET['amount'];
    $date = $_GET['date']; 

    // ✅ Update only the exact payment entry using username, amount, and date as unique keys
    $sql = "UPDATE tblpayments SET status='Confirmed' WHERE username=? AND amount=? AND date=?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $amount, $date);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: payments-management.php");
            exit();
        } else {
            echo "<p class='err-msg'>Error confirming payment.</p>";
        }
    } else {
        echo "<p class='err-msg'>Error preparing statement.</p>";
    }
} else {
    echo "<p class='err-msg'>Invalid request.</p>";
}
?>
