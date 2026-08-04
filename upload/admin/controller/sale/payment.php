<?php
class ControllerSalePayment extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('sale/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/payment');

		$this->getList();
	}

	public function add() {
		$this->load->language('sale/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/payment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_payment->addpayment($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_payment_id'])) {
				$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
			}

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product'])) {
				$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_payment_status_id'])) {
				$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('sale/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/payment');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_sale_payment->editpayment($this->request->get['payment_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_payment_id'])) {
				$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
			}

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product'])) {
				$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_payment_status_id'])) {
				$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getForm();
	}

	public function deleteSlip() {
		$this->db->query("DELETE FROM fd_payment WHERE payment_id = '".$_GET['payment_id']."'");

		$this->response->redirect($this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true));
	}

	public function delete() {
		$this->load->language('sale/payment');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/payment');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $payment_id) {
				$this->model_sale_payment->deletepayment($payment_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_payment_id'])) {
				$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
			}

			if (isset($this->request->get['filter_order_id'])) {
				$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
			}

			if (isset($this->request->get['filter_customer'])) {
				$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_product'])) {
				$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_payment_status_id'])) {
				$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
			}

			if (isset($this->request->get['filter_date_modified'])) {
				$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		/*if (isset($this->request->get['filter_payment_id'])) {
			$filter_payment_id = $this->request->get['filter_payment_id'];
		} else {
			$filter_payment_id = '';
		}

		if (isset($this->request->get['filter_order_id'])) {
			$filter_order_id = $this->request->get['filter_order_id'];
		} else {
			$filter_order_id = '';
		}

		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = '';
		}

		if (isset($this->request->get['filter_product'])) {
			$filter_product = $this->request->get['filter_product'];
		} else {
			$filter_product = '';
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = '';
		}

		if (isset($this->request->get['filter_payment_status_id'])) {
			$filter_payment_status_id = $this->request->get['filter_payment_status_id'];
		} else {
			$filter_payment_status_id = '';
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = '';
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$filter_date_modified = $this->request->get['filter_date_modified'];
		} else {
			$filter_date_modified = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'r.payment_id';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_payment_id'])) {
			$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_payment_status_id'])) {
			$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

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
			'href' => $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		$data['add'] = $this->url->link('sale/payment/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		$data['delete'] = $this->url->link('sale/payment/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['payments'] = array();

		$filter_data = array(
			'filter_payment_id'        => $filter_payment_id,
			'filter_order_id'         => $filter_order_id,
			'filter_customer'         => $filter_customer,
			'filter_product'          => $filter_product,
			'filter_model'            => $filter_model,
			'filter_payment_status_id' => $filter_payment_status_id,
			'filter_date_added'       => $filter_date_added,
			'filter_date_modified'    => $filter_date_modified,
			'sort'                    => $sort,
			'order'                   => $order,
			'start'                   => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'                   => $this->config->get('config_limit_admin')
		);

		$payment_total = $this->model_sale_payment->getTotalpayments($filter_data);

		$results = $this->model_sale_payment->getpayments($filter_data);

		foreach ($results as $result) {
			$data['payments'][] = array(
				'payment_id'     => $result['payment_id'],
				'order_id'      => $result['order_id'],
				'customer'      => $result['customer'],
				'product'       => $result['product'],
				'model'         => $result['model'],
				'payment_status' => $result['payment_status'],
				'date_added'    => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
				'edit'          => $this->url->link('sale/payment/edit', 'user_token=' . $this->session->data['user_token'] . '&payment_id=' . $result['payment_id'] . $url, true)
			);
		}

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		} elseif (isset($this->error['warning'])) {
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

		if (isset($this->request->get['filter_payment_id'])) {
			$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_payment_status_id'])) {
			$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_payment_id'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=r.payment_id' . $url, true);
		$data['sort_order_id'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=r.order_id' . $url, true);
		$data['sort_customer'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=customer' . $url, true);
		$data['sort_product'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=r.product' . $url, true);
		$data['sort_model'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=r.model' . $url, true);
		$data['sort_status'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=status' . $url, true);
		$data['sort_date_added'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=r.date_added' . $url, true);
		$data['sort_date_modified'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . '&sort=r.date_modified' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_payment_id'])) {
			$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_payment_status_id'])) {
			$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $payment_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($payment_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($payment_total - $this->config->get('config_limit_admin'))) ? $payment_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $payment_total, ceil($payment_total / $this->config->get('config_limit_admin')));

		$data['filter_payment_id'] = $filter_payment_id;
		$data['filter_order_id'] = $filter_order_id;
		$data['filter_customer'] = $filter_customer;
		$data['filter_product'] = $filter_product;
		$data['filter_model'] = $filter_model;
		$data['filter_payment_status_id'] = $filter_payment_status_id;
		$data['filter_date_added'] = $filter_date_added;
		$data['filter_date_modified'] = $filter_date_modified;

		$this->load->model('localisation/payment_status');

		$data['payment_statuses'] = $this->model_localisation_payment_status->getpaymentStatuses();

		$data['sort'] = $sort;
		$data['order'] = $order;
		*/

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$data['payment'] = $this->model_sale_payment->getPayment();

		$data['user_token'] = $_GET['user_token'];

		$this->response->setOutput($this->load->view('sale/payment_list', $data));
	}

	protected function getForm() {
		$data['text_form'] = !isset($this->request->get['payment_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['user_token'] = $this->session->data['user_token'];

		if (isset($this->request->get['payment_id'])) {
			$data['payment_id'] = $this->request->get['payment_id'];
		} else {
			$data['payment_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['order_id'])) {
			$data['error_order_id'] = $this->error['order_id'];
		} else {
			$data['error_order_id'] = '';
		}

		if (isset($this->error['firstname'])) {
			$data['error_firstname'] = $this->error['firstname'];
		} else {
			$data['error_firstname'] = '';
		}

		if (isset($this->error['lastname'])) {
			$data['error_lastname'] = $this->error['lastname'];
		} else {
			$data['error_lastname'] = '';
		}

		if (isset($this->error['email'])) {
			$data['error_email'] = $this->error['email'];
		} else {
			$data['error_email'] = '';
		}

		if (isset($this->error['telephone'])) {
			$data['error_telephone'] = $this->error['telephone'];
		} else {
			$data['error_telephone'] = '';
		}

		if (isset($this->error['product'])) {
			$data['error_product'] = $this->error['product'];
		} else {
			$data['error_product'] = '';
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_payment_id'])) {
			$url .= '&filter_payment_id=' . $this->request->get['filter_payment_id'];
		}

		if (isset($this->request->get['filter_order_id'])) {
			$url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
		}

		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_product'])) {
			$url .= '&filter_product=' . urlencode(html_entity_decode($this->request->get['filter_product'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_payment_status_id'])) {
			$url .= '&filter_payment_status_id=' . $this->request->get['filter_payment_status_id'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['filter_date_modified'])) {
			$url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
		}

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
			'href' => $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true)
		);

		if (!isset($this->request->get['payment_id'])) {
			$data['action'] = $this->url->link('sale/payment/add', 'user_token=' . $this->session->data['user_token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('sale/payment/edit', 'user_token=' . $this->session->data['user_token'] . '&payment_id=' . $this->request->get['payment_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('sale/payment', 'user_token=' . $this->session->data['user_token'] . $url, true);

		if (isset($this->request->get['payment_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$payment_info = $this->model_sale_payment->getpayment($this->request->get['payment_id']);
		}

		if (isset($this->request->post['order_id'])) {
			$data['order_id'] = $this->request->post['order_id'];
		} elseif (!empty($payment_info)) {
			$data['order_id'] = $payment_info['order_id'];
		} else {
			$data['order_id'] = '';
		}

		if (isset($this->request->post['date_ordered'])) {
			$data['date_ordered'] = $this->request->post['date_ordered'];
		} elseif (!empty($payment_info)) {
			$data['date_ordered'] = ($payment_info['date_ordered'] != '0000-00-00' ? $payment_info['date_ordered'] : '');
		} else {
			$data['date_ordered'] = '';
		}

		if (isset($this->request->post['customer'])) {
			$data['customer'] = $this->request->post['customer'];
		} elseif (!empty($payment_info)) {
			$data['customer'] = $payment_info['customer'];
		} else {
			$data['customer'] = '';
		}

		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($payment_info)) {
			$data['customer_id'] = $payment_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}

		if (isset($this->request->post['firstname'])) {
			$data['firstname'] = $this->request->post['firstname'];
		} elseif (!empty($payment_info)) {
			$data['firstname'] = $payment_info['firstname'];
		} else {
			$data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
			$data['lastname'] = $this->request->post['lastname'];
		} elseif (!empty($payment_info)) {
			$data['lastname'] = $payment_info['lastname'];
		} else {
			$data['lastname'] = '';
		}

		if (isset($this->request->post['email'])) {
			$data['email'] = $this->request->post['email'];
		} elseif (!empty($payment_info)) {
			$data['email'] = $payment_info['email'];
		} else {
			$data['email'] = '';
		}

		if (isset($this->request->post['telephone'])) {
			$data['telephone'] = $this->request->post['telephone'];
		} elseif (!empty($payment_info)) {
			$data['telephone'] = $payment_info['telephone'];
		} else {
			$data['telephone'] = '';
		}

		if (isset($this->request->post['product'])) {
			$data['product'] = $this->request->post['product'];
		} elseif (!empty($payment_info)) {
			$data['product'] = $payment_info['product'];
		} else {
			$data['product'] = '';
		}

		if (isset($this->request->post['product_id'])) {
			$data['product_id'] = $this->request->post['product_id'];
		} elseif (!empty($payment_info)) {
			$data['product_id'] = $payment_info['product_id'];
		} else {
			$data['product_id'] = '';
		}

		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($payment_info)) {
			$data['model'] = $payment_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($payment_info)) {
			$data['quantity'] = $payment_info['quantity'];
		} else {
			$data['quantity'] = '';
		}

		if (isset($this->request->post['opened'])) {
			$data['opened'] = $this->request->post['opened'];
		} elseif (!empty($payment_info)) {
			$data['opened'] = $payment_info['opened'];
		} else {
			$data['opened'] = '';
		}

		if (isset($this->request->post['payment_reason_id'])) {
			$data['payment_reason_id'] = $this->request->post['payment_reason_id'];
		} elseif (!empty($payment_info)) {
			$data['payment_reason_id'] = $payment_info['payment_reason_id'];
		} else {
			$data['payment_reason_id'] = '';
		}

		$this->load->model('localisation/payment_reason');

		$data['payment_reasons'] = $this->model_localisation_payment_reason->getpaymentReasons();

		if (isset($this->request->post['payment_action_id'])) {
			$data['payment_action_id'] = $this->request->post['payment_action_id'];
		} elseif (!empty($payment_info)) {
			$data['payment_action_id'] = $payment_info['payment_action_id'];
		} else {
			$data['payment_action_id'] = '';
		}

		$this->load->model('localisation/payment_action');

		$data['payment_actions'] = $this->model_localisation_payment_action->getpaymentActions();

		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (!empty($payment_info)) {
			$data['comment'] = $payment_info['comment'];
		} else {
			$data['comment'] = '';
		}

		if (isset($this->request->post['payment_status_id'])) {
			$data['payment_status_id'] = $this->request->post['payment_status_id'];
		} elseif (!empty($payment_info)) {
			$data['payment_status_id'] = $payment_info['payment_status_id'];
		} else {
			$data['payment_status_id'] = '';
		}

		$this->load->model('localisation/payment_status');

		$data['payment_statuses'] = $this->model_localisation_payment_status->getpaymentStatuses();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('sale/payment_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['order_id'])) {
			$this->error['order_id'] = $this->language->get('error_order_id');
		}

		if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
			$this->error['firstname'] = $this->language->get('error_firstname');
		}

		if ((utf8_strlen(trim($this->request->post['lastname'])) < 1) || (utf8_strlen(trim($this->request->post['lastname'])) > 32)) {
			$this->error['lastname'] = $this->language->get('error_lastname');
		}

		if ((utf8_strlen($this->request->post['email']) > 96) || !filter_var($this->request->post['email'], FILTER_VALIDATE_EMAIL)) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
			$this->error['telephone'] = $this->language->get('error_telephone');
		}

		if ((utf8_strlen($this->request->post['product']) < 1) || (utf8_strlen($this->request->post['product']) > 255)) {
			$this->error['product'] = $this->language->get('error_product');
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if (empty($this->request->post['payment_reason_id'])) {
			$this->error['reason'] = $this->language->get('error_reason');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/payment')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function history() {
		$this->load->language('sale/payment');

		$this->load->model('sale/payment');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['histories'] = array();

		$results = $this->model_sale_payment->getpaymentHistories($this->request->get['payment_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['histories'][] = array(
				'notify'     => $result['notify'] ? $this->language->get('text_yes') : $this->language->get('text_no'),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_payment->getTotalpaymentHistories($this->request->get['payment_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('sale/payment/history', 'user_token=' . $this->session->data['user_token'] . '&payment_id=' . $this->request->get['payment_id'] . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($history_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($history_total - 10)) ? $history_total : ((($page - 1) * 10) + 10), $history_total, ceil($history_total / 10));

		$this->response->setOutput($this->load->view('sale/payment_history', $data));
	}
	
	public function addHistory() {
		$this->load->language('sale/payment');

		$json = array();

		if (!$this->user->hasPermission('modify', 'sale/payment')) {
			$json['error'] = $this->language->get('error_permission');
		} else {
			$this->load->model('sale/payment');

			$this->model_sale_payment->addpaymentHistory($this->request->get['payment_id'], $this->request->post['payment_status_id'], $this->request->post['comment'], $this->request->post['notify']);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
	public function changeStatus() {
		$sql = "SELECT * FROM oc_order INNER JOIN oc_order_product ON oc_order.order_id = oc_order_product.order_id WHERE oc_order.invoice_no = '".$_GET['invoice_no']."'";

		$query = $this->db->query($sql);

		$rows = $query->rows;

		if(!empty($rows)) {
			foreach($rows as $r) {
				$sql_update_status = "UPDATE oc_order_product SET oc_order_product.status = 2 WHERE oc_order_product.order_product_id = '".$r['order_product_id']."'";

				$this->db->query($sql_update_status);
			}
		}

		$this->response->redirect($this->url->link('sale/order/order1', 'user_token=' . $this->session->data['user_token'] . $url, true));
	}
}