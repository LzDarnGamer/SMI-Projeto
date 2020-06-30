<?php

function getBrowser() {
    $userBrowser = '';
    /*
      foreach( $_SERVER as $key => $value) {
      echo $key . "=>" . $value . "<br>\n";
      }
      exit(0);
     */

    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    //echo $userAgent;

    if (preg_match('/Trident/i', $userAgent)) {
        $userBrowser = "Internet Explorer";
    } elseif (preg_match('/MSIE/i', $userAgent)) {
        $userBrowser = "Internet Explorer";
    } elseif (preg_match('/Firefox/i', $userAgent)) {
        $userBrowser = "Mozilla Firefox";
    } elseif (preg_match('/Safari/i', $userAgent)) {
        $userBrowser = "Apple Safari";
    } elseif (preg_match('/Chrome/i', $userAgent)) {
        $userBrowser = "Google Chrome";
    } elseif (preg_match('/Flock/i', $userAgent)) {
        $userBrowser = "Flock";
    } elseif (preg_match('/Opera/i', $userAgent)) {
        $userBrowser = "Opera";
    } elseif (preg_match('/Netscape/i', $userAgent)) {
        $userBrowser = "Netscape";
    }

    if (preg_match('/Mobile/i', $userAgent)) {
        $userBrowser = "Mobile Device";
    }
    return $userBrowser;
}

function redirectToPage($url, $title, $message, $refresTime) {
    echo "<html>\n";
    echo "  <head>\n";
    echo "    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n";
    echo "    <meta http-equiv=\"REFRESH\" content=\"$refresTime;url=$url\">\n";
    echo "    <title>$title</title>\n";
    echo "  </head>\n";
    echo "  <body>\n";
    echo "    <p>$message</p>";
    echo "    <p>You will be redirect in $refresTime seconds.</p>";
    echo "  </body>\n";
    echo "</html>";
    exit(1);
}

function redirectToLastPage($title, $refreshTime = 5) {
    $referer = $_SERVER["HTTP_REFERER"];

    echo "<html>\n";
    echo "  <head>\n";
    echo "    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n";
    echo "    <meta http-equiv=\"REFRESH\" content=\"$refreshTime;url=$referer\">\n";
    echo "    <title>$title</title>\n";
    echo "  </head>\n";
    echo "  <body>\n";
    echo "    <p> Invalid data!";
    echo "    <p> Please fill all the fields marked with *. You will be redirect to the last page in $refreshTime seconds\n";
    echo "  </body>\n";
    echo "</html>";
}

$find;
$replace;

function convertToEntities($str) {
    global $find;
    global $replace;

    if (($find == NULL) || ($replace == NULL)) {
        $find = array();
        $replace = array();

        foreach (get_html_translation_table(HTML_ENTITIES, ENT_QUOTES) as $key => $value) {
            $find[] = $key;
            $replace[] = $value;
        }
    }

    return str_replace($find, $replace, $str);
}


function url(){

  $serverName = $_SERVER['SERVER_NAME'];
  #$serverName = "localhost";

  $serverPortSSL = 443;
  $serverPort = 80;

  $name = webAppName();

  $currentUrl = "https://" . $serverName . ":" . $serverPortSSL . $name;

  return $currentUrl;
}

function webAppNameWithDepth($depth) {
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    $n = count($uri);
    $webApp = "";
    for ($idx = 0; $idx < $n - $depth; $idx++) {
        $webApp .= ($uri[$idx] . "/" );
    }

    return $webApp;
}

function webAppName() {
    $uri = explode("/", $_SERVER['REQUEST_URI']);
    $n = count($uri);
    $webApp = "";
    for ($idx = 0; $idx < $n - 1; $idx++) {
        $webApp .= ($uri[$idx] . "/" );
    }

    return $webApp;
}

function prepareHeaders() {
    list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
}

