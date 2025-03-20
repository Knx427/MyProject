<?php 
session_start();
require "./includes/db.php";

$error="";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if(empty($username) || empty($password)){
        $error = "Fill out all collumns!";
    }else{ if(!preg_match("/^[a-zA-Z0-9_]*$/", $username)){
            $error = "Only letters and numbers allowed!";
        }else{ if(!preg_match("/^[a-zA-z0-9_!@#$%^&*]*$/", $password)){
            $error = "password contains restricted special characters";
        } else{
    $stmt=$conn->prepare("SELECT user,pwd FROM users WHERE user = :user");
    $stmt->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($username && password_verify($password, $user['pwd'])){
        $_SESSION['username'] = $user['user'];
        header("location: index.php?loggedIn");
        exit;
    } else{
        $error="Wrong username or password!";
    }
}
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Login</title>
</head>
<body>
    <?php include "./templates/header.php"; ?>
    <div class="formContainer">
    <h1>Login</h1>
    <p class="error"><?php echo $error; ?></p>
    <form action="login.php" method="post" class="form">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" ><br>
        <p style="font-size:12px;">Don't have acc?<a href="register.php" style="text-decoration: none; color:aqua"> Register</a></p>
        <div class="centered"><input type="submit" value="Login" class="btn submit"></div>
    </form>
    </div>
<?php include "./templates/footer.php" ?>
</body>
</html>