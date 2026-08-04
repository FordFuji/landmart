<?php
class ControllerSaleOrder extends Controller {
	private $error = array();
	private $limit;

	// รอการชำระเงิน
	public function index() {
		$this->limit = 10;

		if(!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$offset = ($page * $this->limit) - $this->limit;

		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['test'] = 'Test';

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['orderAllCtrl'] = $this->model_sale_order->getOrderAll();

		$data['categoryCtrl'] = $this->model_sale_order->getCategoryOrder();

		$data['orderCtrl'] = $this->model_sale_order->getProductPending($offset, $this->limit);
		$data['count_page'] = ceil(count($this->model_sale_order->countProductPending()) / $this->limit);

		$data['tumbol'] = $this->model_sale_order->getTumbolList();

		$data['amphur'] = $this->model_sale_order->getAmphurList();

		$data['province'] = $this->model_sale_order->getProvinceList();

		$query = $this->db->query("SELECT * FROM fd_payment GROUP BY invoice_no");
		$data['payment'] = $query->rows;

		$data['user_token'] = $_GET['user_token'];

		$this->response->setOutput($this->load->view('order/index', $data));
	}

	// กำลังดำเนินการ() ทั้งหมด()
	public function order1() {
		$this->limit = 10;

		if(!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$offset = ($page * $this->limit) - $this->limit;

		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['orderAllCtrl'] = $this->model_sale_order->getOrderAll();

		$data['categoryCtrl'] = $this->model_sale_order->getCategoryOrder();

		$data['orderCtrl'] = $this->model_sale_order->getProductProcessing($offset, $this->limit);
		$count_page1 = count($this->model_sale_order->countProductProcessing());
		$data['orderCompleteCtrl'] = $this->model_sale_order->getProductProcessingComplete($offset, $this->limit);
		$count_page2 = count($this->model_sale_order->countProductProcessingComplete());

		$data['count_page'] = ceil(($count_page1 + $count_page2) / $this->limit);

		$data['slipCtrl'] = $this->model_sale_order->getSlip();

		$data['tumbol'] = $this->model_sale_order->getTumbolList();

		$data['amphur'] = $this->model_sale_order->getAmphurList();

		$data['province'] = $this->model_sale_order->getProvinceList();

		$data['user_token'] = $_GET['user_token'];

		//pre($data['orderCtrl']);

		$this->response->setOutput($this->load->view('order/order1', $data));
	}

	// พร้อมจัดส่ง
	public function order2() {
		$this->limit = 10;

		if(!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$offset = ($page * $this->limit) - $this->limit;

		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['orderAllCtrl'] = $this->model_sale_order->getOrderAll();

		$data['categoryCtrl'] = $this->model_sale_order->getCategoryOrder();

		$data['orderCtrl'] = $this->model_sale_order->getProductProcessed($offset, $this->limit);
		$data['count_page'] = ceil(count($this->model_sale_order->countProductProcessed()) / $this->limit);

		$data['tumbol'] = $this->model_sale_order->getTumbolList();

		$data['amphur'] = $this->model_sale_order->getAmphurList();

		$data['province'] = $this->model_sale_order->getProvinceList();

		$data['user_token'] = $_GET['user_token'];
		
		$this->response->setOutput($this->load->view('order/order2', $data));
	}

	// พร้อมจัดส่ง รายละเอียด
	public function order2_detail() {
		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['tumbol'] = $this->model_sale_order->getTumbolList();

		$data['amphur'] = $this->model_sale_order->getAmphurList();

		$data['province'] = $this->model_sale_order->getProvinceList();

		$data['user_token'] = $_GET['user_token'];

		$this->response->setOutput($this->load->view('order/order2_detail', $data));
	}

	// จัดส่งแล้ว
	public function order3() {
		$this->limit = 10;

		if(!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$offset = ($page * $this->limit) - $this->limit;

		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['orderAllCtrl'] = $this->model_sale_order->getOrderAll();

		$data['categoryCtrl'] = $this->model_sale_order->getCategoryOrder();

		$data['user_token'] = $_GET['user_token'];

		$data['orderCtrl'] = $this->model_sale_order->getProductShipped($offset, $this->limit);
		$data['count_page'] = ceil(count($this->model_sale_order->countProductShipped()) / $this->limit);

		$data['tumbol'] = $this->model_sale_order->getTumbol();

		$data['amphur'] = $this->model_sale_order->getAmphur();

		$data['province'] = $this->model_sale_order->getProvince();

		$this->response->setOutput($this->load->view('order/order3', $data));
	}

	// ยกเลิก
	public function order4() {
		$this->limit = 10;

		if(!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$offset = ($page * $this->limit) - $this->limit;

		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['orderAllCtrl'] = $this->model_sale_order->getOrderAll();

		$data['categoryCtrl'] = $this->model_sale_order->getCategoryOrder();

		$data['orderCtrl'] = $this->model_sale_order->getProductCanceled($offset, $this->limit);	
		$data['count_page'] = ceil(count($this->model_sale_order->countProductCanceled()) / $this->limit);

		$data['tumbol'] = $this->model_sale_order->getTumbolList();

		$data['amphur'] = $this->model_sale_order->getAmphurList();

		$data['province'] = $this->model_sale_order->getProvinceList();
		
		$data['user_token'] = $_GET['user_token'];

		$this->response->setOutput($this->load->view('order/order4', $data));
	}

	// ประวัติการขาย
	public function order5() {
		$this->limit = 10;

		if(!empty($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = 1;
		}

		$data['page'] = $page;

		$offset = ($page * $this->limit) - $this->limit;

		$data['payment_method'] = @$_GET['payment_method'];

		$this->load->language('sale/order');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['status'] = $this->load->controller('sale/status');

		$data['orderAllCtrl'] = $this->model_sale_order->getOrderAll();

		$data['categoryCtrl'] = $this->model_sale_order->getCategoryOrder();

		if(!empty($_GET['payment_method']) and $_GET['payment_method'] == 'cod') {
			$data['orderCtrl'] = $this->model_sale_order->getCOD($offset, $this->limit);
			$data['count_page'] = ceil(count($this->model_sale_order->countCOD()) / $this->limit);
		} elseif(!empty($_GET['payment_method']) and $_GET['payment_method'] == 'credit_card') {
			$data['orderCtrl'] = $this->model_sale_order->getCreditCard($offset, $this->limit);
			$data['count_page'] = ceil(count($this->model_sale_order->countCreditCard()) / $this->limit);
		} elseif(!empty($_GET['payment_method']) and $_GET['payment_method'] == 'bank') {
			$data['orderCtrl'] = $this->model_sale_order->getBank($offset, $this->limit);
			$data['count_page'] = ceil(count($this->model_sale_order->countBank()) / $this->limit);
		} else {
			$data['orderCtrl'] = $this->model_sale_order->getProductAll($offset, $this->limit);
			$data['count_page'] = ceil(count($this->model_sale_order->countProductAll()) / $this->limit);
		}

		//pre($data['orderCtrl']);

		$data['user_token'] = $_GET['user_token'];

		$data['count_cod'] = count($this->model_sale_order->countCOD());
		$data['count_credit_card'] = count($this->model_sale_order->countCreditCard());
		$data['count_bank'] = count($this->model_sale_order->countBank());

		$data['payment_method'] = @$_GET['payment_method'];

		$data['tumbol'] = $this->model_sale_order->getTumbolList();

		$data['amphur'] = $this->model_sale_order->getAmphurList();

		$data['province'] = $this->model_sale_order->getProvinceList();

		$this->response->setOutput($this->load->view('order/order5', $data));
	}

	// Cancel Order ราย Order
	public function submitCancel() {
		//pre($_POST['order_id']);
		if(!empty($_POST['order_id'])) {
			$order_id = $_POST['order_id'];

			if(!empty($order_id)) {
				foreach($order_id as $id) {
					$query = $this->db->query('SELECT * FROM oc_order INNER JOIN oc_order_product ON oc_order.order_id = oc_order_product.order_id WHERE oc_order.order_id = "'.$id.'"');

					$rows = $query->rows;

					if(!empty($rows)) {
						foreach($rows as $r_order_id) {
							$this->db->query("UPDATE oc_order_product SET oc_order_product.status = '7', datetime_cancel = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$r_order_id['order_product_id']."'");
						}
					}
				}
			}

			echo '<script>window.location.href="index.php?route=sale/order&user_token='.$_GET['user_token'].'";</script>';
		}
	}

	// Cancel Order ราย Item
	public function submitCancelItem() {
		//pre($_POST);
		if(!empty($_POST['order_product_id'])) {
			$order_product_id = $_POST['order_product_id'];

			if(!empty($order_product_id)) {
				foreach($order_product_id as $id) {
					$this->db->query("UPDATE oc_order_product SET oc_order_product.status = '7', datetime_cancel = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$id."'");
				}
			}

			echo '<script>window.location.href="index.php?route=sale/order/'.$_GET['path'].'&user_token='.$_GET['user_token'].'";</script>';
		}
	}

	// เปลี่ยนสถานะ Processing
	public function UpdateInvoiceProcessing() {
		$this->db->query("UPDATE oc_order_product SET oc_order_product.status = '5', processing_invoice = '".$_POST['processing_invoice'][0]."', datetime_processing = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$_POST['update_invoice']."'");

		$order_product_id = $_POST['update_invoice'];

		if(!empty($order_product_id)) {
			$query = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_product ON oc_order_product.product_id = oc_product.product_id INNER JOIN oc_product_description ON oc_product_description.product_id = oc_product.product_id INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.order_product_id = '".$order_product_id."'");

			$row = $query->row;

			if(!empty($row)) {
				// mail

				$to = 'landmart.online1@gmail.com, ';

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

				$subject = 'Invoice No : Landmart';
				/*$headers = 'From: webmaster@landmart.com' . "\r\n" .
					'Reply-To: webmaster@landmart.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();*/

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
							<div class="bgYellowBlack" style="background:#f9c22a; height:15px;">
								<div class="bgBlack" style="background:#000; width:100px; height:15px;"></div>
							</div>
							<div class="logo" style="display:inline-block; width:50%;">
								<img src="https://www.landmart.co.th/demo/asset/images/mail_logo.png" alt="" style="width:400px;">
							</div>
							<div class="sellerText" style="display:inline-block; width:49%; color:#f9c22a; font-size: 45px; text-transform: uppercase; vertical-align: top; margin-top: 20px;">
								Seller <span style="color:#6e6e70;">Center</span>
							</div>
							<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif;">
								Picklist printed : '.date('j F Y').'
							</div>
							<div class="borderGray" style="border-bottom:4px solid #eee; padding-bottom:10px; width: 92.2%;">
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
									<td style="border:1px solid #dddee0;"><img class="logo" src="https://www.landmart.co.th/image/'.$row['image'].'" style="margin: 0 auto 25px auto; width: 40%; height: auto; display: block;"></td>
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

				mail($to, $subject, $message, $headers);

				//echo $message;
				// send mail

				echo '<script>window.location.href="index.php?route=sale/order/order1&user_token='.$_GET['user_token'].'";</script>';
			}
		}
	}

	// เปลี่ยนสถานะ Processed
	public function ajaxChangeStatus2Processed() {
		$this->db->query("UPDATE oc_order_product SET oc_order_product.status = '15', datetime_processing_complete = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$_POST['order_product_id']."'");

		$query = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.order_product_id = '".$_POST['order_product_id']."'");

		$row = $query->row;
		
		if(!empty($row)) {
			$this->load->model('sale/order');

			$datetime_create = $this->model_sale_order->formatDatetime(date('Y-m-d H:i:s'));
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
							<img src="'.HTTPS_SERVER.'../asset/images/mail_logo.png" alt="" style="width:400px;">
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
								Hi there Your recent order on LANDMART has been completed. Your order details are shown below for your reference.<br><br>
								สวัสดีค่ะ คำสั่งซื้อล่าสุดของคุณบน LANDMART เสร็จสิ้นแล้ว รายละเอียดการสั่งซื้อของคุณจะแสดงไว้ด้านล่างเพื่อเป็นข้อมูลอ้างอิง
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
								<img class="logo" src="'.HTTPS_SERVER.'../image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
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
								<td style="color:green;">ยอดที่ต้องชำระทั้งหมด :</td>
								<td><span style="color:green;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							<span style="color: green;">(คำสั่งซื้อสินค้าของคุณได้ทำการอนุมัติแล้วโปรดรอทางบริษัทฯทำการจัดส่งสินค้าภายใน 48 ชม.)</span>
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

				$to = '';
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

				$subject = 'Tracking No : Landmart';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
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
							<img src="'.HTTPS_SERVER.'../asset/images/mail_logo.png" alt="" style="width:400px;">
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
								Hi there Your recent order on LANDMART has been completed. Your order details are shown below for your reference.<br><br>
								สวัสดีค่ะ คำสั่งซื้อล่าสุดของคุณบน LANDMART เสร็จสิ้นแล้ว รายละเอียดการสั่งซื้อของคุณจะแสดงไว้ด้านล่างเพื่อเป็นข้อมูลอ้างอิง
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
								<img class="logo" src="'.HTTPS_SERVER.'../image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
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
								<td style="color:green;">ยอดที่ต้องชำระทั้งหมด :</td>
								<td><span style="color:green;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							<span style="color: green;">(คำสั่งซื้อสินค้าของคุณได้ทำการอนุมัติแล้วโปรดรอทางบริษัทฯทำการจัดส่งสินค้าภายใน 48 ชม.)</span>
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

				$to = '';
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

				$subject = 'Tracking No : Landmart';

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
							<img src="'.HTTPS_SERVER.'../asset/images/mail_logo.png" alt="" style="width:400px;">
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
								Hi there Your recent order on LANDMART has been completed. Your order details are shown below for your reference.<br><br>
								สวัสดีค่ะ คำสั่งซื้อล่าสุดของคุณบน LANDMART เสร็จสิ้นแล้ว รายละเอียดการสั่งซื้อของคุณจะแสดงไว้ด้านล่างเพื่อเป็นข้อมูลอ้างอิง
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
								<img class="logo" src="'.HTTPS_SERVER.'../image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
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
								<td style="color:green;">ยอดที่ต้องชำระปลายทาง(COD)ทั้งหมด :</td>
								<td><span style="color:green;">฿'.number_format($row['total']).'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							<span style="color: green;">(คำสั่งซื้อสินค้าของคุณได้ทำการอนุมัติแล้วโปรดรอทางบริษัทฯทำการจัดส่งสินค้าภายใน 48 ชม.)</span>
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

				$to = '';
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

				$subject = 'Tracking No : Landmart';

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
							<img src="'.HTTPS_SERVER.'../asset/images/mail_logo.png" alt="" style="width:400px;">
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
								Hi there Your recent order on LANDMART has been completed. Your order details are shown below for your reference.<br><br>
								สวัสดีค่ะ คำสั่งซื้อล่าสุดของคุณบน LANDMART เสร็จสิ้นแล้ว รายละเอียดการสั่งซื้อของคุณจะแสดงไว้ด้านล่างเพื่อเป็นข้อมูลอ้างอิง
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
								<img class="logo" src="'.HTTPS_SERVER.'../image/'.$r['image'].'"  style=" width: 40%; height: auto; display: block;"> <br>
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
								<td style="color:green;">ยอดที่ต้องชำระมัดจำก่อน 50% :</td>
								<td><span style="color:green;">฿'.number_format($row['total'], 0, '.', ',').'</span></td>
							</tr>
							<tr>
								<td style="color:green;">ยอดที่ต้องชำระเก็บเงินปลายทาง 50% :</td>
								<td><span style="color:green;">฿'.number_format($row['total'], 0, '.', ',').'</span></td>
							</tr>
						</table>
						<br>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
							<span style="color: green;">(คำสั่งซื้อสินค้าของคุณได้ทำการอนุมัติแล้วโปรดรอทางบริษัทฯทำการจัดส่งสินค้าภายใน 48 ชม.)</span>
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

				$to = '';
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

				$subject = 'Tracking No : Landmart';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
			}
		}
		// ใส่หน้า Confirm ที่นี่

		// end ใส่หน้า Confirm ที่นี่
	}

	// ใส่ Shipping Code
	public function setShippingNo() {
		$this->db->query("UPDATE oc_order_product SET processed_shipping_no = '".$_POST['processed_shipping_no'][0]."', datetime_processed = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$_POST['order_product_id']."'");

		echo '<script>window.location.href="index.php?route=sale/order/order2&user_token='.$_GET['user_token'].'";</script>';
	}

	// ยืนยัน Shipping Code
	public function changeStatus2Shipped() {
		$this->db->query("UPDATE oc_order_product SET oc_order_product.status = '3', datetime_processed = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$_POST['order_product_id']."'");

		// ford ส่งเมล์ ส่งสินค้า Landmart
		// Template Email
		//pre($row);
		$query = $this->db->query("SELECT * FROM oc_order_product INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.order_product_id = '".$_POST['order_product_id']."'");

		$row = $query->row;

		if(!empty($row)) {
			$this->load->model('sale/order');

			$datetime_create = $this->model_sale_order->formatDatetime(date('Y-m-d H:i:s'));

			// อีเมล์คำสั่งซื้อ
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
							<img src="https://www.landmart.co.th/asset/images/mail_logo.png" alt="" style="width:400px;">
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
								LANDMART ได้ทำการจัดส่งสินค้าตามรายการสั่งซื้อให้คุณเรียบร้อย
							</span> <br><br>
							<span style="font-size:20px; color:#000;">
								<b>รายละเอียดการจัดส่งสินค้า</b>
							</span>
						</div>
						<br>
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
								<td>วันที่จัดส่งสินค้า :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';

				$message .= '
							<tr>
								<td>บริษัทฯขนส่ง :</td>
								<td>Flash Express</td>
							</tr>
							<tr>
								<td>รหัสติดตามสินค้า :</td>
								<td>'.$row['processed_shipping_no'].'</td>
							</tr>
							<tr>
								<td>ลิงก์ตรวจสอบการจัดส่งสินค้า :</td>
								<td><a href="https://www.flashexpress.co.th/tracking/">https://www.flashexpress.co.th/tracking/</a></td>
							</tr>
							';
				
				$message .= '
						</table>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
						<span style="color:#96989b;">
							หากตรวจสอบเลขพัสดุแล้วไม่พบข้อมูล โปรดตรวสอบอีกครั้งในวันถัดไป หรือติดต่อทางเรา @landmart
						</span>
						<br>
							<span style="color: green;">(การจัดส่งสินค้าจะใช้เวลาในการจัดส่งโดยประมาณ 2-4 วัน)<br>
								(การจัดส่งสินค้าขนาดใหญ่จะใช้เวลาในการจัดส่งโดยประมาณ 5-7 วัน)
							</span>
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

				$to = '';
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

				$subject = 'Shipped : Landmart';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
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
							<img src="https://www.landmart.co.th/asset/images/mail_logo.png" alt="" style="width:400px;">
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
								LANDMART ได้ทำการจัดส่งสินค้าตามรายการสั่งซื้อให้คุณเรียบร้อย
							</span> <br><br>
							<span style="font-size:20px; color:#000;">
								<b>รายละเอียดการจัดส่งสินค้า</b>
							</span>
						</div>
						<br>
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
								<td>วันที่จัดส่งสินค้า :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';

				$message .= '
							<tr>
								<td>บริษัทฯขนส่ง :</td>
								<td>Business idea</td>
							</tr>
							<tr>
								<td>รหัสติดตามสินค้า :</td>
								<td>'.$row['processed_shipping_no'].'</td>
							</tr>
							<tr>
								<td>ลิงก์ตรวจสอบการจัดส่งสินค้า :</td>
								<td><a href="https://www.business-idea.co.th/tracking">https://www.business-idea.co.th/tracking</a></td>
							</tr>
							';
				
				$message .= '
						</table>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
						<span style="color:#96989b;">
							หากตรวจสอบเลขพัสดุแล้วไม่พบข้อมูล โปรดตรวสอบอีกครั้งในวันถัดไป หรือติดต่อทางเรา @landmart
						</span>
						<br>
							<span style="color: green;">(การจัดส่งสินค้าขนาดใหญ่จะใช้เวลาในการจัดส่งโดยประมาณ 5-7 วัน)</span>
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

				$to = '';
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

				$subject = 'Shipped : Landmart';

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
							<img src="https://www.landmart.co.th/asset/images/mail_logo.png" alt="" style="width:400px;">
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
								LANDMART ได้ทำการจัดส่งสินค้าตามรายการสั่งซื้อให้คุณเรียบร้อย
							</span> <br><br>
							<span style="font-size:20px; color:#000;">
								<b>รายละเอียดการจัดส่งสินค้า</b>
							</span>
						</div>
						<br>
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
								<td>วันที่จัดส่งสินค้า :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';

				$message .= '
							<tr>
								<td>บริษัทฯขนส่ง :</td>
								<td>Flash Express</td>
							</tr>
							<tr>
								<td>รหัสติดตามสินค้า :</td>
								<td>'.$row['processed_shipping_no'].'</td>
							</tr>
							<tr>
								<td>ลิงก์ตรวจสอบการจัดส่งสินค้า :</td>
								<td><a href="https://www.flashexpress.co.th/tracking/">https://www.flashexpress.co.th/tracking/</a></td>
							</tr>
							';
				
				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total']).'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price']).'</td>
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
								<td>ยอดที่ต้องชำระปลายทาง(COD)ทั้งหมด :</td>
								<td>฿'.number_format($row['total']).'</td>
							</tr>
						</table>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
						<span style="color:#96989b;">
							หากตรวจสอบเลขพัสดุแล้วไม่พบข้อมูล โปรดตรวสอบอีกครั้งในวันถัดไป หรือติดต่อทางเรา @landmart
						</span>
						<br>
							<span style="color: green;">(การจัดส่งสินค้าจะใช้เวลาในการจัดส่งโดยประมาณ 2-4 วัน)<br>
								(การจัดส่งสินค้าขนาดใหญ่จะใช้เวลาในการจัดส่งโดยประมาณ 5-7 วัน)
							</span>
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

				$to = '';
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

				$subject = 'Shipped : Landmart';

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
							<img src="https://www.landmart.co.th/asset/images/mail_logo.png" alt="" style="width:400px;">
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
								LANDMART ได้ทำการจัดส่งสินค้าตามรายการสั่งซื้อให้คุณเรียบร้อย
							</span> <br><br>
							<span style="font-size:20px; color:#000;">
								<b>รายละเอียดการจัดส่งสินค้า</b>
							</span>
						</div>
						<br>
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
								<td>วันที่จัดส่งสินค้า :</td>
								<td>'.$datetime_create.' น.</td>
							</tr>
							<tr>
								<td>ผู้ซื้อ:</td>
								<td>'.$row['shipping_firstname'].' '.$row['shipping_lastname'].'</td>
							</tr>';

				$message .= '
							<tr>
								<td>บริษัทฯขนส่ง :</td>
								<td>Business idea</td>
							</tr>
							<tr>
								<td>รหัสติดตามสินค้า :</td>
								<td>'.$row['processed_shipping_no'].'</td>
							</tr>
							<tr>
								<td>ลิงก์ตรวจสอบการจัดส่งสินค้า :</td>
								<td><a href="https://www.business-idea.co.th/tracking/">https://www.business-idea.co.th/tracking/</a></td>
							</tr>
							';
				
				$message .= '
							<tr>
								<td>ยอดรวมสินค้า :</td>
								<td>฿'.number_format($row['sub_total']).'</td>
							</tr>
							<tr>
								<td>ค่าจัดส่งสินค้า :</td>
								<td>฿'.number_format($row['shipping_price']).'</td>
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
								<td>ยอดที่ต้องชำระมัดจำก่อน 50% :</td>
								<td style="color:green;">฿'.number_format($row['total']).' (จ่ายแล้ว)</td>
							</tr>
							<tr>
								<td>ยอดที่ต้องชำระเก็บเงินปลายทาง 50% :</td>
								<td style="color:green;">฿'.number_format($row['total']).' (จ่ายแล้ว)</td>
							</tr>
						</table>
						<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						<br>
						<span style="color:green;">กรุณาเตรียมเงินในการชำระสินค้าให้พอดีกับสินค้าเพื่อง่ายต่อการรับสินค้าตรวจสอบที่อยู่เบอร์โทรให้ชัดเจน หรือมีข้อมูลในการจัดส่งเพิ่มเติมสามารถ แจ้งได้ที่ @landmart</span>
						<br>
						<span style="color:#96989b;">
							หากตรวจสอบเลขพัสดุแล้วไม่พบข้อมูล โปรดตรวสอบอีกครั้งในวันถัดไป หรือติดต่อทางเรา @landmart
						</span>
						<br>
							<span style="color: green;">(การจัดส่งสินค้าขนาดใหญ่จะใช้เวลาในการจัดส่งโดยประมาณ 5-7 วัน)
							</span>
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

				$to = '';
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

				$subject = 'Shipped : Landmart';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
			}
			// end template email
		}
		// End ford ส่งเมล์ ส่งสินค้า Landmart
	}

	public function UpdateCancel() {
		$query = $this->db->query("UPDATE oc_order_product SET cancel_reason = '".$_POST['cancel_reason']."', cancel_remark = '".$_POST['cancel_remark']."', status = '7', datetime_cancel = '".date('Y-m-d H:i:s')."' WHERE order_product_id = '".$_POST['order_product_id']."'");

		echo '<script>window.location.href="index.php?route='.$_GET['callback'].'&user_token='.$_GET['user_token'].'";</script>';
	}

	public function deleteCancel() {
		$query = $this->db->query("DELETE FROM oc_order_product WHERE order_product_id = '".$_GET['order_product_id']."'");

		echo '<script>window.location.href="index.php?route=sale/order/order4&user_token='.$_GET['user_token'].'";</script>';
	}
}
