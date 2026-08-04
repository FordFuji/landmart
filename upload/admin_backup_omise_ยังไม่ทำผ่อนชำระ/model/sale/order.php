<?php
class ModelSaleOrder extends Model {
	public function getOrder($order_id) {
		$order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int)$order_id . "'");

		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			$reward = 0;

			$order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

			foreach ($order_product_query->rows as $product) {
				$reward += $product['reward'];
			}
			
			$this->load->model('customer/customer');

			$affiliate_info = $this->model_customer_customer->getCustomer($order_query->row['affiliate_id']);

			if ($affiliate_info) {
				$affiliate_firstname = $affiliate_info['firstname'];
				$affiliate_lastname = $affiliate_info['lastname'];
			} else {
				$affiliate_firstname = '';
				$affiliate_lastname = '';
			}

			$this->load->model('localisation/language');

			$language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

			if ($language_info) {
				$language_code = $language_info['code'];
			} else {
				$language_code = $this->config->get('config_language');
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'customer'                => $order_query->row['customer'],
				'customer_group_id'       => $order_query->row['customer_group_id'],
				'firstname'               => $order_query->row['firstname'],
				'lastname'                => $order_query->row['lastname'],
				'email'                   => $order_query->row['email'],
				'telephone'               => $order_query->row['telephone'],
				'custom_field'            => json_decode($order_query->row['custom_field'], true),
				'payment_firstname'       => $order_query->row['payment_firstname'],
				'payment_lastname'        => $order_query->row['payment_lastname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address_1'       => $order_query->row['payment_address_1'],
				'payment_address_2'       => $order_query->row['payment_address_2'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_custom_field'    => json_decode($order_query->row['payment_custom_field'], true),
				'payment_method'          => $order_query->row['payment_method'],
				'payment_code'            => $order_query->row['payment_code'],
				'shipping_firstname'      => $order_query->row['shipping_firstname'],
				'shipping_lastname'       => $order_query->row['shipping_lastname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address_1'      => $order_query->row['shipping_address_1'],
				'shipping_address_2'      => $order_query->row['shipping_address_2'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_custom_field'   => json_decode($order_query->row['shipping_custom_field'], true),
				'shipping_method'         => $order_query->row['shipping_method'],
				'shipping_code'           => $order_query->row['shipping_code'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'reward'                  => $reward,
				'order_status_id'         => $order_query->row['order_status_id'],
				'order_status'            => $order_query->row['order_status'],
				'affiliate_id'            => $order_query->row['affiliate_id'],
				'affiliate_firstname'     => $affiliate_firstname,
				'affiliate_lastname'      => $affiliate_lastname,
				'commission'              => $order_query->row['commission'],
				'language_id'             => $order_query->row['language_id'],
				'language_code'           => $language_code,
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'ip'                      => $order_query->row['ip'],
				'forwarded_ip'            => $order_query->row['forwarded_ip'],
				'user_agent'              => $order_query->row['user_agent'],
				'accept_language'         => $order_query->row['accept_language'],
				'date_added'              => $order_query->row['date_added'],
				'date_modified'           => $order_query->row['date_modified']
			);
		} else {
			return;
		}
	}

	public function getOrders($data = array()) {
		$sql = "SELECT o.order_id, CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int)$this->config->get('config_language_id') . "') AS order_status, o.shipping_code, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

		if (!empty($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "o.order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} elseif (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND o.order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(o.firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND o.total = '" . (float)$data['filter_total'] . "'";
		}

		$sort_data = array(
			'o.order_id',
			'customer',
			'order_status',
			'o.date_added',
			'o.date_modified',
			'o.total'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY o.order_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getOrderProducts($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderVoucherByVoucherId($voucher_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int)$voucher_id . "'");

		return $query->row;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}
	
	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

		if (!empty($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} elseif (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND total = '" . (float)$data['filter_total'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalOrdersByStoreId($store_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int)$store_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int)$order_status_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByProcessingStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_processing_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode));

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByCompleteStatus() {
		$implode = array();

		$order_statuses = $this->config->get('config_complete_status');

		foreach ($order_statuses as $order_status_id) {
			$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
		}

		if ($implode) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE " . implode(" OR ", $implode) . "");

			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getTotalOrdersByLanguageId($language_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int)$language_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}

	public function getTotalOrdersByCurrencyId($currency_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int)$currency_id . "' AND order_status_id > '0'");

		return $query->row['total'];
	}
	
	public function getTotalSales($data = array()) {
		$sql = "SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order`";

		if (!empty($data['filter_order_status'])) {
			$implode = array();

			$order_statuses = explode(',', $data['filter_order_status']);

			foreach ($order_statuses as $order_status_id) {
				$implode[] = "order_status_id = '" . (int)$order_status_id . "'";
			}

			if ($implode) {
				$sql .= " WHERE (" . implode(" OR ", $implode) . ")";
			}
		} elseif (isset($data['filter_order_status_id']) && $data['filter_order_status_id'] !== '') {
			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}

		if (!empty($data['filter_order_id'])) {
			$sql .= " AND order_id = '" . (int)$data['filter_order_id'] . "'";
		}

		if (!empty($data['filter_customer'])) {
			$sql .= " AND CONCAT(firstname, ' ', o.lastname) LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if (!empty($data['filter_date_modified'])) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
		}

		if (!empty($data['filter_total'])) {
			$sql .= " AND total = '" . (float)$data['filter_total'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function createInvoiceNo($order_id) {
		$order_info = $this->getOrder($order_id);

		if ($order_info && !$order_info['invoice_no']) {
			$query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

			if ($query->row['invoice_no']) {
				$invoice_no = $query->row['invoice_no'] + 1;
			} else {
				$invoice_no = 1;
			}

			$this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int)$invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int)$order_id . "'");

			return $order_info['invoice_prefix'] . $invoice_no;
		}
	}

	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}

		$query = $this->db->query("SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added DESC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int)$order_status_id . "'");

		return $query->row['total'];
	}
	
	public function getEmailsByProductsOrdered($products, $start, $end) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int)$start . "," . (int)$end);

		return $query->rows;
	}

	public function getTotalEmailsByProductsOrdered($products) {
		$implode = array();

		foreach ($products as $product_id) {
			$implode[] = "op.product_id = '" . (int)$product_id . "'";
		}

		$query = $this->db->query("SELECT COUNT(DISTINCT email) AS total FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

		return $query->row['total'];
	}

	public function getAddressTumbol() {
		$query = $this->db->query("select * from district inner join oc_order on district.DISTRICT_ID = oc_order.shipping_tumbol where oc_order.order_id = '".$_GET['order_id']."'");

		return $query->row;
	}

	public function getAddressAmphur() {
		$query = $this->db->query("select * from amphur inner join oc_order on amphur.AMPHUR_ID = oc_order.shipping_amphur where oc_order.order_id = '".$_GET['order_id']."'");

		return $query->row;
	}

	public function getAddressProvince() {
		$query = $this->db->query("select * from province inner join oc_order on province.PROVINCE_ID = oc_order.shipping_city where oc_order.order_id = '".$_GET['order_id']."'");

		return $query->row;
	}

	public function getOrderRecord() {
		$query = $this->db->query("select * from oc_order where order_id = '".$_GET['order_id']."'");

		return $query->row;
	}

	public function getOrderResult() {
		$query = $this->db->query("SELECT * FROM oc_order INNER JOIN oc_order_status ON oc_order.order_status_id = oc_order_status.order_status_id WHERE oc_order_status.order_status_id = 1 GROUP BY oc_order.order_id ORDER BY oc_order.order_id DESC");

		return $query->rows;
	}

	public function getOrderCategoryProductResult() {
		$query = $this->db->query("SELECT oc_category_description.name AS category_name, oc_order_product.order_id AS order_id_ FROM oc_order_product INNER JOIN oc_product_to_category ON oc_order_product.product_id = oc_product_to_category.product_id INNER JOIN oc_category_description ON oc_product_to_category.category_id = oc_category_description.category_id GROUP BY order_id_ ORDER BY oc_product_to_category.category_id DESC");

		return $query->rows;
	}

	public function getOrderProductResult() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id ORDER BY oc_product.product_id ASC");

		return $query->rows;
	}

	public function getProductPending($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '1' ORDER BY oc_order_product.order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '1' ORDER BY oc_order_product.order_product_id DESC LIMIT 1, 10");
		}

		return $query->rows;
	}

	public function countProductPending() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '1' ORDER BY oc_order_product.order_product_id DESC");

		return $query->rows;
	}

	public function getProductProcessing($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '2' or oc_order_product.status = '5' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '2' or oc_order_product.status = '5' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countProductProcessing() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '2' or oc_order_product.status = '5' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getProductProcessingComplete($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.status = '5' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.status = '5' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countProductProcessingComplete() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.status = '5' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getProductProcessed($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '15' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '15' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countProductProcessed() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '15' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getProductShipped($offset = '', $limit = '') {	
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '3' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '3' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countProductShipped() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id INNER JOIN oc_product_description ON oc_order_product.product_id = oc_product_description.product_id WHERE oc_order_product.status = '3' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getProductCanceled($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.status = '7' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.status = '7' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countProductCanceled() {
		$query = $this->db->query("SELECT *, oc_order_product.price as price_order FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.status = '7' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getProductAll($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countProductAll() {
		$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getOrderAll() {
		$query = $this->db->query("SELECT * FROM oc_order ORDER BY oc_order.order_id DESC");

		return $query->rows;
	}

	public function countOrderAll() {
		$query = $this->db->query("SELECT * FROM oc_order ORDER BY oc_order.order_id DESC");

		return $query->rows;
	}

	public function getCategoryOrder() {
		$query = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product_to_category ON oc_order_product.product_id = oc_product_to_category.product_id INNER JOIN oc_category_description ON oc_product_to_category.category_id = oc_category_description.category_id");

		return $query->row;
	}

	public function getTumbol() {
		$query = $this->db->query("SELECT * FROM district");

		return $query->rows;
	}

	public function getAmphur() {
		$query = $this->db->query("SELECT * FROM amphur");

		return $query->rows;
	}

	public function getProvince() {
		$query = $this->db->query("SELECT * FROM province");

		return $query->rows;
	}

	public function getCOD($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'เก็บเงินปลายทาง COD' OR oc_order.payment_method2 = 'เก็บเงินปลายทาง COD' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'เก็บเงินปลายทาง COD' OR oc_order.payment_method2 = 'เก็บเงินปลายทาง COD' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countCOD() {
		$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'เก็บเงินปลายทาง COD' OR oc_order.payment_method2 = 'เก็บเงินปลายทาง COD' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getCreditCard($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'บัตรเครดิต / บัตรเดบิต' OR oc_order.payment_method2 = 'บัตรเครดิต / บัตรเดบิต' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'บัตรเครดิต / บัตรเดบิต' OR oc_order.payment_method2 = 'บัตรเครดิต / บัตรเดบิต' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countCreditCard() {
		$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'บัตรเครดิต / บัตรเดบิต' OR oc_order.payment_method2 = 'บัตรเครดิต / บัตรเดบิต' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getBank($offset = '', $limit = '') {
		if(!empty($offset) and !empty($limit)) {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส' OR oc_order.payment_method2 = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส' OR oc_order.payment_method = 'Online Banking' OR oc_order.payment_method2 = 'Online Banking' ORDER BY order_product_id DESC LIMIT ".$offset.", ".$limit);
		} else {
			$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส' OR oc_order.payment_method2 = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส' OR oc_order.payment_method = 'Online Banking' OR oc_order.payment_method2 = 'Online Banking' ORDER BY order_product_id DESC LIMIT 0, 10");
		}

		return $query->rows;
	}

	public function countBank() {
		$query = $this->db->query("SELECT *, oc_order_product.status AS status_ FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order.payment_method = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส' OR oc_order.payment_method2 = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส' OR oc_order.payment_method = 'Online Banking' OR oc_order.payment_method2 = 'Online Banking' ORDER BY order_product_id DESC");

		return $query->rows;
	}

	public function getSlip() {
		$query = $this->db->query("SELECT * FROM fd_payment ORDER BY payment_id ASC");

		return $query->rows;
	}

	public function formatDatetime($datetime) {
		$datetime_exp = explode(' ', $datetime);

		if(!empty($datetime_exp)) {
			$date = explode('-', $datetime_exp[0]);

			$year = $date[0];
			$month = $date[1];
			$day = $date[2];

			return $day.'/'.$month.'/'.$year.' | '.$datetime_exp[1];
		}
	}

	public function getTumbolList() {
		$query = $this->db->query("SELECT * FROM district ORDER BY DISTRICT_ID ASC");

		return $query->rows;
	}

	public function getAmphurList() {
		$query = $this->db->query("SELECT * FROM amphur ORDER BY AMPHUR_ID ASC");

		return $query->rows;
	}

	public function getProvinceList() {
		$query = $this->db->query("SELECT * FROM province ORDER BY PROVINCE_ID ASC");

		return $query->rows;
	}
}
