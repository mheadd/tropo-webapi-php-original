<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Set up our prompts and input collection options.
$say = new Say("Please say your account number");
$choices = new Choices("[5 DIGITS]");

// Set up new Ask object.
$ask = new Ask(NULL, true, $choices, NULL, "foo", true, $say, 30);
	
// Create a new instance of the Tropo object and add our shiny new Ask object.
$tropo = new Tropo();
$tropo->Ask($ask);

// Render the JSON for Tropo to consume.
echo $tropo;

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "ask": {
	                "bargein": true,
	                "choices": {
	                    "value": "[5 DIGITS]"
	                },
	                "name": "foo",
	                "requied": true,
	                "say": {
	                    "value": "Please say your account number"
	                },
	                "timeout": 30
	            }
	        }
	    ]
	}
 *
 */

?>