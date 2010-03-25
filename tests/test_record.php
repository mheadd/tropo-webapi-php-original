<?php

// Include Tropo classes.
require('../TropoClasses.php');

$say = new Say("Please say your account number");
$choices = new Choices("[5 DIGITS]", NULL, "#");

$record = new Record(NULL, NULL, true, $choices, NULL, 5, "POST", NULL, NULL, $say, NULL, NULL);
	
// Create a new instance of the Tropo object and add our shiny new Record object.
$tropo = new Tropo();
$tropo->Record($record);

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "record": {
	                "beep": true,
	                "choices": {
	                    "value": "[5 DIGITS]",
	                    "termChar": "#"
	                },
	                "maxSilence": 5,
	                "method": "POST",
	                "say": {
	                    "value": "Please say your account number"
	                }
	            }
	        }
	    ]
	}
 *
 */

?>