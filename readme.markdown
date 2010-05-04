Overview
========

TropoPHP is a set of PHP classes for working with Tropo's cloud communication service. Tropo allows a developer to create applications that run over the phone, IM, SMS, and Twitter using web technologies. This library communicates with Tropo over JSON.

Usage
=====

<?php
require 'TropoPHP.php';

$tropo = new Tropo();
// Use Tropo's text to speech to say a sentance.
$tropo->Say('Yes, Tropo is this easy.');

// Render the JSON back to Tropo
$tropo->RenderJSON();
?>