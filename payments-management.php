<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$usertype = $_SESSION['usertype'];
$username = $_SESSION['username']; 

?>

<!DOCTYPE html>
<html>
<head>
    <title>Apt-Ease - Payments Management</title>
    <link rel="stylesheet" type="text/css" href="management.css">
    <script>
        function confirmPayment(username, amount, date) {
            if (confirm("Are you sure you want to confirm this payment?")) {
                window.location.href = "confirm-payment.php?username=" + username + "&amount=" + amount + "&date=" + date;
            }
        }
    </script>
</head>
<body>
    <h2>Payment Records</h2>
    <a href='logout.php'>Logout</a>

    <?php
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

    function buildTable($result, $usertype) {
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='table-container'>";
            echo "<table class='tblmanage'>";
            echo "<tr class='headers'>";
            echo "<th>Apartment ID</th><th>Amount</th><th>Payment Method</th><th>Date</th><th>Status</th>";

            if ($usertype == "LANDLORD") {
                echo "<th>Action</th>"; 
            }

            echo "</tr>";
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr class='cells'>";
                echo "<td class='items'>" . htmlspecialchars($row['username']) . "</td>";
                echo "<td class='items'>" . htmlspecialchars($row['amount']) . "</td>";
                echo "<td class='items'>" . htmlspecialchars($row['paymentMethod']) . "</td>";
                echo "<td class='items'>" . htmlspecialchars($row['date']) . "</td>";

                // ✅ Display status for BOTH Tenant and Landlord
                $status = htmlspecialchars($row['status']);
                echo "<td class='items'>" . $status . "</td>";

                // ✅ Landlord sees Confirm button only for "Pending Confirmation" payments
                if ($usertype == "LANDLORD") {
                    if ($status == "Pending Confirmation") {
                        echo "<td class='items'>
                                <button onclick='confirmPayment(\"" . urlencode($row['username']) . "\", \"" . $row['amount'] . "\", \"" . urlencode($row['date']) . "\")'>Confirm</button>
                              </td>";
                    } else {
                        echo "<td class='items'>—</td>"; // Empty action column if already confirmed
                    }
                }

                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "<div class='table-container'>";
            echo "<p class='err-msg'>No payment records found.</p>";
            echo "</div>";
        }
    }

    // Fetch payments based on user type
    if ($usertype == 'LANDLORD') {
        $sql = "SELECT username, amount, paymentMethod, date, status FROM tblpayments ORDER BY date DESC";
    } else {
        $sql = "SELECT username, amount, paymentMethod, date, status FROM tblpayments WHERE username = ? ORDER BY date DESC";
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
        echo "Error loading payment records.";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
        <input type="submit" name="btnrefresh" value="Refresh">
    </form>

    <?php if ($usertype == "TENANT") { ?>
    <form action="submit-payment.php" method="GET">
        <button type="submit">Add Payment</button>
    </form>
    <?php } ?>

</body>
</html>