function ensureAuth($redirectPage) {
    prepareHeaders();

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
        header("locationafLocation: $redirectPage");
        exit;
    }
}

function showAuth($authType, $realm, $message) {
    header("WWW-Authenticate: $authType realm=\"$realm\"");
    header("HTTP/1.0 401 Unauthorized");

    echo $message;
}

function checkIfVerified($userName, $password){
    $userOk = 0;

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT valid FROM `$dataBaseName`.`auth-basic` " .
            "WHERE `name`='$userName' AND `password`='$password' ";
    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $userData = mysqli_fetch_array($result);
        $userOk = $userData['valid'];
    }
    mysqli_free_result($result);

    dbDisconnect();

    return $userOk;
}


function isValid($userName, $password, $authType) {
    $userOk = -1;

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT * FROM `$dataBaseName`.`auth-$authType` " .
            "WHERE `name`='$userName' AND `password`='$password'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $userData = mysqli_fetch_array($result);
        $userOk = $userData['id'];
    }
    mysqli_free_result($result);

    dbDisconnect();

    return $userOk;
}



function existUserField($field, $value, $authType = "basic") {
    $exists = true;

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    
    $query = "SELECT * FROM `$dataBaseName`.`auth-$authType` " .
            "WHERE `$field`='$value'";
    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows == 0) {
        $exists = false;
    }

    mysqli_free_result($result);

    dbDisconnect();

    return $exists;
}

function getPosterID($articleID){
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT poster_id FROM `$dataBaseName`.`articles` WHERE article_id='$articleID'");

    if(mysqli_num_rows($result)>0){
      $row = mysqli_fetch_array($result);

      mysqli_free_result($result);

      dbDisconnect();

      return $row['poster_id'];
    }
    return NULL;

}

function getnumArticles($idUser){
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT * FROM `$dataBaseName`.`articles` WHERE poster_id='$idUser'");

    $numRows = mysqli_num_rows($result);

    mysqli_free_result($result);

    dbDisconnect();

    return $numRows;
}
function getArticle($idArticle) {
  dbConnect(ConfigFile);
    
  $dataBaseName = $GLOBALS['configDataBase']->db;

  mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );
    
  $result = $GLOBALS['ligacao']->query("SELECT * FROM `$dataBaseName`.`articles` WHERE article_id='$idArticle'");
  
  $articleArray = mysqli_fetch_array($result);
  
  mysqli_free_result($result);
  
  dbDisconnect();

  return $articleArray;
}

function getComments($articleId){
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT * FROM `$dataBaseName`.`comments` WHERE articleId='$articleId' ORDER BY timestamp");

    $rows = [];
    while($row = mysqli_fetch_array($result)) {
        $rows[] = $row;

    }

    mysqli_free_result($result);

    dbDisconnect();

    return $rows;
}

function getArticles($idUser){
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT * FROM `$dataBaseName`.`articles` WHERE poster_id='$idUser' ORDER BY article_timestamp");

    $rows = [];
    while($row = mysqli_fetch_array($result)) {
        $rows[] = $row;

    }

    mysqli_free_result($result);

    dbDisconnect();

    return $rows;
}

function getAllSubscriptions () {
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT `email` FROM `$dataBaseName`.`subscription` ORDER BY id");

    $rows = [];
    while($row = mysqli_fetch_array($result)) {
        $rows[] = $row;

    }

    mysqli_free_result($result);

    dbDisconnect();

    return $rows;
}

function getAllUsers () {
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT `name` FROM `$dataBaseName`.`auth-basic` ORDER BY 'id'");

    $rows = [];
    while($row = mysqli_fetch_array($result)) {
        $rows[] = $row['name'];
    }

    mysqli_free_result($result);

    dbDisconnect();

    return $rows;
}

function getUser ($id) {
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT `name` FROM `$dataBaseName`.`auth-basic` WHERE id=$id");

    $row = mysqli_fetch_array($result);

    mysqli_free_result($result);

    return $row['name'];
}


