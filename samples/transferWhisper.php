<?php
require 'tropo.class.php';
error_reporting(0);

$tropo = new Tropo(); 

//Send a whisper array with all of the functions
$whisper = array();

//The next method will be an ask
$choices = new Choices("1", "dtmf");
$a = new Ask(1,true, $choices, NULL,"foo", true, "Press one to accept the call or any other number to decline.", 30, NULL, NULL, NULL, NULL, NULL, .01, NULL);
$ask = array("ask" => $a);

//push the ask to the whisper array  
array_push($whisper, $ask);

//The first method will be a say
$say = array("say" => new Say("You are now being connected to the call."));

//Push the say to the whisper array
array_push($whisper, $say);


$tropo->say("please hold while you are transferred");

//Create the connect whisper on event for the transfer with a ring event
$on = array("event" => "connect", "whisper" => $whisper, "ring" => "http://www.phono.com/audio/holdmusic.mp3"); 

//Create the connect whisper on event for the transfer without a ring event
$on = array("event" => "connect", "whisper" => $whisper);

$options = array(
  'on' => $on,
  'from' => '14071234321'
);

//use the connect whisper in the transfer
$tropo->transfer("+14071234321", $options);
$tropo->on(array("event" => "incomplete", "next" => "hangup.php", "say" => "You have opted to not accept this call. Goodbye!"));

echo $tropo->RenderJson();
?>