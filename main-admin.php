<?php 
require_once 'config.php';
include 'sessionchecker.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/defaults/main-defaults.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <link rel="stylesheet" href="css/main-admin.css">
    <title>Main Admin Page - Apt Ease</title>
</head>
<body>
    <div class="wrapper">
        <header></header>
        <div class="main-content">
            <nav>
                <img src="src/apt-ease-logo.png" alt="">
                <ul>
                    <div class="middle__nav">
                        <li><a href="">Accounts</a></li>
                        <li><a href="">Tenants</a></li>
                        <li><a href="">Payments</a></li>
                        <li><a href="">Maintentance</a></li>

                    </div>
                    <div class="lower__nav">
                        <li><a href="logout.php">Logout</a></li>
                    </div>
                    
                </ul>
            </nav>
        </div>
        <footer></footer>
    </div>
</body>
</html>