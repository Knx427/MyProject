<?php

session_start();
require "./includes/db.php";

$random = [];
$posts = [];

$stmt=$conn->prepare("SELECT id FROM posts ORDER BY RAND() LIMIT 3");
$stmt->execute();
$randoms = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

foreach($randoms as $random){
$stmt=$conn->prepare("SELECT id,title,content from posts WHERE id = :id");
$stmt->bindValue(":id",$random,PDO::PARAM_INT);
$stmt->execute();
$post=$stmt->fetch(PDO::FETCH_ASSOC);
if($post){
    $posts[] = $post;
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Home</title>
</head>
<body>
    <?php include "./templates/header.php" ?>
    <h1>Home Page</h1>

    <?php if (isset($_SESSION['username'])) { ?>
        <div class="centered">
            <a href="dashboard.php"><button class="btn">Dashboard</button></a>
        </div>   
    <?php } ?>
        <div class="posts-container">
            <?php foreach ($posts as $post) { ?>
                <div class="post-preview">
                    <h2><?php echo $post['title']; ?></h2>
                    <p><?php echo substr($post['content'], 0, 150); ?>...</p>
                    <a href="viewPost.php?id=<?php echo $post['id']; ?>">Read more</a>
                </div>
            <?php } ?>
        </div>
        <?php if(!isset($_SESSION['username'])){?>
    <a href="login.php" class="gg"><p class="centered p"><strong>Login</strong> to see more!</p></a>
    <?php } ?> <br>
<?php include "./templates/footer.php" ?>
</body>
</html>
