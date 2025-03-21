<?php
require_once "config.php"; //need data
include "sessionchecker.php"; //just including the codes from the src file 
if (isset($_POST['btnsubmit'])) {
    $updatemsg = "";
    $msg = "";
    //if user is already existing
    $sql = "SELECT * FROM tbltenants WHERE apartmentNo = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $_POST['txtapartmentNo']);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) ==  0) {
                //insert account
                $sql = "INSERT INTO tbltenants (apartmentNo, firstname, middlename, lastname, contactNo, downpayment, addedby, dateadded) VALUES (?,?,?,?,?,?,?,?)";
                if ($stmt = mysqli_prepare($link, $sql)) {
                    $dateadded = date("m/d/Y");
                    mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['txtapartmentNo'], $_POST['firstname'], $_POST['middlename'], $_POST['lastname'], $_POST['contactNo'], $_POST['downpayment'], $_SESSION['username'], $dateadded);
                    if (mysqli_stmt_execute($stmt)) {
                        $sql = "INSERT INTO tbllogs (datelog, timelog, action, module, ID, performedby) VALUES (?, ?, ?, ?, ?, ?)";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $date = date("d/m/Y");
                            $time = date("h:i:sa");
                            $action = "Create";
                            $module = "Tenants Management";
                            mysqli_stmt_bind_param($stmt, "ssssss", $date, $time, $action, $module, trim($_POST['txtusername']), $_SESSION['username']);
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
                    $msg = "Error on adding new tenant";
                }
            } else {
                $msg = "Apartment No. already exist";
            }
        }
    } else {
        echo "Error on finding if tenant exist";
    }
}

?>

<html>
    <head>
        <title>Add new Tenant</title>
    </head>
    <body>
        <p>Add new Tenant</p>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="text" name="txtapartmentNo" placeholder="ApartmentNo" required><br>
        <input type="text" name="firstname" placeholder="First Name" required><br>
        <input type="text" name="middlename" placeholder="Middle Name" required><br>
        <input type="text" name="lastname" placeholder="Last Name" required><br>
        <input type="text" name="contactNo" placeholder="Contact No." required><br>
            Downpayment: <select name="downpayment" id="downpayment" required><br>
                <option class="default" value="">-- Select Downpayment Status --</option>
                <option value="YES">PAID</option>
                <option value="NO">NOT PAID</option><br><br>
            </select><br><br>
            <button type="submit" name="btnsubmit">Submit</button>
            <a href="tenants-management.php">Cancel</a>
        </form>
    </body>
</html>