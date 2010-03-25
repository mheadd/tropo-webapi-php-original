<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Get the JSON data submitted from the Tropo Web API
$session_json = file_get_contents("php://input");

$session = new Session($session_json);
$to = $session->getTo();

if($to[3] == 'PSTN') {
	$sayText = "Welcome to my Phone application.";
} else {
	$sayText = "Welcome to my SMS application.";
}

$say = new Say($sayText);
$tropo = new Tropo();
$tropo->Say($say);
$tropo->Hangup();

echo $tropo;

/**
 * Delivered JSON
 * 
	{
	   "session":{
	      "id":"1aa06515183223ec0894039c2af433f2",
	      "accountId":"33932",
	      "timestamp":"2010-02-18T19:07:36.375Z",
	      "userType":"HUMAN",
	      "initialText":null,
	      "to":{
	         "id":"9991427645",
	         "name":"unknown",
	         "channel":"VOICE",
	         "network":"PSTN"
	      },
	      "from":{
	         "id":"jsgoecke",
	         "name":"unknown",
	         "channel":"VOICE",
	         "network":"PSTN"
	      },
	      "headers":{
	         "x-sbc-from":"\"jsgoecke\"<sip:0000123456@192.168.34.202>;tag=2a648c6e",
	         "x-sbc-allow":"BYE",
	         "x-sbc-user-agent":"sipgw-1.0",
	         "x-voxeo-sbc-name":"10.6.63.104",
	         "x-sbc-contact":"<sip:0000123456@192.168.34.202:16000>",
	         "Content-Length":"247",
	         "To":"<sip:9991427645@10.6.61.101:5060>",
	         "x-voxeo-sbc":"true",
	         "Contact":"<sip:jsgoecke@10.6.63.104:5060>",
	         "x-voxeo-to":"<sip:990009369991427645@66.193.54.18:5060>",
	         "x-sbc-request-uri":"sip:990009369991427645@66.193.54.18:5060",
	         "x-sbc-call-id":"OWE0OGFkMTE1ZGY4NTI1MmUzMjc1M2Y3Y2ExMzc2YjE.",
	         "x-sid":"39f4688b8896f024f3a3aebd0cfb40b2",
	         "x-sbc-cseq":"1 INVITE",
	         "x-sbc-max-forwards":"70",
	         "x-voxeo-sbc-session-id":"39f4688b8896f024f3a3aebd0cfb40b2",
	         "CSeq":"2 INVITE",
	         "Via":"SIP/2.0/UDP 66.193.54.18:5060;received=10.6.63.104",
	         "x-sbc-record-route":"<sip:195.46.253.237:5061;r2=on;lr;ftag=2a648c6e>",
	         "Call-ID":"0-13c4-4b7d8ff7-1c3c1b82-7935-1d10b080",
	         "Content-Type":"application/sdp",
	         "x-sbc-to":"<sip:990009369991427645@66.193.54.18:5060>",
	         "From":"<sip:jsgoecke@10.6.63.104:5060>;tag=0-13c4-4b7d8ff7-1c3c1b82-5d8c"
	      }
	   }
	}
 */

/**
 * Rendered JSON.
 * 
	{
	    "tropo": [
	        {
	            "say": {
	                "value": "Welcome to my Phone application."
	            }
	        },
	        {
	            "hangup": "null"
	        }
	    ]
	}
 */


?>