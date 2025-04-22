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
    <title>Apt-Ease - Logs </title>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="text" name="txtsearch" placeholder="Search by datelog, action, or module....">
    <input type="submit" name="btnsearch" value="Search">
</body>
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
        echo "<th>Date log</th><th>Time log</th><th>Action</th><th>Module</th><th>ID</th><th>Performed by</th>";
        echo "</tr>";
        echo "<br>";
        //display the data of the tablecx
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='cells'>";
            echo "<td class = 'items'>" . $row['datelog'] . "</td>";
            echo "<td class = 'items'>" . $row['timelog'] . "</td>";
            echo "<td class = 'items'>" . $row['action'] . "</td>";
            echo "<td class = 'items'>" . $row['module'] . "</td>";
            echo "<td class = 'items'>" . $row['ID'] . "</td>";
            echo "<td class = 'items'>" . $row['performedby'] . "</td>";
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
    $sql = "SELECT * FROM tbllogs WHERE datelog LIKE ? OR action LIKE ? OR module LIKE ? ORDER BY datelog";
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
    $sql = "SELECT * FROM tbllogs ORDER BY datelog";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    }
} else { //load the data from the accounts table
    $sql = "SELECT * FROM tbllogs ORDER BY datelog desc";
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