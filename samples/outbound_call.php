<?php
include_once 'tropo.class.php';
$token = 'your token here';
$number = 'the number you would like to dial';

$tropo = new Tropo();

try {
  $session = new Session();
  if ($session->getParams("action") == "create") {
     $tropo->call($session->getParams("dial"));
     $tropo->say('This is an outbound call.');
  } else {
     $tropo->say('Thank you for calling us.');
  }
  $tropo->renderJSON();
} catch (Exception $e) {
  if ($e->getCode() == '1') {
    // The session object threw an exception, so this file wasn't
    // loaded as part of a Tropo session. Launch a Tropo session.
    if ($tropo->createSession($token, array('dial' => $number))) {
      print 'Call launched to ' . $number;
    }
  }
}
?>
