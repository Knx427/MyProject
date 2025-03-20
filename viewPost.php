<?php 
session_start();
require "db.php";
$error="";

if(!isset($_SESSION['username'])){
    header("location: login.php?loginToSeePost");
    exit;
}
if(isset($_GET['id'])){
    $user = $_SESSION["username"];
    $postID = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT posts.id, posts.title, posts.content, posts.created_at, users.user FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = :postid");
    $stmt->bindValue("postid",$postID,PDO::PARAM_INT);
    $stmt->execute();
    $post=$stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title><?php echo $post['title']; ?></title>
</head>
<body>
    <?php include "header.php" ?>
<div class="post">
                <h1><a href="viewPost.php?id=<?php echo $post['id'] ?>" style="text-decoration: none; color: black;"><?php echo htmlspecialchars($post['title']) ?></a></h1>
                <p><?php echo htmlspecialchars($post['content']) ?></p>
                <p class="meta">By <?php echo htmlspecialchars($post['user']) ?></p>
                
                <?php if($post['user'] == $_SESSION['username']){ ?>
                    <a href="editPost.php?id=<?php echo $post['id'] ?>" class="edit-link">
                        Edit
                    </a> | 
                    <a href="deletePost.php?id=<?php echo $post['id'] ?>" class="delete-link" onclick="confirm('Are you sure you want to delete this post?')">
                        Delete
                    </a>
                <?php } ?>
            </div>
<?php include "footer.php" ?>
</body>
</html>