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
