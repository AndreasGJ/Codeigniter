<?php
if(!function_exists('add_filter')){
	function add_filter($tag, $func, $priority = 10, $accepted_args = 1){
		$ci =& get_instance();
		return $ci->event_handler->add_filter($tag, $func, $priority, $accepted_args);
	}
}
if(!function_exists('has_filter')){
	function has_filter($tag){
		$ci =& get_instance();
		return $ci->event_handler->has_filter($tag);
	}
}
if(!function_exists('do_filter')){
	function do_filter($tag, $value){
		$ci =& get_instance();
		return $ci->event_handler->do_filter($tag, $value);
	}
}

if(!function_exists('add_action')){
	function add_action($tag, $func, $priority = 10, $accepted_args = 1){
		$ci =& get_instance();
		return $ci->event_handler->add_action($tag, $func, $priority, $accepted_args);
	}
}
if(!function_exists('has_action')){
	function has_action($tag){
		$ci =& get_instance();
		return $ci->event_handler->has_action($tag);
	}
}
if(!function_exists('do_action')){
	function do_action($tag, $value){
		$ci =& get_instance();
		return $ci->event_handler->do_action($tag, $value);
	}
}
