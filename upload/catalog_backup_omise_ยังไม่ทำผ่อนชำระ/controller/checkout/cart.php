<?php
class ControllerCheckoutCart extends Controller {
	public function index() {
		$this->load->language('checkout/cart');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if(empty($this->model_catalog_product->getCartList())) {
			echo '<script>window.location.href="index.php"</script>';
		}

		//echo $this->session->data['member_id'];

		/*$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);*/

		/*if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {
			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
				$data['error_warning'] = $this->session->data['error'];

				unset($this->session->data['error']);
			} else {
				$data['error_warning'] = '';
			}

			if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
				$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
			} else {
				$data['attention'] = '';
			}

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit', '', true);

			if ($this->config->get('config_cart_weight')) {
				$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			} else {
				$data['weight'] = '';
			}

			$this->load->model('tool/image');
			$this->load->model('tool/upload');

			$data['products'] = array();

			$products = $this->cart->getProducts();

			foreach ($products as $product) {
				$product_total = 0;

				foreach ($products as $product_2) {
					if ($product_2['product_id'] == $product['product_id']) {
						$product_total += $product_2['quantity'];
					}
				}

				if ($product['minimum'] > $product_total) {
					$data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
				}

				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_width'), $this->config->get('theme_' . $this->config->get('config_theme') . '_image_cart_height'));
				} else {
					$image = '';
				}

				$option_data = array();

				foreach ($product['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}

				// Display prices
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$unit_price = $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'));
					
					$price = $this->currency->format($unit_price, $this->session->data['currency']);
					$total = $this->currency->format($unit_price * $product['quantity'], $this->session->data['currency']);
				} else {
					$price = false;
					$total = false;
				}

				$recurring = '';

				if ($product['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year')
					);

					if ($product['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
					}

					if ($product['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
					}
				}

				$data['products'][] = array(
					'cart_id'   => $product['cart_id'],
					'thumb'     => $image,
					'name'      => $product['name'],
					'model'     => $product['model'],
					'option'    => $option_data,
					'recurring' => $recurring,
					'quantity'  => $product['quantity'],
					'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('product/product', 'product_id=' . $product['product_id'])
				);
			}

			// Gift Voucher
			$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount'], $this->session->data['currency']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}

			// Totals
			$this->load->model('setting/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;
			
			// Because __call can not keep var references so we put them into an array. 			
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);
			
			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_setting_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get('total_' . $result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);
						
						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}

			$data['totals'] = array();

			foreach ($totals as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'], $this->session->data['currency'])
				);
			}

			$data['continue'] = $this->url->link('common/home');

			$data['checkout'] = $this->url->link('checkout/checkout', '', true);

			$this->load->model('setting/extension');

			$data['modules'] = array();
			
			$files = glob(DIR_APPLICATION . '/controller/extension/total/*.php');

			if ($files) {
				foreach ($files as $file) {
					$result = $this->load->controller('extension/total/' . basename($file, '.php'));
					
					if ($result) {
						$data['modules'][] = $result;
					}
				}
			}*/

		//echo pre($this->session->data['free_shipping']);

		$data['cart_amount'] = $this->model_catalog_product->getCartOrderAmount();

		$carts = $this->model_catalog_product->getCartList();

		$data['carts_'] = array();

		$sub_total = 0;
		$shipping_price = 0;
		$i = 0;
		//pre($carts);
		if(!empty($carts)) {
			foreach($carts as $cart) {
				// ถ้ามีสินค้าที่ไม่ใช่ มัดจำ 50% จะให้แสดงผลเป็นแบบธรรมดา
				if($cart['method_product'] != 'COD 50%') {
					unset($this->session->data['total2']);
				}

				$option = json_decode($cart['option']);

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 

					//echo $shipping_price;
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
					'option' => $option_
				);

				//pre($data['carts_']['option']);

				$i++;
			}
		}

		//pre($data['carts_']);

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');

		$data['member'] = $this->model_catalog_product->getMemberValue();

