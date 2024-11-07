<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modern-normalize.css">
    <link rel="stylesheet" href="utils.css">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />

    <title>Main | AptEase</title>
</head>

<body>
    <div class="main__wrapper">
        <div class="main__sidebar">
            <div class="main__logo">
                <span class="APT">APT</span>
                <span class="Ease">Ease</span>
            </div>

            <div class="main__sidebarlinks">
                <span class="nav__type">Main</span>
                <nav>
                    <ul>
                        <?php
                        $usertype = $_SESSION['usertype'];
                        switch ($_SESSION['usertype']) {
                            case 'ADMINISTRATOR':
                                echo "<li><a class='links' href='accounts-management.php'><i class='ti ti-address-book'></i>Accounts</a></li>";
                                echo "<li><a class='links' href='tenants-management.php'><i class='ti ti-door'></i>Tenants</a></li>";
                                echo "<li><a class='links' href='payments-management.php'><i class='ti ti-receipt'></i>Payments</a></li>";
                                echo "<li><a class='links' href='maintenance-management.php'><i class='ti ti-book'></i>Maintenance Records</a></li>";
                                break;
                            case 'LANDLORD':
                                echo "<li><a class='links' href='accounts-management.php'><i class='ti ti-address-book'></i>Accounts</a></li>";
                                echo "<li><a class='links' href='tenants-management.php'><i class='ti ti-door'></i>Tenants</a></li>";
                                echo "<li><a class='links' href='payments-management.php'><i class='ti ti-receipt'></i>Payments</a></li>";
                                echo "<li><a class='links' href='maintenance-management.php'><i class='ti ti-book'></i>Maintenance Records</a></li>";
                                break;
                            case 'TENANT':
                                echo "<li><a class='links' href='maintenance-management.php'><i class='ti ti-tool'></i>Maintenance Submission</a></li>";
                                break;
                            default:
                                // Handle unknown usertypess
                                echo "<li>Unknown usertype.</li>";
                                break;
                        }


                        ?>
                    </ul>

                </nav>
            </div>
            <div class="main__user">
                <?php
                //check if there is a session recorded
                if (isset($_SESSION['username'])) {
                    echo "<p class='welcome-name'>Welcome, " . $_SESSION['username'] . "</p>";
                    echo "<p class='welcome-type'>Type: " . $_SESSION['usertype'] . "</p>";
                    echo "<li><a class='logout' href='logout.php'>Logout</a></li>";
                } else {
                    //redirect the user to the login page
                    header("location: login.php");
                }
                ?>

            </div>

        </div>
        <div class="main__content">

        </div>
    </div>
</body>

</html>