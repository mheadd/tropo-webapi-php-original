<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Create a conference object.
$conference = new Conference(1234, false, "foo", NULL, false, NULL, "#");

// Create a new instance of the Tropo object and add our shiny new Conference object.
$tropo = new Tropo();
$tropo->Conference($conference);

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "conference": {
	                "id": 1234,
	                "mute": false,
	                "name": "foo",
	                "on": "",
	                "playTones": false,
	                "terminator": "#"
	            }
	        }
	    ]
	}
 * 
 */ 

?>