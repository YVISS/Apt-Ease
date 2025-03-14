<?php
require_once 'config.php';
include 'sessionchecker.php';
include 'errors.php';
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
    <nav class="sidebar">
       <header>
        <div class="image-text">
            <span class="image">
                <img src="src/apt-ease-logo.png" alt="">
            </span>
            <div class="text header-text">
                <span class="name"><?php echo $_GET['username'];?></span>
            </div>
        </div>
       </header>
    </nav>
    <div class="wrapper">
        <header>
        </header>

        <div class="main-content">
            <div class="page-title">
                <h1>Main Admin</h1>
            </div>


        </div>
        <footer>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas, quisquam.</footer>
    </div>
</body>

</html>