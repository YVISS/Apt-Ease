<?php
require_once "config.php";
include "sessionchecker.php";
$updatemsg = '';
$errormsg = '';

if (!isset($_SESSION['username'])) {
    echo "<font color='red'>Error: User not logged in.</font>";
    exit();
}

if (isset($_POST['btnsubmit'])) {
    $sql = "DELETE FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $username = trim($_POST['txtusername']);
        mysqli_stmt_bind_param($stmt, "s", $username);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("m/d/Y");
                $time = date("h:i:s");
                $action = "Delete";
                $module = "Accounts Management";
                $username = trim($_POST['txtusername']);
                $performedby = $_SESSION['username'];
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $username, $performedby);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Account Deleted";
                    header("location: accounts-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                } else {
                    echo "<font color='red'>Error on inserting logs: " . mysqli_error($link) . "</font>";
                }
            } else {
                
                $errormsg = "ERROR: Inserting on Logs";
                header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        } else {
            
            $errormsg = "Error on deleting account:";
            header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        $errormsg = "Error on preparing delete statement";
        header("location: accounts-management.php?errormsg=" . urlencode($errormsg));
        exit();

    }
}
?>
