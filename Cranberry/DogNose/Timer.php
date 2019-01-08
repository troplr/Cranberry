<?php

namespace DN;

class Timer{
	private $start_time = false;
	private $stop_time = false;

	public function __construct(){
		//
	}

	public function start(){
		$this->start_time = microtime(true);
		$this->stop_time = false;

		return $this->start_time;
	}

	public function get_elapsed_time(){
		if($this->start_time !== false and $this->stop_time !== false){
			return $this->stop_time - $this->start_time;
		}
		elseif($this->start_time !== false){
			return microtime(true) - $this->start_time;
		}
		else{
			return -1;
		}
	}

	public function stop(){
		$this->stop_time = microtime(true);

		return $this->get_elapsed_time();
	}

	public function lap(){
		$this->stop();
		$t = $this->get_elapsed_time();
		$this->start();
		return $t;
	}
}