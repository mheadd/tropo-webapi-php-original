<?php
// Settings! Shiny.
$token = 'your token here';
$number = 'the number you would like to dial';


include_once 'tropo.class.php';

$tropo = new Tropo();

try {
  $session = new Session();
  if ($session->getParameters("action") == "create") {
     $tropo->call($session->getParameters("dial"));
     $tropo->say('This is an outbound call.');
  } else {
     $tropo->say('Thank you for calling us.');
  }
  $tropo->renderJSON();
} catch (TropoException $e) {
  if ($e->getCode() == '1') {
    // The session object threw an exception, so this file wasn't
    // loaded as part of a Tropo session. Launch a Tropo session.
    if ($tropo->createSession($token, array('dial' => $number))) {
      print 'Call launched to ' . $number;
    } else {
      print "call failed! Try it again with the Tropo debugger running to see what the error is.";
    }
  }
}
?>
