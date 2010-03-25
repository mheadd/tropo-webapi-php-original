<?php

// Include Tropo classes.
require('../TropoClasses.php');

$startRecording = new StartRecording("myrecording", NULL, NULL, NULL, "http://postthis.com/a_resource", NULL);
$say = new Say("I am now recording!");

// Create a new instance of the Tropo object and add our Recording object.
$tropo = new Tropo();
$tropo->StartRecording($startRecording);
$tropo->Say($say);
$tropo->StopRecording();

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "startRecording": {
	                "name": "myrecording",
	                "url": "http://postthis.com/a_resource"
	            }
	        },
	        {
	            "say": {
	                "value": "I am now recording!"
	            }
	        },
	        {
	            "stopRecording": "null"
	        }
	    ]
	}
 */

?>