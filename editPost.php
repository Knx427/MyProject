<?php 
session_start();
require "db.php";
$_SESSION['username']="asd";
$error="";

if(isset($_GET['id'])){
    $user = $_SESSION["username"];
    $postID = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT posts.title, posts.content, users.user FROM posts JOIN users ON posts.user_id = users.id WHERE posts.id = :postid");
    $stmt->bindValue("postid",$postID,PDO::PARAM_INT);
    $stmt->execute();
    $post=$stmt->fetch(PDO::FETCH_ASSOC);
    $authorUID = $post['user'];

    if($authorUID !== $user){
        header("location: dashboard.php?forbidden");
        exit;
    } else{
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $title = $_POST['title'];
            $content = $_POST['content'];

            $stmt=$conn->prepare("UPDATE posts SET title = :title, content = :content WHERE id = :id");
            $stmt->bindParam(":title",$title,PDO::PARAM_STR);
            $stmt->bindParam(":content",$content,PDO::PARAM_STR);
            $stmt->bindValue(":id",$postID,PDO::PARAM_INT);
            if($stmt->execute()){
                header("location: dashboard.php?updatedPost");
                exit;
            } else $error="failed to sunmit";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <?php include "header.php"; if($error) echo $error; ?>
    <div class="formContainer">
    <form action="editPost.php?id=<?php echo $postID ?>" method="post" class="form">
        <label for="title">Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title'], ENT_QUOTES, 'UTF-8') ?>"><br>
        <label for="content">Content:</label><br>
        <textarea name="content" rows="10" cols="40"><?php echo htmlspecialchars($post['content'], ENT_QUOTES, 'UTF-8') ?></textarea><br>
        <div class="centered"><input type="submit" class="btn" value="Update Post"></div>
    </form>
    </div>
</body>
</html>