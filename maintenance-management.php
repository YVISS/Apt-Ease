<html>
    <head>
        <title> Apt-Ease - Maintenance Management Page</title>
        <link rel="stylesheet" type="text/css" href="management.css">
    </head>
<body>
    <p>Maintenance Records</p>
    <a href='logout.php'>Logout</a>
    <?php
        session_start();
        require_once "config.php";
        $usertype = $_SESSION['usertype'];
        
        switch ($usertype) {
            case 'LANDLORD':
                echo "<li><a class='links' href='accounts-management.php'>Accounts</a></li>";
                echo "<li><a class='links' href='tenants-management.php'>Tenants</a></li>";
                echo "<li><a class='links' href='payments-management.php'>Payments</a></li>";
                echo "<li><a class='links' href='maintenance-management.php'>Maintenance Records</a></li>";
                break;
            case 'TENANT':
                echo "<li><a class='links' href='payments-management.php'>Payments Submission</a></li>";
                echo "<li><a class='links' href='maintenance-management.php'>Maintenance Submission</a></li>";
                break;
            default:
                echo "<li>Unknown usertype.</li>";
                break;
        }
    ?>
    
    <?php
    function buildTable($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-container'>";
            echo "<table class='tblmanage'>";
            echo "<tr class='headers'>";
            echo "<th>Ticket ID</th><th>Apartment ID</th><th>Description</th><th>Date Submitted</th>";
            echo "</tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr class='cells'>";
                echo "<td class='items'>" . $row['ticketID'] . "</td>";
                echo "<td class='items'>" . $row['apartmentID'] . "</td>";
                echo "<td class='items'>" . $row['description'] . "</td>";
                echo "<td class='items'>" . $row['dateSubmitted'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='table-container'>";
            echo "<p class='err-msg'>No maintenance records found.</p>";
            echo "</div>";
        }
    }
    
    if ($usertype == 'LANDLORD') {
        $sql = "SELECT m.ticketID, t.apartmentID, m.description, m.dateSubmitted 
                FROM tblmaintenance m
                JOIN tbltenants t ON t.apartmentID = t.apartmentID
                ORDER BY m.dateSubmitted DESC";
    } else {
        $sql = "SELECT m.ticketID, t.apartmentID, m.description, m.dateSubmitted 
                FROM tblmaintenance m
                JOIN tbltenants t ON t.apartmentID = t.apartmentID
                WHERE t.apartmentID = ?
                ORDER BY m.dateSubmitted DESC";
    }
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        if ($usertype == 'TENANT') {
            mysqli_stmt_bind_param($stmt, "i", $apartmentID);
        }
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    } else {
        echo "Error loading maintenance records.";
    }
    ?>
    
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="submit" name="btnrefresh" value="Refresh">
    </form>
    
    <?php if ($usertype == "TENANT") { ?>
        <form action="submit-maintenance.php" method="POST">
            <label for="description">Maintenance Request:</label>
            <textarea name="description" required></textarea>
            <input type="submit" value="Submit">
        </form>
    <?php } ?>
    
    <?php if ($usertype == "LANDLORD") { ?>
        <form action="confirm-maintenance.php" method="POST">
            <input type="submit" name="btnconfirm" value="Confirm Resolution">
        </form>
    <?php } ?>
</body>
</html>
