<?php

/**
 * 
 * Copyright 2010 Mark J. Headd
 * http://www.voiceingov.org
 * 
 * A set of PHP classes for working with the Voxeo Tropo WebAPI
 *
 */

/**
 * The main Tropo class
 *
 */
class Tropo {
	
	const TROPO_QUERYSTRING = "tropo-engine=json";
	
	public $tropo = array();
	
	public function Ask(Ask $ask) {
		$this->ask = sprintf($ask);
	}

	public function Conference($conference) {
		if(!is_object($conference)) {
			$conference = new Conference($conference);
		}
		$this->conference = sprintf($conference);
	}
	
	public function Hangup() {
		$hangup = new Hangup();
		$this->hangup = sprintf($hangup);
	}
	
	public function On(On $on) {
		$this->on = sprintf($on);
	}
	
	public function Record(Record $record) {
		$this->record = sprintf($record);
	}
	
	public function Redirect($redirect) {
		if(!is_object($redirect)) {
			$to = new EndPointObject($redirect);
			$redirect = new Redirect($to);
		}
		$this->redirect = sprintf($redirect);
	}
	
	public function Reject() {
		$reject = new Reject();
		$this->reject = sprintf($reject);
	}
	
	public function Result(Result $result) {
		$this->result = sprintf($result);
	}
	
	public function Say($say) {
		if(!is_object($say)) {
			$say = new Say($say);
		} 
		$this->say = array(sprintf($say));	
	}
	
	public function StartRecording(StartRecording $startRecording) {
		$this->startRecording = sprintf($startRecording);
	}
	
	public function StopRecording() {
		$stopRecording = new stopRecording();
		$this->stopRecording = sprintf($stopRecording);
	}
	
	public function Transfer($transfer) {
		if(!is_object($transfer)) {
			$to = new EndPointObject($transfer);
			$transfer = new Transfer($to);
		}
		$this->transfer = sprintf($transfer);
	}
	
	public function RenderJSON() {
		header('Content-type: application/json');
		echo $this;
	}
	
	private function __set($name, $value) {
		array_push($this->tropo, array($name => $value));
	}	
	
	private function __toString() {
		if(!strstr($_SERVER['REQUEST_URI'], self::TROPO_QUERYSTRING)) {
			die('*** Start URL for script must include querystring ?'.self::TROPO_QUERYSTRING.' ***');
		} 
		else {
			return str_replace(array("\\", "\"{", "}\""), array("", "{", "}"), json_encode($this));	
		}		
	}
	
}

/**
 * Base classes for different Tropo actions.
 *
 */

abstract class BaseClass {
	
	// Derived classes must implement both a constructor and toString function.
	abstract public function __construct();
	abstract public function __toString();
	
	// Allows derived classes to set undeclared properties.
	private function __set($attribute, $value) {
		$this->$attribute= $value;
	}	
}

/**
 * Base classe for empty actions.
 *
 */
class EmptyBaseClass {	
	
	final public function __toString() { 
		return json_encode(null);
	}	
}

/**
 * Action classes. Each object represents a Tropo action.
 *
 */

/**
 * Sends a prompt to the user and optionally waits for a response.
 *
 */
class Ask extends BaseClass {
	
	private $_attempts;
	private $_bargein;
	private $_choices;
	private $_minConfidence;
	private $_name;
	private $_requied;
	private $_say;
	private $_timeout;
	
	/**
	 * Class constructor
	 *
	 * @param int $attempts
	 * @param boolean $bargein
	 * @param Choices $choices
	 * @param float $minConfidence
	 * @param string $name
	 * @param boolean $requied
	 * @param Say $say
	 * @param int $timeout
	 */
	public function __construct($attempts=NULL, $bargein=NULL, Choices $choices=NULL, $minConfidence=NULL, $name=NULL, $requied=NULL, Say $say=NULL, $timeout=NULL) {
		$this->_attempts = $attempts;
		$this->_bargein = $bargein;
		$this->_choices = isset($choices) ? sprintf($choices) : null ;
		$this->_minConfidence = $minConfidence;
		$this->_name = $name;
		$this->_requied = $requied;
		$this->_say = isset($say) ? sprintf($say) : null;
		$this->_timeout = $timeout;		
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		if(isset($this->_attempts)) { $this->attempts = $this->_attempts; }
		if(isset($this->_bargein)) { $this->bargein = $this->_bargein; }
		if(isset($this->_choices)) { $this->choices = $this->_choices; }
		if(isset($this->_minConfidence)) { $this->minConfidence = $this->_minConfidence; }
		if(isset($this->_name)) { $this->name = $this->_name; }
		if(isset($this->_requied)) { $this->requied = $this->_requied; }
		if(isset($this->_say)) { $this->say = $this->_say; }
		if(isset($this->_timeout)) { $this->timeout = $this->_timeout; }		
		return json_encode($this);
	}
}

