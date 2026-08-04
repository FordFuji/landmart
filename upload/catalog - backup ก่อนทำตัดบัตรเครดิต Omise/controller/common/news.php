<?php
class ControllerCommonNews extends Controller {
	public function index() {

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->load->model('catalog/news');
		$data['news1'] = $this->model_catalog_news->getNews1();
		$data['news2'] = $this->model_catalog_news->getNews2();
		$data['news3'] = $this->model_catalog_news->getNews3();
		$data['news4'] = $this->model_catalog_news->getNews4();

		$query = $this->db->query("SELECT * FROM fd_vdo_news ORDER BY vdo_news_id DESC");
		$rows = $query->rows;

		$data['vdo_news'] = $rows;
		
		$this->response->setOutput($this->load->view('common/news', $data));
	}

	public function news_inside() {

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->load->model('catalog/news');
		$data['newsCtrl'] = $this->model_catalog_news->getNewsRecord();
		
		$this->response->setOutput($this->load->view('common/news_inside', $data));
	}
}
