<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Session_handler {
	private $CI;
	private $session_id;
	private $visitor_id;
	
	protected $session_cookie;
	protected $visitor_cookie;
	
	protected $user_id;
	
	protected $current_visitor;
	protected $current_visitor_cookie;
	
	protected $current_session;
	protected $current_session_cookie;
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->config('sessions', TRUE);
		
		$this->CI->load->model('session_handler_model');
		$this->CI->load->helper('cookie');
		$this->CI->load->helper('string');
		
		$this->session_cookie = $this->CI->config->item('session_cookie', 'sessions');
		$this->visitor_cookie = $this->CI->config->item('visitor_cookie', 'sessions');
		$this->is_ssl = false;
		
		$this->init();
	}
	/**
	* Update this to return the current user id
	**/
	private function get_current_user_id(){
		
		return false;
	}
	public function init(){
		$this->user_id = $this->get_current_user_id();
		/* If first time on website */
		$this->current_visitor_cookie = $this->CI->input->cookie($this->visitor_cookie, TRUE);
		if($this->current_visitor_cookie){
			$this->current_visitor = $this->CI->session_handler_model->get_visitor($this->current_visitor_cookie);
		}
		$just_created = false;
		if(!$this->current_visitor){
			$this->current_visitor = $this->create_new_visitor();
			$this->current_visitor_cookie = ($this->current_visitor ? $this->current_visitor->cookie : false);
			$just_created = true;
		}
		if($this->user_id && $this->current_visitor && ($this->current_visitor->user_id != $this->user_id && $just_created != true)){
			die();
			$visitor_id = $this->CI->session_handler_model->merge_visitors($this->current_visitor->id, $this->user_id);
			$this->current_visitor = $this->CI->session_handler_model->get_visitor($visitor_id);
			$this->current_visitor_cookie = ($this->current_visitor ? $this->current_visitor->cookie : false);
			$this->CI->input->set_cookie(array(
				'name' => $this->visitor_cookie,
				'value' => $this->current_visitor_cookie,
				'expire' => $this->CI->config->item('visitor_cookie_expire', 'sessions'),
				'secure' => $this->is_ssl
			));
		}
		
		/* If first time on website in this session */
		$this->current_session_cookie = $this->CI->input->cookie($this->session_cookie, TRUE);
		if($this->current_session_cookie){
			$this->current_session = $this->CI->session_handler_model->get_visitor($this->current_session_cookie);
		}
		if(!$this->current_session && $this->current_visitor){
			$this->current_session = $this->create_new_session($this->current_visitor->id);
			$this->current_session_cookie = ($this->current_session ? $this->current_session->cookie : false);
		}
	}
	private function create_new_visitor(){
		$cookie_val = random_string('alnum', $this->CI->config->item('visitor_cookie_length', 'sessions'));
		$this->CI->input->set_cookie(array(
			'name' => $this->visitor_cookie,
			'value' => $cookie_val,
			'expire' => $this->CI->config->item('visitor_cookie_expire', 'sessions'),
			'secure' => $this->is_ssl
		));
		
		$status = $this->CI->session_handler_model->create_visitor($cookie_val, 'visitor');
		if($status){
			return $this->CI->session_handler_model->get_visitor($cookie_val);
		}
		return false;
	}
	private function create_new_session($visitor_id){
		$cookie_val = random_string('alnum', $this->CI->config->item('session_cookie_length', 'sessions'));
		$this->CI->input->set_cookie(array(
			'name' => $this->session_cookie,
			'value' => $cookie_val,
			'expire' => 0,
			'secure' => $this->is_ssl
		));
		$status = $this->CI->session_handler_model->create_visitor($cookie_val, 'session', $visitor_id);
		if($status){
			return $this->CI->session_handler_model->get_visitor($cookie_val);
		}
		return false;
	}
	public function get_current_visitor(){
		return $this->current_visitor;
	}
	public function get_current_session(){
		return $this->current_session;
	}
}