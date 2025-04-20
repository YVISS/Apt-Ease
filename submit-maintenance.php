<?php
session_start();
require_once "config.php"; // Database connection

// Ensure only tenants can access this page
if (!isset($_SESSION['username']) || $_SESSION['usertype'] != 'TENANT') {
    echo "Access denied.";
    exit;
}

$username = $_SESSION['username']; // Get logged-in username (Apartment ID)
$dateSubmitted = date("Y-m-d H:i:s"); // Auto-generate submission date

// Generate the next ticketID for this user
$sql = "SELECT COUNT(*) AS ticketCount FROM tblmaintenance WHERE username = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $ticketCount);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}

// Format ticketID (Start from 001 per user)
$nextTicketID = str_pad($ticketCount + 1, 3, '0', STR_PAD_LEFT);

$error = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["description"])) {
        $description = trim($_POST["description"]);

        if (empty($description)) {
            $error = "Description cannot be empty.";
        } else {
            // Insert the maintenance request
            $sql = "INSERT INTO tblmaintenance (ticketID, username, description, dateSubmitted) VALUES (?, ?, ?, ?)";

            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "ssss", $nextTicketID, $username, $description, $dateSubmitted);

                if (mysqli_stmt_execute($stmt)) {
                    $updatemsg = "New Issue Added";
                    header("Location: maintenance-management.php?updatemsg=" . urlencode($updatemsg));
                    exit;
                } else {
                    $errormsg = "Error: Could not submit request.";
                    header("Location: maintenance-management.php?errormsg=" . urlencode($errormsg));
                }
                mysqli_stmt_close($stmt);
            } else {
                $errormsg = "Error: Could not prepare the statement.";
                header("Location: maintenance-management.php?errormsg=" . urlencode($errormsg));
                exit;
            }
        }
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Submit Maintenance Request</title>
    <link rel="stylesheet" type="text/css" href="css/modern-normalize.css">
    <link rel="stylesheet" type="text/css" href="css/submit-maintenance.css">
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1>Submit Maintenance Request</h1>
            <!-- Display any error messages -->
            <?php if (!empty($error)) echo "<p class='message'>$error</p>"; ?>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="form-group">
                    <label for="apartmentID">Apartment ID (Username):</label>
                    <input type="text" name="apartmentID" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="ticketID">Ticket ID:</label>
                    <input type="text" name="ticketID" value="<?php echo htmlspecialchars($nextTicketID); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="description">Maintenance Report:</label>
                    <textarea name="description" required></textarea>
                </div>
                <div class="form-actions">
                    <input type="submit" value="Submit">
                    <a href="maintenance-management.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>