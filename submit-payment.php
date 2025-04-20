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
                header("Location: payments-management.php?updatemsg=" . urlencode("Payment submitted successfully."));
                exit();
            } else {
                $errormsg = "Error submitting payment.";
            }
        } else {
            $errormsg = "Error preparing statement.";
        }
    } else {
        $errormsg = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/submit-payment.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
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
                qrContainer.style.display = "block";
            }
        }
    </script>
</head>

<body>
    <div class="wrapper">
        <div class="card">
            <h1>Submit Payment</h1>
            <!-- Display error message -->
            <?php if (!empty($errormsg)) echo "<p class='message error'>$errormsg</p>"; ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-group">
                    <label for="username">Apartment ID</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="Enter amount" min="0" required>
                </div>
                <div class="form-group">
                    <label>Payment Method</label><br>
                    <input type="radio" name="paymentMethod" value="GCash" onclick="showQR()" required> GCash
                    <input type="radio" name="paymentMethod" value="Bank" onclick="showQR()" required> Bank
                </div>
                <div id="qrContainer" style="display:none;">
                    <p>Scan QR to Pay:</p>
                    <img id="qrImage" src="" alt="QR Code">
                </div>
                <div class="form-actions">
                    <button type="submit">Submit Payment</button>
                    <a href="payments-management.php" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>