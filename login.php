
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="modern-normalize.css">
    <link rel="stylesheet" href="utils.css">
    <link rel="stylesheet" href="login.css">
    <title>Apt-Ease | Login</title>
</head>
<body>
<div class="login__wrapper">
    <div class="login__card">
        <div class="login__image">
            <img class="aptease" src="./src/apt-ease.jpg" alt="AptEase Logo">
        </div>
        <div class="login__form">
            <div class="login__information">
                <h1>Welcome, User!</h1>
                <p>Sign in to continue</p>
            </div>
            <div class="login__inputs">
            <form class="login__creds" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <input type="text" placeholder="Username" name="txtusername" id="username" required>
                <input type="password" placeholder="Password" name="txtpassword" id="password" required>
                    <?php
                    if (!empty($errorMessage)) {
                        echo "<p class='error'>$errorMessage</p>";
                    }
                    ?>
                <button type="submit" name="btnlogin" value="Login">Login</button>
            </form>
            </div>
        </div>
    </div>
</div>
<header>
        <h1>APTEASE</h3>
    </header>

    <?php
$errorMessage = "";

if (isset($_POST['btnlogin'])) {
    require_once "config.php";

    $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ? AND status = 'ACTIVE'";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) > 0) {
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                session_start();
                $_SESSION['username'] = $_POST['txtusername'];
                $_SESSION['usertype'] = $account['usertype'];
                header("Location: index.php");
                exit(); // Always call exit after header redirection
            } else {
                $errorMessage = "Incorrect login details or account is inactive"; 
            }
        }
    } else {
        $errorMessage = "Error on the select statement"; 
    }
}
?>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> APTEASE</p>
    </footer>
</body>
</html>