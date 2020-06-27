<?php
	require_once("../Lib/db.php");
	require_once("../Lib/lib.php");
	include( "../ensureAuth.php" );
	require_once( "../Lib/ImageResize-class.php" );
	$ffmpegBinary = "C:/xampp/ffmpeg/bin/ffmpeg.exe";


	$zip = new ZipArchive;
    $res = $zip->open($_FILES['file']['tmp_name']);

	if($res === true){
		dbConnect(ConfigFile);
	    $linkIdentifier = $GLOBALS['ligacao'];
	    $dataBaseName = $GLOBALS['configDataBase']->db;
		mysqli_select_db($linkIdentifier, $dataBaseName);


		$configurations = getConfiguration();
		$dstDir = $configurations['destination'];
		$zipDirectory = $dstDir . DIRECTORY_SEPARATOR . "zips";
		$zip->extractTo($zipDirectory);

		$doc = new DOMDocument();
		$doc->load($zipDirectory.'/articles.xml');
		$articles = $doc->getElementsByTagName( "articles" );
		echo count($articles);
		foreach($articles as $article) {
			$article_id = $article->getElementsByTagName("article_id");
			$article_id_ = $article_id->item(0)->nodeValue;
			
			$article_categorie_id = $article->getElementsByTagName("article_categorie_id");
			$article_categorie_id_ = $article_categorie_id->item(0)->nodeValue;
			
			$article_subcategorie_id = $article->getElementsByTagName("article_subcategorie_id");
			$article_subcategorie_id_ = $article_subcategorie_id->item(0)->nodeValue;
			
			$poster_id = $article->getElementsByTagName("poster_id");
			$poster_id_ = $poster_id->item(0)->nodeValue;
			
			$article_title = $article->getElementsByTagName("article_title");
			$article_title_ = $article_title->item(0)->nodeValue;
			
			$article_context = $article->getElementsByTagName("article_context");
			$article_context_ = $article_context->item(0)->nodeValue;
			
			$article_image = $article->getElementsByTagName("article_image");
			$article_image_ = $article_image->item(0)->nodeValue;
			
			$article_timestamp = $article->getElementsByTagName("article_timestamp");
			$article_timestamp_ = $article_timestamp->item(0)->nodeValue;
			
			$likes = $article->getElementsByTagName("likes");
			$likes_ = $likes->item(0)->nodeValue;

			$tags = $article->getElementsByTagName("tags");
			$tags_ = $tags->item(0)->nodeValue;
			
			$visible = $article->getElementsByTagName("visible");
			$visible_ = $visible->item(0)->nodeValue;
			
			//Images
			$id = $article->getElementsByTagName("id");
			$id_ = $id->item(0)->nodeValue;

			$fileName = $article->getElementsByTagName("fileName");
			$fileName_ = $fileName->item(0)->nodeValue;

			$latitude = $article->getElementsByTagName("latitude");
			$latitude_ = $latitude->item(0)->nodeValue;

			$longitude = $article->getElementsByTagName("longitude");
			$longitude_ = $longitude->item(0)->nodeValue;

			$articleQuery = 
            "INSERT INTO `$dataBaseName`.`articles` " .
            "(`article_categorie_id`, `article_id`,`article_subcategorie_id` ,`poster_id`, `article_title`, `article_context`, `article_image`, `article_timestamp`, `likes`, `tags` , `visible`) values " .
            "('$article_categorie_id_', '$article_id_', '$article_subcategorie_id_','$poster_id_', '$article_title_', '$article_context_', '$article_image_',  '$article_timestamp_', '$likes_','$tags_', '$visible_')";




            ###########################Media management##########################

			$dstDir = $configurations['destination'];
			//Create Folder if not exists
			$dstDir = $dstDir . DIRECTORY_SEPARATOR . $poster_id_;
			if (!file_exists($dstDir)) {
		    	mkdir($dstDir, 0777, true);
		    	mkdir($dstDir. DIRECTORY_SEPARATOR . "thumbs", 0777, true);
			}

			// Destination for the uploaded file
			
			$src = $zipDirectory . DIRECTORY_SEPARATOR . $fileName_;
			$dst = $dstDir . DIRECTORY_SEPARATOR . $fileName_;
			echo $src;
			echo "<br>" . $dst;

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

			$width = $configurations['thumbWidth'];
			$height = $configurations['thumbHeight'];

			echo "File is of type $mimeFileName<br>\n";

			$imageFileNameAux = null;
			$imageMimeFileName = null;
			$imageTypeFileName = null;

			$thumbFileNameAux = null;
			$thumbMimeFileName = null;
			$thumbTypeFileName = null;

			switch ($mimeFileName) {
			    case "image":

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

			    default:
			        $imageFileNameAux = $dstDir . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "Unknown-Large.jpg";
			        $imageMimeFileName = "image";
			        $imageTypeFileName = "jpeg";

			        $thumbFileNameAux = $dstDir . DIRECTORY_SEPARATOR . "default" . DIRECTORY_SEPARATOR . "Unknown.jpg";
			        $thumbMimeFileName = "image";
			        $thumbTypeFileName = "jpeg";
			    break;
			}
			unlink($zipDirectory.'/articles.xml');


			$imageFileName = addslashes($imageFileNameAux);
			$thumbFileName = addslashes($thumbFileNameAux);


			$imgQuery = "INSERT INTO `images-details`" .
			"(`id`,`fileName`, `mimeFileName`, `typeFileName`, `imageFileName`, `imageMimeFileName`, `imageTypeFileName`, `thumbFileName`, `thumbMimeFileName`, `thumbTypeFileName`, `latitude`, `longitude`) values " .
			"('$id_','$fileName_', '$mimeFileName', '$typeFileName', '$imageFileName', '$imageMimeFileName', '$imageTypeFileName', '$thumbFileName', '$thumbMimeFileName', '$thumbTypeFileName', '$latitude_', '$longitude_')";

			$linkIdentifier->begin_transaction();
			$img = $linkIdentifier -> query($imgQuery);
			$art = $linkIdentifier -> query($articleQuery);
			
		    if($art && $img){
		        $linkIdentifier->commit();
		    }else{
		        $linkIdentifier->rollback();
		    }


		    
		}
		exit();
	}else{
		$title = "Invalid File Type";
		$info = "Make sure you are uploading a ZIP file";
		header("Location: ../responsePage.php?title=$title&info=$info");
		exit();
	}
	dbDisconnect();
	header("Location: profilepage.php");
	exit();
	
?>