		if(!empty($data['member'])) {
			$data['provinces_list'] = $this->model_catalog_product->getProvinceList();

			$data['amphurs_list'] = $this->model_catalog_product->getAmphurList($data['member']['customer_province']);

			$data['amphurs_invoice_list'] = $this->model_catalog_product->getAmphurInvoiceList($data['member']['customer_invoice_province']);

			$data['tumbol_list'] = $this->model_catalog_product->getTumbolList($data['member']['customer_amphur']);

			$data['tumbol_invoice_list'] = $this->model_catalog_product->getTumbolInvoiceList($data['member']['customer_invoice_amphur']);
		} else {
			$data['provinces_list'] = $this->model_catalog_product->getProvinceList();

			$data['amphurs_list'] = $this->model_catalog_product->getAmphurList();

			$data['amphurs_invoice_list'] = $this->model_catalog_product->getAmphurInvoiceList();

			$data['tumbol_list'] = $this->model_catalog_product->getTumbolList();

			$data['tumbol_invoice_list'] = $this->model_catalog_product->getTumbolInvoiceList();
		}

		$data['shipping_price'] = $shipping_price;

		$data['businessHoursCtrl'] = $this->model_catalog_product->getBusinessHoursRecord();

		$data['discount_price'] = @$this->session->data['discount_price'];

		$data['coupon_code'] = @$this->session->data['coupon_code'];

		if(@$this->session->data['free_shipping'] == true) {
			$data['shipping'] = 0;
			$data['sub_total'] = $sub_total;
			$data['total'] = $sub_total - $data['discount_price'];

			//echo '123';
		} elseif(!empty($this->session->data['total2'])) {
			if(!empty($shipping_price)) {
				$data['shipping'] = $shipping_price;
			} else {
				$data['shipping'] = 0;
			}
			$data['sub_total'] = $sub_total;
			$data['total'] = $this->session->data['total2'];

			//echo '456';
		} else {
			$data['shipping'] = $shipping_price;
			$data['sub_total'] = $sub_total;
			$data['total'] = $sub_total + $shipping_price - $data['discount_price'];

			//echo '789';
		}

		$query = $this->db->query("SELECT * FROM oc_product ORDER BY product_id ASC");
		$data['productCtrl'] = $query->rows; 

		$data['free_shipping'] = @$this->session->data['free_shipping'];

		//echo $data['shipping'];

