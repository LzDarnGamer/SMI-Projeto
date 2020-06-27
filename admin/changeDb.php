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
include_once( "../Lib/config.php" );

$dbHost = $_GET["host"];
$dbPort = $_GET["port"];
$db = $_GET["db"];
$dbUser = $_GET["username"];
$dbPass = $_GET["password"];

echo $dbHost . "\n";
echo $dbPort . "\n";
echo $db . "\n";
echo $dbUser . "\n";
echo $dbPass . "\n";

$dom = new DOMDocument();
$dom->load($htdocsDirectory);

$node = $dom->getElementsByTagName("DataBase");
foreach ($node as $searchNode) {
    $dbHost = $searchNode->getElementsByTagName('host'); $dbHost = $dbHost[0]->nodeValue;
    $dbPort = $searchNode->getElementsByTagName('port'); $dbPort = $dbPort[0]->nodeValue;
    $db = $searchNode->getElementsByTagName('db'); $db = $db[0]->nodeValue;
    $dbUser = $searchNode->getElementsByTagName('username'); $dbUser = $dbUser[0]->nodeValue;
    $dbPass = $searchNode->getElementsByTagName('password'); $dbPass = $dbPass[0]->nodeValue;
}


if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}


?>