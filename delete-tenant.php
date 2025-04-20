<?php
require_once "config.php";
include "sessionchecker.php";

if (isset($_POST['btnsubmit'])) {
    $sql = "DELETE FROM tbltenants WHERE apartmentNo = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $apartmentNo = trim($_POST['txtapartmentNo']);
        mysqli_stmt_bind_param($stmt, "s", $apartmentNo);
        if (mysqli_stmt_execute($stmt)) {
            // Log the deletion
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("m/d/Y");
                $time = date("h:i:s");
                $action = "Delete";
                $module = "Tenants Management";
                $performedby = $_SESSION['username'];
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $apartmentNo, $performedby);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Tenant deleted successfully.";
                    header("location: tenants-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                } else {
                    $errormsg = "Error on inserting logs.";
                    header("location: tenants-management.php?errormsg=" . urlencode($errormsg));
                    exit();
                }
            } else {
                $errormsg = "Error on preparing log statement.";
                header("location: tenants-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        } else {
            $errormsg = "Error on deleting tenant.";
            header("location: tenants-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        $errormsg = "Error on preparing delete statement.";
        header("location: tenants-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
}
?>