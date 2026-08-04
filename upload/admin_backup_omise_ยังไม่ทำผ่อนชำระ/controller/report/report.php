<?php
class ControllerReportReport extends Controller {
	public function index() {
		//$this->load->language('design/banner');

		$this->document->setTitle('ข่าวสารและโปรโมชัน');

		$this->load->model('news/news');

		$this->getList();
	}

	public function add() {
		//$this->load->language('design/banner');

		$this->document->setTitle('ข่าวสารและโปรโมชัน');

		$this->load->model('news/news');

		if(!empty($_POST)) {
			$this->model_news_news->addNews();

			$this->response->redirect($this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('design/banner');

		$this->document->setTitle('ข่าวสารและโปรโมชัน');

		$this->load->model('news/news');

		if (!empty($_POST)) {
			$this->model_news_news->editNews();

			$this->response->redirect($this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		//$this->load->language('design/banner');

		$this->document->setTitle('ข่าวสารและโปรโมชัน');

		$this->load->model('news/news');

		if (!empty($_POST)) {
			foreach ($_POST['delete_item'] as $news_id) {
				$this->model_news_news->deleteNews($news_id);
			}

			$this->response->redirect($this->url->link('report/report', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		$data['heading_title'] = 'ข่าวสารและโปรโมชัน';

		$data['newsCtrl'] = $this->model_news_news->getNews();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['user_token'] = $this->session->data['user_token'];

		$this->response->setOutput($this->load->view('report/news_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = 'ข่าวสารและโปรโมชัน';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['news'] = $this->model_news_news->getNewsSingle();

		$data['user_token'] = $_GET['user_token'];

		$data['id'] = @$_GET['id'];

		$this->response->setOutput($this->load->view('report/news_form', $data));
	}

	/*protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'design/banner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (isset($this->request->post['banner_image'])) {
			foreach ($this->request->post['banner_image'] as $language_id => $value) {
				foreach ($value as $banner_image_id => $banner_image) {
					if ((utf8_strlen($banner_image['title']) < 2) || (utf8_strlen($banner_image['title']) > 64)) {
						$this->error['banner_image'][$language_id][$banner_image_id] = $this->language->get('error_title');
					}
				}
			}
		}

		return !$this->error;
	}*/

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'design/banner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function news() {
		$this->load->model('news/news');

		if(!empty($_POST['submit_vdo'])) {
			$query = $this->db->query("TRUNCATE fd_vdo_news");

			if(!empty($_POST['vdo_news_embed_youtube'])) {
				foreach($_POST['vdo_news_embed_youtube'] as $value) {
					$this->db->query("INSERT INTO fd_vdo_news(vdo_news_embed_youtube, vdo_news_datetime_update) VALUES('".$value."', '".date('Y-m-d H:i:s')."')");
				}
			}
		}

		$data['heading_title'] = 'วีดีโอข่าวสารและโปรโมชัน';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['news'] = $this->model_news_news->getNewsSingle();

		$data['user_token'] = $_GET['user_token'];

		$query = $this->db->query('SELECT * FROM fd_vdo_news ORDER BY vdo_news_id DESC');
		$data['vdo_news'] = $query->rows;

		$this->response->setOutput($this->load->view('report/vdo_news_form', $data));
	}
}