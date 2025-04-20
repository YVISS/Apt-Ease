<?php
require_once "config.php";
include "sessionchecker.php";
include "errors.php";

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
                    header("location: tenants-management.php");
                    exit();
                } else {
                    echo "<font color='red'>Error on inserting logs: " . mysqli_error($link) . "</font>";
                }
            } else {
                echo "<font color='red'>Error on preparing log statement: " . mysqli_error($link) . "</font>";
            }
        } else {
            echo "<font color='red'>Error on deleting tenant: " . mysqli_error($link) . "</font>";
        }
    } else {
        echo "<font color='red'>Error on preparing delete statement: " . mysqli_error($link) . "</font>";
    }
}
?>
<html>
<title>Delete Tenant</title>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="hidden" name="txtapartmentNo" value="<?php echo trim($_GET['apartmentNo']); ?>" />
        <p>Are you sure you want to delete this tenant?</p><br>
        <input type="submit" name="btnsubmit" value="Yes">
        <a href="tenants-management.php">No</a>
    </form>
</body>
</html>