/**
 * Defines the input to be collected from the user.
 *
 */
class Choices extends BaseClass {
	
	private $_value;
	private $_mode;
	private $_termChar;
	
	/**
	 * Class constructor
	 *
	 * @param string $value
	 * @param string $mode
	 * @param string $termChar
	 */
	public function __construct($value, $mode=NULL, $termChar=NULL) {
		$this->_value = $value;
		$this->_mode = $mode;
		$this->_termChar = $termChar;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		$this->value = $this->_value;
		if(isset($this->_mode)) { $this->mode = $this->_mode; }
		if(isset($this->_termChar)) { $this->termChar = $this->_termChar; }	
		return json_encode($this);
	}
}

/**
 * This object allows multiple lines in separate sessions to be conferenced together so that 
 *   the parties on each line can talk to each other simultaneously. 
 *   This is a voice channel only feature. 
 * 
 * TODO: Conference object should support multiple event handlers (e.g. join and leave).
 *
 */
class Conference extends BaseClass {
	
	private $_id;
	private $_mute;
	private $_name;
	private $_on;
	private $_playTones;
	private $_required;
	private $_terminator;
	
	/**
	 * Class constructor
	 *
	 * @param int $id
	 * @param boolean $mute
	 * @param string $name
	 * @param On $on
	 * @param boolean $playTones
	 * @param boolean $required
	 * @param string $terminator
	 */
	public function __construct($name, $id=NULL, $mute=NULL, On $on=NULL, $playTones=NULL, $required=NULL, $terminator=NULL) {
		$this->_name = $name;
		$this->_id = $id;
		$this->_mute = $mute;		
		$this->_on = isset($on) ? sprintf($on) : null;
		$this->_playTones = $playTones;
		$this->_required = $required;
		$this->_terminator = $terminator;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		$this->name = $this->_name;
		if(isset($this->_id)) { $this->id = $this->_id; }
		if(isset($this->_mute)) { $this->mute = $this->_mute; }
		if(isset($this->_on)) { $this->on = $this->_on; }
		if(isset($this->_playTones)) { $this->playTones = $this->_playTones; }
		if(isset($this->_required)) { $this->required = $this->_required; }
		if(isset($this->_terminator)) { $this->terminator = $this->_terminator; }		
		return json_encode($this);
	}	
}

/**
 * This function instructs Tropo to "hang-up" or disconnect the session associated with the current session. 
 *
 */
class Hangup extends EmptyBaseClass { }

/**
 * Adds an event callback so that your application may be notified when a particular event occurs
 *
 */
class On extends BaseClass {
	
	private $_event;
	private $_next;
	private $_say;
	
	/**
	 * Class constructor
	 *
	 * @param string $event
	 * @param string $next
	 * @param Say $say
	 */
	public function __construct($event=NULL, $next=NULL, Say $say=NULL) {
		$this->_event = $event;
		$this->_next = $next;
		$this->_say = isset($say) ? sprintf($say) : null ;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		if(isset($this->_event)) { $this->event = $this->_event; }
		if(isset($this->_next)) { $this->next = $this->_next; }
		if(isset($this->_say)) { $this->say = $this->_say; }		
		return json_encode($this);
	}
}

/**
 * Plays a prompt (audio file or text to speech) and optionally waits for a response from the caller that is recorded. 
 *
 */
class Record extends BaseClass {
	
	private $_attempts;
	private $_bargein;
	private $_beep;
	private $_choices;
	private $_format;
	private $_maxSilence;
	private $_method;
	private $_password;
	private $_required;
	private $_say;
	private $_timeout;
	private $_username;
	
