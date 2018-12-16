<?php namespace Performance\Lib\Holders;

class QueryLineHolder{
	protected $line;
	protected $time;

	/**
	 * @return string
	 */
	public function getLine() {
		return $this->line;
	}

	/**
	 * @param mixed $line
	 */
	public function setLine($line) {
		$this->line = $line;
	}

	/**
	 * @return string
	 */
	public function getTime() {
		return $this->time;
	}

	/**
	 * @param mixed $time
	 */
	public function setTime($time) {
		$this->time = number_format((float)$time, 2, '.', '');
	}
}
