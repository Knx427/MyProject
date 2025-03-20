<?php 
session_start();
require "db.php";

if(!isset($_SESSION["username"])){
    header("location: login.php?loginToSeePosts");
    exit;
}

$search = $_GET["search"] ?? '';

$query = "SELECT posts.id, posts.title, posts.content, posts.created_at, users.user from posts JOIN users ON posts.user_id = users.id";

if($search){
    $query .= " WHERE posts.title LIKE :search OR posts.content LIKE :search OR users.user LIKE :search";
}

$query .= " ORDER BY posts.created_at DESC";

$stmt=$conn->prepare($query);

if($search){
    $stmt->bindValue(":search", "%".$search."%", PDO::PARAM_STR);
}

$stmt->execute();
$entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Dashboard</title>

</head>
<body>
<?php include "header.php"; ?>
<!-- Loading Spinner -->
<div class="container">
    <h1>Dashboard</h1>
    <div class="centered"><a href="createPost.php"><button class="btn">Create Post</button></a></div><br>
    <form action="dashboard.php" method="get" class="search-box">
        <input type="search" name="search" placeholder="Search posts...">
        <button type="submit" class="btn">Search</button>
    </form>
    
    <?php foreach($entries as $entry){ ?>
        <div class="post">
                <div id="loading" class="loader hidden"></div>
                <h1><a href="viewPost.php?id=<?php echo $entry['id'] ?>" style="text-decoration: none; color: black;"><?php echo htmlspecialchars($entry['title']) ?></a></h1>
                <p><?php echo htmlspecialchars($entry['content']) ?></p>
                <p class="meta">By <a href="profile.php?uid=<?php echo $entry['user'] ?>"><?php echo htmlspecialchars($entry['user']) ?></a></p>
                
                <?php if($entry['user'] == $_SESSION['username']){ ?>
                    <a href="editPost.php?id=<?php echo $entry['id'] ?>" class="edit-link">
                        Edit
                    </a> | 
                    <a href="deletePost.php?id=<?php echo $entry['id'] ?>" class="delete-link" onclick="confirm('Are you sure you want to delete this post?')">
                        Delete
                    </a>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php include "footer.php" ?>
</body>
</html>
<script>
    // Show loading spinner when the search form is submitted
    document.querySelector("form").addEventListener("submit", function() {
        document.getElementById("loading").style.display = "block"; // Show the spinner
    });
</script>