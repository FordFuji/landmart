<?php
class ControllerCommonCareer extends Controller {
	public function index() {

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->load->model('catalog/career');

		$data['category'] = $this->model_catalog_career->getCareerCategory();

		$data['career'] = $this->model_catalog_career->getCareer();
		
		$this->response->setOutput($this->load->view('common/career', $data));
	}

	public function detail() {
		if(!empty($_POST['submit_application'])) {
			if(move_uploaded_file($_FILES['application_file_resume']['tmp_name'], 'image/resume/'.$_FILES['application_file_resume']['name'])) {
				$query = $this->db->query("INSERT INTO fd_application(career_id, application_name, application_surname, application_email, application_tel, application_detail, application_file_resume, application_datetime_create, application_datetime_update) VALUES('".$_POST['career_id']."', '".$_POST['application_name']."', '".$_POST['application_surname']."', '".$_POST['application_email']."', '".$_POST['application_tel']."', '".$_POST['application_detail']."', 'image/resume/".$_FILES['application_file_resume']['name']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
			}

			echo '<script>alert("สมัครงานเรียบร้อย");</script>';
		}

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->load->model('catalog/career');

		$data['category'] = $this->model_catalog_career->getCareerCategory();

		$data['career'] = $this->model_catalog_career->getCareerRecord();

		$data['career_id'] = $_GET['career_id'];
		
		$this->response->setOutput($this->load->view('common/career_detail', $data));
	}
}
