<?php

/**
 * 
 * @copyright 2010 Mark J. Headd (http://www.voiceingov.org)
 * @package TropoPHP: A set of PHP classes for working with the Voxeo Tropo WebAPI.
 * @author Mark Headd
 * @author Adam Kalsey
 */

/**
 * Base classes for Tropo class and indvidual Tropo action classes.
 * Derived classes must implement both a constructor and toString function.
 * @abstract BaseClass
 */

abstract class BaseClass {
	
	/**
	 * Class constructor
	 * @abstract __construct()
	 */
	abstract public function __construct();
	
	/**
	 * toString Function
	 * @abstract __toString()
	 */
	abstract public function __toString();
	
	/**
	 * Allows derived classes to set Undeclared properties.
	 *
	 * @param mixed $attribute
	 * @param mixed $value
	 */
	private function __set($attribute, $value) {
		$this->$attribute= $value;
	}
	
	/**
	 * Removes escape characters from a JSON string.
	 *
	 * @param string $json
	 * @return string
	 */
	public function unescapeJSON($json) {
	  return str_replace(array("\\", "\"{", "}\""), array("", "{", "}"), $json);
	}
}

/**
 * Base class for empty actions.
 *
 */
class EmptyBaseClass {	
	
	final public function __toString() { 
		return json_encode(null);
	}	
}

/**
 * The main Tropo class
 *
 */
class Tropo extends BaseClass {
	
	public $tropo;
	
	public function __construct() {
		$this->tropo = array();
	}
	
	public function ask($ask, Array $params=NULL) {
		if(!is_object($ask)) {
			$say = new Say($ask);
			$choices = isset($params["choices"]) ? new Choices($params["choices"]) : null;
			$p = array('attempts', 'bargein', 'minConfidence', 'name', 'required', 'timeout');
			foreach ($p as $option) {
		  	    if (array_key_exists($option, $params)) {
		  	      $$option = $params[$option];
		  	    }
	  	  	}
	  	  	$ask = new Ask($attempts, $bargein, $choices, $minConfidence, $name, $required, $say, $timeout);
		}
		$this->ask = sprintf($ask);
	}

	public function call($call, Array $params=NULL) {
	if(!is_object($call)) {
  	  $p = array('call', 'from', 'network', 'channel', 'answerOnMedia', 'timeout', 'headers', 'recording');
  	  foreach ($p as $option) {
  	    if (array_key_exists($option, $params)) {
  	      $$option = $params[$option];
  	    }
  	  }
		$call = new Call($call, $from, $network, $channel, $answerOnMedia, $timeout, $headers, $recording);
	}
		$this->call = sprintf($call);
	}
	
	public function conference($conference, Array $params=NULL) {
		if(!is_object($conference)) {
			$p = array('name', 'id', 'mute', 'on', 'playTones', 'required', 'terminator');
		  	foreach ($p as $option) {
		  	    if (array_key_exists($option, $params)) {
		  	      $$option = $params[$option];
		  	    }
	  	  	}
	  	  	$conference = new Conference($name, $id, $mute, $on, $playTones, $required, $terminator);
		}
		$this->conference = sprintf($conference);
	}
	
	public function hangup() {
		$hangup = new Hangup();
		$this->hangup = sprintf($hangup);
	}
	
	public function on(Array $params) {		
		$on = new On($params["event"], $params["next"], $params["null"]);
		$this->on = sprintf($on);
	}
	
	public function record($record, Array $params=NULL) {
		if(!is_object($record)) {
			$choices = isset($params["choices"]) ? new Choices($params["choices"]) : null;
			$say = $params["say"];
			$transcription =$params["transcription"];
			$p = array('attempts', 'bargein', 'beep', 'format', 'maxSilence', 'method', 'password', 'required', 'timeout', 'username');
			foreach ($p as $option) {
		  	    if (array_key_exists($option, $params)) {
		  	      $$option = $params[$option];
		  	    }
	  	  	}
	  	  	$record = new Record($attempts, $bargein, $beep, $choices, $format, $maxSilence, $maxTime, $method, $password, $required, $say, $timeout, $transcription, $username);
		}
		$this->record = sprintf($record);		
	}
	
	public function redirect($redirect, Array $params=NULL) {
		if(!is_object($redirect)) {
			$to = isset($params["to"]) ? $params["to"]: null;
			$from = isset($params["from"]) ? $params["to"] : null;
			$redirect = new Redirect($to, $from);
		}
		$this->redirect = sprintf($redirect);
	}
	
	public function reject() {
		$reject = new Reject();
		$this->reject = sprintf($reject);
	}
	
	public function say($say, Array $params=NULL) {
		if(!is_object($say)) {
			$p = array('value', 'as', 'format', 'event');
			foreach ($p as $option) {
		  	    if (array_key_exists($option, $params)) {
		  	      $$option = $params[$option];
		  	    }
	  	  	}
	  	  	$say = new Say($value, $as, $event, $format);
		}
		$this->say = array(sprintf($say));	
	}
	
