<?php
require_once "config.php"; // Include database connection
include "sessionchecker.php"; // Session checker (not modified)

if (isset($_POST['btnsubmit'])) {
    $updatemsg = "";
    $msg = "";
    // Check if the tenant's apartmentNo already exists
    $sql = "SELECT * FROM tbltenants WHERE apartmentNo = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtapartmentNo']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) ==  0) {
                // Insert tenant data into tbltenants
                $sql = "INSERT INTO tbltenants (apartmentNo, firstname, middlename, lastname, contactNo, downpayment, addedby, dateadded, username) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $dateadded = date("m/d/Y");
                    // Add username from the form as well
                    mysqli_stmt_bind_param($stmt, "sssssssss", $_POST['txtapartmentNo'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['contactNo'], $_POST['downpayment'], $_SESSION['username'], $dateadded, $_POST['username']);
                    if (mysqli_stmt_execute($stmt)) {
                        // Insert log for this action
                        $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) 
                                VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $date = date("d/m/Y");
                            $time = date("h:i:sa");
                            $action = "Create";
                            $module = "Tenants Management";
                            mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_POST['txtapartmentNo'], $_SESSION['username']);
                            if (mysqli_stmt_execute($stmt)) {
                                $updatemsg = "New Tenant Added";
                                header("Location: tenants-management.php?msg=" . urlencode($updatemsg));
                                exit();
                            } else {
                                $msg = "<font color='red'>Error on inserting Logs</font>";
                            }
                        }
                    }
                } else {
                    $msg = "<font color='red'>Error on adding new tenant</font>";
                }
            } else {
                $msg = "<font color='red'>Apartment No. already exists</font>";
            }
        }
    } else {
        echo "<font color='red'>Error on finding if tenant exists</font>";
    }
}

?>

<html>
    <head>
        <title>Add new Tenant</title>
    </head>
    <body>
        <p>Add new Tenant</p>
        <?php if (!empty($msg)) echo "<p>$msg</p>"; ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <!-- Select Account from tblaccounts that does not have tenant information -->
            <label for="username">Select Account:</label>
            <select name="username" id="username" required>
                <option value="">-- Select Account --</option>
                <?php
                // Fetch accounts from tblaccounts that do not have corresponding tenant information in tbltenants
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
            </select><br><br>

            <!-- Tenant Information -->
            <input type="text" name="txtapartmentNo" placeholder="Apartment No" required><br>
            <input type="text" name="firstname" placeholder="First Name" required><br>
            <input type="text" name="middlename" placeholder="Middle Name" required><br>
            <input type="text" name="lastname" placeholder="Last Name" required><br>
            <input type="text" name="contactNo" placeholder="Contact No." required><br>

            <!-- Downpayment Selection -->
            Downpayment: 
            <select name="downpayment" id="downpayment" required>
                <option value="">-- Select Downpayment Status --</option>
                <option value="YES">PAID</option>
                <option value="NO">NOT PAID</option>
            </select><br><br>

            <button type="submit" name="btnsubmit">Submit</button>
            <a href="tenants-management.php">Cancel</a>
        </form>
    </body>
</html>
