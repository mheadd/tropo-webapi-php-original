<?php

/**
 * Updating an Application to Add a Number from the Pool
 * the updateApplicationAddress() method can be used to add a number from the pool of available Tropo numbers, 
 * based on a specified prefix.
 * 
 */

require_once '../tropo.class.php';

$userid = "";
$password = "";
$applicationID = "";

$tropo = new Tropo();

try {
	echo $tropo->updateApplicationAddress($userid, $password, $applicationID, array("type" => AddressType::$number, "prefix" => "1407"));
}

catch (TropoException $ex) {
	echo $ex->getMessage();
}

?>