<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="css/modern-normalize.css">
    <title>Apt-Ease</title>
</head>

<body>
    <div class="wrapper">
        <header>
            <img src="src/apt-ease-logo.png" alt="logo">
            <nav>
                <ul>
                    <li>
                        <div class="nav__links">
                            <a href="landing.php">Home</a>
                        </div>
                        <button type="submit"><a href="login.php">Login</a></button>
                    </li>
                </ul>
            </nav>
        </header>
        <div class="main-content">
            <div class="main__info">
                <h1>Effortless Living,</h1>
                <h3>SEAMLESS MANAGEMENT</h3>
            </div>
            <img src="src/aptease-index.png" alt="">
        </div>
        <footer>
            <div >
                <img src="src/apt-ease-logo.png" alt="logo">
            </div>
            <div>
                <p>
                    Apt-Ease is an apartment records management system. Helps improve efficiency in both record tracking and payment tracking.
                </p>
                <p>&copy; <span id="year"></span> Apt Ease. All Rights Reserved.</p>
            </div>

        </footer>
        <script>
            document.getElementById("year").textContent = new Date().getFullYear();
        </script>
    </div>
    
    <script>
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>

</html>