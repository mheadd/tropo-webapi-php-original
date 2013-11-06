<?php
require 'tropo.class.php';
require 'limonade/lib/limonade.php';
error_reporting(0);

dispatch_post('/', 'app_start');
function app_start() {

  $tropo = new Tropo(); 

  $tropo->call("+14071234321", array(
    "machineDetection" => "This is just a test to see if you are a human or a machine. PLease hold while we determine. Almost finished. Thank you!", 
    "voice" => "Victor"
  ));
  $tropo->on(array("event" => "continue", "next" => "your_app.php?uri=continue"));
  
  $tropo->RenderJson();
}

dispatch_post('/continue', 'app_continue');
function app_continue() {

  $tropo = new Tropo(); 
  @$result = new Result();

  $userType = $result->getUserType();
  $tropo->say("You are a $userType");
  $tropo->RenderJson();
}
run();
?>