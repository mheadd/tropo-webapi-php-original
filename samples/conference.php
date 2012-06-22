<?php
/*

Conference application
----------------------
This is a full-featured conference bridge, written for Tropo's WebAPI
using the Slim Framework for PHP (http://www.slimframework.com/) and
the Tropo WebAPI library (https://github.com/tropo/tropo-webapi-php)

To use, install Slim Framework according to the documentation. Adjust
the require lines to match your locations of Slim and the Tropo classes.

Set your Tropo application's start URL to be the url to your Slim
installation and call your application.

 */

// Which voice would you like to use in prompts?
$voice = 'Veronica';

require '../tropo.class.php';
require 'Slim/Slim.php';

$app = new Slim();

$app->map('/', 'start')
  ->via('GET')
  ->via('POST');
$app->post('/restart', 'start');
  
function start() {
  global $voice;
  $tropo = new Tropo();
  $tropo->setVoice($voice);

  $tropo->ask("Enter your conference ID, followed by the pound key.", array(
    "choices" => "[1-10 DIGITS]", 
    "name" => "confid", 
    "attempts" => 5, 
    "timeout" => 60, 
    "mode" => "dtmf",
    "terminator" => "#",
    "event" => array(
        "incomplete" => 'Sorry, I didn\'t hear anything.',
        "nomatch" => 'Sorry, that is not a valid conference ID.'
      )
    ));

  $tropo->on(array("event" => "continue", "next" => "conference"));
  $tropo->on(array("event" => "incomplete", "next" => "restart"));

  $tropo->RenderJson();
}
 
$app->post('/conference', 'conference');
function conference() {
  global $voice;
  $tropo = new Tropo();
  $tropo->setVoice($voice);

  $result = new Result();   
  $conference = $result->getValue();
   
  $tropo->say('<speak>Conference ID <say-as interpret-as=\'vxml:digits\'>' . $conference . '</say-as> accepted.</speak>');
  $tropo->say('You will now be placed into the conference. Please announce yourself. To exit the conference without disconnecting, press pound.');
  $tropo->conference($conference, array('id' => $conference, 'terminator' => '#'));
  $tropo->say('You have left the conference.');
  
  $tropo->on(array("event" => "continue", "next" => "restart"));
  $tropo->RenderJson();
}

$app->run(); 
?>