	/**
	 * Class constructor
	 *
	 * @param int $attempts
	 * @param boolean $bargein
	 * @param boolean $beep
	 * @param Choices $choices
	 * @param string $format
	 * @param int $maxSilence
	 * @param string $method
	 * @param string $password
	 * @param boolean $required
	 * @param Say $say
	 * @param int $timeout
	 * @param string $username
	 */
	public function __construct($attempts, $bargein, $beep, Choices $choices, $format, $maxSilence, $method, $password, $required, Say $say, $timeout, $username) {
		$this->_attempts = $attempts;
		$this->_bargein = $bargein;
		$this->_beep = $beep;
		$this->_choices = isset($choices) ? sprintf($choices) : null;
		$this->_format = $format;
		$this->_maxSilence = $maxSilence;
		$this->_method = $method;
		$this->_password = $password;
		$this->_say = isset($say) ? sprintf($say) : null;
		$this->_timeout = $timeout;
		$this->_username = $username;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		if(isset($this->_attempts)) { $this->attempts = $this->_attempts; }
		if(isset($this->_bargein)) { $this->bargein = $this->_bargein; }
		if(isset($this->_beep)) { $this->beep = $this->_beep; }
		if(isset($this->_choices)) { $this->choices = $this->_choices; }
		if(isset($this->_format)) { $this->format = $this->_format; }
		if(isset($this->_maxSilence)) { $this->maxSilence = $this->_maxSilence; }
		if(isset($this->_method)) { $this->method = $this->_method; }
		if(isset($this->_password)) { $this->password = $this->_password; }
		if(isset($this->_say)) { $this->say = $this->_say; }
		if(isset($this->_timeout)) { $this->timeout = $this->_timeout; }
		if(isset($this->_username)) { $this->username = $this->_username; }		
		return json_encode($this);
	}
}

/**
 * The redirect function forwards an incoming call to another destination / phone number before answering it.
 *
 */
class Redirect extends BaseClass {
	
	private $_to;
	private $_from;
	
	/**
	 * Class constructor
	 *
	 * @param EndpointObject $to
	 * @param EndpointObject $from
	 */
	public function __construct($to, EndpointObject $from=NULL) {
		$this->_to = sprintf($to);
		$this->_from = isset($from) ? sprintf($from) : null;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		$this->to = $this->_to;
		if(isset($this->_from)) { $this->from = $this->_from; }		
		return json_encode($this);
	}
}

/**
 * Allows Tropo applications to reject incoming sessions before they are answered.
 *
 */
class Reject extends EmptyBaseClass { }

/**
 * Returned anytime a request is made to the Tropo Web API. 
 *
 */
class Result {
	
	private $_sessionId;
	private $_state;
	private $_sessionDuration;
	private $_sequence;
	private $_complete;
	private $_error;
	private $_actions;
	private $_name;
    private $_attempts;
    private $_disposition;
    private $_confidence;
    private $_interpretation;
    private $_utterance;
    private $_value;
	
	/**
	 * Class constructor
	 *
	 * @param string $json
	 */
	public function __construct($json) {
		$result = json_decode($json);
		$this->_sessionId = $result->result->sessionId;
		$this->_state = $result->result->state;
		$this->_sessionDuration = $result->result->sessionDuration;
		$this->_sequence = $result->result->sequence;
		$this->_complete = $result->result->complete;
		$this->_error = $result->result->error;
		$this->_actions = $result->result->actions;		
		$this->_name = $result->result->actions[0]->name;
		$this->_attempts = $result->result->actions[0]->attempts;
		$this->_disposition = $result->result->actions[0]->disposition;
		$this->_confidence = $result->result->actions[0]->confidence;
		$this->_interpretation = $result->result->actions[0]->interpretation;
		$this->_utterance = $result->result->actions[0]->utterance;
		$this->_value = $result->result->actions[0]->value;
		
	}
	
	function getSessionId() {
		return $this->_sessionId;
	}
	
	function getState() {
		return $this->_state;
	}
	
	function getSessionDuration() {
		return $this->_sessionDuration;
	}
	
