<?php
require_once "config.php";
include "session-checker.php";

session_start(); // Ensure the session is started

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
                    header("location: accounts-management.php");
                    exit();
                } else {
                    echo "<font color='red'>Error on inserting logs: " . mysqli_error($link) . "</font>";
                }
            } else {
                echo "<font color='red'>Error on preparing log statement: " . mysqli_error($link) . "</font>";
            }
        } else {
            echo "<font color='red'>Error on deleting account: " . mysqli_error($link) . "</font>";
        }
    } else {
        echo "<font color='red'>Error on preparing delete statement: " . mysqli_error($link) . "</font>";
    }
}
?>
<html>
<title>Delete Account</title>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="hidden" name="txtusername" value="<?php echo trim($_GET['username']); ?>" />
        <p>Are you sure you want to delete this account?</p><br>
        <input type="submit" name="btnsubmit" value="Yes">
        <a href="accounts-management.php">No</a>
    </form>
</body>
</html>