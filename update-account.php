<?php
require_once 'config.php';
include "sessionchecker.php";

if (isset($_POST['btnsubmit'])) {
    $sql = "UPDATE tblaccounts SET password =?, usertype =? WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $_POST['txtpassword'], $_POST['cmbtype'], $_GET['username']);
        if (mysqli_stmt_execute($stmt)) {
            $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = mysqli_prepare($link, $sql)) {
                $date = date("m/d/Y");
                $time = date("h:i:s");
                $action = "Update";
                $module = "Accounts Management";
                $performedby = $_SESSION['username'];
                mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, $_GET['username'], $performedby);
                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "Account updated successfully.";
                    header("Location: accounts-management.php?updatemsg=" . urlencode($updatemsg));
                    exit();
                } else {
                    $errormsg = "Error on inserting logs.";
                    header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
                    exit();
                }
            } else {
                $errormsg = "Error on preparing log statement.";
                header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        } else {
            $errormsg = "Error on updating account.";
            header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
            exit();
        }
    } else {
        $errormsg = "Error on preparing update statement.";
        header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
        exit();
    }
} else { // Load data to the form
    if (isset($_GET['username']) && !empty(trim($_GET['username']))) {
        $username = trim($_GET['username']); // Assign to a variable
        $sql = "SELECT * FROM tblaccounts WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username); // Pass the variable
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                $errormsg = "Error on loading screen.";
                header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        } else {
            $errormsg = "Error on preparing select statement.";
            header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
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
    <link rel="stylesheet" href="css/create-account.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <title>Update Account</title>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1>Update Account</h1>
            <!-- Display any error messages -->
            <?php if (!empty($msg)) echo "<p class='message'>$msg</p>"; ?>
            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
                <div class="form-group">
                    <label for="txtusername">Username</label>
                    <input type="text" id="txtusername" name="txtusername" value="<?php echo htmlspecialchars($account['username']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password</label>
                    <input type="password" id="passwordInput" name="txtpassword" placeholder="Enter new password" value="<?php echo htmlspecialchars($account['password']); ?>" required>
                    <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()"> Show Password
                </div>
                <div class="form-group">
                    <label for="cmbtype">User Type</label>
                    <select name="cmbtype" id="cmbtype" required>
                        <option value="" disabled>-- Select Usertype --</option>
                        <option value="LANDLORD" <?php echo $account['usertype'] == 'LANDLORD' ? 'selected' : ''; ?>>LANDLORD</option>
                        <option value="TENANT" <?php echo $account['usertype'] == 'TENANT' ? 'selected' : ''; ?>>TENANT</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="btnsubmit">Update</button>
                    <a href="accounts-management.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('passwordInput');
            passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>

</html>