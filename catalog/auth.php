<?php
function isLoggedIn() {
    return isset($_SESSION['id']);
}

function checkLogin() {
    if (!isset($_SESSION['id'])) {
        header("Location: login.php");
        exit();
    }
}
?>