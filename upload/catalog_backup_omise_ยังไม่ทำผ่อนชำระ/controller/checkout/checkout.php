<?php
class ControllerCheckoutCheckout extends Controller {
	public function index() {
		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$this->response->redirect($this->url->link('checkout/cart'));
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
				$this->response->redirect($this->url->link('checkout/cart'));
			}
		}

		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/moment/moment-with-locales.min.js');
		$this->document->addScript('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js');
		$this->document->addStyle('catalog/view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css');

		// Required by klarna
		if ($this->config->get('payment_klarna_account') || $this->config->get('payment_klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_cart'),
			'href' => $this->url->link('checkout/cart')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('checkout/checkout', '', true)
		);

		$data['text_checkout_option'] = sprintf($this->language->get('text_checkout_option'), 1);
		$data['text_checkout_account'] = sprintf($this->language->get('text_checkout_account'), 2);
		$data['text_checkout_payment_address'] = sprintf($this->language->get('text_checkout_payment_address'), 2);
		$data['text_checkout_shipping_address'] = sprintf($this->language->get('text_checkout_shipping_address'), 3);
		$data['text_checkout_shipping_method'] = sprintf($this->language->get('text_checkout_shipping_method'), 4);
		
		if ($this->cart->hasShipping()) {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 5);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 6);
		} else {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 3);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 4);	
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}

		$data['shipping_required'] = $this->cart->hasShipping();

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/checkout', $data));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function checkout() {
		//pre($this->session->data);
		
		// สร้าง invoice_no
		$query_invoice_no = $this->db->query("SELECT * FROM oc_order ORDER BY invoice_no DESC LIMIT 1");
		$row_invoice_no = $query_invoice_no->row;

		if(!empty($row_invoice_no)) {
			$invoice_no = $row_invoice_no['invoice_no'] + 1;
		} else {
			$invoice_no = 1;
		}
		// end สร้าง invoice_no

		$query = $this->db->query("select *, oc_cart.quantity as quantity_, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = oc_product.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special from oc_cart inner join oc_product on oc_cart.product_id = oc_product.product_id inner join oc_product_description on oc_cart.product_id = oc_product_description.product_id where oc_cart.session_id = '".$this->session->getId()."'");

		$rows = $query->rows;

		$sub_total = 0;
		$shipping_price = 0;

		if(@$this->session->data['receive_product'] == 'รับสินค้าที่แลนด์มาร์ท') {
			foreach($rows as $r) {
				if($r['special'] == 0) {
					$price = $r['price'];
					$sub_total += $r['price'] * $r['quantity'];
				} else {
					$price = $r['special'];
					$sub_total += $r['special'] * $r['quantity'];
				}
			}
		} elseif(!empty($rows)) {
			foreach($rows as $r) {
				if($r['special'] == 0) {
					$price = $r['price'];
					$sub_total += $r['price'] * $r['quantity'];
				} else {
					$price = $r['special'];
					$sub_total += $r['special'] * $r['quantity'];
				}

				if($r['shipping'] == '1') {
					$shipping_price += $r['shipping_price'] * $r['quantity_']; 
				}
			}
		}

		$total = $sub_total + $shipping_price;

		if(empty($this->session->data['member_id'])) {
			$customer_id = 0;
		} else {
			$customer_id = $this->session->data['member_id'];
		}

		if(!empty($this->session->data['total2'])) {
			$sql = "insert into oc_order (
				invoice_no,
				customer_id, 
				receive_product, 
				firstname, 
				lastname, 
				email, 
				telephone, 
				payment_firstname, 
				payment_address_1, 
				payment_address_2, 
				payment_city, 
				payment_postcode,
				payment_amphur,
				payment_tumbol, 
				payment_method, 
				payment_method2,
				shipping_firstname, 
				shipping_lastname, 
				shipping_address_1, 
				shipping_address_2, 
				shipping_city, 
				shipping_amphur, 
				shipping_tumbol, 
				shipping_postcode, 
				order_status_id,
				currency_code,
				shipping_price,
				total,
				date_added, 
				date_modified,
				payment_card_id,
				sub_total,
				coupon_code,
				discount_price
			) values (
				'".$invoice_no."',
				'".$customer_id."',
				'".$this->session->data['receive_product']."',
				'".$this->session->data['firstname']."',	
				'".$this->session->data['lastname']."',
				'".$this->session->data['email']."',
				'".$this->session->data['telephone']."',
				'".$this->session->data['customer_invoice_name']."',
				'".$this->session->data['customer_invoice_address1']."',
				'".$this->session->data['customer_invoice_address2']."',
				'".$this->session->data['customer_invoice_province']."',
				'".$this->session->data['customer_invoice_postcode']."',
				'".$this->session->data['customer_invoice_amphur']."',
				'".$this->session->data['customer_invoice_tumbol']."',
				'จองสินค้า 50%',
				'".$_POST['payment_method_']."',
				'".$this->session->data['firstname']."',
				'".$this->session->data['lastname']."',
				'".$this->session->data['customer_address1']."',
				'".$this->session->data['customer_address2']."',
				'".$this->session->data['customer_province']."',
				'".$this->session->data['customer_amphur']."',
				'".$this->session->data['customer_tumbol']."',
				'".$this->session->data['customer_postcode']."',
				'1',
				'THB',
				'".number_format(@$this->session->data['shipping_price'], 2, '.', '')."',
				'".number_format($this->session->data['total2'], 2, '.', '')."',
				'".date('Y-m-d H:i:s')."',
				'".date('Y-m-d H:i:s')."',
				'".$this->session->data['customer_card_id']."',
				'".number_format($this->session->data['sub_total'], 2, '.', '')."',
				'".@$this->session->data['coupon_code']."',
				'".@number_format($this->session->data['discount_price'], 2, '.', '')."'
			)";
		} else {
			$sql = "insert into oc_order (
				invoice_no,
				customer_id, 
				receive_product, 
				firstname, 
				lastname, 
				email, 
				telephone, 
				payment_firstname, 
				payment_address_1, 
				payment_address_2, 
				payment_city, 
				payment_postcode,
				payment_amphur,
				payment_tumbol, 
				payment_method, 
				shipping_firstname, 
				shipping_lastname, 
				shipping_address_1, 
				shipping_address_2, 
				shipping_city, 
				shipping_amphur, 
				shipping_tumbol, 
				shipping_postcode, 
				order_status_id,
				currency_code,
				shipping_price,
				total,
				date_added, 
				date_modified,
				payment_card_id,
				sub_total,
				coupon_code,
				discount_price
			) values (
				'".$invoice_no."',
				'".$customer_id."',
				'".$this->session->data['receive_product']."',
				'".$this->session->data['firstname']."',	
				'".$this->session->data['lastname']."',
				'".$this->session->data['email']."',
				'".$this->session->data['telephone']."',
				'".$this->session->data['customer_invoice_name']."',
				'".$this->session->data['customer_invoice_address1']."',
				'".$this->session->data['customer_invoice_address2']."',
				'".$this->session->data['customer_invoice_province']."',
				'".$this->session->data['customer_invoice_postcode']."',
				'".$this->session->data['customer_invoice_amphur']."',
				'".$this->session->data['customer_invoice_tumbol']."',
				'".$_POST['payment_method_']."',
				'".$this->session->data['firstname']."',
				'".$this->session->data['lastname']."',
				'".$this->session->data['customer_address1']."',
				'".$this->session->data['customer_address2']."',
				'".$this->session->data['customer_province']."',
				'".$this->session->data['customer_amphur']."',
				'".$this->session->data['customer_tumbol']."',
				'".$this->session->data['customer_postcode']."',
				'1',
				'THB',
				'".number_format(@$this->session->data['shipping_price'], 2, '.', '')."',
				'".number_format($this->session->data['total'], 2, '.', '')."',
				'".date('Y-m-d H:i:s')."',
				'".date('Y-m-d H:i:s')."',
				'".$this->session->data['customer_card_id']."',
				'".number_format($this->session->data['sub_total'], 2, '.', '')."',
				'".@$this->session->data['coupon_code']."',
				'".@number_format($this->session->data['discount_price'], 2, '.', '')."'
			)";
		}

		$this->db->query($sql);

		$query = $this->db->query("select * from oc_order order by order_id desc limit 1");

		$row = $query->row;

		if(!empty($row)) {
			$order_id = $row['order_id'];
		} else {
			$order_id = 1;
		}

		if(!empty($rows)) {
			foreach($rows as $r) {
				$product_option_value = json_decode($r['option']);

				if(!empty($product_option_value)) {
					$query_option_value = $this->db->query("SELECT * FROM oc_product_option_value INNER JOIN oc_option_value_description ON oc_product_option_value.option_value_id = oc_option_value_description.option_value_id WHERE product_option_value_id = '".$product_option_value[0]."'");

					$row_option_value = $query_option_value->row;

					if(!empty($row_option_value)) {
						$size_color = $row_option_value['name'];
						if($row_option_value['price_prefix'] == '+') {
							$price = $r['price'] + $row_option_value['price'];
							$sub_total = $price * $r['quantity_'];
						} elseif($row_option_value['price_prefix'] == '-') {
							$price = $r['price'] - $row_option_value['price'];
							$sub_total = $price * $r['quantity_'];
						}
					}
				} else {
					$size_color = '';
					if($r['special'] == 0) {
						$price = $r['price'];
						$sub_total = $r['price'] * $r['quantity_'];
					} else {
						$price = $r['special'];
						$sub_total = $r['special'] * $r['quantity_'];
					}
				}

				$query = $this->db->query("
					insert into oc_order_product
					(
					order_id,
					product_id,
					product_option_value_id,
					name,
					model,
					size_color,
					quantity,
					price,
					total,
					datetime_create,
					datetime_update
					) values (
					'".$order_id."',
					'".$r['product_id']."',
					'".@$product_option_value[0]."',
					'".$r['name']."',
					'".$r['model']."',
					'".@$size_color."',
					'".$r['quantity_']."',
					'".$price."',
					'".$sub_total."',
					'".date('Y-m-d H:i:s')."',
					'".date('Y-m-d H:i:s')."'
					)
				");
			}

			$query = $this->db->query("delete from oc_cart where session_id = '".$this->session->getId()."'");

			// Change Status
			if(move_uploaded_file($_FILES['payment_image']['tmp_name'], 'uploads_payment/'.$_FILES['payment_image']['name'])) {
				$exp_date = explode('/', $_POST['date_']);

				$date = $exp_date[2].'-'.$exp_date[0].'-'.$exp_date[1];

				if(!empty($this->session->data['total2'])) {
					$total = $this->session->data['total2'];
				} else {
					$total = $this->session->data['total'];
				}

				$this->db->query('INSERT INTO fd_payment(
					invoice_no,
					payment_total,
					payment_image,
					payment_datetime_create
				) VALUES (
					"'.$invoice_no.'",
					"'.$total.'",
					"uploads_payment/'.$_FILES['payment_image']['name'].'",
					"'.$date.' '.$_POST['time_'].'"
				)');

				// เปลี่ยน Status
				$query = $this->db->query('SELECT * FROM oc_order WHERE invoice_no = "'.$invoice_no.'"');

				$rows = $query->rows;

				if(!empty($rows)) {
					foreach($rows as $r) {
						$this->db->query('UPDATE oc_order_product SET 
							oc_order_product.status = "1",
							oc_order_product.datetime_processing = "'.date('Y-m-d H:i:s').'"
							WHERE oc_order_product.order_id = "'.$r['order_id'].'"
						');
					}
				}
			}

			// ford ส่งเมล์ คำสั่งซื้อ
			// Template Email

			$this->load->model('checkout/order');

			$query = $this->db->query("SELECT * FROM oc_order ORDER BY order_id DESC");
			$row = $query->row;

			if(!empty($row)) {
				$datetime_create = $this->model_checkout_order->formatDatetime($row['date_added']);

				if($row['payment_method'] == 'บัตรเครดิต / บัตรเดบิต') {
					/*$message = '
						<head>
							<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
						</head>

						<body>
							<style>
								body {
									font-family: "Prompt", sans-serif;
									color: #000;
								}

								@media print {

									body,
									page {
										margin: 0;
										box-shadow: 0;
									}

									.breaknewpage {
										page-break-after: always;
									}
								
								}
							</style>

							<div class="logo" style="display:inline-block; width:50%;">
								<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
							</div>
							
							<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
								Hello From LANDMART 
								<br>
								<span style="font-size:30px; color:#000;">
									<b> Thanks for your order!</b>
								</span>
								<br>
								<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
								<br>
								<span style="color:#96989b;">
									คำสั่งซื้อผ่าน บัตรเครดิต/เดบิต หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>โปรดรอทางระบบตรวจสอบการชำระเงินโดย บัตรเครดิต/เดบิต ภายใน 24 ชม. นับจากเวลาที่ทำรายการ เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
								</span> <br><br>
								<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							</div>
							<br>
							<span style="font-size:25px; color:#000;">
								<b> รายละเอียดคำสั่งซื้อ</b>
							</span>
							<table class="table_order" style="    
								font-size: 15px;
								width: 740px;
								max-width: 740px;
								min-width: 740px;
								margin-top: 15px;">';

					$message .= '
								<tr class="bg_gd">
									<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
									<td>
									<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
									</td>
								</tr>
								<tr>
									<td>วันที่สั่งซื้อ :</td>
									<td>'.$datetime_create.' น.</td>
								</tr>
								<tr>
									<td>ผู้ซื้อ:</td>
									<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
								</tr>';
					$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
					$row_order_product = $query_order_product->rows;
					$i = 0;
					if(!empty($row_order_product)) {
						foreach($row_order_product as $r) {
							$i++;
							$message .= '
								<tr>
									<td><br>
									<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
									'.$i.'. '.$r['name'].'
									</td>
								</tr>
								<tr>
									<td><b>ตัวเลือกสินค้า</b>  </td>
								</tr>
								<tr>
									<td>จำนวน :</td>
									<td>'.$r['quantity'].'</td>
								</tr>
								<tr>
									<td>ราคา :</td>
									<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
								</tr>';
						}
					}

					$message .= '
								<tr>
									<td>ยอดรวมสินค้า :</td>
									<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
								</tr>
								<tr>
									<td>ค่าจัดส่งสินค้า :</td>
									<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
								</tr>';
					if($row['discount_price'] != '0.00') {
						$message .= '
								<tr>
									<td>ส่วนลด :</td>
									<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
								</tr>
						';
					}

					$message .= '
								<tr>
									<td>ยอดที่ชำระทั้งหมด :</td>
									<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
								</tr>
							</table>
							<br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							<br>
								(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
							<br>
							<br>
							<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
								บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
								<br><br>

								<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

								<br>
								<span style="color:#96989b; font-size:14px;">
									อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
									ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
								</span>
							</center>
						</body>';	
					//echo $message;

					$to = 'landmartthailand@gmail.com, ';
					$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
					$rows_email = $query_email->rows;

					if(!empty($rows_email)) {
						foreach($rows_email as $r) {
							$to .= $r['email'].', ';
						}
					}

					$to .= $row['email'];

					if($to != '') {
						$to = substr($to, 0, -2);
					}

					$subject = 'คำสั่งซื้อ : Landmart';

					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= "From: webmaster@landmart.com\r\n"."X-Mailer: php";

					mail($to, $subject, $message, $headers);*/
				} elseif($row['payment_method'] == 'Online Banking') {
					$message = '
						<head>
							<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
						</head>

						<body>
							<style>
								body {
									font-family: "Prompt", sans-serif;
									color: #000;
								}

								@media print {

									body,
									page {
										margin: 0;
										box-shadow: 0;
									}

									.breaknewpage {
										page-break-after: always;
									}
								
								}
							</style>

							<div class="logo" style="display:inline-block; width:50%;">
								<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
							</div>
							
							<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
								Hello From LANDMART 
								<br>
								<span style="font-size:30px; color:#000;">
									<b> Thanks for your order!</b>
								</span>
								<br>
								<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
								<br>
								<span style="color:#96989b;">
									คำสั่งซื้อหมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>
									กรุณายืนยันการชำระเงินโดยการอัพโหลดสลิปการโอนเงิน ภายใน 24 ชม. นับจากเวลาที่ทำรายการ <br>
									เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
								</span> <br><br>
								<span style="color:#000;">
									วิธีชำระเงินผ่านการโอนเงินเข้าบัญชีธนาคาร <br>
									ธนาคารกสิกรไทย <br>
									ชื่อบัญชีบจก. แลนด์มาร์ท (ประเทศไทย) <br>
									หมายเลขบัญชี 051-1-68603-2
								</span> <br><br>
								<br><br>
								<span style="color:#c22d3b; font-size:15px;">
									(หมายเหตุ : กรุณาโอนเงินและแจ้งหลักฐานการโอน ภายใน 24 ชม. นับจากวันที่ทำรายการ แต่เมื่อทำการส่งหลักฐานการโอนเงินมาแล้วโปรดรอตรวจสอบข้อมูลภายใน 24 ชม
								</span>
								<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							</div>
							<br>
							<span style="font-size:25px; color:#000;">
								<b> รายละเอียดคำสั่งซื้อ</b>
							</span>
							<table class="table_order" style="    
								font-size: 15px;
								width: 740px;
								max-width: 740px;
								min-width: 740px;
								margin-top: 15px;">';

					$message .= '
								<tr class="bg_gd">
									<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
									<td>
									<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
									</td>
								</tr>
								<tr>
									<td>วันที่สั่งซื้อ :</td>
									<td>'.$datetime_create.' น.</td>
								</tr>
								<tr>
									<td>ผู้ซื้อ:</td>
									<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
								</tr>';
					$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
					$row_order_product = $query_order_product->rows;
					$i = 0;
					if(!empty($row_order_product)) {
						foreach($row_order_product as $r) {
							$i++;
							$message .= '
								<tr>
									<td><br>
									<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
									'.$i.'. '.$r['name'].'
									</td>
								</tr>
								<tr>
									<td><b>ตัวเลือกสินค้า</b>  </td>
								</tr>
								<tr>
									<td>จำนวน :</td>
									<td>'.$r['quantity'].'</td>
								</tr>
								<tr>
									<td>ราคา :</td>
									<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
								</tr>';
						}
					}

					$message .= '
								<tr>
									<td>ยอดรวมสินค้า :</td>
									<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
								</tr>
								<tr>
									<td>ค่าจัดส่งสินค้า :</td>
									<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
								</tr>';
					//if($row['discount_price'] != '0.00') {
						$message .= '
								<tr>
									<td>ส่วนลด :</td>
									<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
								</tr>
						';
					//}

					$message .= '
								<tr>
									<td>ยอดที่ชำระทั้งหมด :</td>
									<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
								</tr>
							</table>
							<br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							<br>
								(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
							<br>
							<br>
							<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
								บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
								<br><br>

								<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

								<br>
								<span style="color:#96989b; font-size:14px;">
									อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
									ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
								</span>
							</center>
						</body>';	
					//echo $message;

					$to = 'landmartthailand@gmail.com, ';
					$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
					$rows_email = $query_email->rows;

					if(!empty($rows_email)) {
						foreach($rows_email as $r) {
							$to .= $r['email'].', ';
						}
					}
						
					$to .= $row['email'].', ';

					if($to != '') {
						$to = substr($to, 0, -2);
					}

					$subject = 'Order : Landmart';

					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

					mail($to, $subject, $message, $headers);
				} elseif($row['payment_method'] == 'เก็บเงินปลายทาง COD') {
					$message = '
						<head>
							<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
						</head>

						<body>
							<style>
								body {
									font-family: "Prompt", sans-serif;
									color: #000;
								}

								@media print {

									body,
									page {
										margin: 0;
										box-shadow: 0;
									}

									.breaknewpage {
										page-break-after: always;
									}
								
								}
							</style>

							<div class="logo" style="display:inline-block; width:50%;">
								<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
							</div>
							
							<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
								Hello From LANDMART 
								<br>
								<span style="font-size:30px; color:#000;">
									<b> Thanks for your order!</b>
								</span>
								<br>
								<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
								<br>
								<span style="color:#96989b;">
									คำสั่งซื้อเก็บเงินปลายทาง (COD) หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. 
								</span> <br><br>
								<span style="color:#333;">
									ทำการสั่งซื้อสินค้า แบบการชำระเงินปลายทาง (COD)<br>
									(โปรดรอทำการตรวจสอบข้อมูลคำสั่งซื้อภายใน 24 ชม.)
								</span><br><br>
								<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							</div>
							<br>
							<span style="font-size:25px; color:#000;">
								<b> รายละเอียดคำสั่งซื้อ</b>
							</span>
							<table class="table_order" style="    
								font-size: 15px;
								width: 740px;
								max-width: 740px;
								min-width: 740px;
								margin-top: 15px;">';

					$message .= '
								<tr class="bg_gd">
									<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
									<td>
									<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
									</td>
								</tr>
								<tr>
									<td>วันที่สั่งซื้อ :</td>
									<td>'.$datetime_create.' น.</td>
								</tr>
								<tr>
									<td>ผู้ซื้อ:</td>
									<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
								</tr>';
					$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
					$row_order_product = $query_order_product->rows;
					$i = 0;
					if(!empty($row_order_product)) {
						foreach($row_order_product as $r) {

							$query_status = $this->db->query("UPDATE oc_order_product SET status = '2', datetime_processing = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$r['order_product_id']."'");
							
							$i++;
							$message .= '
								<tr>
									<td><br>
									<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
									'.$i.'. '.$r['name'].'
									</td>
								</tr>
								<tr>
									<td><b>ตัวเลือกสินค้า</b>  </td>
								</tr>
								<tr>
									<td>จำนวน :</td>
									<td>'.$r['quantity'].'</td>
								</tr>
								<tr>
									<td>ราคา :</td>
									<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
								</tr>';
						}
					}

					$message .= '
								<tr>
									<td>ยอดรวมสินค้า :</td>
									<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
								</tr>
								<tr>
									<td>ค่าจัดส่งสินค้า :</td>
									<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
								</tr>';
					//if($row['discount_price'] != '0.00') {
						$message .= '
								<tr>
									<td>ส่วนลด :</td>
									<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
								</tr>
						';
					//}

					$message .= '
								<tr>
									<td>ยอดที่ต้องชำระปลายทาง(COD)ทั้งหมด :</td>
									<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
								</tr>
							</table>
							<br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							<br>
								(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
							<br>
							<br>
							<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
								บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
								<br><br>

								<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

								<br>
								<span style="color:#96989b; font-size:14px;">
									อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
									ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
								</span>
							</center>
						</body>';	
					//echo $message;

					$to = 'landmartthailand@gmail.com, ';
					$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
					$rows_email = $query_email->rows;

					if(!empty($rows_email)) {
						foreach($rows_email as $r) {
							$to .= $r['email'].', ';
						}
					}

					$to .= $row['email'].', ';

					if($to != '') {
						$to = substr($to, 0, -2);
					}

					$subject = 'Order : Landmart';

					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

					mail($to, $subject, $message, $headers);
				} elseif($row['payment_method'] == 'จองสินค้า 50%') {
					$message = '
						<head>
							<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
						</head>

						<body>
							<style>
								body {
									font-family: "Prompt", sans-serif;
									color: #000;
								}

								@media print {

									body,
									page {
										margin: 0;
										box-shadow: 0;
									}

									.breaknewpage {
										page-break-after: always;
									}
								
								}
							</style>

							<div class="logo" style="display:inline-block; width:50%;">
								<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
							</div>
							
							<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
								Hello From LANDMART 
								<br>
								<span style="font-size:30px; color:#000;">
									<b> Thanks for your order!</b>
								</span>
								<br>
								<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
								<br>
								<span style="color:#96989b;">
									คำสั่งซื้อแบบ (COD 50%) หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>
									กรุณายืนยันการชำระเงินโดยการอัพโหลดสลิปการโอนเงิน ภายใน 24 ชม. นับจากเวลาที่ทำรายการ <br>
									เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
								</span> <br><br>
								<span style="color:#000;">
									วิธีชำระเงินผ่านการโอนเงินเข้าบัญชีธนาคาร <br>
									ธนาคารไทยพาณิชย์ <br>
									ชื่อบัญชีบจก. แลนด์มาร์ท (ประเทศไทย) <br>
									หมายเลขบัญชี 468-0-65951-6
								</span> <br><br>
								<br><br>
								<span style="color:#c22d3b; font-size:15px;">
									(หมายเหตุ : กรุณาโอนเงินและแจ้งหลักฐานการโอน ภายใน 24 ชม. นับจากวันที่ทำรายการ แต่เมื่อทำการส่งหลักฐานการโอนเงินมาแล้วโปรดรอตรวจสอบข้อมูลภายใน 24 ชม
								</span>
								<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							</div>
							<br>
							<span style="font-size:25px; color:#000;">
								<b> รายละเอียดคำสั่งซื้อ</b>
							</span>
							<table class="table_order" style="    
								font-size: 15px;
								width: 740px;
								max-width: 740px;
								min-width: 740px;
								margin-top: 15px;">';

					$message .= '
								<tr class="bg_gd">
									<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
									<td>
									<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
									</td>
								</tr>
								<tr>
									<td>วันที่สั่งซื้อ :</td>
									<td>'.$datetime_create.' น.</td>
								</tr>
								<tr>
									<td>ผู้ซื้อ:</td>
									<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
								</tr>';
					$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
					$row_order_product = $query_order_product->rows;
					$i = 0;
					if(!empty($row_order_product)) {
						foreach($row_order_product as $r) {
							$i++;
							$message .= '
								<tr>
									<td><br>
									<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
									'.$i.'. '.$r['name'].'
									</td>
								</tr>
								<tr>
									<td><b>ตัวเลือกสินค้า</b>  </td>
								</tr>
								<tr>
									<td>จำนวน :</td>
									<td>'.$r['quantity'].'</td>
								</tr>
								<tr>
									<td>ราคา :</td>
									<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
								</tr>';
						}
					}

					$message .= '
								<tr>
									<td>ยอดรวมสินค้า :</td>
									<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
								</tr>
								<tr>
									<td>ค่าจัดส่งสินค้า :</td>
									<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
								</tr>';
					//if($row['discount_price'] != '0.00') {
						$message .= '
								<tr>
									<td>ส่วนลด :</td>
									<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
								</tr>
						';
					//}

					$message .= '
								<tr>
									<td>ยอดที่ต้องชำระทั้งหมด :</td>
									<td><span style="color:#c22d3b;">฿'.number_format($row['total'] * 2, 0, '.', ',').'</span></td>
								</tr>
								<tr>
									<td>ยอดที่ต้องชำระเก็บเงินปลายทาง 50% :</td>
									<td><span style="color:#c22d3b;">฿'.number_format($row['total'], 0, '.', ',').'</span></td>
								</tr>
								<tr>
									<td>ยอดที่ต้องชำระมัดจำก่อน 50% :</td>
									<td><span style="color:#c22d3b;">฿'.number_format($row['total'], 0, '.', ',').'</span></td>
								</tr>
							</table>
							<br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
							<br>
								(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
							<br>
							<br>
							<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
								บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
								<br><br>

								<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

								<br>
								<span style="color:#96989b; font-size:14px;">
									อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
									ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
								</span>
							</center>
						</body>';	
					//echo $message;

					$to = 'landmartthailand@gmail.com, ';
					$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
					$rows_email = $query_email->rows;

					if(!empty($rows_email)) {
						foreach($rows_email as $r) {
							$to .= $r['email'].', ';
						}
					}

					$to .= $row['email'].', ';

					if($to != '') {
						$to = substr($to, 0, -2);
					}

					$subject = 'Order : Landmart';

					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

					mail($to, $subject, $message, $headers);
				}
			}

			// End ford ส่งเมล์ คำสั่งซื้อ

			unset($this->session->data['shipping_type']);
			unset($this->session->data['sub_total']);
			//unset($this->session->data['total']);
			unset($this->session->data['coupon_code']);
			unset($this->session->data['discount_price']);
			unset($this->session->data['shipping_type']);
			unset($this->session->data['shipping_price']);
			unset($this->session->data['free_shipping']);
		}

		if($_POST['payment_method_'] == 'บัตรเครดิต / บัตรเดบิต') {
			if(!empty($this->session->data['total2'])) {
				$total = number_format($this->session->data['total2'], 2, '.', '');
			} elseif(!empty($this->session->data['total'])) {
				$total = number_format($this->session->data['total'], 2, '.', '');
			}

			if(!empty($this->session->data['total2'])) {
				$total = $this->session->data['total2'];
			} elseif(!empty($this->session->data['total'])) {
				$total = $this->session->data['total'];
			}

			/*$pymtReturnURL = HTTPS_SERVER.'index.php?route=checkout/checkout/returnPaymentGateway&invoice_no='.$invoice_no;
?>
			<!-- 
			<form id="payment_form" method='post' action='https://payment.webpakpay.com/api.php'>
				<input type='hidden' name='pymtToken' value='986c5943e427485b320803d0d24c4691fb44d854d14cb2768aec198b894e1a9d'>
				<input type='hidden' name='pymtProcess' value='PAYMENT'>
				<input type='hidden' name='pymtType' value='PDT'>
				<input type='hidden' name='pymtMethod' value='ANY'>
				<input type='hidden' name='pymtLang' value='TH'>
				<input type='hidden' name='pymtCurrency' value='THB'>
				<input type='hidden' name='pymtNumber' value='<?php echo $invoice_no;?>'>
				<input type='hidden' name='pymtDesc' value='Order Landmart'>
				<input type='hidden' name='pymtAmount' value='<?php echo number_format($total, 2, '.', '');?>'>
				<input type='hidden' name='pymtCustName' value='<?php echo $this->session->data['firstname'].' '.$this->session->data['lastname'];?>'>
				<input type='hidden' name='pymtCustMobile' value='<?php echo $this->session->data['telephone'];?>'>
				<input type='hidden' name='pymtCustEmail' value='<?php echo $this->session->data['email'];?>'>
				<input type='hidden' name='pymtCustIP' value='<?php echo $_SERVER['REMOTE_ADDR'];?>'>
				<input type='hidden' name='pymtReturnURL' value='<?php echo $pymtReturnURL;?>'>
				<input type='hidden' name='pymtTermURL' value='HTTPS_SERVER.'index.php?route=information/contact/term'>
			</form>
			
			<script src="asset/js/jquery.min.js"></script>

			<script>
				$( document ).ready(function() {
					$("#payment_form").submit();
				});
			</script> -->
<?php	
			*/
			//pre($_POST);

			require_once 'omise-php/lib/Omise.php';
			 
			$omiseToken = $_POST['omiseToken'];

			$order_total = $total * 100;

			if($_SERVER['SERVER_NAME'] == 'localhost' or $_SERVER['SERVER_NAME'] == 'ford.orangeworkshop.info') {
				//define('OMISE_API_VERSION', '2017-11-02');
				define('OMISE_API_VERSION', '2019-05-29');
				define('OMISE_PUBLIC_KEY', 'pkey_test_5rgblv3gakwqqe0r1o8');
				define('OMISE_SECRET_KEY', 'skey_test_5rgblv4h140fbd7ku7t');

				$charge = OmiseCharge::create(array(
					'amount' => $order_total,
					'currency' => 'thb',
					'return_uri' => 'https://ford.orangeworkshop.info/landmart/index.php?route=checkout/checkout/returnPaymentGateway&invoice_no='.$invoice_no,
					'description' => 'Invoice No. '.$invoice_no,
					'metadata'    => array(
						'order_id'  => $invoice_no
					),
					'card' => $omiseToken
				));
			} else {
				//define('OMISE_API_VERSION', '2017-11-02');
				define('OMISE_API_VERSION', '2019-05-29');
				define('OMISE_PUBLIC_KEY', 'pkey_5ro8ryoakfqn8a7s7sm');
				define('OMISE_SECRET_KEY', 'skey_5rwrxuh2ugyaegl0rle');

				$charge = OmiseCharge::create(array(
					'amount' => $order_total,
					'currency' => 'thb',
					'return_uri'  => 'https://www.landmart.co.th/index.php?route=checkout/checkout/returnPaymentGateway&invoice_no='.$invoice_no,
					'description' => 'Invoice No. '.$invoice_no,
					'metadata'    => array(
						'order_id'  => $invoice_no
					),
					'card' => $omiseToken
				));
			}

			//pre($charge);

			$this->session->data['charge_id'] = $charge['id'];
			
			//echo $this->session->data['charge_id'];
			//if($charge['status'] == 'successful') {

				unset($this->session->data['total2']);
				/*
?>
				<script>window.location.href = 'index.php?route=checkout/checkout/returnPaymentGateway&invoice_no=<?php echo $invoice_no;?>';</script>";
<?php
				*/
			//}

			//header('Location: ' . $charge['authorize_uri']);

			echo '<script>window.location.href="'.$charge['authorize_uri'].'";</script>';
		} else {
			unset($this->session->data['total2']);
			
			echo "<script>window.location.href = 'index.php?route=checkout/checkout/thank_you&invoice_no=".$invoice_no."';</script>";
		}
	}

	public function returnPaymentGateway() {
		$this->load->model('checkout/order');

		require_once 'omise-php/lib/Omise.php';

		if($_SERVER['SERVER_NAME'] == 'localhost' or $_SERVER['SERVER_NAME'] == 'ford.orangeworkshop.info') {
			define('OMISE_API_VERSION', '2019-05-29');
			define('OMISE_PUBLIC_KEY', 'pkey_test_5rgblv3gakwqqe0r1o8');
			define('OMISE_SECRET_KEY', 'skey_test_5rgblv4h140fbd7ku7t');
		} else {
			define('OMISE_API_VERSION', '2019-05-29');
			define('OMISE_PUBLIC_KEY', 'pkey_5ro8ryoakfqn8a7s7sm');
			define('OMISE_SECRET_KEY', 'skey_5rwrxuh2ugyaegl0rle');
		}
		
		$charge = OmiseCharge::retrieve($this->session->data['charge_id']);

		//if($_POST['resultCode'] == '00') {
		if($charge['authorized'] == false || $charge['paid'] == false) {
			echo "<h3 align='center'>บัตรเครดิตมีปัญหา</h3>";
		} else {
			$query = $this->db->query('SELECT * FROM oc_order INNER JOIN oc_order_product ON oc_order.order_id = oc_order_product.order_id WHERE oc_order.invoice_no = "'.$_GET['invoice_no'].'"');

			$rows = $query->rows;

			if(!empty($rows)) {
				foreach($rows as $s) {
					$query = $this->db->query('UPDATE oc_order_product SET status = "2" WHERE order_product_id = "'.$s['order_product_id'].'"');
				}
			}

			// send mail
			$query = $this->db->query("SELECT * FROM oc_order WHERE invoice_no = '".$_GET['invoice_no']."'");
			$row = $query->row;

			if(!empty($row)) {
				$datetime_create = $this->model_checkout_order->formatDatetime($row['date_added']);

				$message = '
					<head>
						<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
					</head>

					<body>
						<style>
							body {
								font-family: "Prompt", sans-serif;
								color: #000;
							}

							@media print {

								body,
								page {
									margin: 0;
									box-shadow: 0;
								}

								.breaknewpage {
									page-break-after: always;
								}
							
							}
						</style>

						<div class="logo" style="display:inline-block; width:50%;">
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
						</div>
						
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							Hello From LANDMART 
							<br>
							<span style="font-size:30px; color:#000;">
								<b> Thanks for your order!</b>
							</span>
							<br>
							<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
							<br>
							<span style="color:#96989b;">
								คำสั่งซื้อผ่าน <b>บัตรเครดิต/เดบิต</b> หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>โปรดรอทางระบบตรวจสอบการชำระเงินโดย <b>บัตรเครดิต/เดบิต</b> ภายใน 24 ชม. นับจากเวลาที่ทำรายการ เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
							</span> <br><br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						</div>
						<br>
						<span style="font-size:25px; color:#000;">
							<b> รายละเอียดคำสั่งซื้อ</b>
						</span>
						<table class="table_order" style="    
							font-size: 15px;
							width: 740px;
							max-width: 740px;
							min-width: 740px;
							margin-top: 15px;">';

				$message .= '
							<tr class="bg_gd">
								<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
								<td>
								<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
								</td>
							</tr>
							<tr>
								<td>วันที่สั่งซื้อ :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';
				$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
				$row_order_product = $query_order_product->rows;
				$i = 0;
				if(!empty($row_order_product)) {
					foreach($row_order_product as $r) {
						$i++;
						$message .= '
							<tr>
								<td><br>
								<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
								'.$i.'. '.$r['name'].'
								</td>
							</tr>
							<tr>
								<td><b>ตัวเลือกสินค้า</b>  </td>
							</tr>
							<tr>
								<td>จำนวน :</td>
								<td>'.$r['quantity'].'</td>
							</tr>
							<tr>
								<td>ราคา :</td>
								<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
							</tr>';
					}
				}

				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
							</tr>';
				//if($row['discount_price'] != '0.00') {
					$message .= '
							<tr>
								<td>ส่วนลด :</td>
								<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
							</tr>
					';
				//}

				$message .= '
							<tr>
								<td>ยอดที่ชำระทั้งหมด :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
						<br>
						<br>
						<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
							บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
							<br><br>

							<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

							<br>
							<span style="color:#96989b; font-size:14px;">
								อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
								ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
							</span>
						</center>
					</body>';	
				//echo $message;

				$to = 'landmartthailand@gmail.com, ';
				$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
				$rows_email = $query_email->rows;

				if(!empty($rows_email)) {
					foreach($rows_email as $r) {
						$to .= $r['email'].', ';
					}
				}

				$to .= $row['email'].', ';

				if($to != '') {
					$to = substr($to, 0, -2);
				}

				$subject = 'Order : Landmart';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
				// end send mail

				echo "<script>window.location.href = 'index.php?route=checkout/checkout/thank_you&invoice_no=".$_GET['invoice_no']."';</script>";
			}
		}
	}

	public function thank_you() {
		unset($this->session->data['total2']);

		$data = array(
			'invoice_no' => $_GET['invoice_no']
		);

		$query = $this->db->query("SELECT * FROM oc_order WHERE invoice_no = '".$_GET['invoice_no']."'");

		$order = $query->row;

		if(!empty($order)) {
			$data['row'] = $order; 
		}

		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('thank_you/thank_you', $data));
	}

	/*public function testSendMail() {
		// Template Email
		$query = $this->db->query("SELECT * FROM oc_order ORDER BY order_id DESC");
		$row = $query->row;

		//pre($row);

		if(!empty($row)) {
			// อีเมล์คำสั่งซื้อ
			
			// หน้า 1
			$datetime = explode(' ', $row['date_added']);

			$date = explode('-', $datetime[0]);

			$year = $date[0];

			$month = $date[1];

			$day = $date[2];

			if($month == '01') {
				$month_ = 'Jan';
			} elseif($month == '02') {
				$month_ = 'Feb';
			} elseif($month == '03') {
				$month_ = 'Mar';
			} elseif($month == '04') {
				$month_ = 'Apr';
			} elseif($month == '05') {
				$month_ = 'May';
			} elseif($month == '06') {
				$month_ = 'Jun';
			} elseif($month == '07') {
				$month_ = 'Jul';
			} elseif($month == '08') {
				$month_ = 'Aug';
			} elseif($month == '09') {
				$month_ = 'Sep';
			} elseif($month == '10') {
				$month_ = 'Oct';
			} elseif($month == '11') {
				$month_ = 'Nov';
			} elseif($month == '12') {
				$month_ = 'Dec';
			}

			$message = '<table border="1" width="100%" style="border-collapse: collapse;">';

			if($row['receive_product'] == 'รับสินค้าที่แลนด์มาร์ท') {
				$message .= '<tr><th align="left" width="25%">ชื่อลูกค้า</th><td>'.$row['firstname'].' '.$row['lastname'].'</td></tr><tr><th align="left">ที่อยู่</th><td>'.$row['shipping_address_1'].'</td></tr><tr><th align="left">เบอร์โทรศัพท์</th><td>'.$row['telephone'].'</td></tr>';
			} elseif($row['receive_product'] == 'รับสินค้าตามที่อยู่ปลายทาง') {
				$query_tumbol = $this->db->query("SELECT * FROM district WHERE DISTRICT_ID = '".$row['shipping_tumbol']."'"); 
				$row_tumbol = $query_tumbol->row;

				$query_amphur = $this->db->query("SELECT * FROM amphur WHERE AMPHUR_ID = '".$row['shipping_amphur']."'");
				$row_amphur = $query_amphur->row;

				$query_province = $this->db->query("SELECT * FROM province WHERE PROVINCE_ID = '".$row['shipping_city']."'");
				$row_province = $query_province->row;

				$message .= '<tr><th align="left" width="25%">ชื่อลูกค้า</th><td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td></tr><tr><th align="left">ที่อยู่</th><td>'.$row['shipping_company'].' '.$row['shipping_address_1'].' '.$row['shipping_address_2'].' '.$row_tumbol['DISTRICT_NAME'].' '.$row_amphur['AMPHUR_NAME'].' '.$row_province['PROVINCE_NAME'].' '.$row['shipping_postcode'].'</td></tr><tr><th align="left">เบอร์โทรศัพท์</th><td>'.$row['telephone'].'</td></tr>';
			}

			$message .= '</table>';
			$message .= '<br>';
			$message .= '<table border="1" width="100%" style="border-collapse: collapse;">';
			$message .= '<tr><th width="15%">Date/วันที่</th><th width="15%">SKU/รหัสสินค้า</th><th width="35%">Image/รูปภาพ</th><th width="35%">Product/สินค้า</th></tr>';
			
			$query_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."'");
			$rows = $query_product->rows;

			$i = 0;
			if(!empty($rows)) {
				foreach($rows as $r) {
					$i++;
					$message .= '<tr></tr><td>'.$day.' '.$month_.' '.$year.'</td><td>'.$r['model'].'</td><td><img src="image/'.$r['image'].'" width="150"></td><td>'.$r['name'].'</td></tr>';
				}
			}

			$message .= '</table>';
			$message .= '<br>';
			$message .= '<table border="1" width="100%" style="border-collapse: collapse;">';
			$message .= '<tr><th>Order Number/เลขที่ออร์เดอร์</th><th>Package/จำนวนชิ้น </th></tr>';
			$message .= '<tr><td>'.$row['invoice_no'].'</td><td>'.$i.'</td></tr>';
			$message .= '</table>';
			//echo $message;
			
			$to = 'landmart.online1@gmail.com, nirvanaford94@gmail.com';
			$subject = 'อีเมล์คำสั่งซื้อ';
			$headers = 'From: webmaster@landmart.com' . "\r\n" .
				'Reply-To: webmaster@landmart.com' . "\r\n" .
				'X-Mailer: PHP/' . phpversion();

			mail($to, $subject, $message, $headers);
			// end template email
		}
	}*/

	public function testSendMail() {
		// ford ส่งเมล์ คำสั่งซื้อ
		// Template Email
		$query = $this->db->query("SELECT * FROM oc_order ORDER BY oc_order.order_id DESC");
		$row = $query->row;

		if(!empty($row)) {
			// mail
			$to = '';
			$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
			$rows_email = $query_email->rows;

			if(!empty($rows_email)) {
				foreach($rows_email as $r) {
					$to .= $r['email'].', ';
				}
			}

			if($to != '') {
				$to = substr($to, 0, -2);
			}

			$subject = 'Order : Landmart';

			$message = '
				<head>
					<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
				</head>
				
				<body>
					<style>
						body {
							font-family: "Prompt", sans-serif;
							color: #000;
						}
				
						@media print {
							body,
							page {
								margin: 0;
								box-shadow: 0;
							}
				
							.breaknewpage {
								page-break-after: always;
							}
						}
					</style>
				
					<div class="page_container" style="padding: 15px 15px; max-width: 800px; width: 800px; min-width:800px; font-family:"Prompt", sans-serif; color: #000;">
						<div class="logo" style="display:inline-block; width:50%;">
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
						</div>
						<div class="sellerText" style="display:inline-block; width:49%; color:#f9c22a; font-size: 45px; text-transform: uppercase; vertical-align: top; margin-top: 20px;">
						</div>
						<div style="font-family: "Roboto", "Prompt", sans-serif; color:#333 !important; font-size:40px;">
							Hello from LANDMART
						</div>
						<div align="left" style="font-size: 16px;">
							Thanks for your order!
						</div>
						<div align="right">
							<h2>Landmart</h2>
							<div>
								945 หมู่ 1 ต.เมืองพาน/Mueangphan Sub-District<br>
								เชียงราย/Chiang Rai
								<p>โทร 09-2929-4998</p>
							</div>
						</div>
						<div align="left">
							'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'<br>
							'.$row['shipping_address_1'].' '.$row['shipping_address_2'].' ';
			if($row['shipping_tumbol'] != '0' and $row['shipping_tumbol'] != '') {
				$query_tumbol = $this->db->query("SELECT * FROM district WHERE DISTRICT_ID = '".$row['shipping_tumbol']."'");

				$row_tumbol = $query_tumbol->row;

				$message .= $row_tumbol['DISTRICT_NAME'];
			}

			if($row['shipping_amphur'] != '0' and $row['shipping_amphur'] != '') {
				$query_amphur = $this->db->query("SELECT * FROM amphur WHERE AMPHUR_ID = '".$row['shipping_amphur']."'");

				$row_tumbol = $query_amphur->row;

				$message .= $row_tumbol['AMPHUR_NAME'];
			}

			if($row['shipping_city'] != '0' and $row['shipping_city'] != '') {
				$query_province = $this->db->query("SELECT * FROM province WHERE PROVINCE_ID = '".$row['shipping_city']."'");

				$row_province = $query_province->row;

				$message .= $row_province['PROVINCE_NAME'];
			}

			if($row['shipping_postcode'] != '') {
				$message .= $row['shipping_postcode'];
			}

			$message .= 'Your ordered items
						Date: '.date('j F Y').'<br>
						Invoice-NO: '.date('j F Y').'<br>
						Date: '.date('j F Y').'<br>
						</div>
						<table class="table_order" style="font-size: 15px; width: 740px; max-width: 740px; min-width: 740px; margin-top: 15px;border-collapse: collapse;">
							<thead>
								<tr class="bg_gd" style="border:1px solid #dddee0;">
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px;">SKU</th>
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px;">Image</th>
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px;">Product</th>
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px;">Order Number</th>
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px;">Quantity</th>
								</tr>
							</thead>
							<tbody style="border:1px solid #dddee0;">
							<tr>
								<td style="border:1px solid #dddee0;">'.$row['sku'].'</td>
								<td style="border:1px solid #dddee0;"><img class="logo" src="https://www.landmart.co.th/demo/image/'.$row['image'].'" style="margin: 0 auto 25px auto; width: 40%; height: auto; display: block;"></td>
								<td style="border:1px solid #dddee0;">'.$row['name'].'</td>
								<td style="border:1px solid #dddee0;">'.$row['invoice_no'].'</td>
								<td style="border:1px solid #dddee0;">'.$row['quantity'].'</td>
							</tr>
							</tbody>
						</table>
						<br>
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif;">
							Date: '.date('j F Y').' <br>
							Invoice-No.: '.$_POST['processing_invoice'][0].' <br>
							Order No.: '.$row['invoice_no'].' <br><br>
							Shipping Provider : Business Idea
						</div>
						<table class="table_order" style="font-size: 15px; width: 740px; max-width: 740px; min-width: 740px; margin-top: 15px;border-collapse: collapse;">
							<thead>
								<tr class="bg_gd" style="border:1px solid #dddee0;">
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px;">Order number</th>
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px; ">Package tracking number</th>
									<th style="font-weight: 500; text-align: center; color: #231f20; padding-bottom: 5px; padding-top: 5px; ">Number of Pieces in Package</th>
								</tr>
							</thead>
							<tbody style="border:1px solid #dddee0;">
							<tr>
								<td style="border:1px solid #dddee0;">'.$row['invoice_no'].'</td>
								<td style="border:1px solid #dddee0;">'.$_POST['processing_invoice'][0].'</td>
								<td style="border:1px solid #dddee0;">'.$row['quantity'].'</td>
							</tr>
							</tbody>
						</table>
						<br><br>
						<div class="boxOrder" style="border:1px solid #dddee0; width:350px; padding:5px 20px; margin-bottom:10px;">
							Total of Packages
						</div>
						<div class="boxOrder" style="border:1px solid #dddee0; width:350px; padding:5px 20px; margin-bottom:10px;">
							'.$row['quantity'].'
						</div>
						<div class="boxOrder" style="border:1px solid #dddee0; width:350px; padding:5px 20px;height:150px;">
							Date : '.date(DATE_RFC2822).'
						</div>
						<div class="boxOrder" style="border:1px solid #dddee0; width:350px; padding:5px 20px; margin-bottom:10px; height:130px;">
							Signature
						</div>
						<div class="borderGray" style="border-bottom:4px solid #eee; padding-bottom:10px; width: 92.2%;">
						</div>
						<br><br>
				
						<div class="namesender" style="width:30%; display:inline-block;">
							<span class="blackBG" style="background:#000; border-radius:50px; padding:10px; color:#fff;">
								ผู้จัดส่ง
							</span>
							<div class="addressMail" style="padding-top:20px;color:#595959;">
								<div class="nameAddress" style="color:#000;"><b>LANDMART</b></div>
								945 หมู่ 1 ต.เมืองพาน/Muangphan Sub-district <br> เชียงราย/Chiang Rai 
								<br><br>
								โทร 09-2929-4998
							</div>
						</div>
						<div class="senderIcon" style="width:10%; display:inline-block;">
							<img src="images/send_icon.png" alt="">
						</div>
						
						<div class="namesender" style="width:30%; display:inline-block;">
							<span class="blackBG" style="background:#000; border-radius:50px; padding:10px; color:#fff;">
								ผู้รับสินค้า
							</span>
							<div class="addressMail" style="padding-top:20px;color:#595959;">
								<div class="nameAddress" style="color:#000;"><b>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</b></div>
								'.$row['shipping_address_1'].' '.$row['shipping_address_2'].' ';
			if($row['shipping_tumbol'] != '0' and $row['shipping_tumbol'] != '') {
				$query_tumbol = $this->db->query("SELECT * FROM district WHERE DISTRICT_ID = '".$row['shipping_tumbol']."'");

				$row_tumbol = $query_tumbol->row;

				$message .= $row_tumbol['DISTRICT_NAME'];
			}

			if($row['shipping_amphur'] != '0' and $row['shipping_amphur'] != '') {
				$query_amphur = $this->db->query("SELECT * FROM amphur WHERE AMPHUR_ID = '".$row['shipping_amphur']."'");

				$row_tumbol = $query_amphur->row;

				$message .= $row_tumbol['AMPHUR_NAME'];
			}

			if($row['shipping_city'] != '0' and $row['shipping_city'] != '') {
				$query_province = $this->db->query("SELECT * FROM province WHERE PROVINCE_ID = '".$row['shipping_city']."'");

				$row_province = $query_province->row;

				$message .= $row_province['PROVINCE_NAME'];
			}

			if($row['shipping_postcode'] != '') {
				$message .= $row['shipping_postcode'];
			}

			$message .= '
				
								<br><br>
								โทร '.$row['telephone'].'
							</div>
						</div>
					</div>
					</div>
				</body>
			';

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

			//mail($to, $subject, $message, $headers);

			echo $message;
			// send mail
		}
	}

	public function print_order() {
		$query = $this->db->query("SELECT * FROM oc_order WHERE invoice_no = '".$_GET['invoice_no']."'");
		$row = $query->row;

		$this->load->model('checkout/order');

		if(!empty($row)) {
			$datetime_create = $this->model_checkout_order->formatDatetime($row['date_added']);

			if($row['payment_method'] == 'บัตรเครดิต / บัตรเดบิต') {
				$message = '
					<head>
						<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
					</head>

					<body>
						<style>
							body {
								font-family: "Prompt", sans-serif;
								color: #000;
							}

							@media print {

								body,
								page {
									margin: 0;
									box-shadow: 0;
								}

								.breaknewpage {
									page-break-after: always;
								}
							
							}
						</style>

						<div class="logo" style="display:inline-block; width:50%;">
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
						</div>
						
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							Hello From LANDMART 
							<br>
							<span style="font-size:30px; color:#000;">
								<b> Thanks for your order!</b>
							</span>
							<br>
							<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
							<br>
							<span style="color:#96989b;">
								คำสั่งซื้อผ่าน บัตรเครดิต/เดบิต หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>โปรดรอทางระบบตรวจสอบการชำระเงินโดย บัตรเครดิต/เดบิต ภายใน 24 ชม. นับจากเวลาที่ทำรายการ เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
							</span> <br><br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						</div>
						<br>
						<span style="font-size:25px; color:#000;">
							<b> รายละเอียดคำสั่งซื้อ</b>
						</span>
						<table class="table_order" style="    
							font-size: 15px;
							width: 740px;
							max-width: 740px;
							min-width: 740px;
							margin-top: 15px;">';

				$message .= '
							<tr class="bg_gd">
								<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
								<td>
								<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
								</td>
							</tr>
							<tr>
								<td>วันที่สั่งซื้อ :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';
				$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
				$row_order_product = $query_order_product->rows;
				$i = 0;
				if(!empty($row_order_product)) {
					foreach($row_order_product as $r) {
						$i++;
						$message .= '
							<tr>
								<td><br>
								<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
								'.$i.'. '.$r['name'].'
								</td>
							</tr>
							<tr>
								<td><b>ตัวเลือกสินค้า</b>  </td>
							</tr>
							<tr>
								<td>จำนวน :</td>
								<td>'.$r['quantity'].'</td>
							</tr>
							<tr>
								<td>ราคา :</td>
								<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
							</tr>';
					}
				}

				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
							</tr>';
				if($row['discount_price'] != '0.00') {
					$message .= '
							<tr>
								<td>ส่วนลด :</td>
								<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
							</tr>
					';
				}

				$message .= '
							<tr>
								<td>ยอดที่ชำระทั้งหมด :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
						<br>
						<br>
						<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
							บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
							<br><br>

							<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

							<br>
							<span style="color:#96989b; font-size:14px;">
								อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
								ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
							</span>
						</center>
					</body>';	
				echo $message;
			} elseif($row['payment_method'] == 'Online Banking') {
				$message = '
					<head>
						<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
					</head>

					<body>
						<style>
							body {
								font-family: "Prompt", sans-serif;
								color: #000;
							}

							@media print {

								body,
								page {
									margin: 0;
									box-shadow: 0;
								}

								.breaknewpage {
									page-break-after: always;
								}
							
							}
						</style>

						<div class="logo" style="display:inline-block; width:50%;">
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
						</div>
						
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							Hello From LANDMART 
							<br>
							<span style="font-size:30px; color:#000;">
								<b> Thanks for your order!</b>
							</span>
							<br>
							<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
							<br>
							<span style="color:#96989b;">
								คำสั่งซื้อหมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>
								กรุณายืนยันการชำระเงินโดยการอัพโหลดสลิปการโอนเงิน ภายใน 24 ชม. นับจากเวลาที่ทำรายการ <br>
								เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
							</span> <br><br>
							<span style="color:#000;">
								วิธีชำระเงินผ่านการโอนเงินเข้าบัญชีธนาคาร <br>
								ธนาคารกสิกรไทย <br>
								ชื่อบัญชีบจก. แลนด์มาร์ท (ประเทศไทย) <br>
								หมายเลขบัญชี 051-1-68603-2
							</span> <br><br>
							<br><br>
							<span style="color:#c22d3b; font-size:15px;">
								(หมายเหตุ : กรุณาโอนเงินและแจ้งหลักฐานการโอน ภายใน 24 ชม. นับจากวันที่ทำรายการ แต่เมื่อทำการส่งหลักฐานการโอนเงินมาแล้วโปรดรอตรวจสอบข้อมูลภายใน 24 ชม
							</span>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						</div>
						<br>
						<span style="font-size:25px; color:#000;">
							<b> รายละเอียดคำสั่งซื้อ</b>
						</span>
						<table class="table_order" style="    
							font-size: 15px;
							width: 740px;
							max-width: 740px;
							min-width: 740px;
							margin-top: 15px;">';

				$message .= '
							<tr class="bg_gd">
								<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
								<td>
								<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
								</td>
							</tr>
							<tr>
								<td>วันที่สั่งซื้อ :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';
				$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
				$row_order_product = $query_order_product->rows;
				$i = 0;
				if(!empty($row_order_product)) {
					foreach($row_order_product as $r) {
						$i++;
						$message .= '
							<tr>
								<td><br>
								<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
								'.$i.'. '.$r['name'].'
								</td>
							</tr>
							<tr>
								<td><b>ตัวเลือกสินค้า</b>  </td>
							</tr>
							<tr>
								<td>จำนวน :</td>
								<td>'.$r['quantity'].'</td>
							</tr>
							<tr>
								<td>ราคา :</td>
								<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
							</tr>';
					}
				}

				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
							</tr>';
				//if($row['discount_price'] != '0.00') {
					$message .= '
							<tr>
								<td>ส่วนลด :</td>
								<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
							</tr>
					';
				//}

				$message .= '
							<tr>
								<td>ยอดที่ชำระทั้งหมด :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
						<br>
						<br>
						<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
							บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
							<br><br>

							<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

							<br>
							<span style="color:#96989b; font-size:14px;">
								อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
								ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
							</span>
						</center>
					</body>';	
				echo $message;

			} elseif($row['payment_method'] == 'เก็บเงินปลายทาง COD') {
				$message = '
					<head>
						<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
					</head>

					<body>
						<style>
							body {
								font-family: "Prompt", sans-serif;
								color: #000;
							}

							@media print {

								body,
								page {
									margin: 0;
									box-shadow: 0;
								}

								.breaknewpage {
									page-break-after: always;
								}
							
							}
						</style>

						<div class="logo" style="display:inline-block; width:50%;">
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
						</div>
						
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							Hello From LANDMART 
							<br>
							<span style="font-size:30px; color:#000;">
								<b> Thanks for your order!</b>
							</span>
							<br>
							<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
							<br>
							<span style="color:#96989b;">
								คำสั่งซื้อเก็บเงินปลายทาง (COD) หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. 
							</span> <br><br>
							<span style="color:#333;">
								ทำการสั่งซื้อสินค้า แบบการชำระเงินปลายทาง (COD)<br>
								(โปรดรอทำการตรวจสอบข้อมูลคำสั่งซื้อภายใน 24 ชม.)
							</span><br><br>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						</div>
						<br>
						<span style="font-size:25px; color:#000;">
							<b> รายละเอียดคำสั่งซื้อ</b>
						</span>
						<table class="table_order" style="    
							font-size: 15px;
							width: 740px;
							max-width: 740px;
							min-width: 740px;
							margin-top: 15px;">';

				$message .= '
							<tr class="bg_gd">
								<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
								<td>
								<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
								</td>
							</tr>
							<tr>
								<td>วันที่สั่งซื้อ :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';
				$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
				$row_order_product = $query_order_product->rows;
				$i = 0;
				if(!empty($row_order_product)) {
					foreach($row_order_product as $r) {

						$query_status = $this->db->query("UPDATE oc_order_product SET status = '2', datetime_processing = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$r['order_product_id']."'");
						
						$i++;
						$message .= '
							<tr>
								<td><br>
								<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
								'.$i.'. '.$r['name'].'
								</td>
							</tr>
							<tr>
								<td><b>ตัวเลือกสินค้า</b>  </td>
							</tr>
							<tr>
								<td>จำนวน :</td>
								<td>'.$r['quantity'].'</td>
							</tr>
							<tr>
								<td>ราคา :</td>
								<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
							</tr>';
					}
				}

				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
							</tr>';
				//if($row['discount_price'] != '0.00') {
					$message .= '
							<tr>
								<td>ส่วนลด :</td>
								<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
							</tr>
					';
				//}

				$message .= '
							<tr>
								<td>ยอดที่ต้องชำระปลายทาง(COD)ทั้งหมด :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
						<br>
						<br>
						<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
							บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
							<br><br>

							<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

							<br>
							<span style="color:#96989b; font-size:14px;">
								อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
								ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
							</span>
						</center>
					</body>';	
				echo $message;
			} elseif($row['payment_method'] == 'จองสินค้า 50%') {
				$message = '
					<head>
						<link href="https://fonts.googleapis.com/css?family=Prompt:400,500,700|Roboto:400,500,700" rel="stylesheet">
					</head>

					<body>
						<style>
							body {
								font-family: "Prompt", sans-serif;
								color: #000;
							}

							@media print {

								body,
								page {
									margin: 0;
									box-shadow: 0;
								}

								.breaknewpage {
									page-break-after: always;
								}
							
							}
						</style>

						<div class="logo" style="display:inline-block; width:50%;">
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;">
						</div>
						
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							Hello From LANDMART 
							<br>
							<span style="font-size:30px; color:#000;">
								<b> Thanks for your order!</b>
							</span>
							<br>
							<span style="font-size:20px; color:#000;">เรียน คุณ '.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</span>
							<br>
							<span style="color:#96989b;">
								คำสั่งซื้อแบบ (COD 50%) หมายเลข <span style="color:#f9c22a;">#'.$row['invoice_no'].'</span> ได้ทำการสั่งซื้อเมื่อวันที่ '.$datetime_create.' น. <br><br>
								กรุณายืนยันการชำระเงินโดยการอัพโหลดสลิปการโอนเงิน ภายใน 24 ชม. นับจากเวลาที่ทำรายการ <br>
								เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
							</span> <br><br>
							<span style="color:#000;">
								วิธีชำระเงินผ่านการโอนเงินเข้าบัญชีธนาคาร <br>
								ธนาคารไทยพาณิชย์ <br>
								ชื่อบัญชีบจก. แลนด์มาร์ท (ประเทศไทย) <br>
								หมายเลขบัญชี 468-0-65951-6
							</span> <br><br>
							<br><br>
							<span style="color:#c22d3b; font-size:15px;">
								(หมายเหตุ : กรุณาโอนเงินและแจ้งหลักฐานการโอน ภายใน 24 ชม. นับจากวันที่ทำรายการ แต่เมื่อทำการส่งหลักฐานการโอนเงินมาแล้วโปรดรอตรวจสอบข้อมูลภายใน 24 ชม
							</span>
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						</div>
						<br>
						<span style="font-size:25px; color:#000;">
							<b> รายละเอียดคำสั่งซื้อ</b>
						</span>
						<table class="table_order" style="    
							font-size: 15px;
							width: 740px;
							max-width: 740px;
							min-width: 740px;
							margin-top: 15px;">';

				$message .= '
							<tr class="bg_gd">
								<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
								<td>
								<span style="color:#f9c22a;">#'.$row['invoice_no'].'</span>
								</td>
							</tr>
							<tr>
								<td>วันที่สั่งซื้อ :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';
				$query_order_product = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id WHERE oc_order_product.order_id = '".$row['order_id']."' ORDER BY oc_order_product.order_product_id ASC");
				$row_order_product = $query_order_product->rows;
				$i = 0;
				if(!empty($row_order_product)) {
					foreach($row_order_product as $r) {
						$i++;
						$message .= '
							<tr>
								<td><br>
								<img class="logo" src="'.HTTPS_SERVER.'image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
								'.$i.'. '.$r['name'].'
								</td>
							</tr>
							<tr>
								<td><b>ตัวเลือกสินค้า</b>  </td>
							</tr>
							<tr>
								<td>จำนวน :</td>
								<td>'.$r['quantity'].'</td>
							</tr>
							<tr>
								<td>ราคา :</td>
								<td>฿'.number_format($r['price'], 0, '.', ',').'</td>
							</tr>';
					}
				}

				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total'], 0, '.', ',').'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price'], 0, '.', ',').'</td>
							</tr>';
				//if($row['discount_price'] != '0.00') {
					$message .= '
							<tr>
								<td>ส่วนลด :</td>
								<td>฿'.number_format($row['discount_price'], 0, '.', ',').'</td>
							</tr>
					';
				//}

				$message .= '
							<tr>
								<td>ยอดที่ต้องชำระทั้งหมด :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total'] * 2, 0, '.', ',').'</span></td>
							</tr>
							<tr>
								<td>ยอดที่ต้องชำระเก็บเงินปลายทาง 50% :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total'], 0, '.', ',').'</span></td>
							</tr>
							<tr>
								<td>ยอดที่ต้องชำระมัดจำก่อน 50% :</td>
								<td><span style="color:#c22d3b;">฿'.number_format($row['total'], 0, '.', ',').'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							(หมายเหตุ : อยู่ในขั้นตอนการตรวจสอบข้อมูลภายใน 24 ชั่วโมงเมื่อไม่มีข้อผิดพลาด)
						<br>
						<br>
						<center><b>ขอบคุณที่เลือกใช้ LANDMART</b> <br>  
							บริษัท แลนด์มาร์ท (ประเทศไทย) จำกัด
							<br><br>

							<span style="font-size:14px;">ถ้ามีข้อสงสัย กรุณาติดต่อฝ่ายลูกค้าสัมพันธ์หรือเรียนรู้เพิ่มเติมที่ศูนย์ช่วยเหลือ <a href="#" style="color:#f9c22a;">คลิก </a></span>

							<br>
							<span style="color:#96989b; font-size:14px;">
								อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบอัตโนมัติกรุณาตอบกลับที่ไลน์นี้ @landmart เพื่อมั่นใจ <br>
								ว่าข่าวสารจากทางเราจะเข้าไปอยู่ในอินบ็อกของคุณ
							</span>
						</center>
					</body>';	
				echo $message;
			}
		}
	}
}