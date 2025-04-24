<?php
require_once "config.php";
include "sessionchecker.php"; // Include session checker

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

// Determine the SQL query based on usertype
if ($_SESSION['usertype'] === 'LANDLORD') {
    // LANDLORD: Show all logs
    $sql = "SELECT * FROM tblmaintenancelogs ORDER BY dateConfirmed DESC";
} elseif ($_SESSION['usertype'] === 'TENANT') {
    // TENANT: Show only logs for the logged-in tenant
    $sql = "SELECT * FROM tblmaintenancelogs WHERE username = ? ORDER BY dateConfirmed DESC";
} else {
    echo "<p class='err-msg'>Unauthorized access.</p>";
    exit();
}

// Execute the query
if ($stmt = mysqli_prepare($link, $sql)) {
    if ($_SESSION['usertype'] === 'TENANT') {
        // Bind the username parameter for tenants
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
    }
    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        buildTable($result);
    } else {
        echo "<p class='err-msg'>Error executing query.</p>";
    }
} else {
    echo "<p class='err-msg'>Error preparing query.</p>";
}
?>