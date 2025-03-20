<?php 
session_start();
require "./includes/db.php";

if(!isset($_SESSION["username"])){
    header("location: login.php?loginToSeePosts");
    exit;
}

$error = "";
$username = $_SESSION["username"];

$stmt=$conn->prepare("SELECT id from users where user = :username");
$stmt->bindParam(":username", $username,PDO::PARAM_STR);
$stmt->execute();
$userID = $stmt->fetchColumn();

if($_SERVER["REQUEST_METHOD"]=="POST"){

$title = trim($_POST['title']);
$content = trim($_POST['content']);

if(!preg_match("/^[a-zA-Z0-9$#!@€()]*$/", $title) || !preg_match("/^[a-zA-Z0-9$#!@€(*)]*$/", $content)){
    $error = "Unallowed chars included";
} else{

$stmt=$conn->prepare("INSERT INTO posts(title,content,user_id) VALUES (:title, :content, :user_id)");
$stmt->bindParam(":title", $title, PDO::PARAM_STR);
$stmt->bindParam(":content", $content, PDO::PARAM_STR);
$stmt->bindParam(":user_id", $userID, PDO::PARAM_INT);
if($stmt->execute()){
    header("location: dashboard.php?success");
    exit;
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
    <title>Document</title>
</head>
<body>
    <?php include "./templates/header.php" ?>
    <h1>Create Post</h1>
    <p class="error"><?php if($error) echo $error ?></p>
<div class="formContainer">
    <form action="createPost.php" method="post" class="form">
        <label for="title">Title:</label><br>
        <input type="text" name="title" placeholder="title" required><br>
        <label for="content">Content:</label><br>
        <textarea name="content" rows="10" cols="40" placeholder="Enter some text..." required></textarea><br>
        <div class="centered"><input type="submit" class="btn submit" value="Submit Post"></div>
    </form>
</div>
<?php include "./templates/footer.php" ?>
</body>
</html>