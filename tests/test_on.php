<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Set up a prompt for a join event.
$say = new Say('Welcome to the conference. Press the pound key to exit.');

// Set up an On object to handle the event.
// Note - statically calling the properties of the Event object can be used 
//   as the first parameter to the On Object constructor.
$on = new On(Event::$join, NULL, $say);

// Add our On event handler to a Conference object.
$conference = new Conference(1234, false, "foo", $on, true, NULL, "#");

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
                "on": {
                    "event": "join",
                    "say": {
                        "value": "Welcome to the conference. Press the pound key to exit."
                    }
                },
                "playTones": true,
                "terminator": "#"
            }
        } 
 */

?>