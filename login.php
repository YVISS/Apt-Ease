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
                <form action="login.php" method="post">
                    <label for="">Account Name</label>
                    <input id="txtusername" type="text" name="txtusername" placeholder="Username" required >
                    <label for="">Password</label>
                    <input type="password" id="txtpassword" name="txtpassword" placeholder="Password" required minlength="6">
                    <button type="submit">Login</button>
                </form>
                </div>
            </div>
        </div>
        <footer>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quia, inventore?</footer>
    </div>
</body>
</html>
<?php
session_start();

if (isset($_POST['btnlogin'])) {
    require_once ('config.php');

    $msg = "";
    $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $_SESSION['username'] = $_POST['txtusername'];
                $_SESSION['usertype'] = $account['usertype'];
                header("location: index.php");
            } 
            else{
                $msg = "Incorrect Login Credentials";
            }
        } 
        else{
            $msg = "ERROR on the login statement";
        }
    }
}
?>