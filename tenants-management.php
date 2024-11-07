<?php
session_start();
?>

<?php
if (isset($_SESSION['username'])) {
    
    if (isset($_SESSION['success_message'])) {
        echo "<script>showToast('".$_SESSION['success_message']."');</script>";
        unset($_SESSION['success_message']); 
    }
} else {
    header("location:login.php");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="utils.css">
    <link rel="stylesheet" href="modern-normalize.css">
    <title>Apt-Ease | Tenants Management</title>
</head>
<body>
<header>
    <h1>Apt-Ease</h1>
    <div class="account-actions">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <a href="logout.php">Logout</a>
        </form>
    </div>
</header>

<br> <a href="main.php">Home</a>
<div class="search-container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <center><a href="create-account.php">Add new Tenant</a><br></center>   
        <br>
        Search: <input type="text" name="txtSearch">
    </form>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="deleteContent"></div>
    </div>
</div>
    
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function showToast(message) {
            var toast = document.createElement('div');
            toast.classList.add('toast');
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(function() {
                toast.remove();
            }, 3000);
        }

        $(document).ready(function() {
            var modal = document.getElementById("myModal");
            var span = document.getElementsByClassName("close")[0];

            span.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }

            function openModal(username) {
                modal.style.display = "block";
                $.get("delete-account.php?username=" + username, function(data) {
                    $("#deleteContent").html(data);
                });
            }

            $(document).on("click", ".deleteLink", function(e) {
                e.preventDefault();
                openModal($(this).data("username"));
            });
        });
    </script>
</html>

<?php
function buildTable($result){
    if(mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr>";
        echo "<th>Apartment number</th><th>First name</th> <th>Middle name</th> <th>Last name</th> <th>Down payment</th> <th>Date created</th> <th>Created by</th> <th>Action</th>";
        echo "</tr>";
        echo "<br>";
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>". $row['aptnumber'] . "</td>";
            echo "<td>". $row['firstname'] . "</td>";
            echo "<td>". $row['middlename'] . "</td>";
            echo "<td>". $row['lastname'] . "</td>";
            echo "<td>". $row['downpayment'] . "</td>";
            echo "<td>". $row['datecreated'] . "</td>";
            echo "<td>". $row['createdby'] . "</td>";

            echo "<td>";
            echo "<a href='update-account.php?username=" . $row['username'] . "'>Update</a>";
            echo "<a href='#' class='deleteLink' data-username='" . $row['username'] . "'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No record/s found.";
    }
}

require_once "config.php";
if (isset($_POST['btnSearch'])) {
    $sql = "SELECT * FROM tbltenants WHERE aptnumber LIKE ? or lastname LIKE ? ORDER BY aptnumber";
    if($stmt = mysqli_prepare($link, $sql) ) {
        $searchvalue =  '%' . $_POST['txtSearch'] . '%';
        mysqli_stmt_bind_param($stmt, "ss",$searchvalue, $searchvalue);
        if(mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    } else {
        echo "Error on search";
    }
} else {
    $sql = "SELECT * FROM tbltenants ORDER BY aptnumber";
    if ($stmt = mysqli_prepare($link, $sql)) {
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            buildTable($result);
        }
    } else {
        echo "Error on tenants load";
    }
}
?>
