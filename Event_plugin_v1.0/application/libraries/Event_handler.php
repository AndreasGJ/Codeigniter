<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event_handler {
	private $filters = array();
	private $hooks = array();
	
	public function __construct(){
		$ci =& get_instance();
		$ci->load->helper('event_handler');
	}
	
	public function add_filter($tag, $func, $priority = 10, $accepted_args = 1){
		if(!isset($this->filters[$tag])) $this->filters[$tag] = array();
		
		while(isset($this->filters[$tag][$priority])){
			$priority--;
		}
		$this->filters[$tag][$priority] = array(
			'function' => $func,
			'args_count' => $accepted_args
		);
	}
	public function has_filter($tag){
		if(isset($this->filters[$tag]) && $this->filters[$tag] && count($this->filters[$tag]) > 0){
			return true;
		}
		return false;
	}
	public function do_filter($tag, $value){
		$args = func_get_args();
		unset($args[0]);
		if(isset($this->filters[$tag]) && $this->filters[$tag] && count($this->filters[$tag]) > 0){
			ksort($this->filters[$tag]);
			$num_args = count($args);
			foreach($this->filters[$tag] as $func){
				if($num_args >= $func['args_count']){
					$value = call_user_func_array($func['function'], $args);
					$args[1] = $value;
				}
			}
		}
		return $value;
	}
	
	public function add_action($tag, $func, $priority = 10, $accepted_args = 1){
		if(!isset($this->hooks[$tag])) $this->hooks[$tag] = array();
		
		while(isset($this->hooks[$tag][$priority])){
			$priority--;
		}
		$this->hooks[$tag][$priority] = array(
			'function' => $func,
			'args_count' => $accepted_args
		);
	}
	public function has_action($tag){
		if(isset($this->hooks[$tag]) && $this->hooks[$tag] && count($this->hooks[$tag]) > 0){
			return true;
		}
		return false;
	}
	public function do_action($tag){
		$args = func_get_args();
		unset($args[0]);
		if(isset($this->hooks[$tag]) && $this->hooks[$tag] && count($this->hooks[$tag]) > 0){
			ksort($this->hooks[$tag]);
			$num_args = count($args);
			foreach($this->hooks[$tag] as $func){
				if($num_args >= $func['args_count']){
					call_user_func_array($func['function'], $args);
				}
			}
		}
	}
}
