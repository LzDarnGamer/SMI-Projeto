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

$ini_email = parse_ini_file($emailServicesDirectory);

$smtpServer = $_POST['smtpServer'];
$smtpPort = $_POST['smtpPort'];
$smtpUsername = $_POST['smtpUsername'];
$smtpPassword = $_POST['smtpPassword'];

$pop3Server = $_POST['pop3Server'];
$pop3Username = $_POST['pop3Username'];
$pop3Password = $_POST['pop3Password'];

if (isset($ini_email)) {
    $ini_email['smtp_server']   = $smtpServer;
    $ini_email['smtp_port']     = $smtpPort;

    $ini_email['auth_username'] = $smtpUsername;
    $ini_email['auth_password'] = $smtpPassword;

    $ini_email['pop3_server']   = $pop3Server;
    $ini_email['pop3_username'] = $pop3Username;
    $ini_email['pop3_password'] = $pop3Password;

    write_php_ini($ini_email, $emailServicesDirectory);
}

function write_php_ini($array, $file)
{
    $res = array();
    foreach($array as $key => $val)
    {
        if(is_array($val))
        {
            $res[] = "[$key]";
            foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
        }
        else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
    }
    safefilerewrite($file, implode("\r\n", $res));
}

function safefilerewrite($fileName, $dataToSave)
{    if ($fp = fopen($fileName, 'w'))
    {
        $startTime = microtime(TRUE);
        do
        {            $canWrite = flock($fp, LOCK_EX);
           // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
           if(!$canWrite) usleep(round(rand(0, 100)*1000));
        } while ((!$canWrite)and((microtime(TRUE)-$startTime) < 5));

        //file was locked so now we can store information
        if ($canWrite)
        {            fwrite($fp, $dataToSave);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }

}

if (isset($_SERVER["HTTP_REFERER"])) {
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

?>