<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Session_handler_model extends CI_Model {
	/**
	 * Holds an array of tables used
	 *
	 * @var array
	*/
	public $tables = array();

	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->library('user_agent');
		$this->load->config('sessions', TRUE);
		
		$this->tables  = $this->config->item('tables', 'sessions');
	}
	public function get_visitor($identify){
		if($identify){
			if(is_array($identify)){
				print_r($identify);
				die();
			}
			$q = $this->db->select('a.*')->from($this->tables['visitors'].' AS a')->where(is_numeric($identify) ? 'a.id' : 'a.cookie', $identify)->limit(1)->get();
			if($q && $q->num_rows() == 1){
				$item = $q->row();
				return $item;
			}
		}
		return false;
	}
	public function create_visitor($cookie_val, $visitor_type, $parent_id = 0){
		if($cookie_val && $visitor_type && in_array($visitor_type, ['session', 'visitor'])){
			if ($this->agent->is_browser() || $this->agent->is_mobile()) {
				$user_agent = $this->agent->agent_string();
				$browser = ($this->agent->is_browser() ? $this->agent->browser() : $this->agent->mobile());
				$browser_version = ($this->agent->is_browser() ? $this->agent->version() : '1.0');
				$user_id = $this->user_handler->get_current_user_id();
				$arg = array(
					'cookie' => $cookie_val,
					'type' => $visitor_type,
					'user_id' => $user_id ? $user_id : 0,
					'parent_id' => $visitor_type == 'session' ? $parent_id : 0,
					'user_agent' => $user_agent,
					'browser' => $browser,
					'version' => $browser_version,
					'created' => date('Y-m-d H:i:s')
				);
				$q = $this->db->insert($this->tables['visitors'], $arg);
				if($q){
					return true;
				}
			}
		}
		return false;
	}
	public function merge_visitors($visitor_id, $user_id){
		$q = $this->db->select('a.*')->from($this->tables['visitors']. ' AS a')->where('a.user_id', $user_id)->limit(1)->get();
		if($q && $q->num_rows() > 0){
			$visitor = $q->row();
			$this->db->update($this->tables['visitors'], array(
				'parent_id' => $visitor->id
			), array(
				'parent_id' => $visitor_id
			));
			$this->db->delete($this->tables['visitors'], array(
				'id' => $visitor_id
			));
			return $visitor->id;
		} else {
			$this->db->update($this->tables['visitors'], array(
				'user_id' => $user_id
			), array(
				'id' => $visitor_id
			));
		}
		return $visitor_id;
	}
	public function add_session_data($key, $value, $multiple = false, $only_to = false){		
		if($only_to === false || $only_to == 'visitor'){
			$visitor = $this->session_handler->get_current_visitor();
			$q = $this->db->select('*')->from($this->tables['visitors_data'])->where(array(
				'visitor_id' => $visitor->id,
				'data_name' => $key
			))->get();
			if($q && $q->num_rows() > 0 && $multiple === false){
				$this->db->update($this->tables['visitors_data'], array(
					'data_value' => (is_array($value) || is_object($value) ? json_encode($value) : $value),
					'created' => time()
				), array(
					'visitor_id' => $visitor->id,
					'data_name' => $key,
				));
			} else {
				$this->db->insert($this->tables['visitors_data'], array(
					'visitor_id' => $visitor->id,
					'data_name' => $key,
					'data_value' => (is_array($value) || is_object($value) ? json_encode($value) : $value),
					'created' => time()
				));
			}
		}
		if($only_to === false || $only_to == 'session'){
			$session = $this->session_handler->get_current_session();
			$q2 = $this->db->select('*')->from($this->tables['visitors_data'])->where(array(
				'visitor_id' => $session->id,
				'data_name' => $key
			))->get();
			if($q2 && $q2->num_rows() > 0 && $multiple === false){
				$this->db->update($this->tables['visitors_data'], array(
					'data_value' => (is_array($value) || is_object($value) ? json_encode($value) : $value),
					'created' => time()
				), array(
					'visitor_id' => $session->id,
					'data_name' => $key,
				));
			} else {
				$this->db->insert($this->tables['visitors_data'], array(
					'visitor_id' => $session->id,
					'data_name' => $key,
					'data_value' => (is_array($value) || is_object($value) ? json_encode($value) : $value),
					'created' => time()
				));
			}
		}
		
		return true;
	}
	public function get_session_data($key, $multiple = false, $only_to = false){
		$value = array();
		if($only_to === false || $only_to == 'visitor'){
			$visitor = $this->session_handler->get_current_visitor();
			$q = $this->db->select('data_value')->from($this->tables['visitors_data'])->where(array(
				'visitor_id' => $visitor->id,
				'data_name' => $key
			))->order_by('created', 'desc')->get();
			if($q && $q->num_rows() > 0){
				foreach($q->result() as $x){
					$value[] = $x->data_value;
					if(!$multiple) break;
				}
			}
		}
		if($only_to === false || $only_to == 'session'){
			$session = $this->session_handler->get_current_session();
			$q2 = $this->db->select('data_value')->from($this->tables['visitors_data'])->where(array(
				'visitor_id' => $session->id,
				'data_name' => $key
			))->order_by('created', 'desc')->get();
			if($q2 && $q2->num_rows() > 0){
				foreach($q2->result() as $x){
					$value[] = $x->data_value;
					if(!$multiple) break;
				}
			}
		}
		return ($multiple ? $value : (count($value) > 0 ? $value[0] : false));
	}
}
