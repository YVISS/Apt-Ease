<?php
require_once 'config.php';
include "sessionchecker.php";

$updatemsg = "";
$errormsg = "";

if (isset($_POST['btnsubmit'])) {
    // Update tenant information
    $sql = "UPDATE tbltenants SET firstname = ?, middlename = ?, lastname = ?, contactNo = ?, downpayment = ? WHERE apartmentNo = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $_POST['txtfirstname'], $_POST['txtmiddlename'], $_POST['txtlastname'], $_POST['txtcontactno'], $_POST['downpayment'], $_GET['apartmentNo']);
        if (mysqli_stmt_execute($stmt)) {
            // Log the update action
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("m/d/Y");
                $time = date("h:i:s");
                $action = "Update";
                $module = "Tenants Management";
                $performedby = $_SESSION['username'];
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_GET['apartmentNo'], $performedby);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Tenant updated successfully.";
                    header("Location: tenants-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                } else {
                    $errormsg = "Error on inserting logs.";
                    header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
                    exit();
                }
            }
        } else {
            $errormsg = "Error on updating tenant.";
            header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        $errormsg = "Error on preparing update statement.";
        header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else {
    // Load tenant data into the form
    if (isset($_GET['apartmentNo']) && !empty(trim($_GET['apartmentNo']))) {
        $apartmentNo = trim($_GET['apartmentNo']);
        $sql = "SELECT * FROM tbltenants WHERE apartmentNo = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $apartmentNo);
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if ($result && mysqli_num_rows($result) > 0) {
                    $tenant = mysqli_fetch_array($result, MYSQLI_ASSOC);
                } else {
                    $errormsg = "No tenant found with the given Apartment No.";
                    header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
                    exit();
                }
            } else {
                $errormsg = "Error on loading tenant data.";
                header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        } else {
            $errormsg = "Error on preparing select statement.";
            header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/update-tenant.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <title>Update Tenant</title>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1>Update Tenant</h1>
            <!-- Display any error or success messages -->
            <?php if (!empty($errormsg)) echo "<p class='message error'>$errormsg</p>"; ?>
            <?php if (!empty($updatemsg)) echo "<p class='message success'>$updatemsg</p>"; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
                <div class="form-group">
                    <label for="txtapartmentNo">Apartment No</label>
                    <input type="text" id="txtapartmentNo" name="txtapartmentNo" value="<?php echo htmlspecialchars($tenant['apartmentNo']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="txtfirstname">First Name</label>
                    <input type="text" id="txtfirstname" name="txtfirstname" value="<?php echo htmlspecialchars($tenant['firstname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="txtmiddlename">Middle Name</label>
                    <input type="text" id="txtmiddlename" name="txtmiddlename" value="<?php echo htmlspecialchars($tenant['middlename']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="txtlastname">Last Name</label>
                    <input type="text" id="txtlastname" name="txtlastname" value="<?php echo htmlspecialchars($tenant['lastname']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="txtcontactno">Contact No</label>
                    <input type="text" id="txtcontactno" name="txtcontactno" value="<?php echo htmlspecialchars($tenant['contactNo']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="downpayment">Downpayment</label>
                    <select name="downpayment" id="downpayment" required>
                        <option value="YES" <?php echo ($tenant['downpayment'] === 'YES') ? 'selected' : ''; ?>>PAID</option>
                        <option value="NO" <?php echo ($tenant['downpayment'] === 'NO') ? 'selected' : ''; ?>>NOT PAID</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="btnsubmit">Update</button>
                    <a href="tenants-management.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>