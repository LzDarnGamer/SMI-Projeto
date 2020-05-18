<?php

    session_start();
    
    header('Content-Type: image/jpeg');

    $md5_hash = md5(rand(0,999));
    $captcha = substr($md5_hash, 15, 5);


    $_SESSION['captcha'] = $captcha;

    $width = 160;
    $height = 50;

    $image = ImageCreate($width, $height);

    $white = imagecolorallocate($image, 255, 255, 255);
    $black = imagecolorallocate($image, 0, 0, 0);
    $green = imagecolorallocate($image, 0, 255, 0);
    $red = imagecolorallocate($image, 255, 0, 0);
    $orange = imagecolorallocate($image, 204, 204, 204);


    $colors = array (
        $black, $green, $red, $orange
    );
    $rand_keys = rand(0, count($colors)-1);

    imagefill($image, 0, 0, $white);



    $font = 'C:\xampp\htdocs\smi\07-Auth\Unipix.ttf';
    imagettftext($image, rand(15,20), rand(-20,20), rand(0,90), 30, $colors[$rand_keys], $font, $captcha);


    imagejpeg($image);
    imagedestroy($image);

?>