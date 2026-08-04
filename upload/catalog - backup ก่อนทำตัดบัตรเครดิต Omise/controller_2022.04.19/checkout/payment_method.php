<?php
class ControllerCheckoutPaymentMethod extends Controller {
	public function index() {
		$this->load->language('checkout/checkout');

		//pre($this->session->data);

		$this->load->model('catalog/product');

		$data['cart_amount'] = $this->model_catalog_product->getCartOrderAmount();

		$data['carts'] = $this->model_catalog_product->getCartList();

		$sub_total = 0;
		$shipping_price = 0;
		$i = 0;
		$method_product = '';

		//pre($data['carts']);

		if(!empty($data['carts'])) {
			foreach($data['carts'] as $cart) {

				$option = json_decode($cart['option']);

				//pre($option[0]);

				$method_product = $this->model_catalog_product->getShippingProduct($cart['product_id']);

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 
					$shipping_price_test = $cart['shipping_price'] * $cart['quantity_']; 
				}

				if(!empty($option)) {
					$row = $this->model_catalog_product->getProductOptionValue($option[0]);
					if(!empty($row)) {
						if($row['price_prefix'] == '-') {
							$price_cal = $cart['product_price'] - $row['price'];
							$sub_total += $price_cal * $cart['quantity_'];
						} elseif($row['price_prefix'] == '+') {
							$price_cal = $cart['product_price'] + $row['price'];
							$sub_total += $price_cal * $cart['quantity_'];
						} 

						$option_ = $row['option_name'];
					} else {
						if($cart['special'] == 0) {
							$price_cal = $cart['product_price'];
							$sub_total += $cart['product_price'] * $cart['quantity_'];
						} else {
							$price_cal = $cart['special'];
							$sub_total += $cart['special'] * $cart['quantity_'];
						}

						$option_ = false;
					}
				} else {
					if($cart['special'] == 0) {
						$price_cal = $cart['product_price'];
						$sub_total += $cart['product_price'] * $cart['quantity_'];
					} else {
						$price_cal = $cart['special'];
						$sub_total += $cart['special'] * $cart['quantity_'];
					}

					$option_ = false;
				}

				//pre($option_);

				$data['carts_'][] = array(
					'product_id' => $cart['product_id'],
					'product_name' => $cart['product_name'],
					'option_name' => $cart['option_name'],
					'image' => $cart['image'],
					'name' => $cart['name'],
					'model' => $cart['model'],
					'quantity' => $cart['quantity_'],
					'special' => $cart['special'],
					'price' => $price_cal,
					'option' => $option_,
					'shipping_price' => $shipping_price_test
				);

				//pre($shipping_price);

				$i++;
			}
		}

		//pre($sub_total);

		if(@$this->session->data['free_shipping'] == 'true' or @$this->session->data['receive_product'] == 'รับสินค้าที่แลนด์มาร์ท') {
			$data['shipping_price'] = 0;
		} elseif(@$this->session->data['free_shipping'] == 'false') {
			$data['shipping_price'] = $shipping_price;
		} else {
			$data['shipping_price'] = $shipping_price;
		}

		/*if(!empty($data['carts'])) {
			$data['shipping'] = 0;
			$data['sub_total'] = $sub_total;
			$data['total'] = $sub_total + $data['shipping_price'];
		}*/

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['footer'] = $this->load->controller('common/footer');
		
		$data['sub_total'] = $this->session->data['sub_total'];
		$data['total'] = $this->session->data['total'];
		$data['coupon_code'] = @$this->session->data['coupon_code'];
		$data['discount_price'] = @$this->session->data['discount_price'];
		//$data['shipping_price'] = $this->session->data['shipping_price'];
		
		$data['method_shipping'] = $this->session->data['receive_product'];
		
		$data['method_product'] = $method_product;

		if(!empty($this->session->data['total2'])) {
			$data['total2'] = $this->session->data['total'] / 2;
		} else {
			$data['total2'] = $this->session->data['total'];
		}

		if(!empty($this->session->data['total2'])) {
			$data['total2_check'] = true;
		} else {
			$data['total2_check'] = false;
		}

		// payment_method
		$data['payment_method'] = $this->model_catalog_product->getPaymentMethod();

		//pre($data['payment_method']);

		$data['bank_account'] = $this->model_catalog_product->getBankAccount();

		$query = $this->db->query("SELECT * FROM oc_product ORDER BY product_id ASC");
		$data['productCtrl'] = $query->rows; 

		$data['free_shipping'] = @$this->session->data['free_shipping'];

		$data['count_qty'] = count($data['carts']);

		//echo $data['shipping_price'];

		$this->response->setOutput($this->load->view('checkout/payment_method', $data));
	}

	public function ajaxPaymentMethod() {
		//echo $_POST['payment_method'].'<br>';

		if(!empty($_POST['payment_method'])) {
			if($_POST['payment_method'] == 'credit_card') {
				$this->session->data['payment_method'] = 'บัตรเครดิต / บัตรเดบิต';
			} else if($_POST['payment_method'] == 'counter_service') {
				$this->session->data['payment_method'] = 'ชำระเงินผ่านทางเคาน์เตอร์เซอร์วิส';
			} else if($_POST['payment_method'] == 'online_banking') {
				$this->session->data['payment_method'] = 'Online Banking';
			} else if($_POST['payment_method'] == 'cod') {
				$this->session->data['payment_method'] = 'เก็บเงินปลายทาง COD';
			} else if($_POST['payment_method'] == 'installment_payment_0_percent') {
				$this->session->data['payment_method'] = 'จองสินค้า 50%';
			} else if($_POST['payment_method'] == 'book_50_percent') {
				$this->session->data['payment_method'] = 'จองสินค้า 50%';
			}
		}

		echo $this->session->data['payment_method'];
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if payment address has been set.
		if (!isset($this->session->data['payment_address'])) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!isset($this->request->post['payment_method'])) {
			$json['error']['warning'] = $this->language->get('error_payment');
		} elseif (!isset($this->session->data['payment_methods'][$this->request->post['payment_method']])) {
			$json['error']['warning'] = $this->language->get('error_payment');
		}

		if ($this->config->get('config_checkout_id')) {
			$this->load->model('catalog/information');

			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_checkout_id'));

			if ($information_info && !isset($this->request->post['agree'])) {
				$json['error']['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}

		if (!$json) {
			$this->session->data['payment_method'] = $this->session->data['payment_methods'][$this->request->post['payment_method']];

			$this->session->data['comment'] = strip_tags($this->request->post['comment']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
