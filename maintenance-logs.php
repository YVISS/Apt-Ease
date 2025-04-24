<?php
session_start();
require_once "config.php";

// Ensure the user is logged in and is a LANDLORD
if (!isset($_SESSION['username']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 'LANDLORD') {
    header("Location: login.php");
    exit();
}

// Fetch maintenance logs from the tblmaintenancelogs table
$sql = "SELECT ticketID, username, description, dateSubmitted, dateConfirmed FROM tblmaintenancelogs";
$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/modern-normalize.css">
    <link rel="stylesheet" type="text/css" href="css/maintenance-management.css">
    <title>Apt-Ease - Maintenance Logs</title>
</head>

<body>
    <nav class="sidebar">
        <header>
            <i class="toggle">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left-pipe">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 6v12" />
                    <path d="M18 6l-6 6l6 6" />
                </svg>
            </i>
        </header>
        <div class="menu-bar">
            <div class="menu">
                <ul class="menu-links">
                    <!-- Landlord's Menu Items -->
                    <li class="nav-link"><a href="accounts-management.php">Accounts</a></li>
                    <li class="nav-link"><a href="tenants-management.php">Tenants</a></li>
                    <li class="nav-link"><a href="payments-management.php">Payments</a></li>
                    <li class="nav-link"><a href="maintenance-management.php">Maintenance</a></li>
                </ul>
            </div>
            <div class="logout">
                <li class="nav-link">
                    <a href="logout.php">
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>
            </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="wrapper-container">
            <header>
                <div class="header_logo">
                    <img src="src/apt-ease-logo.png" alt="" style="width: auto; height: 80px;">
                    <div class="user-info">
                        <?php echo $_SESSION['username'] . " | " . $_SESSION['usertype']; ?>
                    </div>
                </div>
            </header>
            <div class="main-content">
                <div class="page-title">
                    <h1>Maintenance Logs</h1>
                    <p>Below are the confirmed maintenance requests.</p>
                </div>
                <div class="table-section">
                    <table class="maintenance-logs-table">
                        <thead>
                            <tr>
                                <th>Ticket ID</th>
                                <th>Tenant Username</th>
                                <th>Description</th>
                                <th>Date Submitted</th>
                                <th>Date Confirmed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['ticketID']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['username']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['dateSubmitted']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['dateConfirmed']) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No maintenance logs found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <footer>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, quisquam.</footer>
        </div>
    </div>
</body>

</html>
