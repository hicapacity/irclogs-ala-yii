<?php

/**
 * LogsModel class.
 * Encapsulates all Log access/rendering behavior.
 */
class LogsModel extends CFormModel{
	public $log_location;
	public $log_prefix;

	public function __construct(){
		$this->log_location = '/home/paull/irclogs/logs';
		$this->log_prefix = 'hicapacity.log';
	}

	public function getLogFiles(){
		/* Returns an array of all log files available. Returns full path to log file */
		// TODO: Memoize this
		return glob($this->log_location . DIRECTORY_SEPARATOR . $this->log_prefix . '.*');
	}

	private function _extractLogDate($filename){
		// Extracts out the date from the filename
		$pieces = explode('.', $filename);
		return end($pieces);
	}

	private function _filenameFromDate($date){
		// Returns full path filename from date string
		return $this->log_location . DIRECTORY_SEPARATOR . $this->log_prefix . '.' . $date;
	}

	public function getLogDates(){
		/* Returns an array of all log file dates as strings */
		$files = $this->getLogFiles();
		return array_map(array($this, '_extractLogDate'), $files);
	}

	public function getLogFromDate($date){
		/* Return a LogFile object from a particular date */
		$fn = $this->_filenameFromDate($date);
		return new LogFile($fn);
	}

	public function validateDate($date){
		/* Makes sure the date is valid. */
		return ctype_digit($date) && strlen($date) === 8;
	}
}

class LogLine{
	/* Encapsulates behavior of a line of a log */
	private $raw; // Raw string
	public $time;
	public $type; // 'speech' or 'action'
	public $speaker;
	public $text;

	public function __construct($line){
		$this->raw = $line;
		$this->parse();
		$this->funkify();
	}
	
	private function parse(){
		/* Figure out what all the parts are */
		// We currently assume logs look like:
		//   [12:34] <someguy> This is what I said
		// TODO: Give constructor a format string (logs won't always be in this format)
		$pieces = explode(' ', $this->raw, 3);
		$this->time = substr($pieces[0], 1, 5);
		if ($pieces[1][0] === '<'){
			$this->type = 'speech';
			$this->speaker = substr($pieces[1], 1, -1);
			$this->text = $pieces[2];
		}else{
			$this->type = 'action';
			$this->speaker = $pieces[1];
			$this->text = $pieces[2];
		}
	}

	private function funkify(){
		/* During development/testing we'll funk up all the text */
		if ($this->type === 'speech'){
			$arr = range('a', 'z');
			$arrb = $arr;
			shuffle($arrb);
			$this->text = str_replace($arr, $arrb, $this->text);
		}
	}
}

class LogFile{
	private $file;
	public function __construct($date){
		$this->file = file($date, FILE_IGNORE_NEW_LINES ^ FILE_SKIP_EMPTY_LINES);
	}

	public function getLines(){
		return $this->file;
	}
}
