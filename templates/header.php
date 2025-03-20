<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Navigation</title>
    <link rel="stylesheet" href="./assets/style.css">
    <script src="./assets/script.js" defer></script>
</head>
<body>
    <header>
        <nav>
            <span class="logo">LOGO</span>
            <div class="hamburger" onclick="toggleMenu()">
                <div class="bar rot1"></div>
                <div class="bar hide"></div>
                <div class="bar rot2"></div>
            </div>
            <ul class="nav-list">
                <hr class="line">
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <?php if(isset($_SESSION['username'])){ ?>
                    <li class='user'><a href="profile.php?uid=<?php echo $_SESSION['username'] ?>">Profile</a></li>
                    <li class='user'><a href="logout.php">Logout <?php echo $_SESSION['username'] ?></a></li>
                    <?php } else {?>
                    <li class="user"><a href="register.php">Register</a></li>
                    <li class='user'><a href="login.php">Login</a></li>
                    <?php } ?>
            </ul>
        </nav>
    </header>
</body>
</html>


