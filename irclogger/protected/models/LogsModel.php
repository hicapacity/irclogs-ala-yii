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
		$fn = $this->_filenameFromDate($date);
		return new LogFile($fn);
	}

	public function validateDate($date){
		return ctype_digit($date) && strlen($date) === 8;
	}
}

class LogLine{
	private $raw;
	public $time;
	public $type;
	public $speaker;
	public $text;

	public function __construct($line){
		$this->raw = $line;
		$this->parse();
		$this->funkify();
	}
	
	private function parse(){
		$pieces = explode(" ", $this->raw, 3);
		$this->time = substr($pieces[0], 1, 5);
		if ($pieces[1][0] === '<'){
			$this->type = "speech";
			$this->speaker = substr($pieces[1], 1, -1);
			$this->text = $pieces[2];
		}else{
			$this->type = "action";
			$this->speaker = $pieces[1];
			$this->text = $pieces[2];
		}
	}

	private function funkify(){
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
