<?php

    session_start();
    
    header('Content-Type: image/jpeg');

    $md5_hash = md5(rand(0,999));
    $captcha = substr($md5_hash, 15, 5);


    $_SESSION['captcha'] = $captcha;

    $width = 200;
    $height = 50;

    $image = imagecreatefromjpeg( "images/captchabackimg.jpg" );

    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $green = imagecolorallocate($image, 0, 255, 0);
    $red = imagecolorallocate($image, 255, 0, 0);
    $blue = imagecolorallocate($image, 0, 0, 255);


    $colors = array (
        $black, $red, $blue
    );
    $rand_keys = rand(0, count($colors)-1);



    $font = 'C:\xampp\htdocs\smi\07-Auth\Unipix.ttf';
    imagettftext($image, rand(20,25), rand(-15,15), rand(30,100), 30, $colors[$rand_keys], $font, $captcha);


    imagejpeg($image);
    imagedestroy($image);

?>