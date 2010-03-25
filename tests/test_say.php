<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Set up a Say Object.
$say = new Say("Goodbye world!", NULL, Event::$hangup);

// Create a new instance of the Tropo object and add our shiny new Say object.
$tropo = new Tropo();
$tropo->Say($say);
$tropo->Hangup();

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 *
	{
	    "tropo": [
	        {
	            "say": {
	                "value": "Goodbye world!",
	                "event": "hangup"
	            }
	        },
	        {
	            "hangup": "null"
	        }
	    ]
	}
 */

?>