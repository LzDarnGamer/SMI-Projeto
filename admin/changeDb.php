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

$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
$str .= "<!DOCTYPE DataBase SYSTEM \"./database.dtd\">";
$str .= "<Config xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:noNamespaceSchemaLocation=\"./htconfig.xsd\">";
    $str .= "<DataBase>";
        $str .= "<host>" . $dbHost . "</host>";
        $str .= "<port>" . $dbPort . "</port>";
        $str .= "<db>" . $db . "</db>";
        $str .= "<username>" . $dbUser . "</username>";
        $str .= "<password>" . $dbPass . "</password>";
    $str .= "</DataBase>";
$str .= "</Config>";

file_put_contents($htdocsDirectory, $str);

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

?>