	public function startRecording($startRecording, Array $params=NULL) {
		if(!is_object($startRecording)) {
			$p = array('format', 'method', 'password', 'url', 'username');
			foreach ($p as $option) {
		  	    if (array_key_exists($option, $params)) {
		  	      $$option = $params[$option];
		  	    }
	  	  	}
	  	  	$startRecording = new StartRecording($format, $method, $password, $url, $username);
		}		
		$this->startRecording = sprintf($startRecording);
	}
	
	public function stopRecording() {
		$stopRecording = new stopRecording();
		$this->stopRecording = sprintf($stopRecording);
	}
	
	public function transfer($transfer, Array $params=NULL) {
		if(!is_object($transfer)) {
			$choices = isset($params["choices"]) ? new Choices($params["choices"]) : null;
			$to = isset($params["to"]) ? $params["to"]: null;
			$from = isset($params["from"]) ? $params["to"] : null;
			$on = isset($params["on"]) ? new On($params["on"]) : null;
			$p = array('answerOnMedia', 'ringRepeat', 'timeout');
			foreach ($p as $option) {
		  	    if (array_key_exists($option, $params)) {
		  	      $$option = $params[$option];
		  	    }
	  	  	}
	  	  	$transfer = new Transfer($to, $answerOnMedia, $choices, $from, $on, $ringRepeat, $timeout);
		}
		$this->transfer = sprintf($transfer);
	}
	
	public function renderJSON() {
		header('Content-type: application/json');
		echo $this;
	}
	
	private function __set($name, $value) {
		array_push($this->tropo, array($name => $value));
	}	
	
	public function __toString() {
		return $this->unescapeJSON(json_encode($this));	
	}	
}

/**
 * Action classes. Each object represents a specific Tropo action.
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
		return $this->unescapeJSON(json_encode($this));
	}
}

/**
 * This object allows Tropo to make an outbound call. The call can be over voice or one
 * of the text channels. 
 *
 */
class Call extends BaseClass {
	
	private $_to;
	private $_from;
	private $_network;
	private $_channel;
	private $_answerOnMedia;
	private $_timeout;
	private $_headers; 
	private $_recording;
	