function getAllIds () {
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT `id` FROM `$dataBaseName`.`auth-basic` ORDER BY 'id'");

    $rows = [];
    while($row = mysqli_fetch_array($result)) {
        $rows[] = $row['id'];
    }

    mysqli_free_result($result);

    dbDisconnect();

    return $rows;
}

function getImageForArticle($imgID){
    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT thumbFileName FROM `$dataBaseName`.`images-details` WHERE id=$imgID ");

    $row = mysqli_fetch_array($result);

    mysqli_free_result($result);

    return $row['thumbFileName'];
}

function getCategoryID($name, $close){
  dbConnect(ConfigFile);
    
  $dataBaseName = $GLOBALS['configDataBase']->db;

  mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );
    
  $query = "SELECT categorie_id FROM `$dataBaseName`.`categories` WHERE categorie_title='$name'";
  
  $result = mysqli_query($GLOBALS['ligacao'], $query);
  
  $catID = mysqli_fetch_array($result);
    
  mysqli_free_result($result);
  
  if($close)
    dbDisconnect();

  return $catID['categorie_id'];
}

function getSubCategoryID($name, $close){
  dbConnect(ConfigFile);
    
  $dataBaseName = $GLOBALS['configDataBase']->db;

  mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );
    
  $query = "SELECT subcategorie_id FROM `$dataBaseName`.`subcategories` WHERE subcategorie_title='$name'";
  
  $result = mysqli_query($GLOBALS['ligacao'], $query);
  
  $catID = mysqli_fetch_array($result);
    
  mysqli_free_result($result);
  
  if($close)
    dbDisconnect();

  return $catID['subcategorie_id'];
}


function getcategoryName($id){

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT categorie_title FROM `$dataBaseName`.`categories` WHERE categorie_id=$id";

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    
    $categorie_title = mysqli_fetch_array($result);
    
    mysqli_free_result($result);

    dbDisconnect();
    return $categorie_title['categorie_title'];
}

function getsubcategoryName($id){

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT subcategorie_title FROM `$dataBaseName`.`subcategories` WHERE subcategorie_id=$id";

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $subcategorie_title = mysqli_fetch_array($result);

    mysqli_free_result($result);

    dbDisconnect();

    return $subcategorie_title['subcategorie_title'];
}
function getcategories(){
    $allcategories = Array();

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT categorie_title FROM `$dataBaseName`.`categories`");

    while ($row = mysqli_fetch_assoc($result)) {
      $allcategories[$row["categorie_title"]] = $row;
    }

    mysqli_free_result($result);

    dbDisconnect();
    return $allcategories;

}


function getSubcategories(){
    $allSubcategories = Array();

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $result = $GLOBALS['ligacao']->query("SELECT subcategorie_title FROM `$dataBaseName`.`subcategories`");

    while ($row = mysqli_fetch_assoc($result)) {
      $allSubcategories[$row["subcategorie_title"]] = $row;
    }

    mysqli_free_result($result);

    dbDisconnect();

    return $allSubcategories;

}

function getRoleFromUser($userID) {
  dbConnect(ConfigFile);
    
  $dataBaseName = $GLOBALS['configDataBase']->db;

  mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

  $query = "SELECT `friendlyName` " .
          "FROM `$dataBaseName`.`auth-basic` u " .
          "JOIN `$dataBaseName`.`auth-permissions` p ON u.`id`=p.`id` " .
          "JOIN `$dataBaseName`.`auth-roles` r on p.`role`=r.`role` WHERE u.`valid`=1 AND u.`id`='$userID'";

  $result = mysqli_query($GLOBALS['ligacao'], $query);

  
  $isFirst = true;
  
  $userRoles = "";
  while ($userData = mysqli_fetch_array($result)) {
      if ($isFirst == true) {
          $isFirst = false;
      }
      $userRoles .= $userData['friendlyName'];
  }

  mysqli_free_result($result);

  dbDisconnect();

  return $userRoles;
}

