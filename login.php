<?php
$msg = "";

if (isset($_POST['btnlogin'])) {

    require_once('config.php');

    $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                session_start();
                $_SESSION['username'] = $account['username'];
                $_SESSION['usertype'] = $_POST['usertype'];
                header("location: main.php");
                // if($_SESSION['usertype'] == 'ADMIN' || $_SESSION['usertype'] == 'LANDLORD'){
                //     header("location: main-admin.php");
                // }
                // if($_SESSION['usertype'] == 'TENANT'){
                //     header("location: main-tenant.php");
                // }
            } else {
                $msg .= "Incorrect Login Credentials";
            }
        } else {
            $msg .= "ERROR on the login statement";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Apt-Ease - Login</title>
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <img src="src/apt-ease-logo.png" alt="Logo">
            </div>
        </header>
        <div class="main-content">
            <div class="card">
                <div class="card__content">
                    <h1>Login</h1>
                    <?php echo $msg; ?>
                    <form action="login.php" method="post">
                        <label for="txtusername">Account Name</label>
                        <input id="txtusername" type="text" name="txtusername" placeholder="Username" required>
                        <label for="txtpassword">Password</label>
                        <input type="password" id="password" name="txtpassword" placeholder="example123..." required>
                       
                        <button type="submit" id="btnlogin" name="btnlogin">Login</button>
                    </form>
                </div>
            </div>
        </div>
        <footer>
            <p>&copy; <span id="year"></span> AptEase. All Rights Reserved.</p>
        </footer>
        <script>
            document.getElementById("year").textContent = new Date().getFullYear();
        </script>
    </div>
</body>

</html>