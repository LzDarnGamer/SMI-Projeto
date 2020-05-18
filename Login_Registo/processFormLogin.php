<?php
    require_once( "../Lib/lib.php" );
    require_once( "../Lib/db.php" );

    $method = $_SERVER[ 'REQUEST_METHOD' ];

    if ( $method=='POST') {
        $_INPUT_METHOD = INPUT_POST;
    } elseif ( $method=='GET' ) {
        $_INPUT_METHOD = INPUT_GET;
    }
    else {
        echo "Invalid HTTP method (" . $method . ")";
        exit();
    }

    $flags[] = FILTER_NULL_ON_FAILURE;

    $username = filter_input( $_INPUT_METHOD, 'username', FILTER_SANITIZE_STRING, $flags);
    $password = filter_input( $_INPUT_METHOD, 'password', FILTER_SANITIZE_STRING, $flags);


    $IsUserVerified = checkIfVerified($username, $password);

    $userId = isValid($username, $password, "basic");



    if ($userId > 0) {
        if ( $IsUserVerified=="0") {
          echo "Please confirm your email first";
          echo "<br><hr><a href=\"../index.php\">Back</a>";
          exit();
        }

        session_start();
        $_SESSION['id'] = $userId;
        $_SESSION['username'] = $username;

        if (isset($_SESSION['locationAfterAuth'])) {
            $baseNextUrl = $baseUrl;
            $nextUrl = $_SESSION['locationAfterAuth'];
            header( "Location: " . $baseNextUrl . $nextUrl );
            exit();
        } else {
            $nextUrl = "pag_1.php";
            header( "Location: " . $baseNextUrl . $nextUrl );
            exit();
        }

    }else {
        echo "Please confirm if your credentials are correct";
        echo "<br><hr><a href=\"../index.php\">Back</a>";
        exit();
    }

    
   
?>