function getNameFromUser($userID) {
    dbConnect(ConfigFile);
      
    $dataBaseName = $GLOBALS['configDataBase']->db;
  
    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );
  
    $query = "SELECT `name` FROM `$dataBaseName`.`auth-basic` WHERE `id`='$userID'";
  
    $result = mysqli_query($GLOBALS['ligacao'], $query);
  
    
    $isFirst = true;
    
    $userRoles = "";
    while ($userData = mysqli_fetch_array($result)) {
        if ($isFirst == true) {
            $isFirst = false;
        }
        $userRoles .= $userData['name'];
    }
  
    mysqli_free_result($result);
  
    dbDisconnect();
  
    return $userRoles;
  }

function getRole($userId) {
    $userRoles = "";

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT `friendlyName` " .
            "FROM `$dataBaseName`.`auth-basic` u " .
            "JOIN `$dataBaseName`.`auth-permissions` p ON u.`id`=p.`id` " .
            "JOIN `$dataBaseName`.`auth-roles` r on p.`role`=r.`role` WHERE u.`valid`=1 AND u.`id`='$userId'";

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $isFirst = true;
    $userRoles .= "[";

    while ($userData = mysqli_fetch_array($result)) {
        if ($isFirst == true) {
            $isFirst = false;
        } else {
            $userRoles .= ", ";
        }

        $userRoles .= $userData['friendlyName'];
    }
    $userRoles .= "]";

    mysqli_free_result($result);

    dbDisconnect();

    return $userRoles;
}

function getEmail($userId, $authType) {
    $userEmail = -1;

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT `email` FROM `$dataBaseName`.`auth-$authType` WHERE `id`='$userId'";

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $userData = mysqli_fetch_array($result);
        $userEmail = $userData['email'];
    }
    mysqli_free_result($result);

    dbDisconnect();

    return $userEmail;
}

function logout($authType, $realm, $location) {
    unset($_SERVER['PHP_AUTH_USER']);
    unset($_SERVER['PHP_AUTH_PW']);
    unset($_SERVER['HTTP_AUTHORIZATION']);

    header("WWW-Authenticate: $authType realm=\"$realm\"");
    header("HTTP/1.0 401 Unauthorized");

    header("Location: $location");
}

function getFileDetails($ids) {
    $isFirst = true;
    $whereClause = "";

    if (is_array($ids)) {
        foreach ($ids as $id) {
            if ($isFirst == false) {
                $whereClause .= " OR `id`='$id'";
            } else {
                $whereClause .= "`id`='$id'";
                $isFirst = false;
            }
        }
    } else {
        $whereClause = "`id`='$ids'";
    }

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT * FROM `$dataBaseName`.`images-details` WHERE " . $whereClause;

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $fileData = array();
    while (($fileDataRecord = mysqli_fetch_array($result)) != false) {
        $fileData[] = $fileDataRecord;
    }

    mysqli_free_result($result);
    dbDisconnect();

    if ( !is_array($ids)) {
        return $fileData[0];
    } else {
        return $fileData;
    }
}

function deleteArticle ($articleID, $posterID) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $info = $GLOBALS['ligacao'] -> query("SELECT imageFileName, thumbFileName, id " .
                                  "FROM `$dataBaseName`.`articles` a " .
                                  "JOIN `$dataBaseName`.`images-details` d ON a.article_image=d.id " .
                                  "WHERE a.article_id=$articleID and a.poster_id=$posterID" );
    if(!$info){
      return false;
    }

    $results = mysqli_fetch_array($info);

    $id = $results['id'];
    $imageFileName = $results['imageFileName'];
    $thumbFileName = $results['thumbFileName'];
    
    
    $GLOBALS['ligacao']->begin_transaction();
    $res2 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`articles` WHERE article_id=$articleID and poster_id=$posterID");
    $res1 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`images-details` WHERE id=$id");


    if($res1 && $res2){
        $GLOBALS['ligacao']->commit();
        unlink($imageFileName);
        unlink($thumbFileName);
        dbDisconnect();
        return true;
    }else{
        $GLOBALS['ligacao']->rollback();
        dbDisconnect();
        return false;
    }
    
    

}

