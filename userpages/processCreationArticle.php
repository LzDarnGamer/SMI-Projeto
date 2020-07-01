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

    $ffmpegBinary = "C:/xampp/ffmpeg/bin/ffmpeg.exe";

	// Maximum time allowed for the upload
	set_time_limit( 300 );


    $userId = $_SESSION['id'];
    $username = $_SESSION['username'];

    if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
      $_INPUT_METHOD = INPUT_POST;
    } else {
      $_INPUT_METHOD = INPUT_GET;
    }
    
    $flags[] = FILTER_NULL_ON_FAILURE;
    
    $article_title = filter_input( 
            $_INPUT_METHOD, 
            'article_title', 
            FILTER_SANITIZE_STRING, 
            $flags);

    $article_categorie = filter_input( 
        $_INPUT_METHOD, 
        'article_categorie', 
        FILTER_SANITIZE_STRING, 
        $flags);

    $article_subcategorie = filter_input( 
        $_INPUT_METHOD, 
        'article_subcategorie', 
        FILTER_SANITIZE_STRING, 
        $flags);


    $article_context = filter_input( 
            $_INPUT_METHOD, 
            'article_context', 
            FILTER_SANITIZE_STRING, 
            $flags);


    $timestamp = date("d/m/Y");


    $Userlat = filter_input( 
            $_INPUT_METHOD, 
            'lat', 
            FILTER_SANITIZE_STRING, 
            $flags);
    $Userlng = filter_input( 
            $_INPUT_METHOD, 
            'lng', 
            FILTER_SANITIZE_STRING, 
            $flags);


    $tags = filter_input( 
            $_INPUT_METHOD, 
            'articleTags', 
            FILTER_SANITIZE_STRING, 
            $flags);


    if ( $article_title===null || $article_categorie==null || $article_context===null || $article_subcategorie === null || $tags === null
        ||$article_title==="" || $article_categorie=="" || $article_context==="" || $article_subcategorie === "" || $tags === "") {
      $title = "Invalid arguments";
      $info = "Invalid subcategory or category title";
      header("Location: ../responsePage.php?title=$title&info=$info");
      exit();
    }




    ###########################Media management##########################
	if ($_FILES['article_img']['error'] != 0) {
	    // Handle the error
	    $errorCode = $_FILES['article_img']['error'];

	    echo showUploadFileError($errorCode);
        echo "<br><hr><a href=\"javascript: history.go(-1)\">Back</a>";
	    exit($errorCode);
	}

	$srcName = uniqid()."_".$_FILES['article_img']['name'];
	// Read configurations from data base
	$configurations = getConfiguration();
	$dstDir = $configurations['destination'];

	//Create Folder if not exists
	$dstDir = $dstDir . DIRECTORY_SEPARATOR . $userId;
	if (!file_exists($dstDir)) {
    	mkdir($dstDir, 0777, true);
    	mkdir($dstDir. DIRECTORY_SEPARATOR . "thumbs", 0777, true);
	}

	// Destination for the uploaded file
	$src = $_FILES['article_img']['tmp_name'];
	$dst = $dstDir . DIRECTORY_SEPARATOR . $srcName;
	$copyResult = copy($src, $dst);

	if ( $copyResult === false ) {
		$title = "Error writing file";
      	$info = "Could not write \"$src\" to \"$dst\".\n<br>";
      	header("Location: ../responsePage.php?title=$title&info=$info");
      	exit();
	}

	unlink($src);


	$fileInfo = finfo_open(FILEINFO_MIME);

	$fileInfoData = finfo_file($fileInfo, $dst);

	$fileTypeComponents = explode(";", $fileInfoData);

	$mimeTypeFileUploaded = explode("/", $fileTypeComponents[0]);
	$mimeFileName = $mimeTypeFileUploaded[0];
	$typeFileName = $mimeTypeFileUploaded[1];



	$thumbsDir = $dstDir . DIRECTORY_SEPARATOR . "thumbs";
	$pathParts = pathinfo($dst);

	$lat = "";
	$lon = "";

	$width = $configurations['thumbWidth'];
	$height = $configurations['thumbHeight'];

	echo "File is of type $mimeFileName<br>\n";

	$imageFileNameAux = null;
	$imageMimeFileName = null;
	$imageTypeFileName = null;

	$thumbFileNameAux = null;
	$thumbMimeFileName = null;
	$thumbTypeFileName = null;


	$latitude = $Userlat;
	$longitude = $Userlng;
	switch ($mimeFileName) {
	    case "image":
	        $exif = @exif_read_data($dst, 'IFD0', true);
	        
	        if ($exif === false) {
	            echo "No exif header data found.<br>\n";
	        }
	        else {
	            $gps = $exif['GPS'];
	            if ( $gps!=NULL ) {
	                $latitudeAux = $gps['GPSLatitude'];
	                $latitudeRef = $gps['GPSLatitudeRef'];
	                $longitudeAux = $gps['GPSLongitude'];
	                $longitudeRef = $gps['GPSLongitudeRef'];

	                if ( ($latitudeAux!=NULL ) && ( $longitudeAux!=NULL ) ) {
	                	//If finds coordinates on FILE overrites
	                    $lat = getCoordAsString($latitudeAux, $latitudeRef);
	                    $lon = getCoordAsString($longitudeAux, $longitudeRef);
						$latitude = addslashes($lat);
						$longitude = addslashes($lon);
	                    echo "File latitude: $lat<br>\n";
	                    echo "File longitued: $lon<br>\n";
	                }
	                else {
	                    echo "File does have GPS coordenates<br>\n";
	                }
	            }
	            else {
	                echo "File does have GPS coordenates<br>\n";
	            }

	        }

	        $imageFileNameAux = $dst;
	        $imageMimeFileName = "image";
	        $imageTypeFileName = $typeFileName;

	        $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "." . $typeFileName;
	        $thumbMimeFileName = "image";
	        $thumbTypeFileName = $typeFileName;

	        $resizeObj = new ImageResize($dst);
	        $resizeObj->resizeImage($width, $height, 'crop');
	        $resizeObj->saveImage($thumbFileNameAux, $typeFileName, 100);
	        $resizeObj->close();


	    break;

	    case "video":
	        $size = "$width" . "x" . "$height";

	        $imageFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "-Large.jpg";
	        $imageMimeFileName = "image";
	        $imageTypeFileName = "jpeg";
	        echo "Generating video 1st image...<br>\n";

	        // -itsoffset -1 -> "avança" o filme 1 segundo
	        // -i $dst -> input file
	        // -vcodec mjpeg -> codec do tipo mjpeg
	        // -vframes 1 -> obter uma frame
	        // -s 640x480 -> dimensão do output
	        $cmdFirstImage = "$ffmpegBinary -itsoffset -1 -i $dst -vcodec mjpeg -vframes 1 -an -f rawvideo -s 640x480 $imageFileNameAux";
	        
	        echo "$cmdFirstImage<br>\n";
	        system($cmdFirstImage, $status);
	        echo "Status from the generation of video 1st image: $status.<br>\n";

	        $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . ".jpg";
	        $thumbMimeFileName = "image";
	        $thumbTypeFileName = "jpeg";
	        echo "Generating video thumb...<br>\n";

	        $cmdVideoThumb = "$ffmpegBinary -itsoffset -5  -i $dst -vcodec mjpeg -vframes 1 -an -f rawvideo -s $size $thumbFileNameAux";
	        echo "$cmdVideoThumb<br>\n";
	        system($cmdVideoThumb, $status);
	        echo "Status from the generation of video thumb: $status.<br>\n";
	    break;

	    case "audio":
	        require_once( "Zend/Media/Id3v2.php" );

	        $id3 = new Zend_Media_Id3v2($dst);

	        $mimeTypeAudioAPIC = explode("/", $id3->apic->mimeType);
	        //$mimeAudioAPIC = $mimeTypeAudioAPIC[0];
	        $typeAudioAPIC = $mimeTypeAudioAPIC[1];

	        $imageFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "-Large." . $typeAudioAPIC;
	        $imageMimeFileName = "image";
	        $imageTypeFileName = $typeAudioAPIC;
	        $fdMusicImage = fopen($imageFileNameAux, "wb");
	        fwrite($fdMusicImage, $id3->apic->getImageData());
	        fclose($fdMusicImage);

	        $thumbFileNameAux = $thumbsDir . DIRECTORY_SEPARATOR . $pathParts['filename'] . "." . $typeAudioAPIC;
	        $thumbMimeFileName = "image";
	        $thumbTypeFileName = $typeAudioAPIC;
	        $resizeObj = new ImageResize($imageFileNameAux);
	        $resizeObj->resizeImage($width, $height, 'crop');
	        $resizeObj->saveImage($thumbFileNameAux, $typeAudioAPIC, 100);
	        $resizeObj->close();
	    break;

	    default:
	        $imageFileNameAux = $dstDir . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "Unknown-Large.jpg";
	        $imageMimeFileName = "image";
	        $imageTypeFileName = "jpeg";

	        $thumbFileNameAux = $dstDir . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "Unknown.jpg";
	        $thumbMimeFileName = "image";
	        $thumbTypeFileName = "jpeg";
	    break;
	}
	// Write information about file into the data base
	dbConnect(ConfigFile);

    $linkIdentifier = $GLOBALS['ligacao'];
    $dataBaseName = $GLOBALS['configDataBase']->db;

	mysqli_select_db($linkIdentifier, $dataBaseName);



	$fileName = addslashes($srcName);
	$imageFileName = addslashes($imageFileNameAux);
	$thumbFileName = addslashes($thumbFileNameAux);


	$imgQuery = "INSERT INTO `images-details`" .
	"(`fileName`, `mimeFileName`, `typeFileName`, `imageFileName`, `imageMimeFileName`, `imageTypeFileName`, `thumbFileName`, `thumbMimeFileName`, `thumbTypeFileName`, `latitude`, `longitude`) values " .
	"('$fileName', '$mimeFileName', '$typeFileName', '$imageFileName', '$imageMimeFileName', '$imageTypeFileName', '$thumbFileName', '$thumbMimeFileName', '$thumbTypeFileName', '$latitude', '$longitude')";

    ###########################Media management##########################
	
	##############################Transaction#############################
    mysqli_query( $linkIdentifier, $imgQuery ); 
	$recordsInserted = mysqli_affected_rows( $linkIdentifier );


	if($recordsInserted == -1){
	    $title = "Processing Error";
	    $info = "There where some errors processing your request please try again";
      	header("Location: ../responsePage.php?title=$title&info=$info");
      	exit();
    }

	##############################Transaction#############################

    ###########################Article management##########################
	$article_imgID=mysqli_insert_id($linkIdentifier);


    $categorieID = getCategoryID($article_categorie, false);
	$subcategorieID = getSubCategoryID($article_subcategorie, false);
    $articleQuery = 
            "INSERT INTO `$dataBaseName`.`articles` " .
            "(`article_categorie_id`, `article_subcategorie_id` ,`poster_id`, `article_title`, `article_context`, `article_image`, `article_timestamp`, `tags` ) values " .
            "('$categorieID', '$subcategorieID','$userId', '$article_title', '$article_context', '$article_imgID', STR_TO_DATE('$timestamp','%d/%m/%y'), '$tags')";
    
    
	###########################Article management##########################

	###########################Transaction##########################

    mysqli_query( $linkIdentifier, $articleQuery ); 
	$recordsInserted = mysqli_affected_rows( $linkIdentifier );


	if($recordsInserted!=-1){
		dbDisconnect();
      	header("Location: profilepage.php");

      	#########################Newsletter############################

		$allEmails = getAllSubscriptions();
		$nextUrl = "https://" . $serverName . ":" . $serverPortSSL . "userpages/article.php?type=view&id=" . getNewestArticle()[0]['article_id'];
		
		for ($i = 0; $i < sizeof($allEmails); $i ++) {
			sendNewsletterEmail ($allEmails[$i]['email'], $nextUrl);
		}
		##########################Newsletter############################


    }else{
    	deleteImage($article_imgID);
		dbDisconnect();
	    $title = "Processing Error";
	    $info = "There where some errors processing your request please try again";
      	header("Location: ../responsePage.php?title=$title&info=$info");
      	exit();
    }

	###########################Transaction##########################



  

