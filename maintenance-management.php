<html>
<head>
    <title>Apt-Ease - Maintenance Management Page</title>
    <link rel="stylesheet" type="text/css" href="management.css">
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to confirm and delete this report?");
        }
    </script>
</head>
<body>
    <p>Maintenance Records</p>
    <a href='logout.php'>Logout</a>

    <?php
    session_start();
    require_once "config.php";
    $usertype = $_SESSION['usertype'];
    $username = $_SESSION['username']; // Get logged-in username

    switch ($usertype) {
        case 'LANDLORD':
            echo "<li><a class='links' href='accounts-management.php'>Accounts</a></li>";
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

    // Process confirmation (deletion) of reports
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btnconfirm'])) {
        $ticketID = $_POST['ticketID'];

        // Delete the record from the database
        $sql = "DELETE FROM tblmaintenance WHERE ticketID = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $ticketID);
            if (mysqli_stmt_execute($stmt)) {
                echo "<p class='success-msg'>Report #$ticketID has been confirmed and removed.</p>";
            } else {
                echo "<p class='err-msg'>Error deleting the report.</p>";
            }
        } else {
            echo "<p class='err-msg'>Error preparing the statement.</p>";
        }
    }

    function buildTable($result, $usertype) {
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-container'>";
            echo "<table class='tblmanage'>";
            echo "<tr class='headers'>";
            echo "<th>Ticket ID</th><th>Apartment ID</th><th>Description</th><th>Date Submitted</th>";

            // Add Confirm Column if user is a LANDLORD
            if ($usertype == "LANDLORD") {
                echo "<th>Action</th>";
            }

            echo "</tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr class='cells'>";
                echo "<td class='items'>" . $row['ticketID'] . "</td>";
                echo "<td class='items'>" . $row['username'] . "</td>";
                echo "<td class='items'>" . $row['description'] . "</td>";
                echo "<td class='items'>" . $row['dateSubmitted'] . "</td>";

                // Display Confirm Button only for LANDLORD
                if ($usertype == "LANDLORD") {
                    echo "<td class='items'>
                            <form method='POST' action=''>
                                <input type='hidden' name='ticketID' value='" . $row['ticketID'] . "'>
                                <input type='submit' name='btnconfirm' value='Confirm' onclick='return confirmDelete();'>
                            </form>
                          </td>";
                }

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

    // Fetch maintenance records correctly
    if ($usertype == 'LANDLORD') {
        $sql = "SELECT m.ticketID, m.username, m.description, m.dateSubmitted 
                FROM tblmaintenance m
                JOIN tblaccounts a ON m.username = a.username
                ORDER BY m.dateSubmitted DESC";
    } else {
        $sql = "SELECT m.ticketID, m.username, m.description, m.dateSubmitted 
                FROM tblmaintenance m
                JOIN tblaccounts a ON m.username = a.username
                WHERE m.username = ?
                ORDER BY m.dateSubmitted DESC";
    }

    if ($stmt = mysqli_prepare($link, $sql)) {
        if ($usertype == 'TENANT') {
            mysqli_stmt_bind_param($stmt, "s", $username);
        }
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result, $usertype);
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
            <input type="submit" value="Submit">
        </form>
    <?php } ?>
</body>
</html>
