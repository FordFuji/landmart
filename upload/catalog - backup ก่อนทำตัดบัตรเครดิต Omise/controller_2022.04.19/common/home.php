<?php
class ControllerCommonHome extends Controller {
	public function index() {

		$this->document->setTitle($this->config->get('config_meta_title'));
		$this->document->setDescription($this->config->get('config_meta_description'));
		$this->document->setKeywords($this->config->get('config_meta_keyword'));

		if (isset($this->request->get['route'])) {
			$this->document->addLink($this->config->get('config_url'), 'canonical');
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['banners'] = $this->model_design_banner->getBanner(7);

		$data['banners4'] = $this->model_design_banner->getBanner(8);

		$data['banners2'] = $this->model_design_banner->getBanner(6);

		$data['product_promotions'] = $this->model_catalog_product->getProductPromotion();

		$data['categories'] = $this->model_catalog_product->getCategoriesParent();

		$data['all_banners'] = $this->model_catalog_product->getBanners();

		$data['banner_mobiles'] = $this->model_catalog_product->getBannerMobiles();

		$data['productPromotion'] = $this->model_catalog_product->productPromotion();

		//pre($data['productPromotion']);

		$products = $this->model_catalog_product->getProductToCategory();

		$data['products'] = array();

		if(!empty($products)) {
			foreach($products as $product) {
				$isProductMore = $this->model_catalog_product->isProductSizeColor($product['product_id']);

				$data['products'][] = array(
					'category_id' => $product['category_id'],
					'product_landmart' => $product['product_landmart'],
					'product_name' => $product['product_name'],
					'model' => $product['model'],
					'price' => number_format($product['price'], 2, '.', ','),
					'price_pure' => $product['price'],
					'special' => number_format($product['special'], 2, '.', ','),
					'special_pure' => $product['special'],
					'product_image' => $product['product_image'],
					'product_id' => $product['product_id'],
					'isSizeColor' => $isProductMore,
					'manufacturer_id' => $product['manufacturer_id']
				);
			}
		}

		//pre($data['products']);

		$sizeColor = $this->model_catalog_product->getProductSizeColor();

		$data['sizeColor'] = array();

		if(!empty($sizeColor)) {
			foreach($sizeColor as $size_color) {
				if ($size_color['product_option_value_image']) {
					$image = $this->model_tool_image->resize($size_color['product_option_value_image'], 229, 229);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', 229, 229);
				}

				if($size_color['price_prefix'] == '-') {
					$price_cal = $size_color['price_product'] - $size_color['price_option'];
				} elseif($size_color['price_prefix'] == '+') {
					$price_cal = $size_color['price_product'] + $size_color['price_option'];
				}

				$data['sizeColor'][] = array(
					'product_option_value_id' => $size_color['product_option_value_id'],
					'product_option_value_image' => $size_color['product_option_value_image'],
					'name_option' => $size_color['name_option'],
					'product_id' => $size_color['product_id'],
					'product_option_value_image' => $image,
					'price_cal' => $price_cal
				);
			}
		}

		//pre($data['sizeColor']);

		$query = $this->db->query('SELECT * FROM oc_manufacturer ORDER BY sort_order ASC');
		$data['manufac'] = $query->rows;

		$query_row = $this->db->query("SELECT * FROM oc_product INNER JOIN oc_stock_status ON oc_product.stock_status_id = oc_stock_status.stock_status_id GROUP BY oc_product.product_id");
		$data['rows'] = $query_row->rows;

		//pre($data['rows']);

		$this->response->setOutput($this->load->view('common/home', $data));
	}

	public function confirm_order() {
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
					<span style="font-size:20px; color:#000;">เรียน คุณ สิทธิพร ครองวิเชียร</span>
					<br>
					<span style="color:#96989b;">
						คำสั่งซื้อหมายเลข <span style="color:#f9c22a;">#000000000A1</span> ได้ทำการสั่งซื้อเมื่อวันที่ 06/08/2021 | 07:30:26 น. <br><br>
						กรุณายืนยันการชำระเงินโดยการอัพโหลดสลิปการโอนเงิน ภายใน 24 ชม. นับจากเวลาที่ทำรายการ <br>
						เพื่อความรวดเร็วในการตรวจสอบและทำการจัดส่งสินค้าในขั้นตอนต่อไป
					</span> <br><br>
					<span style="color:#000;">
						วิธีชำระเงินผ่านการโอนเงินเข้าบัญชีธนาคาร <br>
						ธนาคารกสิกรไทย <br>
						ชื่อบัญชีบจก. แลนด์มาร์ท (ประเทศไทย) <br>
						หมายเลขบัญชี 051-1-68603-2
					</span> <br><br>
					<span style="color:#96989b;">
						แจ้งการโอนเงินได้<a href="#" style="color:#f9c22a;">ที่นี่ </a>
					</span>
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
					margin-top: 15px;">
				
					<tr class="bg_gd">
						<td style="font-weight: 500; color: #231f20;">หมายเลขคำสั่งซื้อ </td>
						<td>
						<span style="color:#f9c22a;">#000000000A1</span>
						</td>
					</tr>
					<tr>
						<td>วันที่สั่งซื้อ :</td>
						<td>06/08/2021 | 07:30:26 น.</td>
					</tr>
					<tr>
						<td>ผู้ซื้อ:</td>
						<td>สิทธิพร ครองวิเชียร</td>
					</tr>
					<tr>
						<td><br>
						<img class="logo" src="images/newd/promotion7.png"  style=" width: 40%; height: auto; display: block;"> <br>
						1. เครื่องนวดข้าวขนาดเล็ก เครื่องยนต์เบนซิน 7.5 แรงม้า รุ่น LM-5TW-50A
						</td>
					</tr>
					<tr>
						<td><b>ตัวเลือกสินค้า</b>  </td>
					</tr>
					<tr>
						<td>จำนวน :</td>
						<td>1</td>
					</tr>
					<tr>
						<td>ราคา :</td>
						<td>฿11,990</td>
					</tr>
					<tr>
						<td>ยอดรวมสินค้า :</td>
						<td>฿11,990</td>
					</tr>
					<tr>
						<td>ค่าจัดส่งสินค้า :</td>
						<td>฿1,500</td>
					</tr>
					<tr>
						<td>ยอดที่ชำระทั้งหมด :</td>
						<td><span style="color:#c22d3b;">฿13,490</span></td>
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
