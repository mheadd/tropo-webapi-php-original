<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Create a new instance of the Tropo object and call the Hangup() method.
$tropo = new Tropo();
$tropo->Hangup();

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "hangup": "null"
	        }
	    ]
	}
*/

?>