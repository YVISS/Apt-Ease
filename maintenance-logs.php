<?php
require_once "config.php";
include "sessionchecker.php"; // Include session checker
include "errors.php"; // Include error handling
$usertype = $_SESSION['usertype'];
$username = $_SESSION['username'];
function buildTable($result)
{
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='table-container'>";
        echo "<table class='tblmanage'>";
        echo "<tr class='headers'>";
        echo "<th>Ticket ID</th><th>Username</th><th>Description</th><th>Date Submitted</th><th>Date Confirmed</th>";
        echo "</tr>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr class='cells'>";
            echo "<td class='items'>" . htmlspecialchars($row['ticketID']) . "</td>";
            echo "<td class='items'>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td class='items'>" . htmlspecialchars($row['description']) . "</td>";
            echo "<td class='items'>" . htmlspecialchars($row['dateSubmitted']) . "</td>";
            echo "<td class='items'>" . htmlspecialchars($row['dateConfirmed']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='table-container'>";
        echo "<p class='err-msg'>No records found.</p>";
        echo "</div>";
    }
}

$sql = "SELECT * FROM tblmaintenancelogs ORDER BY dateConfirmed DESC";
if ($stmt = mysqli_prepare($link, $sql)) {
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        buildTable($result);
    }
} else {
    echo "Error loading logs.";
}
?>
