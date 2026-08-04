<?php
class ControllerB2BForm extends Controller {
	private $error = array();

	public function index() {

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');

		$this->response->setOutput($this->load->view('b2b/form', $data));
	}

	public function add() {
		$query = $this->db->query("insert into oc_b2b (b2b_name_surname, b2b_province, b2b_business_type, b2b_phone, b2b_email, b2b_message, b2b_datetime_create, b2b_ip_create, b2b_datetime_update, b2b_ip_update) values ('".$_POST['b2b_name_surname']."', '".$_POST['b2b_province']."', '".$_POST['b2b_business_type']."', '".$_POST['b2b_phone']."', '".$_POST['b2b_email']."', '".$_POST['b2b_message']."', '".date('Y-m-d H:i:s')."', '".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d H:i:s')."', '".$_SERVER['REMOTE_ADDR']."')");

		if(!empty($query)) {
			echo '<script>alert("Send Data Success");window.location.href="index.php";</script>';
		}
	}
}