		$this->response->setOutput($this->load->view('checkout/cart', $data));
	}

	public function checkout() {
		if($_POST['check1'] == '3') {
			$this->session->data['receive_product'] = 'รับสินค้าตามที่อยู่ปลายทาง';
		} elseif($_POST['check1'] == '1') {
			$this->session->data['receive_product'] = 'รับสินค้าที่แลนด์มาร์ท';
		}

		$this->session->data['customer_id'] = @$this->session->data['member_id'];
		$this->session->data['firstname'] = $_POST['firstname'];
		$this->session->data['lastname'] = $_POST['lastname'];
		$this->session->data['telephone'] = $_POST['telephone'];
		$this->session->data['email'] = $_POST['email'];
		$this->session->data['customer_address1'] = $_POST['customer_address1'];
		$this->session->data['customer_address2'] = $_POST['customer_address2'];
		$this->session->data['customer_postcode'] = $_POST['customer_postcode'];
		$this->session->data['customer_province'] = $_POST['customer_province'];
		$this->session->data['customer_amphur'] = $_POST['customer_amphur'];
		$this->session->data['customer_tumbol'] = $_POST['customer_tumbol'];
		$this->session->data['customer_invoice_name'] = $_POST['customer_invoice_name'];
		$this->session->data['customer_invoice_address1'] = $_POST['customer_invoice_address1'];
		$this->session->data['customer_invoice_address2'] = $_POST['customer_invoice_address2'];
		$this->session->data['customer_invoice_postcode'] = $_POST['customer_invoice_postcode'];
		$this->session->data['customer_invoice_province'] = $_POST['customer_invoice_province'];
		$this->session->data['customer_invoice_amphur'] = $_POST['customer_invoice_amphur'];
		$this->session->data['customer_invoice_tumbol'] = $_POST['customer_invoice_tumbol'];
		$this->session->data['customer_card_id'] = $_POST['customer_card_id'];

		if(empty($_POST['firstname'])) {
			$this->session->data['firstname'] = $_POST['firstname_me'];
			$this->session->data['lastname'] = $_POST['lastname_me'];
			$this->session->data['telephone'] = $_POST['telephone_me'];
			$this->session->data['customer_address1'] = $_POST['address_me'];
			$this->session->data['email'] = $_POST['email_me'];
		}

		//pre($this->session->data);

		echo '<script>window.location.href="index.php?route=checkout/payment_method";</script>';
	}

	public function add() {
		$this->load->language('checkout/cart');

		$json = array();

		if (isset($this->request->post['product_id'])) {
			$product_id = (int)$this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');

		$product_info = $this->model_catalog_product->getProduct($product_id);

		if ($product_info) {
			if (isset($this->request->post['quantity'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = 1;
			}

			if (isset($this->request->post['option'])) {
				$option = array($this->request->post['option']);
			} else {
				$option = array();
			}

			$product_options = $this->model_catalog_product->getProductOptions($this->request->post['product_id']);

			foreach ($product_options as $product_option) {
				if ($product_option['required'] && empty($option[$product_option['product_option_id']])) {
					$json['error']['option'][$product_option['product_option_id']] = sprintf($this->language->get('error_required'), $product_option['name']);
				}
			}

			if (isset($this->request->post['recurring_id'])) {
				$recurring_id = $this->request->post['recurring_id'];
			} else {
				$recurring_id = 0;
			}

			$recurrings = $this->model_catalog_product->getProfiles($product_info['product_id']);

			if ($recurrings) {
				$recurring_ids = array();

				foreach ($recurrings as $recurring) {
					$recurring_ids[] = $recurring['recurring_id'];
				}

				if (!in_array($recurring_id, $recurring_ids)) {
					$json['error']['recurring'] = $this->language->get('error_recurring_required');
				}
			}

			//echo $this->session->getId();
		
			if (!$json) {
				// ford เขียนเพิ่ม
				/*if(!empty($this->session->data['member_id'])) {
					$member_id = $this->session->data['member_id'];
				} else {
					$member_id = 0;
				}

				if(!empty($_POST['color_size'])) {
					$query = $this->db->query("SELECT * FROM oc_cart WHERE `session_id` = '".$this->session->getId()."' AND product_id = '".$this->request->post['product_id']."' AND color_size = '".@$this->request->post['color_size']."'");
					$row_cart = $query->row;

					$datetime = date('Y-m-d H:i:s');
					if(!empty($row_cart)) {
						// update
						$quantity_ = $row_cart['quantity'] + $this->request->post['quantity'];

						$query = $this->db->query("UPDATE oc_cart SET quantity = '".$quantity_."' WHERE `session_id` = '".$this->session->getId()."' AND product_id = '".$this->request->post['product_id']."' AND color_size = '".@$this->request->post['color_size']."'");
					} else {
						// insert
						$query = $this->db->query("INSERT INTO oc_cart (customer_id, `session_id`, product_id,
		recurring_id, quantity, color_size, date_added) VALUES ('".$member_id."', '".$this->session->getId()."', '".$this->request->post['product_id']."', 0, '".$this->request->post['quantity']."', '".@$this->request->post['color_size']."', '".$datetime."')");
					}
				} else {
					$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);
				}
				// End ford เขียนเพิ่ม
				*/
				/* เช็คว่าสั่งซื้อสินค้า COD ได้ไม่เกิน 3 รายการ
				$query = $this->db->query("select * from oc_cart inner join oc_product on oc_cart.product_id = oc_product.product_id where oc_cart.session_id = '".$this->session->getId()."' and (oc_product.method_product = 'COD' or oc_product.method_product = 'COD 50%')");

				$rows = $query->rows;

				if(count($rows) > 3) {
					$json['total'] = '>3';
				} else { End เช็คว่าสั่งซื้อสินค้า COD ได้ไม่เกิน 3 รายการ */
					$this->cart->add($this->request->post['product_id'], $quantity, $option, $recurring_id);

					$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('checkout/cart'));

					// Unset all shipping and payment methods
					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
					unset($this->session->data['payment_method']);
					unset($this->session->data['payment_methods']);

					// Totals
					$this->load->model('setting/extension');

					$totals = array();
					$taxes = $this->cart->getTaxes();
					$total = 0;
			
					// Because __call can not keep var references so we put them into an array. 			
					$total_data = array(
						'totals' => &$totals,
						'taxes'  => &$taxes,
						'total'  => &$total
					);

					// Display prices
					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$sort_order = array();

						$results = $this->model_setting_extension->getExtensions('total');

						foreach ($results as $key => $value) {
							$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
						}

						array_multisort($sort_order, SORT_ASC, $results);

						foreach ($results as $result) {
							if ($this->config->get('total_' . $result['code'] . '_status')) {
								$this->load->model('extension/total/' . $result['code']);

								// We have to put the totals in an array so that they pass by reference.
								$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
							}
						}

						$sort_order = array();

						foreach ($totals as $key => $value) {
							$sort_order[$key] = $value['sort_order'];
						}

						array_multisort($sort_order, SORT_ASC, $totals);
					}

					//$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));

					$json['total'] = $this->cart->countProducts();
				//}
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	/*
	public function addMore() {
		if(!empty($this->session->data['member_id'])) {
			$member_id = $this->session->data['member_id'];
		} else {
			$member_id = 0;
		}

		if(!empty($_POST['color_size'])) {
			$query = $this->db->query("SELECT * FROM oc_cart WHERE `session_id` = '".$this->session->getId()."' AND product_id = '".$this->request->post['product_id']."' AND color_size = '".@$this->request->post['color_size']."'");
			$row_cart = $query->row;

			$datetime = date('Y-m-d H:i:s');
			if(!empty($row_cart)) {
				// update
				$quantity_ = $row_cart['quantity'] + $this->request->post['quantity'];

				$query = $this->db->query("UPDATE oc_cart SET quantity = '".$quantity_."' WHERE `session_id` = '".$this->session->getId()."' AND product_id = '".$this->request->post['product_id']."' AND color_size = '".@$this->request->post['color_size']."'");

				echo 'update';
			} else {
				// insert
				//$query = $this->db->query("INSERT INTO oc_cart (customer_id, `session_id`, product_id,recurring_id, quantity, color_size, date_added) VALUES ('".$member_id."', '".$this->session->getId()."', '".$this->request->post['product_id']."', 0, '".$this->request->post['quantity']."', '".@$this->request->post['color_size']."', '".$datetime."')");

				echo 'insert';
			}
		} else {
			$query = $this->db->query("SELECT * FROM oc_cart WHERE `session_id` = '".$this->session->getId()."' AND product_id = '".$this->request->post['product_id']."'");
			$row_cart = $query->row;

			$datetime = date('Y-m-d H:i:s');
			if(!empty($row_cart)) {
				// update
				$quantity_ = $row_cart['quantity'] + $this->request->post['quantity'];

				$query = $this->db->query("UPDATE oc_cart SET quantity = '".$quantity_."' WHERE `session_id` = '".$this->session->getId()."' AND product_id = '".$this->request->post['product_id']."'");

				echo 'update';
			} else {
				// insert
				//$query = $this->db->query("INSERT INTO oc_cart (customer_id, `session_id`, product_id,recurring_id, quantity, date_added) VALUES ('".$member_id."', '".$this->session->getId()."', '".$this->request->post['product_id']."', 0, '".$this->request->post['quantity']."', '".$datetime."')");

				echo 'insert';
			}
		}
	}*/

	public function edit() {
		$this->load->language('checkout/cart');

		$json = array();

		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}

			$this->session->data['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('checkout/cart');

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			$this->cart->remove($this->request->post['key']);

			unset($this->session->data['vouchers'][$this->request->post['key']]);

			$json['success'] = $this->language->get('text_remove');

			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);

			// Totals
			$this->load->model('setting/extension');

			$totals = array();
			$taxes = $this->cart->getTaxes();
			$total = 0;

			// Because __call can not keep var references so we put them into an array. 			
			$total_data = array(
				'totals' => &$totals,
				'taxes'  => &$taxes,
				'total'  => &$total
			);

			// Display prices
			if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				$results = $this->model_setting_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get('total_' . $value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get('total_' . $result['code'] . '_status')) {
						$this->load->model('extension/total/' . $result['code']);

						// We have to put the totals in an array so that they pass by reference.
						$this->{'model_extension_total_' . $result['code']}->getTotal($total_data);
					}
				}

				$sort_order = array();

				foreach ($totals as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $totals);
			}

			$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countProducts() + (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0), $this->currency->format($total, $this->session->data['currency']));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function ajaxShippingAndCoupon() {
		$this->load->model('catalog/product');

		// เช็คว่ารับสินค้าที่ Landmart รึเปล่า
		if(!empty($_POST['shipping_type']) and $_POST['shipping_type'] == 'me') {
			$this->session->data['free_shipping'] = true;
		} else {
			$this->session->data['free_shipping'] = false;
		}

		$query = $this->db->query("select * from oc_coupon where code = '".$_POST['coupon_code']."' and date_start <= '".date('Y-m-d')."' and date_end >= '".date('Y-m-d')."' and status = '1'");

		$row1 = $query->row;

		//pre($row1);

		$carts = $this->model_catalog_product->getCartList();
		// เหลือหายอด Sub Total รวม
		$sub_total = 0;
		$shipping_price = 0;
		$discount = 0;
		
		if(!empty($carts)) {
			foreach($carts as $cart) {
				$option = json_decode($cart['option']);

				//pre($option[0]);

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

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 

					//pre($cart['shipping_price']);
					//pre($cart['quantity_']);
					//pre($shipping_price);
				}
			}
		}

		$this->session->data['sub_total'] = $sub_total;

		if(!empty($row1)) {
			$this->session->data['coupon_code'] = $row1['code'];

			if($row1['type'] == 'P') {
				// ลดเป็น Percent
				$discount = $sub_total * $row1['discount'] / 100;
			} elseif($row1['type'] == 'F') {
				// ลดเป็นจำนวนเงิน
				$discount = $row1['discount'];
			}

			$this->session->data['discount_price'] = $discount;
			
			if($row1['shipping'] == 1) {
				$this->session->data['free_shipping'] = true;
			}

			if(@$this->session->data['free_shipping'] == true) {
				$total = $sub_total - $discount;
				$shipping_price = 0;
			} else {
				$total = $sub_total + $shipping_price - $discount;
			}

			echo number_format($sub_total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($discount, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($shipping_price, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo 'true';
		} else {
			unset($this->session->data['coupon_code']);
			unset($this->session->data['discount_price']);
			unset($this->session->data['free_shipping']);

			// เช็คว่ารับสินค้าที่ Landmart รึเปล่า
			if(!empty($_POST['shipping_type']) and $_POST['shipping_type'] == 'me') {
				$this->session->data['free_shipping'] = true;
			}

			if(@$this->session->data['free_shipping'] == true) {
				$total = $sub_total - $discount;
				$shipping_price = 0;
			} else {
				$total = $sub_total + $shipping_price - $discount;
			}

			echo number_format($sub_total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($discount, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($shipping_price, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo 'false';
		}

		$this->session->data['shipping_price'] = $shipping_price;
		$this->session->data['total'] = $total;
	}

	public function ajaxTotal50Percent() {
		$this->load->model('catalog/product');

		// เช็คว่ารับสินค้าที่ Landmart รึเปล่า
		if(!empty($_POST['shipping_type']) and $_POST['shipping_type'] == 'me') {
			$this->session->data['free_shipping'] = true;
		} else {
			$this->session->data['free_shipping'] = false;
		}

		$query = $this->db->query("select * from oc_coupon where code = '".$_POST['coupon_code']."' and date_start <= '".date('Y-m-d')."' and date_end >= '".date('Y-m-d')."' and status = '1'");

		$row1 = $query->row;

		//pre($row1);

		$carts = $this->model_catalog_product->getCartList();
		// เหลือหายอด Sub Total รวม
		$sub_total = 0;
		$shipping_price = 0;
		$discount = 0;
		if(!empty($carts)) {
			foreach($carts as $cart) {
				$option = json_decode($cart['option']);

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

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 

					//pre($cart['shipping_price']);
					//pre($cart['quantity_']);
					//pre($shipping_price);
				}
			}
		}

		$this->session->data['sub_total'] = $sub_total;

		if(!empty($row1)) {
			$this->session->data['coupon_code'] = $row1['code'];

			if($row1['type'] == 'P') {
				// ลดเป็น Percent
				$discount = $sub_total * $row1['discount'] / 100;
			} elseif($row1['type'] == 'F') {
				// ลดเป็นจำนวนเงิน
				$discount = $row1['discount'];
			}

			$this->session->data['discount_price'] = $discount;
			
			if($row1['shipping'] == 1) {
				$this->session->data['free_shipping'] = true;
			}

			if(@$this->session->data['free_shipping'] == true) {
				$total = $sub_total - $discount;
				$shipping_price = 0;
			} else {
				$total = $sub_total + $shipping_price - $discount;
			}

			echo number_format($sub_total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($discount, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($shipping_price, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo 'true';
		} else {
			unset($this->session->data['coupon_code']);
			unset($this->session->data['discount_price']);
			unset($this->session->data['free_shipping']);

			// เช็คว่ารับสินค้าที่ Landmart รึเปล่า
			if(!empty($_POST['shipping_type']) and $_POST['shipping_type'] == 'me') {
				$this->session->data['free_shipping'] = true;
			}

			if(@$this->session->data['free_shipping'] == true) {
				$total = $sub_total - $discount;
				$shipping_price = 0;
			} else {
				$total = $sub_total + $shipping_price - $discount;
			}

			echo number_format($sub_total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($discount, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($shipping_price, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo 'false';
		}

		$this->session->data['shipping_price'] = $shipping_price;
		$this->session->data['total'] = $total;

		$this->session->data['total2'] = $this->session->data['total'] / 2;

		pre($this->session->data['total2']);
	}

	public function ajaxSetNormal() {
		$this->load->model('catalog/product');

		// เช็คว่ารับสินค้าที่ Landmart รึเปล่า
		if(!empty($_POST['shipping_type']) and $_POST['shipping_type'] == 'me') {
			$this->session->data['free_shipping'] = true;
		} else {
			$this->session->data['free_shipping'] = false;
		}

		$query = $this->db->query("select * from oc_coupon where code = '".$_POST['coupon_code']."' and date_start <= '".date('Y-m-d')."' and date_end >= '".date('Y-m-d')."' and status = '1'");

		$row1 = $query->row;

		//pre($row1);

		$carts = $this->model_catalog_product->getCartList();
		// เหลือหายอด Sub Total รวม
		$sub_total = 0;
		$shipping_price = 0;
		$discount = 0;
		if(!empty($carts)) {
			foreach($carts as $cart) {
				$option = json_decode($cart['option']);

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

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 

					//pre($cart['shipping_price']);
					//pre($cart['quantity_']);
					//pre($shipping_price);
				}
			}
		}

		$this->session->data['sub_total'] = $sub_total;

		if(!empty($row1)) {
			$this->session->data['coupon_code'] = $row1['code'];

			if($row1['type'] == 'P') {
				// ลดเป็น Percent
				$discount = $sub_total * $row1['discount'] / 100;
			} elseif($row1['type'] == 'F') {
				// ลดเป็นจำนวนเงิน
				$discount = $row1['discount'];
			}

			$this->session->data['discount_price'] = $discount;
			
			if($row1['shipping'] == 1) {
				$this->session->data['free_shipping'] = true;
			}

			if(!empty($this->session->data['total2']) and @$this->session->data['free_shipping'] == true) {
				$total = $this->session->data['total2'];
				$shipping_price = 0;
			} elseif(!empty($this->session->data['total2']) and @$this->session->data['free_shipping'] != true) {
				$total = $this->session->data['total2'];
			} elseif(@$this->session->data['free_shipping'] == true) {
				$total = $sub_total - $discount;
				$shipping_price = 0;
			} else {
				$total = $sub_total + $shipping_price - $discount;
			}

			echo number_format($sub_total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($discount, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($shipping_price, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo 'true';
		} else {
			unset($this->session->data['coupon_code']);
			unset($this->session->data['discount_price']);
			unset($this->session->data['free_shipping']);

			// เช็คว่ารับสินค้าที่ Landmart รึเปล่า
			if(!empty($_POST['shipping_type']) and $_POST['shipping_type'] == 'me') {
				$this->session->data['free_shipping'] = true;
			}

			if(!empty($this->session->data['total2']) and @$this->session->data['free_shipping'] == true) {
				$total = $this->session->data['total2'];
				$shipping_price = 0;
			} elseif(!empty($this->session->data['total2']) and @$this->session->data['free_shipping'] != true) {
				$total = $this->session->data['total2'];
			} elseif(@$this->session->data['free_shipping'] == true) {
				$total = $sub_total - $discount;
				$shipping_price = 0;
			} else {
				$total = $sub_total + $shipping_price - $discount;
			}

			echo number_format($sub_total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($discount, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($shipping_price, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo number_format($total, 2, '.', ',');
			echo '!@#$%^&*()_';
			echo 'false';
		}

		$this->session->data['shipping_price'] = $shipping_price;
		$this->session->data['total'] = $total;
		//$this->session->data['total2'] = $this->session->data['total'] / 2;
		//unset($this->session->data['total2']);
	}

	public function ajaxDeleteCart() {
		$query = $this->db->query("DELETE FROM oc_cart WHERE product_id = '".$_POST['product_id']."' AND session_id = '".$this->session->getId()."'");

		//$this->ajaxCart();
	}

	public function ajaxUpdateCart() {
		$query = $this->db->query("UPDATE oc_cart SET quantity = '".$_POST['qty']."' WHERE product_id = '".$_POST['product_id']."' and session_id = '".$this->session->getId()."'");

		//$this->ajaxCart();
	}

	public function ajaxCart() {
		$this->load->model('catalog/product');

		$rows = $this->model_catalog_product->getCartList();
		
		print_r($rows);

		// [0] class="class_qty"
		$class_qty = 0;
		$class_sub_total = 0;
		$class_shipping = 0;
		$shipping_price = 0;
		$sub_total = 0;
		if(!empty($rows)) {
			foreach($rows as $cart) {
				$option = json_decode($cart['option']);

				//pre($option[0]);

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 
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

				$class_qty += $cart['quantity_'];
				$class_sub_total += $sub_total;
				$shipping = $cart['shipping_price'] * $cart['quantity_'];
				$class_shipping += $shipping;
			}
		}

		echo $class_qty;
		echo '!@#$%^&*()(*&^%$#@!';

		// [1] class="class_sub_total"
		echo number_format($class_sub_total, 2, '.', ',');
		echo '!@#$%^&*()(*&^%$#@!';

		// [2] class="class_discount"
		if(!empty($this->session->data['discount_price'])) {
			$class_discount = $this->session->data['discount_price'];
		} else {
			$class_discount = 0.00;
		}
		echo number_format($class_discount, 2, '.', ',');
		echo '!@#$%^&*()(*&^%$#@!';

		// [3] class="class_shipping"
		echo number_format($class_shipping, 2, '.', ',');
		echo '!@#$%^&*()(*&^%$#@!';

		// [4] class="class_total"
		$class_total = $class_sub_total - $class_discount + $class_shipping;
		echo number_format($class_total, 2, '.', ',');
		echo '!@#$%^&*()(*&^%$#@!';

		// [5] class="class_cart_basket"
		/*echo '<pre>';
		print_r($rows);
		echo '</pre>';
		*/

		$sub_total = 0;
		$shipping_price = 0;
		if(!empty($rows)) {
			foreach($rows as $cart) {
				$option = json_decode($cart['option']);

				//pre($option[0]);

				if($cart['shipping'] == '1') {
					$shipping_price += $cart['shipping_price'] * $cart['quantity_']; 
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
?>
						<div class="row">
							<div class="col-md-2">
								<img src="image/<?php echo $cart['image'];?>" class="img-fluid" alt="">
							</div>
							<div class="col-md-4">
								<div class="product_name">
									<h3><?php echo $cart['product_name'];?></h3><?php if($cart['option'] != false) { ?><h5>(<?php echo $cart['option'];?>)</h5><?php } ?>
									<span class="lightgray">
										รหัสสินค้า <?php echo $cart['model'];?>
									</span>
									<?php /*<span class="bot_tell">
										*งดร่วมรายการส่วนลดอื่นๆ
									</span> */ ?>
								</div>
							</div>
							<div class="col-6 col-md-2">
								<div class="product_name">
									<input type="button" value=" - " onclick="diffQty('<?php echo $cart['product_id'];?>');">
									<input type="number" id="qty_<?php echo $cart['product_id'];?>" style="width:50px;" value="<?php echo $cart['quantity'];?>" onblur="onblurQty('<?php echo $cart['product_id'];?>');">
									<input type="button" value=" + " onclick="plusQty('<?php echo $cart['product_id'];?>');">
								</div>
							</div>
							<div class="col-6 col-md-3 text-right text-md-left">
								<div class="product_name">
								฿<?php echo number_format($cart['price'], 2, '.', ',');?>
								</div>
							</div>
							<div class="col-md-1">
								<div class="product_name">
									<a href="javascript:deleteCart('<?php echo $cart['product_id'];?>');" style="color: black;"><i class="far fa-trash-alt"></i></a>
								</div>
							</div>
						</div>
<?php
			}
		}
	}

	public function getSessionAll() {
		pre($this->session->data);
	}
}
