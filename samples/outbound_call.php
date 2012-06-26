<?php 

//this example accepts parameters passed to it from an outside REST request (such as a curl app) - 
//it extracts the values of the passed parameters and uses it to send, in this case, an outbound text
 
require 'tropo.class.php';

//brings in the Tropo library
 
$session = new Session(); 
$to = "+".$session->getParameters("numbertodial"); 
$name = $session->getParameters("customername"); 
$msg = $session->getParameters("msg"); 

//extracts the contents of the passed parameters and assigns them as variables for later use

$tropo = new Tropo(); 
     
$tropo->call($to, array('network'=>'SMS')); 
$tropo->say("OMG ".$name.", ".$msg."!"); 

//actually creates the call, passed the "to" value and then adds in the other variables for the message

return $tropo->RenderJson(); 

//defines the response to Tropo in JSON
 
?> 