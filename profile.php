<?php
session_start();
require "db.php";

$error="";
if(!isset($_SESSION["username"])){
    header("location: login.php?loginToContinue");
    exit;
}
if(isset($_GET['uid'])){
    $username = $_GET['uid'];

$stmt=$conn->prepare("SELECT id FROM users WHERE user = :username");
$stmt->bindParam(":username", $username, PDO::PARAM_STR);
$stmt->execute();
$userID=$stmt->fetchColumn();

$stmt=$conn->prepare("SELECT posts.id, posts.title, posts.content, users.user FROM posts JOIN users ON posts.user_id = users.id WHERE posts.user_id = :userid");
$stmt->bindValue(":userid", $userID, PDO::PARAM_INT);
    if($stmt->execute()){
        $usersPosts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} if(empty($usersPosts)) $error="User has no Posts!";

$count=0;

} else{
    $error = "invalid Username";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>
<body>
    <?php include "header.php"; ?>
    <h1> <?php echo $username ?>'s Profile</h1>
    <div class="profile">
        <?php if($username === $_SESSION['username']){ ?>
    <h2>Settings</h2>
    <h3><a href="deleteUser.php?userid=<?php echo $userID ?>" class="linkRed" onclick="return confirm('By pressing ok youre deleting the acc and its associated posts! Continue?')">Delete Account</a></h3> 
    <h2>My Posts</h2>
    <p class="error"><?php if($error){ echo $error;  ?>
        <a href="createPost.php?createYourFirstPost">Create Post</a>
        <?php } ?> </p> <?php
     foreach($usersPosts as $usrPost) { $count++; ?>
        <h3><?php echo $count ?>. <a href="viewPost.php?id=<?php echo $usrPost['id'] ?>" class="linkBlue"><?php echo $usrPost['title'] ?></a></h3>
        <?php } } else { ?>
            <h2>Posts:</h2>
            <p class="error"><?php if($error){ echo $error; } ?>
            <?php foreach($usersPosts as $usrPost) { $count++; ?>
                <h3><?php echo $count ?>. <a href="viewPost.php?id=<?php echo $usrPost['id'] ?>" class="linkBlue"><?php echo $usrPost['title'] ?></a></h3>
       <?php } } ?>
        </div>
<?php include "footer.php" ?>
</body>
</html>