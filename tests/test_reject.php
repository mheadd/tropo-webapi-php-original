<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Create a new instance of the Tropo object and call the Reject() method.
$tropo = new Tropo();
$tropo->Reject();

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "reject": "null"
	        }
	    ]
	}
*/

?>