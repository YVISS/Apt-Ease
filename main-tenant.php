<?php
// Include the necessary files
require_once "config.php"; // Database connection
include "sessionchecker.php"; // Ensure the user is logged in

// Initialize error message
$errorMessage = "";

// Check if user is logged in (assuming you store the username in the session)
if (isset($_SESSION['username'])) {
    // Fetch the logged-in user's username
    $username = $_SESSION['username'];

    // Query to get tenant information based on the username
    $sql = "SELECT t.apartmentNo, t.firstname, t.middlename, t.lastname, t.contactNo, t.downpayment, t.addedby, t.dateadded
            FROM tbltenants t
            JOIN tblaccounts a ON t.username = a.username
            WHERE t.username = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind the parameter (username)
        mysqli_stmt_bind_param($stmt, "s", $username);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Get the result
            $result = mysqli_stmt_get_result($stmt);

            // Check if the tenant data exists
            if (mysqli_num_rows($result) > 0) {
                // Fetch the tenant data
                $tenant = mysqli_fetch_array($result, MYSQLI_ASSOC);
            } else {
                $errorMessage = "No tenant data found for the logged-in user.";
            }
        } else {
            $errorMessage = "Failed to execute the query. Please try again later.";
        }
    } else {
        $errorMessage = "Failed to prepare the query. Please contact the administrator.";
    }
} else {
    $errorMessage = "You are not logged in. Please log in to access this page.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/defaults/main-defaults.css">

    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/main-tenant.css">
    <title>Main Tenant Page - Apt Ease</title>
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
                <li class="nav-link">
                        <a href="main-tenant.php">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-home"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l-2 0l9 -9l9 9l-2 0" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="payments-management.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coins">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" />
                                <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" />
                                <path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" />
                                <path d="M3 6v10c0 .888 .772 1.45 2 2" />
                                <path d="M3 11c0 .888 .772 1.45 2 2" />
                            </svg>
                            <span class="text nav-text" data-tenant-text="Payments">Payments</span>
                        </a>
                    </li>
                    <li class="nav-link">
                    <a href="maintenance-management.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hammer">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M11.414 10l-7.383 7.418a2.091 2.091 0 0 0 0 2.967a2.11 2.11 0 0 0 2.976 0l7.407 -7.385" />
                                <path d="M18.121 15.293l2.586 -2.586a1 1 0 0 0 0 -1.414l-7.586 -7.586a1 1 0 0 0 -1.414 0l-2.586 2.586a1 1 0 0 0 0 1.414l7.586 7.586a1 1 0 0 0 1.414 0z" />
                            </svg>
                            <span class="text nav-text" data-tenant-text="Maintenance">Maintenance</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="logout">
                <li class="nav-link">
                    <a href="logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                            <path d="M15 12h-12l3 -3" />
                            <path d="M6 15l-3 -3" />
                        </svg>
                        <span class="text nav-text" data-tenant-text="Logout">Logout</span>
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
            </div>
        </header>
        <div class="main-content">
            <div class="page-title">
                <h1>Main Tenant</h1><br>
                <h3>Welcome, <?php echo $tenant['firstname']  . " " . $tenant['lastname']; ?></h3>
                    <p><strong>Apartment No:</strong> <?= $tenant['apartmentNo']; ?></p>
                    <p><strong>Contact No:</strong> <?= $tenant['contactNo']; ?></p>
                    <p><strong>Downpayment Status:</strong> <?= $tenant['downpayment']; ?></p>
                    <p><strong>Added By:</strong> <?= $tenant['addedby']; ?></p>
                    <p><strong>Date Added:</strong> <?= $tenant['dateadded']; ?></p>
            </div>
        </div>
        <footer>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas, quisquam.</footer>
        </div>
        </div>
    
    <script>
        const body = document.querySelector("body"),
            sidebar = body.querySelector(".sidebar"),
            toggle = sidebar.querySelector(".toggle");

        toggle.addEventListener("click", () => {
            // Toggle class and check if it's added
            const isClosed = sidebar.classList.toggle("close");

            // Change the inner HTML based on the class state
            if (isClosed) {
                toggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-right-pipe">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M6 6l6 6l-6 6" />
                        <path d="M17 5v13" />
                    </svg>`;
            } else {
                toggle.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-left-pipe">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 6v12" />
                        <path d="M18 6l-6 6l6 6" />
                    </svg>`;
            }
        });
    </script>
</body>
</html>