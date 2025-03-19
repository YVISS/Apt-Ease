<?php
$msg = "";

session_start();

if (isset($_POST['btnlogin'])) {

    require_once('config.php');

    $sql = "SELECT * FROM tblaccounts WHERE username = ? AND password = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $_POST['txtusername'], $_POST['txtpassword']);

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                $account = mysqli_fetch_array($result, MYSQLI_ASSOC);//fetches the user data

                $_SESSION['username'] = $account['username'];
<<<<<<< HEAD
                $_SESSION['usertype'] = $_POST['usertype'];
                header("location: main.php");
                // if($_SESSION['usertype'] == 'ADMIN' || $_SESSION['usertype'] == 'LANDLORD'){
                //     header("location: main-admin.php");
                // }
                // if($_SESSION['usertype'] == 'TENANT'){
                //     header("location: main-tenant.php");
                // }
=======
                $_SESSION['usertype'] = $account['usertype'];
                //validate usertype
                if($_SESSION['usertype'] == 'LANDLORD'){
                    header("location: main-admin.php");
                }else if($_SESSION['usertype'] == 'TENANT'){
                    header('location: main-tenant.php');
                }else{
                    $msg .= "ERROR: Usertype not available";
                }
>>>>>>> 65942fd5426c2fe6c445e5aebdd284f80a1bc640
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
                        <input id="txtusername" type="text" name="txtusername" requried placeholder="Username" autofocus>
                        <label for="txtpassword">Password</label>
                        <div class="password-container">
                            <input type="password" id="password" name="txtpassword" placeholder="example123..." required>
                            <span class="toggle-password" onclick="togglePassword()">
                                <div id="togglePassIcon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                </svg>
                                </div>
                                </span>
                        </div>
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
    <script>
        function togglePassword() {
        let passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="m644-428-58-58q9-47-27-88t-93-32l-58-58q17-8 34.5-12t37.5-4q75 0 127.5 52.5T660-500q0 20-4 37.5T644-428Zm128 126-58-56q38-29 67.5-63.5T832-500q-50-101-143.5-160.5T480-720q-29 0-57 4t-55 12l-62-62q41-17 84-25.5t90-8.5q151 0 269 83.5T920-500q-23 59-60.5 109.5T772-302Zm20 246L624-222q-35 11-70.5 16.5T480-200q-151 0-269-83.5T40-500q21-53 53-98.5t73-81.5L56-792l56-56 736 736-56 56ZM222-624q-29 26-53 57t-41 67q50 101 143.5 160.5T480-280q20 0 39-2.5t39-5.5l-36-38q-11 3-21 4.5t-21 1.5q-75 0-127.5-52.5T300-500q0-11 1.5-21t4.5-21l-84-82Zm319 93Zm-151 75Z"/></svg>';
        } else {
            passwordInput.type = "password";
            let eye = document.getElementById('togglePassIcon').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#EEEEE"><path d="M480-320q75 0 127.5-52.5T660-500q0-75-52.5-127.5T480-680q-75 0-127.5 52.5T300-500q0 75 52.5 127.5T480-320Zm0-72q-45 0-76.5-31.5T372-500q0-45 31.5-76.5T480-608q45 0 76.5 31.5T588-500q0 45-31.5 76.5T480-392Zm0 192q-146 0-266-81.5T40-500q54-137 174-218.5T480-800q146 0 266 81.5T920-500q-54 137-174 218.5T480-200Zm0-300Zm0 220q113 0 207.5-59.5T832-500q-50-101-144.5-160.5T480-720q-113 0-207.5 59.5T128-500q50 101 144.5 160.5T480-280Z"/></svg>';
        }
    }
    </script>
</body>
</html>