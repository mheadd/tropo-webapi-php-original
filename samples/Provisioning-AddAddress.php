<?php

/**
 * Updating an Application to Add an AIM Address
 * The updateApplicationAddress() method can be used to add an AIM account to your application. 
 * The same method can be used to add YAHOO, MSN, JABBER, GTALK and SKYPE.
 * 
 */

require_once '../tropo.class.php';

$userid = "";
$password = "";
$applicationID = "";

$tropo = new Tropo();

try {
	echo $tropo->updateApplicationAddress($userid, $password, $applicationID, array("type" => AddressType::$aim, "username" => "AIMUser01", "password" => "secret"));
}

catch (TropoException $ex) {
	echo $ex->getMessage();
}

?>