<html>
    <head>
        <title> Apt-Ease - Accounts Management Page</title>
        <link rel="stylesheet" type="text/css" href="management.css">
    </head>
<body>
    <p>Accounts Management</p>
    
    <?php
        session_start();
        $username = $_SESSION['username'];
        $usertype = $_SESSION['usertype'];
    ?>
    <p>Welcome, <?php echo htmlspecialchars($username); ?>.</p>
    <p>Usertype: <?php echo htmlspecialchars($usertype); ?></p>

    <a href='logout.php'>Logout</a><br><br>
    <a href = "accounts-management.php">Accounts</a><br>
    <a href = "tenants-management.php">Tenants</a><br>
    <a href = "payments-management.php">Payments</a><br>
    <a href = "maintenance-management.php">Maintenance</a><br><br>

    <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "POST">
        <a href ="create-account.php">Create new Account</a><br><br>
		<br>Search: <input type="text" name="txtsearch">
		<input type="submit" name="btnsearch" value="Search">
	</form>	
    
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
                    echo "<td = 'action'>";
                    echo "<a href='update-account.php?username=" . $row['username'] . "'>Update</a>";
                    echo "<a href='delete-account.php?username=" . $row['username'] . "' class='delete'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                        <path stroke='none' d='M0 0h24v24H0z' fill='none'/>
                        <path d='M4 7l16 0' />
                        <path d='M10 11l0 6' />
                        <path d='M14 11l0 6' />
                        <path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12' />
                        <path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3' />
                    </svg></a>";
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
</body>