	/**
	 * Class constructor
	 *
	 * @param string $to
	 * @param string $from
	 * @param string $network
	 * @param string $channel
	 * @param boolean $answerOnMedia
	 * @param int $timeout
	 * @param array $headers
	 * @param StartRecording $recording
	 */
	public function __construct($to, $from=NULL, $network=NULL, $channel=NULL, $answerOnMedia=NULL, $timeout=NULL, Array $headers=NULL, StartRecording $recording=NULL) {
		$this->_to = $to;
		$this->_from = $from;		
		$this->_network = $network;		
		$this->_channel = $channel;		
		$this->_answerOnMedia = $answerOnMedia;		
		$this->_timeout = $timeout;
		$this->_headers = $headers;
		$this->_recording = isset($recording) ? sprintf($recording) : null ;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		$this->to = $this->_to;
		if(isset($this->_from)) { $this->from = $this->_from; }
		if(isset($this->_network)) { $this->network = $this->_network; }
		if(isset($this->_channel)) { $this->channel = $this->_channel; }
		if(isset($this->_timeout)) { $this->timeout = $this->_timeout; }		
		if(isset($this->_answerOnMedia)) { $this->answerOnMedia = $this->_answerOnMedia; }
		if(count($this->_headers)) { $this->headers = $this->_headers; }		
		if(isset($this->_recording)) { $this->recording = $this->_recording; }		
		return $this->unescapeJSON(json_encode($this));	
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
		return $this->unescapeJSON(json_encode($this));	
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
		return $this->unescapeJSON(json_encode($this));	
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
		return $this->unescapeJSON(json_encode($this));	
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
	private $_maxTime;
	private $_method;
	private $_password;
	private $_required;
	private $_say;
	private $_timeout;
	private $_transcription;
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
	public function __construct($attempts=NULL, $bargein=NULL, $beep=NULL, Choices $choices=NULL, $format=NULL, $maxSilence=NULL, $maxTime=NULL, $method=NULL, $password=NULL, $required=NULL, $say=NULL, $timeout=NULL, $transcription=NULL, $username=NULL) {
		$this->_attempts = $attempts;
		$this->_bargein = $bargein;
		$this->_beep = $beep;
		$this->_choices = isset($choices) ? sprintf($choices) : null;
		$this->_format = $format;
		$this->_maxSilence = $maxSilence;
		$this->_maxTime = $maxTime;
		$this->_method = $method;
		$this->_password = $password;
		$this->_say = isset($say) ? sprintf($say) : null;
		$this->_timeout = $timeout;
		$this->_transcription = isset($transcription) ? sprintf($transcription) : null;
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
		if(isset($this->_maxTime)) { $this->maxTime = $this->_maxTime; }
		if(isset($this->_method)) { $this->method = $this->_method; }
		if(isset($this->_password)) { $this->password = $this->_password; }
		if(isset($this->_say)) { $this->say = $this->_say; }
		if(isset($this->_timeout)) { $this->timeout = $this->_timeout; }
		if(isset($this->_transcription)) { $this->transcription = $this->_transcription; }	
		if(isset($this->_username)) { $this->username = $this->_username; }		
		return $this->unescapeJSON(json_encode($this));	
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
	 * @param Endpoint $to
	 * @param Endpoint $from
	 */
	public function __construct($to=NULL, $from=NULL) {
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
		return $this->unescapeJSON(json_encode($this));	
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
	public function __construct($json=NULL) {
		if(empty($json)) {
	 		$json = file_get_contents("php://input");
	 	}
		$result = json_decode($json);
		$this->_sessionId = $result->result->sessionId;
		$this->_state = $result->result->state;
		$this->_sessionDuration = $result->result->sessionDuration;
		$this->_sequence = $result->result->sequence;
		$this->_complete = $result->result->complete;
		$this->_error = $result->result->error;
		$this->_actions = $result->result->actions;		
		$this->_name = $result->result->actions->name;
		$this->_attempts = $result->result->actions->attempts;
		$this->_disposition = $result->result->actions->disposition;
		$this->_confidence = $result->result->actions->confidence;
		$this->_interpretation = $result->result->actions->interpretation;
		$this->_utterance = $result->result->actions->utterance;
		$this->_value = $result->result->actions->value;
		
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
		return $this->unescapeJSON(json_encode($this));	
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
	public function __construct($json=NULL) {
		if(empty($json)) {
	 		$json = file_get_contents("php://input");
	 	}
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
	public function __construct($format=NULL, $method=NULL, $password=NULL, $url=NULL, $username=NULL) {		
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
		if(isset($this->_format)) { $this->format = $this->_format; }
		if(isset($this->_method)) { $this->method = $this->_method; }
		if(isset($this->_password)) { $this->password = $this->_password; }
		if(isset($this->_url)) { $this->url = $this->_url; }
		if(isset($this->_username)) { $this->username = $this->_username; }		
		return $this->unescapeJSON(json_encode($this));	
	}	
}

class StopRecording extends EmptyBaseClass { }

class Transcription extends BaseClass {
	
	private $_url;
	private $_id;
	private $_emailFormat;
	
	/**
	 * Class constructor
	 *
	 * @param string $url
	 * @param string $id
	 * @param string $emailFormat
	 */
	public function __construct($url, $id=NULL, $emailFormat=NULL) {
		$this->_url = $url;
		$this->_id = $id;
		$this->_emailFormat = $emailFormat;
	}
	
	/**
	 * Renders object in JSON format.
	 *
	 */
	public function __toString() {
		if(isset($this->_id)) { $this->id = $this->_id; }
		if(isset($this->_url)) { $this->url = $this->_url; }
		if(isset($this->_emailFormat)) { $this->emailFormat = $this->_emailFormat; }
		return $this->unescapeJSON(json_encode($this));	
	}
}

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
	 * @param Endpoint $to
	 * @param boolean $answerOnMedia
	 * @param Choices $choices
	 * @param Endpoint $from
	 * @param On $on
	 * @param int $ringRepeat
	 * @param int $timeout
	 */
	public function __construct(Endpoint $to, $answerOnMedia=NULL, Choices $choices=NULL, Endpoint $from=NULL, On $on=NULL, $ringRepeat=NULL, $timeout=NULL) {
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
		return $this->unescapeJSON(json_encode($this));			
	}	
}

/**
 * Defnies an endoint for transfer and redirects.
 *
 */
class Endpoint extends BaseClass {
	
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
		return $this->unescapeJSON(json_encode($this));			
	}
}


/**
 * Helper classes. These object are used with action classes to set option values.
 *
 * TODO: Need to complete properties for attribute classes.
 */

class Date {
	public static $monthDayYear = "mdy";
	public static $dayMonthYear = "dmy";
	public static $yearMonthDay = "ymd";
	public static $yearMonth = "ym";
	public static $monthYear = "my";
	public static $monthDay = "md";
	public static $year = "y";
	public static $month = "m";
	public static $day = "d";		
}

class Duration {
	public static $hoursMinutesSeconds = "hms";
	public static $hoursMinutes = "hm";	
	public static $hours = "h";
	public static $minutes = "m";
	public static $seconds = "s";
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
	public static $twitter = "TWITTER";
}

class Channel {
	public static $voice = "VOICE";
	public static $text = "TEXT";
}

class AudioFormat {
	public static $wav = "audio/wav";
	public static $mp3 = "audio/mp3";
}

?>