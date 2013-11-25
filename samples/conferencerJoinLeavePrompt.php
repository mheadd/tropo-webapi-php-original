<?php

require 'tropo.class.php';
error_reporting(0);

$tropo = new Tropo();

$session = new Session();

$from = $session->getFrom();
$callerID = $from["id"];

$tropo->say("You are about to enter the conference");

$tropo->conference(null, array(
  "id"=>"1234",
  "name"=>"joinleave",
  "joinPrompt" => "$callerID has entered the conference",
  "leavePrompt" => "$callerID has left the conference", 
  "voice" => "Victor",
));

$tropo->RenderJson();

?>