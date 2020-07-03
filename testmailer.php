<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require_once "vendor/autoload.php";

    include_once( "Lib/config.php" );
    include_once( "Lib/db.php" );
    include_once( "Lib/lib.php" );
    
    if (isset($_GET['nextUrl']) && isset($_GET['title']) && isset($_GET['context']) && isset($_GET['img'])) {
        $nextUrl = $_GET['nextUrl'];
        $title = $_GET['title'];
        $context = $_GET['context'];
        $img = $_GET['img'];
    }

    $ini_email = parse_ini_file($emailServicesDirectory);

    $allEmails = getAllSubscriptions ();

    for ($i = 0; $i < sizeof($allEmails); $i ++) {
        //PHPMailer Object
        $mail = new PHPMailer(true); //Argument true in constructor enables exceptions

        //From email address and name
        $mail->From = $ini_email['auth_username'];
        $mail->FromName = "SMI G37";

        $mail->Subject = "SMI G37 - Newsletter";

        //To address
        $mail->addAddress($allEmails[$i]['email']);
        if (isset($img)) {
            $mail->AddEmbeddedImage($img,'testImage',$img);
        }

        //Send HTML or Plain Text email
        $mail->isHTML(true);

        if (isset($img)) {
            $mail->Body = '
            <html><body>
            We thought you might want to check this new article:
            <h1>' . $title .'</h1>
            <img src="cid:testImage">
            <p>'. $context .'</p>
            <a href="smi/g37/'.$nextUrl.'">Click here to be redirected</a>
            <p>Best regards</p>
            </html></body>
            ';
        } else {
            $mail->Body = '<img>';
        }

        try {
            $mail->send();
            echo "Message has been sent successfully";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }

    

?>