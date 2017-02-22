<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* Lib: Layout.php
*/

class Layout {
	private $CI;
	private $scripts = array();
	private $styles = array();
	public $footer_scripts = array();
	
	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('language');
		
		/* Adding default scripts */
		$this->add_script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js');
		$this->add_script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js');
		$this->add_script('public/js/main.js');
		
		/* Adding default styling */
		$this->add_style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
		$this->add_style('public/css/style.css');
		
		$current_user = $this->get_current_user();
		if($current_user){
			/* If the user is logged in, then load other scripts or styles? */
		}
	}
	/**
	* Update this function to return the current user
	*/
	private function get_current_user(){
		
		return false;
	}
	public function add_script($script){
		$path = (strpos($script, '//') === false ? site_url($script) : $script);
		if(!in_array($path, $this->scripts))
			$this->scripts[] = $path;
	}
	/**
	* arguments: $script_code
	* return true if added
	*/
	public function add_footer_script($script){
		$script = str_replace(PHP_EOL, '', $script);
		$this->footer_scripts[] = $script;
		return true;
	}
	public function add_style($style){
		$path = (strpos($style, '//') === false ? site_url($style) : $style);
		
		if(!in_array($path, $this->styles))
			$this->styles[] = $path;
	}
	public function view($view, $params = array()){
		$params['scripts'] = $this->scripts;
		$params['styles'] = $this->styles;
		
		$data = array(
			'data' => $params
		);
		$this->_header($data);
		$this->CI->load->view($view, $data);
		$this->_footer($data);
	}
	private function _header($data = array()){
		$this->CI->load->view('layout/header', $data);
	}
	private function _footer($data = array()){
		$this->CI->load->view('layout/footer', $data);
	}
}