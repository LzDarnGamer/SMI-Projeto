<?php

if ( !isset($_SESSION) ) {
    session_start();
  }
require_once("../Lib/db.php");
require_once("../Lib/lib.php");
require_once( "../Lib/lib-coords.php" );
require_once( "../Lib/ImageResize-class.php" );

include_once( "../Lib/config.php" );
include( "../ensureAuth.php" );
header('Content-Type: text/html; charset=utf-8');

$readonly = (isset($_GET['readonly'])) ? $_GET['readonly'] : 0;


    $users = getAllIds();
    for ($i = 0; $i < sizeof($users); $i ++) {
        $articlesArray = getArticles($users[$i]);
    }

    $name = $_SERVER["REQUEST_URI"];

    $web_url = "http://" . $_SERVER["SERVER_NAME"] . substr($name, 0, 8) . "/userpages";

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

    // Read configurations from data base
    $configurations = getConfiguration();
    $dstDir = $configurations['destination'];
    $dstDir = $dstDir . DIRECTORY_SEPARATOR . "RSS";

    //Create Folder if not exists    
    if (!file_exists($dstDir)) {
        mkdir($dstDir, 0777, true);
        mkdir($dstDir. DIRECTORY_SEPARATOR . "RSS", 0777, true);
    }

    file_put_contents($dstDir . "\\rss.xml", $str);
    #echo "update";
    #echo "dir: " . $dstDir . " Done. Redirect back to page.";

    $browser = getBrowser();
    //$userAgent = $_SERVER['HTTP_USER_AGENT'];
    //echo "User Agent: " . $userAgent . "\n";
    //echo "Browser: " . $browser . "\n";
    if ($readonly == 1) {

        if ($browser == "Internet Explorer") {
            header('Content-type: application/rss+xml; charset=utf-8');
        } else {
            header('Content-type: text/xml; charset=utf-8');
        }
    
        header('Content-Length: ' . strlen($str));
        echo $str;
    } else {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

?>