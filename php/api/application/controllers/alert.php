<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Alets Mgt (Notification triggers)
 * It's user set-up triggers
 */

require_once (APPPATH. 'libraries/REST_Controller.php');

class Alert extends REST_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library('CORE_Controller');
		$this->core_controller->set_response_helper($this);

		$this->load->model('alert_model'); 
	
	}

	var $user_type = 'user';

	public function addAlert_post(){
		
		$user=$this->core_controller->get_current_user();
		$stock_id=$this->input->post('stock_id');
		$specified_price=$this->input->post('specified_price');
		$alert_type=$this->input->post('alert_type');
		$daily_percent=$this->input->post('daily_percent');
		$renotify_percent=$this->input->post('renotify_percent');
		$valid_till=$this->input->post('valid_till');

		$uid=$user[$this->user_model->KEY_user_id];

		$data = array(
		    $this->alert_model->KEY_user_id =>$uid,
		    $this->alert_model->KEY_stock_id => $stock_id ,
		    $this->alert_model->KEY_specified_price => $specified_price,
		    $this->alert_model->KEY_type => $alert_type,
		    $this->alert_model->KEY_daily_percent => $daily_percent,
		    $this->alert_model->KEY_renotify_diff_percent => $renotify_percent,
		    $this->alert_model->KEY_valid_till => $valid_till,
		    $this->alert_model->KEY_enable => "1",
		  
		);

		$alert_id = $this->alert_model->add_alert($data);
	
		if($alert_id<0){
			$this->core_controller->fail_response(200);
		}
		
		$this->core_controller->add_return_data('alert_id', $alert_id); 
		$this->core_controller->successfully_processed();


	}

	public function getAlerts_get(){
		$user=$this->core_controller->get_current_user();
		$uid=$user[$this->user_model->KEY_user_id];

		$alerts_given_uid=$this->alert_model->get_all_alerts_by_uid($uid);

		$alert_type=$this->alert_model->get_all_notification_type();

		$this->core_controller->add_return_data('alerts', $alerts_given_uid);
		$this->core_controller->add_return_data('alert_type', $alert_type);  
		$this->core_controller->add_return_data('uid', $uid); 
		$this->core_controller->successfully_processed();

	}

	
	

}

/* End of file alert.php */
/* Location: ./application/controllers/alert.php */