<?php

// Include Tropo classes.
require('../TropoClasses.php');

// Get the JSON data submitted from the Tropo Web API
$result_json = file_get_contents("php://input");

$result = new Result($result_json);
$utterance = $result->getUtterance();

$say = new Say("You entered, ".$utterance ." Goodbye");

$tropo = new Tropo();
$tropo->Say($say);
$tropo->Hangup();

echo $tropo;

/**
 * Delivered JSON
 * 
	{
	   "result":{
	      "sessionId":"D53D19981DD111B29E60941E0E68C6DB0xac138102",
	      "state":"CONNECTED",
	      "sessionDuration":7,
	      "sequence":1,
	      "complete":true,
	      "error":null,
	      "actions":[
	         {
	            "name":"mailbox",
	            "attempts":1,
	            "disposition":"SUCCESS",
	            "confidence":100,
	            "interpretation":"12345",
	            "utterance":"1 2 3 4 5",
	            "value":"12345",
	            "xml":"<?xml version=\"1.0\"?>\r\n<result grammar=\"0@b3c1b8e9.vxmlgrammar\">\r\n    <interpretation grammar=\"0@b3c1b8e9.vxmlgrammar\" confidence=\"100\">\r\n        <voxeoresult>\r\n  <concept>\r\n    \r\n  <\/concept>\r\n  <interpretation>\r\n    12345\r\n  <\/interpretation>\r\n  <asrxml>\r\n    <![CDATA[<TopLevel_1a31800_1881950667> <_900f56b92a1aa180e28f621b545dd460> <_5_DIGITS_> <_5DIGITS> <dtmfdigits_5DIGITS> <builtindtmfdigit> dtmf-1 {1} <\/builtindtmfdigit> <builtindtmfdigit> dtmf-2 {2} <\/builtindtmfdigit> <builtindtmfdigit> dtmf-3 {3} <\/builtindtmfdigit> <builtindtmfdigit> dtmf-4 {4} <\/builtindtmfdigit> <builtindtmfdigit> dtmf-5 {5} <\/builtindtmfdigit> <\/dtmfdigits_5DIGITS> <\/_5DIGITS> <\/_5_DIGITS_> <\/_900f56b92a1aa180e28f621b545dd460> <\/TopLevel_1a31800_1881950667>]]>\r\n  <\/asrxml>\r\n<\/voxeoresult>\r\n<instance>1 2 3 4 5<\/instance>\r\n      <input mode=\"dtmf\">dtmf-1 dtmf-2 dtmf-3 dtmf-4 dtmf-5<\/input>\r\n    <\/interpretation>\r\n<\/result>\r\n"
	         }
	      ]
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
	                "value": "You entered, 1 2 3 4 5 Goodbye"
	            }
	        },
	        {
	            "hangup": "null"
	        }
	    ]
	}
 */

?>