<?php
require_once "config.php"; // Include database connection
include "sessionchecker.php"; // Session checker

if (isset($_POST['btnsubmit'])) {
    $updatemsg = "";
    $errormsg = "";

    // Check if the tenant's apartmentNo already exists
    $sql = "SELECT * FROM tbltenants WHERE apartmentNo = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtapartmentNo']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                // Insert tenant data into tbltenants
                $sql = "INSERT INTO tbltenants (apartmentNo, firstname, middlename, lastname, contactNo, downpayment, addedby, dateadded, username) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $dateadded = date("m/d/Y");
                    mysqli_stmt_bind_param($stmt, "sssssssss", $_POST['txtapartmentNo'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['contactNo'], $_POST['downpayment'], $_SESSION['username'], $dateadded, $_POST['username']);
                    if (mysqli_stmt_execute($stmt)) {
                        // Insert log for this action
                        $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $date = date("m/d/Y");
                            $time = date("h:i:s");
                            $action = "Add";
                            $module = "Tenants Management";
                            mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_POST['txtapartmentNo'], $_SESSION['username']);
                            if (mysqli_stmt_execute($stmt)) {
                                $updatemsg = "New Tenant Added";
                                header("Location: tenants-management.php?updatemsg=" . urlencode($updatemsg));
                                exit();
                            } else {
                                $errormsg = "Error on inserting logs.";
                                header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
                                exit();
                            }
                        }
                    } else {
                        $errormsg = "Error on adding new tenant.";
                        header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
                        exit();
                    }
                }
            } else {
                $errormsg = "Apartment No. already exists.";
                header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        }
    } else {
        $errormsg = "Error on finding if tenant exists.";
        header("Location: tenants-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/add-tenant.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <title>Add New Tenant</title>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1>Add New Tenant</h1>
            <!-- Display any error messages -->
            <?php if (!empty($errormsg)) echo "<p class='message error'>$errormsg</p>"; ?>
            <?php if (!empty($updatemsg)) echo "<p class='message success'>$updatemsg</p>"; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="username">Select Account:</label>
                    <select name="username" id="username" required>
                        <option value="">-- Select Account --</option>
                        <?php
                        $sql = "SELECT a.username 
                                FROM tblaccounts a 
                                LEFT JOIN tbltenants t ON a.username = t.username 
                                WHERE t.username IS NULL";
                        $result = mysqli_query($link, $sql);
                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . htmlspecialchars($row['username']) . "'>" . htmlspecialchars($row['username']) . "</option>";
                            }
                        } else {
                            echo "<option>No available accounts</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="txtapartmentNo">Apartment No</label>
                    <input type="text" name="txtapartmentNo" id="txtapartmentNo" placeholder="Apartment No" required>
                </div>
                <div class="form-group">
                    <label for="firstname">First Name</label>
                    <input type="text" name="firstname" id="firstname" placeholder="First Name" required>
                </div>
                <div class="form-group">
                    <label for="middlename">Middle Name</label>
                    <input type="text" name="middlename" id="middlename" placeholder="Middle Name" required>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name</label>
                    <input type="text" name="lastname" id="lastname" placeholder="Last Name" required>
                </div>
                <div class="form-group">
                    <label for="contactNo">Contact No.</label>
                    <input type="text" name="contactNo" id="contactNo" placeholder="Contact No." required>
                </div>
                <div class="form-group">
                    <label for="downpayment">Downpayment</label>
                    <select name="downpayment" id="downpayment" required>
                        <option value="">-- Select Downpayment Status --</option>
                        <option value="YES">PAID</option>
                        <option value="NO">NOT PAID</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="btnsubmit">Submit</button>
                    <a href="tenants-management.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
