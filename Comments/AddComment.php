<?php

require_once("../Lib/db.php");
require_once("../Lib/lib.php");

$comment = $_POST["comment"];
$posterId = $_POST["posterId"];
$articleId = $_POST["articleId"];

insertComment($articleId, $posterId, $comment);

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

?>