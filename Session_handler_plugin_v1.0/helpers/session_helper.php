<?php

if(!function_exists('add_session_data')){
	function add_session_data($key, $value, $multiple = false, $only_to = false){
		$ci =& get_instance();
		$ci->load->model('session_handler_model');
		return $ci->session_handler_model->add_session_data($key, $value, $multiple, $only_to);
	}
}

if(!function_exists('get_session_data')){
	function get_session_data($key, $multiple = false, $only_to = false){
		$ci =& get_instance();
		$ci->load->model('session_handler_model');
		return $ci->session_handler_model->get_session_data($key, $multiple, $only_to);
	}
}
