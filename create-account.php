<?php
require_once "config.php"; // Database connection
include "sessionchecker.php"; // Ensure the user is logged in

$updatemsg = '';
$errormsg = '';

if (isset($_POST['btnsubmit'])) {
    $updatemsg = "";
    // Check if the user already exists
    $sql = "SELECT * FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 0) {
                // Insert account
                $sql = "INSERT INTO tblaccounts (username, password, usertype, createdby, datecreated) VALUES (?,?,?,?,?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $datecreated = date("m/d/Y");
                    mysqli_stmt_bind_param($stmt, "sssss", $_POST['txtusername'], $_POST['txtpassword'], $_POST['cmbtype'], $_SESSION['username'], $datecreated);
                    if (mysqli_stmt_execute($stmt)) {
                        // Log the creation
                        $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $date = date("m/d/Y");
                            $time = date("h:i:s");
                            $action = "Create";
                            $module = "Accounts Management";
                            mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, trim($_POST['txtusername']), $_SESSION['username']);
                            if (mysqli_stmt_execute($stmt)) {
                                $updatemsg = "New User Added";
                                header("Location: accounts-management.php?updatemsg=" . urlencode($updatemsg));
                                exit();
                            } else {
                                $errormsg = "Error on inserting logs: ";
                                header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
                                exit();
                            }
                        }
                    }
                } else {
                    $errormsg = "Error on adding new account";
                    header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
                    exit();
                }
            } else {
                $errormsg = "Username already exists";
                header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
                exit();
            }
        }
    } else {
        $errormsg = "Error on finding if user exists";
        header("Location: accounts-management.php?errormsg=" . urlencode($errormsg));
        exit();
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
    <title>Create New Account</title>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1>Create New Account</h1>
            <!-- Display the message -->
            <?php if (!empty($msg)) echo "<p class='message'>$msg</p>"; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="txtusername">Username</label>
                    <input type="text" id="txtusername" name="txtusername" placeholder="Enter username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="txtpassword" placeholder="Enter password" required>
                    <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password
                </div>
                <div class="form-group">
                    <label for="cmbtype">User Type</label>
                    <select name="cmbtype" id="cmbtype" required>
                        <option value="" disabled selected>-- Select Usertype --</option>
                        <option value="LANDLORD">LANDLORD</option>
                        <option value="TENANT">TENANT</option>
                    </select>
                </div>
                <div class="form-actions">
                    <button type="submit" name="btnsubmit">Submit</button>
                    <a href="accounts-management.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            passwordField.type = passwordField.type === "password" ? "text" : "password";
        }
    </script>
</body>

</html>