<?php
require_once 'config.php';
include 'sessionchecker.php';
include 'errors.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/defaults/main-defaults.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/main-admin.css">
    <title>Main Page - Apt Ease</title>
</head>

</div>
<div class="lower__nav">
    <a href="logout.php"></a>
</div>

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
                    <?php
                    switch ($_SESSION['usertype']) {
                        case 'LANDLORD':
                            echo "<li class='nav-link'>
                                        <a href='accounts-management.php'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-users'>
                                                <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                                <path d='M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0' />
                                                <path d='M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2' />
                                                <path d='M16 3.13a4 4 0 0 1 0 7.75' />
                                                <path d='M21 21v-2a4 4 0 0 0 -3 -3.85' />
                                            </svg>
                                            <span class='text nav-text'>Accounts</span>
                                        </a>
                                    </li>";
                            echo "<li class='nav-link'>
                                    <a href='tenants-management.php'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-tent'>
                                            <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                            <path d='M11 14l4 6h6l-9 -16l-9 16h6l4 -6' />
                                        </svg>
                                        <span class='text nav-text'>Tenants</span>
                                    </a>
                                </li>";
                            echo "<li class='nav-link'>
                                    <a href='payments-management.php'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-coins'>
                                            <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                            <path d='M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z' />
                                            <path d='M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4' />
                                            <path d='M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z' />
                                            <path d='M3 6v10c0 .888 .772 1.45 2 2' />
                                            <path d='M3 11c0 .888 .772 1.45 2 2' />
                                        </svg>
                                        <span class='text nav-text'>Payments</span>
                                    </a>
                                </li>";
                            echo "<li class='nav-link'>
                                    <a href='maintenance-management.php'>
                                        <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-hammer'>
                                            <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                            <path d='M11.414 10l-7.383 7.418a2.091 2.091 0 0 0 0 2.967a2.11 2.11 0 0 0 2.976 0l7.407 -7.385' />
                                            <path d='M18.121 15.293l2.586 -2.586a1 1 0 0 0 0 -1.414l-7.586 -7.586a1 1 0 0 0 -1.414 0l-2.586 2.586a1 1 0 0 0 0 1.414l7.586 7.586a1 1 0 0 0 1.414 0z' />
                                        </svg>
                                        <span class='text nav-text'>Maintenance</span>
                                    </a>
                                </li>";
                            break;
                        case 'TENANT':
                            echo "<li class='nav-link'>
                                <a href='payments-management.php'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-coins'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                        <path d='M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z' />
                                        <path d='M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4' />
                                        <path d='M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z' />
                                        <path d='M3 6v10c0 .888 .772 1.45 2 2' />
                                        <path d='M3 11c0 .888 .772 1.45 2 2' />
                                    </svg>
                                    <span class='text nav-text' data-tenant-text='Payments'>Payments</span>
                                </a>
                            </li>";
                            echo "<li class='nav-link'>
                                <a href='maintenance-management.php'>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='icon icon-tabler icons-tabler-outline icon-tabler-hammer'>
                                        <path stroke='none' d='M0 0h24v24H0z' fill='none' />
                                        <path d='M11.414 10l-7.383 7.418a2.091 2.091 0 0 0 0 2.967a2.11 2.11 0 0 0 2.976 0l7.407 -7.385' />
                                        <path d='M18.121 15.293l2.586 -2.586a1 1 0 0 0 0 -1.414l-7.586 -7.586a1 1 0 0 0 -1.414 0l-2.586 2.586a1 1 0 0 0 0 1.414l7.586 7.586a1 1 0 0 0 1.414 0z' />
                                    </svg>
                                    <span class='text nav-text' data-tenant-text='Maintenance'>Maintenance</span>
                                </a>
                            </li>";
                            break;
                        default:
                            // Handle unknown usertypes
                            echo "<p>Unknown usertype.</p>";
                            break;
                    }
                    ?>

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
                </div>
            </header>
            <div class="main-content">
                <div class="page-title">
                    <h1>Main Admin</h1>
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