<?php
session_start();
require_once "config.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username']; // Tenant's Apartment ID
$amount = "";
$paymentMethod = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['amount']) && isset($_POST['paymentMethod'])) {
        $amount = $_POST['amount'];
        $paymentMethod = $_POST['paymentMethod'];

        // Insert payment with default "Pending Confirmation" status
        $sql = "INSERT INTO tblpayments (username, amount, paymentMethod, date, status) VALUES (?, ?, ?, NOW(), 'Pending Confirmation')";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $amount, $paymentMethod);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: payments-management.php"); // Redirect after submission
                exit();
            } else {
                echo "<p class='err-msg'>Error submitting payment.</p>";
            }
        } else {
            echo "<p class='err-msg'>Error preparing statement.</p>";
        }
    } else {
        echo "<p class='err-msg'>Please fill in all fields.</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Payment</title>
    <script>
        function showQR() {
            var amount = document.getElementById("amount").value;
            var method = document.querySelector('input[name="paymentMethod"]:checked');
            var qrContainer = document.getElementById("qrContainer");
            var qrImage = document.getElementById("qrImage");

            if (amount && method) {
                qrContainer.style.display = "block";
                qrImage.src = "generate_qr.php?amount=" + amount + "&method=" + method.value;
            } else {
                qrContainer.style.display = "none";
            }
        }
    </script>
</head>
<body>
    <h2>Submit Payment</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label>Apartment ID:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly><br>

        <label>Amount:</label>
        <input type="number" id="amount" name="amount" required><br>

        <label>Payment Method:</label><br>
        <input type="radio" name="paymentMethod" value="GCash" onclick="showQR()" required> GCash
        <input type="radio" name="paymentMethod" value="Bank" onclick="showQR()" required> Bank<br>

        <div id="qrContainer" style="display:none;">
            <p>Scan QR to Pay:</p>
            <img id="qrImage" src="" alt="QR Code">
        </div>

        <br>
        <button type="submit">Submit Payment</button>
    </form>

    <br>
    <a href="payments-management.php"><button>Back</button></a>
</body>
</html>
