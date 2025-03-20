<?php
session_start();
session_destroy();
if(isset($_GET['accDeleted'])){
    header("location: index.php?accDeleted");
    exit;
} else {
    header("location: index.php?loggedOut");
    exit;
}