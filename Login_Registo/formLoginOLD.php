<!DOCTYPE html>
<?php
    require_once( "../Lib/lib.php" );

    $serverName = $_SERVER['SERVER_NAME'];
    #$serverName = "localhost";

    $serverPortSSL = 443;
    $serverPort = 80;

    $name = webAppName();

    $nextUrl = "https://" . $serverName . ":" . $serverPortSSL . $name . "processFormLogin.php";
    #$nextUrl = "http://" . $serverName . ":" . $serverPort . $name . "processFormLogin.php";
?>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>Authentication Using PHP</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <link rel="stylesheet" typr="text/css" href="../../Styles/GlobalStyle.css">
    </head>
    
    <body>
        <form 
            action="processFormLogin.php"
            onsubmit="return FormLoginValidator(this)"
            method="POST">
            <table>
                <tr>
                    <td>User Name</td>
                    <td><input type="text" name="username" placeholder="Type your name"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password" placeholder="Type your password"></td>
                </tr>
            </table>

            <input type="submit" value="Login"> <input type="reset" value="Clear">
        </form>
    </body>
</html>
