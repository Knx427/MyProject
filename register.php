<?php 
session_start();
require "./includes/db.php";

$error="";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $pwdRepeat = $_POST['pwdRepeat'];

    if(!preg_match("/^[a-zA-Z0-9_]*$/", $username)){
        $error = "Only letters and numbers allowed for Username!";
    } else if(!preg_match("/^[a-zA-Z0-9_!@#$%^&*]*$/", $password)){
        $error = "Password contains restricted Special Characters";
    } else{
    if($password !== $pwdRepeat){
        $error = "Passwords don't match!";
    } else {
    $stmt = $conn->prepare("SELECT user from users WHERE user = :user");
    $stmt->bindParam(":user", $username, PDO::PARAM_STR);
    $stmt->execute();
    if($user = $stmt->fetchColumn()){
        $error = "Username already exists!";
    } else{
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt=$conn->prepare("INSERT INTO users (user, pwd) VALUES (:user, :pwd)");
        $stmt->bindParam(":user", $username,PDO::PARAM_STR);
        $stmt->bindParam(":pwd", $hashed_password, PDO::PARAM_STR);
        if($stmt->execute()){
            header("location: login.php?registrationComplete");
            exit;
        } else {
            $error = "Registration failed!";
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
    <h1>Register</h1>
    <p class="error"><?php echo $error; ?></p>
    <form action="register.php" method="post" class="form">
        <label for="username">Username:</label><br>
        <input type="text" name="username" required><br>
        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br>
        <label for="pwdRepeat">Repeat Password:</label><br>
        <input type="password" name="pwdRepeat" required><br>
        <p style="font-size:12px;">Already have acc?<a href="login.php" style="text-decoration: none; color:aqua"> Login</a></p>
        <div class="centered"><input type="submit" value="Register" class="btn submit"></div>
    </form>
    </div>
<?php include "./templates/footer.php" ?>
</body>
</html>