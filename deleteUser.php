<?php
session_start();
require "./includes/db.php";

if(!isset($_SESSION['username'])){
    header("location: login.php?loginToContinue");
    exit;
}

if(isset($_GET['userid'])){
    $userID = $_GET['userid'];

    $userUID = $_SESSION['username'];

    $stmt=$conn->prepare("DELETE FROM users WHERE id = :userid AND user = :user");
    $stmt->bindValue(":userid",$userID, PDO::PARAM_INT);
    $stmt->bindParam(":user", $userUID, PDO::PARAM_STR);
    if($stmt->execute()){
        header("location: logout.php?accDeleted");
        exit;
    } else echo "Error: could not delete user";

} else {
    header("location: profile.php?invalidUserID");
    exit;
}