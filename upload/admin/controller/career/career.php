<?php
class ControllerCareerCareer extends Controller {
	private $error = array();

	public function index() {
		
		$this->load->model('career/career');

		$this->document->setTitle('สมัครงาน');

		$this->load->model('catalog/category');
		
		$this->getList();
	}

	public function addCategory() {
		$this->load->model('career/career');

		$this->document->setTitle('สมัครงาน');

		$this->load->model('career/career');

		if (!empty($_POST)) {
			$this->model_career_career->addCareerCategory();

			$this->response->redirect($this->url->link('career/career', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getFormCategory();
	}

	public function editCategory() {
		$this->load->model('career/career');

		$this->document->setTitle('สมัครงาน');

		$this->load->model('career/career');

		if (!empty($_POST)) {
			$this->model_career_career->editCareerCategory();

			$this->response->redirect($this->url->link('career/career', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getFormCategory();
	}

	public function deleteCategory() {
		$this->load->model('career/career');

		$this->document->setTitle('สมัครงาน');

		$this->load->model('career/career');

		if (!empty($_POST)) {
			foreach ($_POST['delete_item_category'] as $career_category_id) {
				$this->model_career_career->deleteCareerCategory($career_category_id);
			}

			$this->response->redirect($this->url->link('career/career', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getFormCategory() {
		$this->load->model('career/career');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['user_token'] = $_GET['user_token'];

		$data['row'] = @$this->model_career_career->getCareerCategoryRecord();

		$data['id'] = @$_GET['id'];

		$this->response->setOutput($this->load->view('career/career_category_form', $data));
	}

	public function add() {
		$this->load->model('career/career');

		$this->document->setTitle('สมัครงาน');

		$this->load->model('career/career');

		if (!empty($_POST)) {
			$this->model_career_career->addCareer();

			$this->response->redirect($this->url->link('career/career', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->model('career/career');

		$this->document->setTitle('สมัครงาน');

		$this->load->model('career/career');

		if (!empty($_POST)) {
			$this->model_career_career->editCareer();

			$this->response->redirect($this->url->link('career/career', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle('สมัครงาน');

		$this->load->model('career/career');

		if (!empty($_POST)) {
			foreach ($_POST['delete_item'] as $career_id) {
				$this->model_career_career->deleteCareer($career_id);
			}

			$this->response->redirect($this->url->link('career/career', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$this->load->model('career/career');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['categoryCareerCtrl'] = $this->model_career_career->getCareerCategory();

		$data['careerCtrl'] = $this->model_career_career->getCareer();

		$data['user_token'] = $_GET['user_token'];

		$data['formApplication'] = $this->model_career_career->getFormApplication();

		$this->response->setOutput($this->load->view('career/career_list', $data));
	}

	protected function getForm() {
		$this->load->model('career/career');
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['user_token'] = $_GET['user_token'];

		$data['category'] = $this->model_career_career->getCareerCategory();

		$data['row'] = @$this->model_career_career->getCareerRecord();

		$data['id'] = @$_GET['id'];

		//pre($data['row']);

		$this->response->setOutput($this->load->view('career/career_form', $data));
	}
}
