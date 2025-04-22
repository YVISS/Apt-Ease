<?php
require_once "config.php";
include "sessionchecker.php"; // Include session checker
include "errors.php"; // Include error handling
$usertype = $_SESSION['usertype'];
$username = $_SESSION['username']
?>
<html>
</html>
<head>
    <title>Apt-Ease - Payments Logs </title>
</head>
</form>
<?php
function buildTable($result)
{
    if (mysqli_num_rows($result) > 0) {
        //create table using html
        echo "<div class='table-container'>";
        echo "<table class='tblmanage'>";
        //create the header
        echo "<tr class='headers'>";
        echo "<th>Username</th><th>Amount</th><th>Payment Method</th><th>Date</th><th>Status</th>";
        echo "</tr>";
        echo "<br>";
        //display the data of the tablecx
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='cells'>";
            echo "<td class = 'items'>" . $row['username'] . "</td>";
            echo "<td class = 'items'>" . $row['amount'] . "</td>";
            echo "<td class = 'items'>" . $row['paymentmethod'] . "</td>";
            echo "<td class = 'items'>" . $row['date'] . "</td>";
            echo "<td class = 'items'>" . $row['status'] . "</td>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='table-container'>";
        echo "<p class='err-msg'>No records found.";
        echo "</div>";
    }
}
//display table
require_once "config.php";
//search
if (isset($_POST['btnsearch'])) {
    $sql = "SELECT * FROM tblpaymentslogs WHERE username LIKE ? OR paymentmethod LIKE ? OR amount LIKE ? ORDER BY datelog";
    if ($stmt = mysqli_prepare($link, $sql)) {
        $searchvalue = '%' . $_POST['txtsearch'] . '%';
        mysqli_stmt_bind_param($stmt, "sss", $searchvalue, $searchvalue, $searchvalue);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    } else {
        echo "Error on Search.";
    }
} elseif (isset($_POST['btnrefresh'])) {
    $sql = "SELECT * FROM tblpaymentslogs ORDER BY username";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    }
} else { //load the data from the accounts table
    $sql = "SELECT * FROM tblpaymentslogs ORDER BY username desc";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    } else {
        echo "Error on logs Load.";
    }
}
?>