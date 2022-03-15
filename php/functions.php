<?php

 /**
  * Custom string encoding
  * @param string $titre string to encode
  * @return string $encoded string encoded
  */
 function url_custom_encode($titre) {
    $titre = htmlspecialchars($titre);
    $find = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Œ', 'œ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Š', 'š', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', 'Ÿ', '?', '?', '?', '?', 'Ž', 'ž', '?', 'ƒ', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?');
    $replace = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?', '?');
    $titre = str_replace($find, $replace, $titre);
    $titre = strtolower($titre);
    $mots = preg_split('/[^A-Z^a-z^0-9]+/', $titre);
    $encoded = "";
    foreach($mots as $mot) {
       if(strlen($mot) >= 3 OR str_replace(['0','1','2','3','4','5','6','7','8','9'], '', $mot) != $mot) {
          $encoded .= $mot.'-';
       }
    }
    $encoded = substr($encoded, 0, -1);
    return $encoded;
 }


 /**
  * Check image validity and upload to the desired directoy
  * @param string $target_dir path to the desired directory
  * @param object $file file to upload
  * @param int $maxSize maximum size of the file
  * @return array error and unique name of the file that has been uploaded. 
  * if $error is not null, $uploadedName is null, the file has not been uploaded . If $error is null, then $uploadedName is not null and the file has been uploaded.
  */
  function image_check_upload($target_dir,$file,$maxSize) {
      $error = null;
      $uploadedName = null;

      $tabExtension = explode('.',$file['name']);
      $extension = strtolower(end($tabExtension));
      $extensions = ['jpg','png','jpeg','gif'];
      
      if(in_array($extension,$extensions)){
         if($file['size']<$maxSize && $file['size'] != 0){
            if($file['error'] == 0 ){
                  $uniqueName = uniqid('', true);
                  $uploadedName = $uniqueName.".".$extension;
                  move_uploaded_file($file['tmp_name'],$target_dir.$uploadedName );
            }else{
                  $error = 'Une erreur est survenue <br/>' ;
            }
         }else{
            $maxSize = substr($maxSize, 0, -6);
            $error =  'La taille des fichiers ne doit pas dépasser '.$maxSize.'Mo<br/>';
         }
      }else{
         $error =  'Les images doivent être au format .png .jpeg ou .jpg <br/>';
      }

      return [$error, $uploadedName];
  }

  /**
  * 
  * @return object the data received with fetch
  * 
  */
  function receive_fetch_body() {

   /* Get content type */
   //$contentType = trim($_SERVER["CONTENT_TYPE"] ?? ''); // PHP 8+
   // Otherwise:
   $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';


   /* Send error to Fetch API, if unexpected content type */
   if ($contentType !== "application/json"){
   die(json_encode(['value' => 0,'error' => 'Content-Type is not set as "application/json"','data' => null,]));
   }
   /* NOTE: Not sure what went on but sometimes needs to add this line*/
   //$decoded = json_decode($decoded, true);

   /* Receive the RAW post data. */
   $content = trim(file_get_contents("php://input"));
   /* $decoded can be used the same as you would use $_POST in $.ajax */
   $decoded = json_decode($content, true);
   /* Send error to Fetch API, if JSON is broken */
   if(! is_array($decoded)){
   die(json_encode(['value' => 0,'error' => 'Received JSON is improperly formatted','data' => null,
   ]));
   }

   return $decoded;
}

 /**
  * 
  * @param object $decoded, data to send back as a response
  */
  function send_fetch_response($decoded) {
   /* Send success to fetch API */
   die(json_encode(['value' => 1,'error' => null,'data' => $decoded, ]));
}

function get_time_ago_fr( $time )
{

   $now = new DateTime('now',new DateTimeZone('Europe/Paris'));
   $ago = new DateTime($time,new DateTimeZone('Europe/Paris'));
   $diff = $now->diff($ago);

   $diff->w = floor($diff->d / 7);

   $string = array(
       'y' => 'year',
       'm' => 'month',
       'w' => 'week',
       'd' => 'day',
       'h' => 'hour',
       'i' => 'minute',
       's' => 'second',
   );
   foreach ($string as $k => &$v) {
       if ($diff->$k) {
           $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
       } else {
           unset($string[$k]);
       }
   }

   if (!$full) $string = array_slice($string, 0, 1);
   return $string ? implode(', ', $string) . ' ago' : 'just now';
}

/**
 * Look for mentions @username in a string
* @param string $text
* @param bool $at, if $at == true, keep the @ in the returned strings
* @return array $mentions, array with all the mentioned names
*/
function get_mentions_from_string( $text, $at = false )
{

   preg_match('/^@[^\s]+/', $text, $mentionAtStart);
   preg_match_all('/\s@[^\s]+/', $text, $mentionsInText);
   $mentions = [];
   if($mentionAtStart){
      if($at){
            array_push($mentions,$mentionAtStart[0]);
      }else{
            array_push($mentions,str_replace('@','',$mentionAtStart[0]));
      }
   }
   if($mentionsInText){
      foreach($mentionsInText[0] as $men){
         if($at){
               array_push($mentions,str_replace(' ','',$men));
         }else{
               array_push($mentions,str_replace([' ','@'],'',$men));
         }
      }
   }
   return $mentions;
}




?>