<?php
require_once "config.php";
include "sessionchecker.php"; // Include session checker
include "errors.php"; // Include error handling
$usertype = $_SESSION['usertype'];
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/accounts-management.css">
    <link rel="stylesheet" type="text/css" href="css/modern-normalize.css">
    <title> Apt-Ease - Accounts Management Page</title>
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
                        <a href="accounts-management.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                            <span class="text nav-text">Accounts</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="tenants-management.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-tent">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M11 14l4 6h6l-9 -16l-9 16h6l4 -6" />
                            </svg>
                            <span class="text nav-text">Tenants</span>
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
                            <span class="text nav-text">Payments</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="maintenance-management.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hammer">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M11.414 10l-7.383 7.418a2.091 2.091 0 0 0 0 2.967a2.11 2.11 0 0 0 2.976 0l7.407 -7.385" />
                                <path d="M18.121 15.293l2.586 -2.586a1 1 0 0 0 0 -1.414l-7.586 -7.586a1 1 0 0 0 -1.414 0l-2.586 2.586a1 1 0 0 0 0 1.414l7.586 7.586a1 1 0 0 0 1.414 0z" />
                            </svg>
                            <span class="text nav-text">Maintenance</span>
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
                        <?php echo $username . " | " . $usertype; ?>
                    </div>
                </div>
            </header>
            <div class="main-content">
                <div class="page-title">
                    <h1>Accounts Management</h1>
                    <p>Create, Delete, and Manage accounts</p>
                </div>
                <div id="php_error" class="error">
                    <?php
                    if (isset($_GET['updatemsg'])) {
                        // Display the update status message
                        echo "<div class='msg' style=' color: green'> <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-circle-check-filled' width='24' height='24' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M17 3.34a10 10 0 1 1 -14.995 8.984l-.005 -.324l.005 -.324a10 10 0 0 1 14.995 -8.336zm-1.293 5.953a1 1 0 0 0 -1.32 -.083l-.094 .083l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.403 1.403l.083 .094l2 2l.094 .083a1 1 0 0 0 1.226 0l.094 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z' stroke-width='0' fill='currentColor' /></svg>" . htmlspecialchars($_GET['updatemsg']) . "</div>";
                    }
                    if (isset($_GET['errormsg'])) {
                        echo '<div class="msg" style=" color: red"> <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-xbox-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10s-10 -4.477 -10 -10s4.477 -10 10 -10m3.6 5.2a1 1 0 0 0 -1.4 .2l-2.2 2.933l-2.2 -2.933a1 1 0 1 0 -1.6 1.2l2.55 3.4l-2.55 3.4a1 1 0 1 0 1.6 1.2l2.2 -2.933l2.2 2.933a1 1 0 0 0 1.6 -1.2l-2.55 -3.4l2.55 -3.4a1 1 0 0 0 -.2 -1.4" /></svg>' . htmlspecialchars($_GET['errormsg']) . "</div>";
                    }
                    ?>
                </div>
                <div class="form_section">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                        <button class="btncreate" type="button" onclick="window.location.href='create-account.php'">Create Account</button>
                        <input type="text" name="txtsearch" placeholder="Search by username or usertype....">
                        <input type="submit" name="btnsearch" value="Search">
                    </form>
                </div>

                <div class="table_component" role="region" tabindex="0">
                    <?php
                    function buildTable($result)
                    {
                        if (mysqli_num_rows($result) > 0) {
                            //create table using html
                            echo "<div class='table-container'>";
                            echo "<table class='tblmanage'>";
                            //create the header
                            echo "<tr class='headers'>";
                            echo "<th>Username</th><th>Password</th><th>Usertype</th><th>Created by</th><th>Date Created</th><th>Action</th>";
                            echo "</tr>";
                            echo "<br>";
                            //display the data of the tablecx
                            while ($row = mysqli_fetch_array($result)) {
                                echo "<tr class='cells'>";
                                echo "<td class = 'items'>" . $row['username'] . "</td>";
                                echo "<td class = 'items'>" . $row['password'] . "</td>";
                                echo "<td class = 'items'>" . $row['usertype'] . "</td>";
                                echo "<td class = 'items'>" . $row['createdby'] . "</td>";
                                echo "<td class = 'items'>" . $row['datecreated'] . "</td>";
                                echo "<td class='action'>";
                                echo "<button class='update-btn' onclick=\"window.location.href='update-account.php?username=" . $row['username'] . "'\">
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                    <path d='M12 20h9' />
                                    <path d='M16.5 3.5a2.121 2.121 0 0 1 3 3l-12 12l-4 1l1 -4z' />
                                </svg>
                            </button>";
                                echo "<button class='delete-btn' onclick=\"confirmDelete('" . $row['username'] . "')\">
                                <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                    <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                                    <path d='M4 7l16 0' />
                                    <path d='M10 11l0 6' />
                                    <path d='M14 11l0 6' />
                                    <path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12' />
                                    <path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3' />
                                </svg>
                            </button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                            echo "</div>";
                        } else {
                            echo "<div class='table-container'>";
                            echo "<p class='err-msg'>No records found.";
                            echo "</div>";
                        }
                    }
                    //display table
                    require_once "config.php";
                    //search
                    if (isset($_POST['btnsearch'])) {
                        $sql = "SELECT * FROM tblaccounts WHERE username LIKE ? OR usertype LIKE ? ORDER BY username";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            $searchvalue = '%' . $_POST['txtsearch'] . '%';
                            mysqli_stmt_bind_param($stmt, "ss", $searchvalue, $searchvalue);
                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                buildTable($result);
                            }
                        } else {
                            echo "Error on Search.";
                        }
                    } elseif (isset($_POST['btnrefresh'])) {
                        $sql = "SELECT * FROM tblaccounts ORDER BY username";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                buildTable($result);
                            }
                        }
                    } else { //load the data from the accounts table
                        $sql = "SELECT * FROM tblaccounts ORDER BY username";
                        if ($stmt = mysqli_prepare($link, $sql)) {
                            if (mysqli_stmt_execute($stmt)) {
                                $result = mysqli_stmt_get_result($stmt);
                                buildTable($result);
                            }
                        } else {
                            echo "Error on accounts Load.";
                        }
                    }
                    ?>
                </div>

                <!-- Update Modal -->
                <div id="updateModal" class="modal">
                    <div class="modal-content">
                        <form action="delete-account.php" method="POST"></form>
                        <span class="close" onclick="closeModal('updateModal')">&times;</span>
                        <p>Are you sure you want to update this account?</p>
                        <button id="confirmUpdate" class="confirm-btn">Yes</button>
                        <button class="cancel-btn" onclick="closeModal('updateModal')">No</button>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div id="deleteModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeModal()">&times;</span>
                        <h2>Delete Account</h2>
                        <p>Are you sure you want to delete this account?</p>
                        <form id="deleteForm" action="delete-account.php" method="POST">
                            <input type="hidden" name="txtusername" id="deleteUsername">
                            <div class="form__btns">
                                <input class="confirm-btn" type="submit" value="Yes" name="btnsubmit">
                                <button class="cancel-btn" type="button" onclick="closeModal()">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <footer>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas, quisquam.</footer>
        </div>
    </div>

    <script>
        let errormsg = document.getElementById("php_error");
        const body = document.querySelector("body"),
            sidebar = body.querySelector(".sidebar"),
            toggle = sidebar.querySelector(".toggle");

        toggle.addEventListener("click", () => {
            // Toggle the 'close' class on the sidebar
            const isClosed = sidebar.classList.toggle("close");

            // Update the SVG icon based on the sidebar state
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

        let selectedUsername = "";

        function openUpdateModal(username) {
            selectedUsername = username;
            document.getElementById("updateModal").style.display = "block";
            document.getElementById("confirmUpdate").onclick = function() {
                window.location.href = `update-account.php?username=${selectedUsername}`;
            };
        }

        function confirmDelete(username) {
            document.getElementById('deleteUsername').value = username;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        // Close modals when clicking outside of them
        window.onclick = function(event) {
            if (event.target == document.getElementById('deleteModal')) {
                closeModal();
            }
        }

        setTimeout(() => {
            if (errormsg) {
                errormsg.style.transition = "opacity 1s";
                errormsg.style.opacity = "0";
                setTimeout(() => errormsg.style.display = none, 1000);
            }
        }, 3000);
    </script>
</body>

</html>