<?php

require_once("Lib/lib.php");
require_once("Lib/db.php");

$users = getAllIds();
for ($i = 0; $i < sizeof($users); $i ++) {
    $articlesArray = getArticles($users[$i]);
}


$web_url = "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];

$str = "<?xml version='1.0' ?>";
$str .= "<rss version='2.0'>";
    $str .= "<channel>";
        $str .= "<title>SMI Project 37</title>";
        $str .= "<description>Travel Guide</description>";
        $str .= "<language>en-UK</language>";
        $str .= "<link>$web_url</link>";

        # Items here
        for ($i = 0; $i < sizeof($articlesArray); $i ++) {
            $str .= "<item>";
                $str .= "<title>" . $articlesArray[$i]['article_title'] . "</title>";
                $str .= "<description>" . $articlesArray[$i]['article_context'] . "</description>";
                $str .= "<comments>";
                    $str .= "Ainda sem nada aqui";
                $str .= "</comments>";
                $str .= "<link>" . $web_url . "/article.php?type=view&amp;id=" . $articlesArray[$i]['article_id'] . "</link>";
            $str .= "</item>";
        }

    $str .= "</channel>";
$str .= "</rss>";

file_put_contents("rss.xml", $str);
echo "Done. Redirect back to page.";

?>