	function getSequence() {
		return $this->_sequence;
	}
	
	function isComplete() {
		return (bool) $this->_complete;
	}
	
	function getError() {
		return $this->_error;
	}
	
	function getActions() {
		return $this->_actions;
	}
	
	function getName() {
		return $this->_name;
	}
	
	function getAttempts() {
		return $this->_attempts;
	}
	
	function getDisposition() {
		return $this->_disposition;
	}
	
	function getConfidence() {
		return $this->_confidence;
	}
	
	function getInterpretation() {
		return $this->_interpretation;
	}
	
	function getUtterance() {
		return $this->_utterance;
	}
	
	function getValue() {
		return $this->_value;
	}
}

/**
 * When the current session is a voice channel this key will either play a message or an audio file from a URL. 
 * In the case of an text channel it will send the text back to the user via i nstant messaging or SMS. 
 *
 */
class Say extends BaseClass {
	
	private $_value;
	private $_as;
	private $_event;
	private $_format;
	
	/**
	 * Class constructor
	 *
	 * @param string $value
	 * @param SayAs $as
	 * @param string $event
	 * @param Format $format
	 */
	public function __construct($value, $as=NULL, $event=NULL, $format=NULL) {
		$this->_value = $value;
		$this->_as = $as;
		$this->_event = $event;
		$this->_format = $format;		
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {		
		$this->value = $this->_value;
		if(isset($this->_as)) { $this->as = $this->_as; }
		if(isset($this->_event)) { $this->event = $this->_event; }
		if(isset($this->_format)) { $this->format = $this->_format; }		
		return json_encode($this);
	}
}

/**
 * The payload sent as an HTTP POST to the web application when a new session arrives.
 *
 * TODO: Consider using associative array for To and From.
 * TODO: Need to break out headers into a more accessible data structure.
 */
class Session {
	
	private $_id;
	private $_accountId;
	private $_timestamp;
	private $_userType;
	private $_initialText;
	private $_to;
	private $_from;
	private $_headers;
	
	/**
	 * Class constructor
	 *
	 * @param string $json
	 */
	public function __construct($json) {
		$session = json_decode($json);
		$this->_id = $session->session->id;
		$this->_accountID = $session->session->accountID;
		$this->_timestamp = $session->session->timestamp;
		$this->_userType = $session->session->userType;
		$this->_initialText = $session->session->initialText;
		$this->_to = array($session->session->to->id, $session->session->to->channel, $session->session->to->name, $session->session->to->network);
		$this->_from = array($session->session->from->id, $session->session->from->channel, $session->session->from->name, $session->session->from->network);
		$this->_headers = $session->session->headers;			
	}
	
	public function getId() {
		return $this->_id;
	}
	
	public function getAccountID() {
		return $this->_accountId;
	}
	
	public function getTimeStamp() {
		return $this->_timestamp;
	}
	public function getUserType() {
		return $this->_userType;	
	}
	
	public function getInitialText() {
		return $this->_initialText;
	}
	
	public function getTo() {
		return $this->_to;
	}
	
	public function getFrom() {
		return $this->_from;
	}
	
	public function getHeaders() {
		return $this->_headers;
	}
}

/**
 * Allows Tropo applications to begin recording the current session. 
 * The resulting recording may then be sent via FTP or an HTTP POST/Multipart Form. 
 * 
 */
class StartRecording extends BaseClass {
	
	private $_name;
	private $_format;
	private $_method;
	private $_password;
	private $_url;
	private $_username;
	
	/**
	 * Class constructor
	 *
	 * @param string $name
	 * @param string $format
	 * @param string $method
	 * @param string $password
	 * @param string $url
	 * @param string $username
	 */
	public function __construct($name, $format=NULL, $method=NULL, $password=NULL, $url=NULL, $username=NULL) {		
		$this->_name = $name;
		$this->_format = $format;
		$this->_method = $method;
		$this->_password = $password;
		$this->_url = $url;
		$this->_username = $username;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {		
		$this->name = $this->_name;
		if(isset($this->_format)) { $this->format = $this->_format; }
		if(isset($this->_method)) { $this->method = $this->_method; }
		if(isset($this->_password)) { $this->password = $this->_password; }
		if(isset($this->_url)) { $this->url = $this->_url; }
		if(isset($this->_username)) { $this->username = $this->_username; }		
		return json_encode($this);
	}	
}

class StopRecording extends EmptyBaseClass { }

/**
 * Transfers an already answered call to another destination / phone number. 
 *
 */
class Transfer extends BaseClass {
	
