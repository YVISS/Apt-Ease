<?php
require_once "config.php"; //need data
include "sessionchecker.php"; //just including the codes from the src file 
if (isset($_POST['btnsubmit'])) {
    $updatemsg = "";
    $msg = "";
    //if user is already existing
    $sql = "SELECT * FROM tblaccounts WHERE username = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtusername']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) ==  0) {
                //insert account
                $sql = "INSERT INTO tblaccounts (username, password, usertype, createdby, datecreated) VALUES (?,?,?,?,?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $datecreated = date("d/m/Y");
                    mysqli_stmt_bind_param($stmt, "sssss", $_POST['txtusername'], $_POST['txtpassword'], $_POST['cmbtype'], $_SESSION['username'], $datecreated);
                    if (mysqli_stmt_execute($stmt)) {
                        $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $date = date("d/m/Y");
                            $time = date("h:i:sa");
                            $action = "Create";
                            $module = "Accounts Management";
                            mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, trim($_POST['txtusername']), $_SESSION['username']);
                            if (mysqli_stmt_execute($stmt)) {
                                $updatemsg = "New User Added";
                                header("Location: accounts-management.php?msg=" . urlencode($updatemsg));
                                exit();
                            } else {
                                $msg = "<font color='red'>Error on insert Log</font>";
                            }
                        }
                    }
                } else {
                    $msg = "Error on adding new account";
                }
            } else {
                $msg = "Username already exixst";
            }
        }
    } else {
        echo "Error on finding if user exist";
    }
}

?>

<html>
    <head>
        <title>Create new Account</title>
    </head>
    <body>
        <p>Create new Account</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="text" name="txtusername" placeholder="Username" required><br>
        <input type="password" id="password" name="txtpassword" placeholder="Password" required><br>
        <input type="checkbox" id="showPassword" onclick="togglePassword()"> Show Password<br>
            User type: <select name="cmbtype" id="cmbtype" required><br>
                <option class="default" value="">-- Select Usertype --</option>
                <option value="ADMINISTRATOR">LANDLORD</option>
                <option value="REGISTRAR">TENANT</option><br><br>
            </select><br><br>
            <button type="submit" name="btnsubmit">Submit</button>
            <a href="accounts-management.php">Cancel</a>
        </form>
        <script>
            function togglePassword() {
                var passwordField = document.getElementById("password");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                } else {
                    passwordField.type = "password";
                }
            }
        </script>
    </body>
</html>