<?php
class ControllerCatalogTransport extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/transport');

		$this->document->setTitle('บริษัทขนส่งเอกชน');

		$this->load->model('catalog/transport');

		$this->getList();
	}

	public function add() {
		//$this->load->language('catalog/transport');

		$this->document->setTitle('บริษัทขนส่งเอกชน');

		$this->load->model('catalog/transport');

		if ((!empty($_POST))) {
			$this->model_catalog_transport->addtransport($this->request->post);

			echo '<script>window.location.href="index.php?route=catalog/transport&user_token='.$this->session->data['user_token'].'";</script>';

			/*$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}*/

			//$this->response->redirect($this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		//$this->load->language('catalog/transport');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/transport');

		if (!empty($_POST)) {
			$this->model_catalog_transport->edittransport($this->request->get['transport_id'], $this->request->post);

			/*$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url, true));*/

			echo '<script>window.location.href="index.php?route=catalog/transport&user_token='.$this->session->data['user_token'].'";</script>';
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/transport');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/transport');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $transport_id) {
				$this->model_catalog_transport->deletetransport($transport_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		/*if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/transport/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/transport/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['transports'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$transport_total = $this->model_catalog_transport->getTotaltransports();

		$results = $this->model_catalog_transport->gettransports($filter_data);

		foreach ($results as $result) {
			$data['transports'][] = array(
				'transport_id' => $result['transport_id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],
				'edit'            => $this->url->link('catalog/transport/edit', 'user_token=' . $this->session->data['user_token'] . '&transport_id=' . $result['transport_id'] . $url, true)
			);
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $transport_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transport_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transport_total - $this->config->get('config_limit_admin'))) ? $transport_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transport_total, ceil($transport_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;*/

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['transport'] = $this->model_catalog_transport->getTranSport();

		$data['user_token'] = $_GET['user_token'];

		$this->response->setOutput($this->load->view('catalog/transport_list', $data));
	}

	protected function getForm() {
		$this->document->setTitle('บริษัทขนส่งเอกชน');

		/*$data['text_form'] = !isset($this->request->get['transport_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['transport_id'])) {
			$data['action'] = $this->url->link('catalog/transport/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/transport/edit', 'user_token=' . $this->session->data['user_token'] . '&transport_id=' . $this->request->get['transport_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/transport', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['transport_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$transport_info = $this->model_catalog_transport->gettransport($this->request->get['transport_id']);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->post['name'])) {
			$data['name'] = $this->request->post['name'];
		} elseif (!empty($transport_info)) {
			$data['name'] = $transport_info['name'];
		} else {
			$data['name'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = array();
		
		$data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->language->get('text_default')
		);
		
		$stores = $this->model_setting_store->getStores();

		foreach ($stores as $store) {
			$data['stores'][] = array(
				'store_id' => $store['store_id'],
				'name'     => $store['name']
			);
		}

		if (isset($this->request->post['transport_store'])) {
			$data['transport_store'] = $this->request->post['transport_store'];
		} elseif (isset($this->request->get['transport_id'])) {
			$data['transport_store'] = $this->model_catalog_transport->gettransportStores($this->request->get['transport_id']);
		} else {
			$data['transport_store'] = array(0);
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($transport_info)) {
			$data['image'] = $transport_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($transport_info) && is_file(DIR_IMAGE . $transport_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($transport_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($transport_info)) {
			$data['sort_order'] = $transport_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['transport_seo_url'])) {
			$data['transport_seo_url'] = $this->request->post['transport_seo_url'];
		} elseif (isset($this->request->get['transport_id'])) {
			$data['transport_seo_url'] = $this->model_catalog_transport->gettransportSeoUrls($this->request->get['transport_id']);
		} else {
			$data['transport_seo_url'] = array();
		}*/
				
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		$data['user_token'] = $_GET['user_token'];

		$this->load->model('catalog/transport');

		$data['transport'] = $this->model_catalog_transport->getTranSportRecord();

		$this->response->setOutput($this->load->view('catalog/transport_form', $data));
	}

	protected function validateForm() {
		/*if (!$this->user->hasPermission('modify', 'catalog/transport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['transport_name']) < 1) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ($this->request->post['transport_seo_url']) {
			$this->load->model('design/seo_url');
			
			foreach ($this->request->post['transport_seo_url'] as $store_id => $language) {
				foreach ($language as $language_id => $keyword) {
					if (trim($keyword)) {
						if (count(array_keys($language, $keyword)) > 1) {
							$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_unique');
						}							
						
						$seo_urls = $this->model_design_seo_url->getSeoUrlsByKeyword($keyword);
						
						foreach ($seo_urls as $seo_url) {
							if (($seo_url['store_id'] == $store_id) && (!isset($this->request->get['transport_id']) || (($seo_url['query'] != 'transport_id=' . $this->request->get['transport_id'])))) {
								$this->error['keyword'][$store_id][$language_id] = $this->language->get('error_keyword');
							}
						}
					}
				}
			}
		}

		return !$this->error;
		*/
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/transport')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $transport_id) {
			$product_total = $this->model_catalog_product->getTotalProductsBytransportId($transport_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/transport');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_transport->gettransports($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'transport_id' => $result['transport_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}