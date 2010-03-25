<?php

// Include Tropo classes.
require('../TropoClasses.php');

$endpoint = new EndpointObject("sip:9991427589@sip.tropo.com", Channel::$voice, NULL, Network::$voip);
$redirect = new Redirect($endpoint, NULL);

// Create a new instance of the Tropo object and call the Redirect() method.
$tropo = new Tropo();
$tropo->Redirect($redirect);

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "redirect": {
	                "to": {
	                    "id": "sip:9991427589@sip.tropo.com",
	                    "channel": "VOICE",
	                    "network": "VOIP"
	                },
	                "from": ""
	            }
	        }
	    ]
	}
*/

?>