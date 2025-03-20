<?php 
session_start();
require "./includes/db.php";
$error="";

if(!isset($_SESSION["username"])){
    header("location: login.php?loginToSeePosts");
    exit;
}

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

            $stmt=$conn->prepare("DELETE FROM posts WHERE id = :id");
            $stmt->bindValue(":id",$postID,PDO::PARAM_INT);
            if($stmt->execute()){
                header("location: dashboard.php?updatedPost");
                exit;
            } else  {
                header("location: dashboard.php?FailedToDeletePost");
                exit;
            }
    }
}