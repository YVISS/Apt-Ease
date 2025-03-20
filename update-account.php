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
                    header("Location: accounts-management.php");
                    exit();
                } else {
                    echo "<font color='red'>Error on inserting logs: " . mysqli_error($link) . "</font>";
                }
            } else {
                echo "<font color='red'>Error on preparing log statement: " . mysqli_error($link) . "</font>";
            }
        } else {
            echo "<font color='red'>Error on updating account: " . mysqli_error($link) . "</font>";
        }
    } else {
        echo "<font color='red'>Error on preparing update statement: " . mysqli_error($link) . "</font>";
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
                echo "<font color='red'>Error on loading screen: " . mysqli_error($link) . "</font>";
            }
        } else {
            echo "<font color='red'>Error on preparing select statement: " . mysqli_error($link) . "</font>";
        }
    }
}
?>
<html>
    <title>Update account</title>
    <body>
        <p>Update Account</p>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="POST">
            Username: <?php echo htmlspecialchars($account['username']); ?> <br>
            Password: <input type="password" id="passwordInput" name="txtpassword" placeholder="Password" required><br>
            <input type="checkbox" id="showPassword" onclick="togglePasswordVisibility()"> Show Password<br><br>
            Current User type: <?php echo htmlspecialchars($account['usertype']); ?><br><br>
            Change User type to: <select name="cmbtype" id="cmbtype" required>
                <option value="">--Select Account Type--</option>
                <option value="LANDLORD">LANDLORD</option>
                <option value="TENANT">TENANT</option>
            </select><br><br>
            <input type="submit" name="btnsubmit" value="Update"><br><br>
            <a href="accounts-management.php">Cancel</a>
        </form>
    </body>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('passwordInput');
            var showPasswordCheckbox = document.getElementById('showPassword');

            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</html>