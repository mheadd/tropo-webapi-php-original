<?php
/**
 * A sample application that demonstrates the use of the TropoPHP packeage.
 * @copyright 2010 Mark J. Headd (http://www.voiceingov.org)
 */

// Include Tropo classes.
require('TropoClasses.php');

// Include Limonade framework (http://www.limonade-php.net/).
require('path/to/limonade/lib/limonade.php');

// The URL to the Google weather service. Renders as XML doc.
define("GOOGLE_WEATHER_URL", "http://www.google.com/ig/api?weather=%zip%&hl=en");

// A helper method to get weather details by zip code.
function getWeather($zip) {
	
	$url = str_replace("%zip", $zip, GOOGLE_WEATHER_URL);
	$weatherXML = simplexml_load_file($url);
	$city = $weatherXML->weather->forecast_information->city["data"];
	$current_conditions = $weatherXML->weather->current_conditions;
	$current_weather = array(
				"condition" => $current_conditions->condition["data"], 
				"temperature" => $current_conditions->temp_f["data"]." degrees", 
				"wind" => formatDirection($current_conditions->wind_condition["data"]),
				"city" => $city
	);
	return $current_weather;
	
}

// A helper method to format directional abbreviations.
function formatDirection($wind) {
	$abbreviated = array(" N ", " S ", " E ", " W ", " NE ", " SE ", " SW ", " NW ");
	$full_name = array(" North ", " South ", " East ", " West ", " North East ", " South East ", " South West ", " North West ");
	return str_replace($abbreviated, $full_name, str_replace("mph", "miles per hour", $wind));
}

// The starting point for the Tropo Weather demo.
// Set up the start URL for this application as http://host/path/to/script/WeatherDemo.php?uri=start
dispatch_post('/start', 'demo_start');
function demo_start() {

	$session = new Session();
	$from_info = $session->getFrom();
	$network = $from_info[3];
	
	$tropo = new Tropo();
	$tropo->say("Welcome to the Tropo PHP weather demo for $network.");
	$options = array("attempts" => 3, "bargein" => true, "choices" => "[5 DIGITS]", "name" => "zip", "timeout" => 5);
	$tropo->ask("Please enter your 5 digit zip code.", $options);
	$tropo->on(array("event" => "continue", "next" => "WeatherDemo.php?uri=end", "say" => "Please hold."));
	$tropo->on(array("event" => "error", "next" => "WeatherDemo.php?uri=error", "say" => "You seem to be having trouble."));
	return $tropo->RenderJson();
	
}

// Get the zip code submitted by the user and look up the weather in that area.
dispatch_post('/end', 'demo_end');
function demo_end() {
	
	$result = new Result();
	$zip = $result->getValue();
		
	$weather_info = getWeather($zip);
	$city = array_pop($weather_info);
	
	$tropo = new Tropo();
	$tropo->say("The current weather for $city is...");

	foreach ($weather_info as $info) {
		$tropo->say("$info.");
	}
	
	$tropo->say("Thank you for calling. Goodbye.");
	$tropo->hangup();
	return $tropo->RenderJson();
	
}

// If an error occurs, tell the user and bail.
dispatch_post('/error', 'demo_error');
function demo_error() {
	
	$tropo = new Tropo();
	$tropo->say("Please try your request again later.");
	$tropo->hangup();
	return $tropo->renderJSON();	
}

// Run this sucker!
run();

?>