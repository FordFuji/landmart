<?php
class ControllerExtensionModuleLaybuyLayout extends Controller {
	public function index() {
		$this->load->model('extension/module/laybuy_layout');

		$status = $this->config->get('module_laybuy_layout_status');

		if ($status && $this->config->get('payment_laybuy_status')) {
			if ($this->customer->isLogged()) {
				if (isset($this->request->get['order_id'])) {
					$order_id = $this->request->get['order_id'];

					if ($this->model_extension_module_laybuy_layout->isLayBuyOrder($order_id)) {
						$this->load->language('extension/module/laybuy_layout');

						$transaction_info = $this->model_extension_module_laybuy_layout->getTransactionByOrderId($order_id);

						$data['transaction'] = array(
							'laybuy_ref_no'      => $transaction_info['laybuy_ref_no'],
							'paypal_profile_id'  => $transaction_info['paypal_profile_id'],
							'status'             => $this->model_extension_module_laybuy_layout->getStatusLabel($transaction_info['status']),
							'amount'             => $this->currency->format($transaction_info['amount'], $transaction_info['currency']),
							'downpayment'        => $transaction_info['downpayment'],
							'months'             => $transaction_info['months'],
							'downpayment_amount' => $this->currency->format($transaction_info['downpayment_amount'], $transaction_info['currency']),
							'payment_amounts'    => $this->currency->format($transaction_info['payment_amounts'], $transaction_info['currency']),
							'first_payment_due'  => date($this->language->get('date_format_short'), strtotime($transaction_info['first_payment_due'])),
							'last_payment_due'   => date($this->language->get('date_format_short'), strtotime($transaction_info['last_payment_due'])),
							'report'             => json_decode($transaction_info['report'], true)
						);

						return $this->load->view('extension/module/laybuy_layout', $data);
					}
				}
			}
		}
	}
}['start'] < 0) {
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

	public function getTotalUploads() {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "upload";

		$implode = array();

		if (!empty($data['filter_name'])) {
			$implode[] = "name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_filename'])) {
			$implode[] = "filename LIKE '" . $this->db->escape($data['filter_filename']) . "%'";
		}

		if (!empty($data['filter_date_added'])) {
			$implode[] = "date_added = '" . $this->db->escape($data['filter_date_added']) . "'";
		}

		if ($implode) {
			$sql .= " WHERE " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
}