	private $_answerOnMedia;
	private $_choices;
	private $_from;
	private $_on;
	private $_ringRepeat;
	private $_timeout;
	private $_to;
	
	/**
	 * Class constructor
	 *
	 * @param EndpointObject $to
	 * @param boolean $answerOnMedia
	 * @param Choices $choices
	 * @param EndpointObject $from
	 * @param On $on
	 * @param int $ringRepeat
	 * @param int $timeout
	 */
	public function __construct(EndpointObject $to, $answerOnMedia=NULL, Choices $choices=NULL, EndpointObject $from=NULL, On $on=NULL, $ringRepeat=NULL, $timeout=NULL) {
		$this->_to = sprintf($to);	
		$this->_answerOnMedia = $answerOnMedia;
		$this->_choices = isset($choices) ? sprintf($choices) : null; 
		$this->_from = isset($from) ? sprintf($from) : null;
		$this->_on = isset($on) ? sprintf($on) : null;
		$this->_ringRepeat = $ringRepeat;
		$this->_timeout = $timeout;	
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {		
		$this->to = $this->_to;
		if(isset($this->_answerOnMedia)) { $this->answerOnMedia = $this->_answerOnMedia; }
		if(isset($this->_choices)) { $this->choices = $this->_choices; }
		if(isset($this->_from)) { $this->from = $this->_from; }
		if(isset($this->_on)) { $this->on = $this->_on; }
		if(isset($this->_ringRepeat)) { $this->ringRepeat = $this->_ringRepeat; }
		if(isset($this->_timeout)) { $this->timeout = $this->_timeout; }		
		return json_encode($this);		
	}	
}

/**
 * Defnies an endoint for transfer and redirects.
 *
 */
class EndpointObject extends BaseClass {
	
	private $_id;
	private $_channel;
	private $_name = 'unknown';
	private $_network;
	
	/**
	 * Class constructor
	 *
	 * @param string $id
	 * @param string $channel
	 * @param string $name
	 * @param string $network
	 */
	public function __construct($id, $channel=NULL, $name=NULL, $network=NULL) {
		
		$this->_id = $id;
		$this->_channel = $channel;
		$this->_name = $name;
		$this->_network = $network;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		
		if(isset($this->_id)) { $this->id = $this->_id; }
		if(isset($this->_channel)) { $this->channel = $this->_channel; }
		if(isset($this->_name)) { $this->name = $this->_name; }
		if(isset($this->_network)) { $this->network = $this->_network; }		
		return json_encode($this);		
	}
}


/**
 * Attribute classes. These object are used with action classes to set option values.
 *
 * TODO: Need to complete properties for attribute classes.
 */

class Date {
	public static $monthDayYear = "mdy";
	public static $dayMonthYear = "dmy";
	
}

class Duration {
	public static $hoursMinutesSeconds = "hms";
	public static $hoursMinutes = "hm";	
}

class Event {
	
	public static $continue = 'continue';
	public static $incomplete = 'incomplete';
	public static $error = 'error';
	public static $hangup = 'hangup';
	public static $join = 'join';
	public static $leave = 'leave';
}

class Format {
	public $date;
	public $duration;
	public static $ordinal = "ordinal";
	public static $digits = "digits";
	
	public function __construct($date=NULL, $duration=NULL) {
		$this->date = $date;
		$this->duration = $duration;
	}
}

class SayAs {
	public static $date = "DATE";
	public static $digits = "DIGITS";
	public static $number = "NUMBER";
}

class Network {
	public static $pstn = "PSTN";
	public static $voip = "VOIP";
	public static $aim = "AIM";
	public static $gtalk = "GTALK";
	public static $jabber = "JABBER";
	public static $msn = "MSN";
	public static $sms = "SMS";
	public static $yahoo = "YAHOO";	
}

class Channel {
	public static $voice = "VOICE";
	public static $text = "TEXT";
}

?>