function deleteUser ($userID) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);    
    
    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`auth-basic` WHERE id='$userID'");
    $res1 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`auth-challenge` WHERE id='$userID'");
    $res1 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`auth-permissions` WHERE id='$userID'");
    

    if($res1){
        $GLOBALS['ligacao']->commit();
        return "true";
    }else{
        $GLOBALS['ligacao']->rollback();
        return "false";
    }


    dbDisconnect();

}

function deleteCategory ($cat) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);    
    
    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`categories` WHERE categorie_title='$cat'");
    

    if($res1){
        $GLOBALS['ligacao']->commit();
        return "true";
    }else{
        $GLOBALS['ligacao']->rollback();
        return "false";
    }


    dbDisconnect();

}

function updateRole ($userID, $roleChosen) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);    
    
    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("UPDATE `$dataBaseName`.`auth-permissions` SET `role`='$roleChosen' WHERE id='$userID'");
    

    if($res1){
        $GLOBALS['ligacao']->commit();
        return "true";
    }else{
        $GLOBALS['ligacao']->rollback();
        return "false";
    }


    dbDisconnect();
}

function updateCat ($oldCategory, $cat) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);    
    
    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("UPDATE `$dataBaseName`.`categories` SET `categorie_title`='$cat' WHERE categorie_title='$oldCategory'");
    

    if($res1){
    	$GLOBALS['ligacao']->commit();
      	return "true";
    }else{
      	$GLOBALS['ligacao']->rollback();
      	return "false";
    }


    dbDisconnect();
}

function subscribeNewsletter ($email) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $timestamp = date("d/m/Y");
    
    $sql = "INSERT INTO `subscription`(`email`) VALUES ('$email')";
    mysqli_query($GLOBALS['ligacao'], $sql);
    $recordsInserted = mysqli_affected_rows( $GLOBALS['ligacao'] );
    
    if($recordsInserted != -1){
      return "true";
    }else{
      return "false";
    }

    dbDisconnect();
}

function insertComment ($articleId, $posterId, $comment) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $timestamp = date("d/m/Y");
    
    $sql = "INSERT INTO `comments`(`userId`, `articleId`, `text`, `timestamp`) VALUES ('$posterId', '$articleId', '$comment', '$timestamp')";
    mysqli_query($GLOBALS['ligacao'], $sql);
    $recordsInserted = mysqli_affected_rows( $GLOBALS['ligacao'] );
    
    if($recordsInserted != -1){
      return "true";
    }else{
      return "false";
    }

    dbDisconnect();
}

function insertCat ($cat) {
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);    

    $sql = "INSERT INTO `categories`(`categorie_title`) VALUES ('$cat')";
    mysqli_query($GLOBALS['ligacao'], $sql);
    $recordsInserted = mysqli_affected_rows( $GLOBALS['ligacao'] );
    
    if($recordsInserted != -1){
      return "true";
    }else{
      return "false";
    }

    dbDisconnect();
}

