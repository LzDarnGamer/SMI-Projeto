<?php

if (!isset($_SESSION)) {
    session_start();
}

if ( !isset($_SESSION['username']) ) {
    $_SESSION['locationAfterAuth'] = $_SERVER['REQUEST_URI'];

    echo "STOP! This content is only for users, please login or create account";
    echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
    exit;
}
?>