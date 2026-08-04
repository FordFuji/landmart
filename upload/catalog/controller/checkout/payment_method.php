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
					'shipping_price' => @$shipping_price_test
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

		$cart_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "cart` INNER JOIN oc_product ON oc_cart.product_id = oc_product.product_id WHERE session_id = '" . $this->session->getId() . "'");

		$installment = true;
		$product_price = 0;
		if ($cart_query->num_rows) {
			foreach($cart_query->rows as $cq) {
				if(@$cq['product_installment'] == 'No') {
					$installment = false;
				}

				$product_price += $cq['price'] - @$this->session->data['discount_price'];
			}
		}

		if($installment == true and $product_price >= 2000 and $product_price <= 150000) {
			$installment_ = true;
		} else {
			$installment_ = false;
		}

		$data['product_installment'] = $installment_;

		$installment_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price ORDER BY installment_id asc");

		$rows = $installment_query->rows;

		if(!empty($rows)) {
			foreach($rows as $r) {
				$bank_id[$r['installment_bank_id']] = $r['installment_bank_id'];
			}
		}

		$data['banks_'] = @$bank_id;

		$installment1_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '1' ORDER BY installment_id asc");

		$data['installment1'] = $installment1_query->rows;


		$installment2_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '2' ORDER BY installment_id asc");

		$data['installment2'] = $installment2_query->rows;


		$installment3_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '3' ORDER BY installment_id asc");

		$data['installment3'] = $installment3_query->rows;


		$installment4_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '4' ORDER BY installment_id asc");

		$data['installment4'] = $installment4_query->rows;


		$installment5_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '5' ORDER BY installment_id asc");

		$data['installment5'] = $installment5_query->rows;


		$installment6_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '6' ORDER BY installment_id asc");

		$data['installment6'] = $installment6_query->rows;


		$installment7_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price AND installment_bank_id = '7' ORDER BY installment_id asc");

		$data['installment7'] = $installment7_query->rows;

		$data['product_price'] = $product_price;

		$who_installment_query = $this->db->query("SELECT * FROM fd_who_installment WHERE who_installment_id = 1");
		$data['whoInstallmentCtrl'] = $who_installment_query->row; 

		$this->response->setOutput($this->load->view('checkout/payment_method', $data));
	}

	public function ajaxCheckBank() {
		$product_price = $_GET['total2'];

		$installment_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= $product_price ORDER BY installment_id asc");

		$installment_id = array();
		$bank = array();
		if($installment_query->num_rows) {
			foreach($installment_query->rows as $iqr) {
				// เก็บค่า installment_id
				$installment_id[] = $iqr['installment_id'];

				if($iqr['installment_bank'] == 'ธนาคารกรุงศรี') {
					$bank[0] = '<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">
					<img src="asset/images/howtopay_15.png">
					ธนาคารกรุงศรี</a>';
				} elseif($iqr['installment_bank'] == 'ธนาคารกรุงเทพ') {
					$bank[1] = '<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
					<img src="asset/images/howtopay_03.png"> ธนาคารกรุงเทพ</a>';
				} elseif($iqr['installment_bank'] == 'กรุงศรีเฟิรส์ช้อยส์') {
					$bank[2] = '<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">
					<img src="asset/images/howtopay_03.png"> กรุงศรีเฟิรส์ช้อยส์</a>';
				} elseif($iqr['installment_bank'] == 'ธนาคารกสิกร') {
					$bank[3] = '<input type="radio" name="installment_name" value="'.$iqr['installment_bank_id'].'" onclick="selectInstallment('.$iqr['installment_bank_id'].');"> '.$iqr['installment_bank'].'<br><span id="bank_id_'.$iqr['installment_bank_id'].'"></span><br>';
				} elseif($iqr['installment_bank'] == 'ธนาคารกรุงไทย') {
					$bank[4] = '<input type="radio" name="installment_name" value="'.$iqr['installment_bank_id'].'" onclick="selectInstallment('.$iqr['installment_bank_id'].');"> '.$iqr['installment_bank'].'<br><span id="bank_id_'.$iqr['installment_bank_id'].'"></span><br>';
				} elseif($iqr['installment_bank'] == 'ธนาคารไทยพาณิชย์') {
					$bank[5] = '<input type="radio" name="installment_name" value="'.$iqr['installment_bank_id'].'" onclick="selectInstallment('.$iqr['installment_bank_id'].');"> '.$iqr['installment_bank'].'<br><span id="bank_id_'.$iqr['installment_bank_id'].'"></span><br>';
				} elseif($iqr['installment_bank'] == 'ธนาคารยูโอบี') {
					$bank[6] = '<input type="radio" name="installment_name" value="'.$iqr['installment_bank_id'].'" onclick="selectInstallment('.$iqr['installment_bank_id'].');"> '.$iqr['installment_bank'].'<br><span id="bank_id_'.$iqr['installment_bank_id'].'"></span><br>';
				}
			}
		}

		if(!empty($bank)) {
			foreach($bank as $b_val) {
				echo '<div align="left">';
				echo $b_val;
				echo '</div>';
			}
		}
?>
		<script src="asset/js/jquery-3.3.1.slim.min.js"></script>
		<script src="asset/js/jquery.min.js"></script>
		<script>
			function selectInstallment(installment_bank_id) {
				$.post('index.php?route=checkout/payment_method/ajaxCheckInstallment', { installment_bank_id: installment_bank_id, total2: '<?php echo $_GET['total2'];?>' }, function(data) {
					$("#bank_id_" + installment_bank_id).html(data);
				});
			}
		</script>
<?php
	}

	public function ajaxCheckInstallment() {
		$installment_query = $this->db->query("SELECT * FROM fd_installment WHERE installment_total <= '".$_POST['total2']."' AND installment_bank_id = '".$_POST['installment_bank_id']."' ORDER BY installment_id asc");

		$txt_installment = '';
		if($installment_query->num_rows) {
			foreach($installment_query->rows as $iqr) {
				$txt_installment .= '<input type="radio" name="installment_id" value="'.$iqr['installment_id'].'"> '.$iqr['installment_time'].' เดือน<br>';
			}
		}

		echo $txt_installment;
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

	public function paymentOmise() {
		require_once 'omise-php/lib/Omise.php';

		//pre($_POST);

		$post = $this->input->post(); 

		$omiseToken = $post['omiseToken'];

		$order_total = '100';

		define('OMISE_API_VERSION', '2017-11-02');
		define('OMISE_PUBLIC_KEY', 'pkey_test_5rpwigssywmnsk618oq');
		define('OMISE_SECRET_KEY', 'skey_test_5rpwigtwpispja0i662');

		$charge = OmiseCharge::create(array(
			'amount' => $_POST['total2'],
			'currency' => 'thb',
			'card' => $omiseToken
		));

		echo($charge['status']);

		/*print('<pre>');
		print_r($charge);
		print('</pre>');*/
	}
}