function deleteImage($imgID){
    dbConnect(ConfigFile);
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName);

    $info = $GLOBALS['ligacao'] -> query("SELECT imageFileName, thumbFileName, id " .
                                  "FROM `$dataBaseName`.`articles` a " .
                                  "JOIN `$dataBaseName`.`images-details` d ON a.article_image = d.id" .
                                  "WHERE a.article_id='$articleID' and a.poster_id='$posterID'" );
    if(!$info){
      return false;
    }

    $results = mysqli_fetch_array($info);

    $id = $results['id'];
    $imageFileName = $results['imageFileName'];
    $thumbFileName = $results['thumbFileName'];
    $GLOBALS['ligacao']->begin_transaction();
    $res1 = $GLOBALS['ligacao'] -> query("DELETE FROM `$dataBaseName`.`images-details` WHERE id='$id'");

    if($res1){
      $GLOBALS['ligacao']->commit();
      unlink($imageFileName);
      unlink($thumbFileName);
      dbDisconnect();
      return true;
    }else{
      $GLOBALS['ligacao']->rollback();
      dbDisconnect();
      return false;
    }

}



function getSubsciptions($userID){
    $userSubscriptionsIDS = Array();

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT `subscription_category_id` FROM `$dataBaseName`.`subscriptions` WHERE `subscriber_id`='$userID'";

    $result = mysqli_query($GLOBALS['ligacao'], $query);
    return $GLOBALS['ligacao'] -> error;

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $ids = mysqli_fetch_array($result);
        $userSubscriptionsIDS = $ids['subscription_category_id'];
    }
    mysqli_free_result($result);

    dbDisconnect();

    return $userSubscriptionsIDS;
}


function getCart($userID){
    dbConnect(ConfigFile);

    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );


    $query = "SELECT list FROM `$dataBaseName`.`cart` " . "WHERE `id`='$userID'";

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    while ($array = mysqli_fetch_array($result)) {
        $list = $array["list"];
    }
    if(!isset($list)){
        return Array();
    }
    return explode(",", $list);
}

function getArticlesOrderLikes($amount){
    $articles = Array();

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

    $query = "SELECT * FROM `$dataBaseName`.`articles` ORDER BY `likes` DESC LIMIT `$amount`";

    $result = mysqli_query($GLOBALS['ligacao'], $query);

    $numRows = mysqli_num_rows($result);

    if ($numRows > 0) {
        $ids = mysqli_fetch_array($result);
        $userSubscriptionsIDS = $ids['subscription_category_id'];
    }
    mysqli_free_result($result);

    dbDisconnect();

    return $articles;
}

function getConfiguration() {
  dbConnect(ConfigFile);
    
  $dataBaseName = $GLOBALS['configDataBase']->db;

  mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );
    
  $query = "SELECT * FROM `$dataBaseName`.`images-config`";
  
  $result = mysqli_query($GLOBALS['ligacao'], $query);
  
  $configuration = mysqli_fetch_array($result);
    
  mysqli_free_result($result);
  
  dbDisconnect();

  return $configuration;
}

function countArticlesPerCategory($visible=null){

    dbConnect(ConfigFile);
    
    $dataBaseName = $GLOBALS['configDataBase']->db;

    mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );
    
    if($visible == null){
        $query = "SELECT article_categorie_id as id, COUNT(*) as amount FROM `$dataBaseName`.`articles` 
        GROUP BY article_categorie_id ORDER BY article_categorie_id ASC";
    }else{
        $query = "SELECT article_categorie_id as id, COUNT(*) as amount FROM `$dataBaseName`.`articles` WHERE visible=$visible 
        GROUP BY article_categorie_id ORDER BY article_categorie_id ASC ";
    }
    
    $results = mysqli_query($GLOBALS['ligacao'], $query);

    while ($result = mysqli_fetch_array($results)) {
        $counters[] = $result;
    }

    mysqli_free_result($results);
  
    dbDisconnect();

    return $counters;
}

