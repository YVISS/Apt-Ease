<?php
require_once 'config.php';
include "sessionchecker.php";

if (isset($_POST['btnsubmit'])) {
    // Update tenant information
    $sql = "UPDATE tbltenants SET firstname = ?, middlename = ?, lastname = ?, contactNo = ?, downpayment = ? WHERE apartmentNo = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $_POST['txtfirstname'], $_POST['txtmiddlename'], $_POST['txtlastname'], $_POST['txtcontactno'], $_POST['downpayment'], $_GET['apartmentNo']);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: tenants-management.php?msg=Tenant updated successfully");
            exit();
        } else {
            echo "<font color='red'>Error on updating tenant: " . mysqli_error($link) . "</font>";
        }
    } else {
        echo "<font color='red'>Error on preparing update statement: " . mysqli_error($link) . "</font>";
    }
} else { 
    // Load tenant data into the form
    if (isset($_GET['apartmentNo']) && !empty(trim($_GET['apartmentNo']))) {
        $apartmentNo = trim($_GET['apartmentNo']); // Assign to a variable
        $sql = "SELECT * FROM tbltenants WHERE apartmentNo = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $apartmentNo); // Use "s" for string
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                if ($result && mysqli_num_rows($result) > 0) {
                    $tenant = mysqli_fetch_array($result, MYSQLI_ASSOC);
                } else {
                    echo "<font color='red'>No tenant found with the given Apartment No.</font>";
                    exit();
                }
            } else {
                echo "<font color='red'>Error on loading tenant data: " . mysqli_error($link) . "</font>";
                exit();
            }
        } else {
            echo "<font color='red'>Error on preparing select statement: " . mysqli_error($link) . "</font>";
            exit();
        }
    } else {
        echo "<font color='red'>Invalid tenant ID. Please check the URL.</font>";
        var_dump($_GET); // Debugging: Output the contents of $_GET
        exit();
    }
}
?>
<html>
    <head>
        <title>Update Tenant</title>
    </head>
    <body>
        <p>Update Tenant</p>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
            Apartment No.: <?php echo htmlspecialchars($tenant['apartmentNo']); ?> <br>
            First Name: <input type="text" name="txtfirstname" placeholder="First Name" value="<?php echo htmlspecialchars($tenant['firstname']); ?>" required><br>
            Middle Name: <input type="text" name="txtmiddlename" placeholder="Middle Name" value="<?php echo htmlspecialchars($tenant['middlename']); ?>" required><br>
            Last Name: <input type="text" name="txtlastname" placeholder="Last Name" value="<?php echo htmlspecialchars($tenant['lastname']); ?>" required><br>
            Contact No: <input type="text" name="txtcontactno" placeholder="Contact No" value="<?php echo htmlspecialchars($tenant['contactNo']); ?>" required><br>
            Downpayment: 
            <select name="downpayment" required>
                <option value="YES" <?php echo ($tenant['downpayment'] === 'YES') ? 'selected' : ''; ?>>PAID</option>
                <option value="NO" <?php echo ($tenant['downpayment'] === 'NO') ? 'selected' : ''; ?>>NOT PAID</option>
            </select><br><br>
            <input type="submit" name="btnsubmit" value="Update"><br><br>
            <a href="tenants-management.php">Cancel</a>
        </form>
    </body>
</html>