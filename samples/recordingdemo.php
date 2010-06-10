<?php
require_once 'TropoClasses.php';
require_once 'KLogger.php';
$log = new KLogger ( "log.txt" , KLogger::INFO );

if (!array_key_exists('record', $_GET)) {
  $tropo = new Tropo();
  $tropo->record('',array(
    'say' => 'Leave your message at the beep.',
    'url' => getself() . '?record',
    ));
  print $tropo;
} else {
  $target_path = 'path/to/recording/' . $_FILES['filename']['name'];
  if(move_uploaded_file($_FILES['filename']['tmp_name'], $target_path)) {
    $log->LogInfo("$target_path [{$_FILES['filename']['size']} bytes] was saved");
  } else {
    $log->LogError("$target_path could not be saved.");
  }
}

function getself() {
 $pageURL = 'http';
 $url = ($_SERVER["HTTPS"] == "on") ? 'https' : 'http';
 $url .= "://" . $_SERVER["SERVER_NAME"];
 $url .= ($_SERVER["SERVER_PORT"] != "80") ? ':'. $_SERVER["SERVER_PORT"] : '';
 $url .= $_SERVER["REQUEST_URI"];
 return $url;
}
?>