function getStats() {
  dbConnect(ConfigFile);
  
  $dataBaseName = $GLOBALS['configDataBase']->db;

  mysqli_select_db($GLOBALS['ligacao'], $dataBaseName );

  "SELECT COUNT(DISTINCT `mimeFileName`) FROM `$dataBaseName`.`images-details`;";
  "SELECT DISTINCT `mimeFileName` FROM `$dataBaseName`.`images-details`;";

  $queryTotal = "SELECT count(*) AS totalFiles FROM `$dataBaseName`.`images-details`";
  $queryImages = "SELECT count(*) AS totalImages FROM `$dataBaseName`.`images-details` WHERE `mimeFileName`='image'";
  $queryVideos = "SELECT count(*) AS totalVideos FROM `$dataBaseName`.`images-details` WHERE `mimeFileName`='video'";
  $queryAudios = "SELECT count(*) AS totalAudios FROM `$dataBaseName`.`images-details` WHERE `mimeFileName`='audio'";

  // Total files
  $resultTotal = mysqli_query($GLOBALS['ligacao'], $queryTotal);
  $totalData = mysqli_fetch_array($resultTotal);
  $stats['numFiles'] = $totalData['totalFiles'];
  mysqli_free_result($resultTotal);

  // Image files
  $resultImages = mysqli_query($GLOBALS['ligacao'], $queryImages);
  $totalImages = mysqli_fetch_array($resultImages);
  $stats['numImages'] = $totalImages['totalImages'];
  mysqli_free_result($resultImages);

  // Video files
  $resultVideos = mysqli_query($GLOBALS['ligacao'], $queryVideos);
  $totalVideos = mysqli_fetch_array($resultVideos);
  $stats['numVideos'] = $totalVideos['totalVideos'];
  mysqli_free_result($resultVideos);

  // Audio files
  $resultAudios = mysqli_query($GLOBALS['ligacao'], $queryAudios);
  $totaltAudios = mysqli_fetch_array($resultAudios);
  $stats['numAudios'] = $totaltAudios['totalAudios'];
  mysqli_free_result($resultAudios);

  dbDisconnect();

  return $stats;
}

function showUploadFileError($errorCode) {
    switch ($errorCode) {
        case UPLOAD_ERR_OK:
            $errorMessage = "($errorCode) There is no error, the file uploaded with success.";
            break;

        case UPLOAD_ERR_INI_SIZE:
            $errorMessage = "($errorCode) The uploaded file exceeds the upload_max_filesize directive in php.ini file.";
            break;

        case UPLOAD_ERR_FORM_SIZE:
            $errorMessage = "($errorCode) The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
            break;

        case UPLOAD_ERR_PARTIAL:
            $errorMessage = "($errorCode) The uploaded file was only partially uploaded.";
            break;

        case UPLOAD_ERR_NO_FILE:
            $errorMessage = "($errorCode) No file was uploaded.";
            break;

        case UPLOAD_ERR_NO_TMP_DIR:
            $errorMessage = "($errorCode) Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.";
            break;

        case UPLOAD_ERR_CANT_WRITE:
            $errorMessage = "($errorCode) Failed to write file to disk. Introduced in PHP 5.1.0.";
            break;

        case UPLOAD_ERR_EXTENSION:
            $errorMessage = "($errorCode) A PHP extension stopped the file upload.";
            break;

        default:
            $errorMessage = "($errorCode) No description available.";
            break;
    }

    return $errorMessage;
}

function getXdebugArg() {
  $method = $_SERVER['REQUEST_METHOD'];
  
  if ($method == 'POST') {
    $args = $_POST;
  } elseif ($method == 'GET') {
    $args = $_GET;
  }

 foreach ($args as $key => $value) {
    if ( $key==="XDEBUG_SESSION_START" ) {
      return "XDEBUG_SESSION_START=$value";
    }
  }
  
  return null;
}

function getXdebugArgAsArray() {
  $method = $_SERVER['REQUEST_METHOD'];
  
  if ($method == 'POST') {
    $args = $_POST;
  } elseif ($method == 'GET') {
    $args = $_GET;
  }

 foreach ($args as $key => $value) {
    if ( $key==="XDEBUG_SESSION_START" ) {
      return array( "key" => $key, "value" => $value);
    }
  }
  
  return null;
}

?>