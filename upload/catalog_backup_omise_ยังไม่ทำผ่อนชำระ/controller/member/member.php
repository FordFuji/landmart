<?php
class ControllerMemberMember extends Controller {
	private $error = array();

    // index.php?route=member/member/member_dashboard
	public function member_dashboard() {
		if(empty($this->session->data['member_id'])) {
			echo '<script>window.location.href="index.php";</script>';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['inc_sidemember'] = $this->load->controller('common/header/inc_sidemember');

		$this->load->model('member/member');

		$data['member'] = $this->model_member_member->getGeneral();

		if(!empty($data['member'])) {
			$data['province'] = $this->model_member_member->getProvinceRecord($data['member']['customer_province']);

			$data['amphur'] = $this->model_member_member->getAmphurRecord($data['member']['customer_amphur']);

			$data['tumbol'] = $this->model_member_member->getDistrictRecord($data['member']['customer_tumbol']);

			$data['province_invoice'] = $this->model_member_member->getProvinceRecord($data['member']['customer_invoice_province']);

			$data['amphur_invoice'] = $this->model_member_member->getAmphurRecord($data['member']['customer_invoice_amphur']);

			$data['tumbol_invoice'] = $this->model_member_member->getDistrictRecord($data['member']['customer_invoice_tumbol']);
		}

		$this->response->setOutput($this->load->view('member/member_dashboard', $data));
	}

    // index.php?route=member/member/member_info
	public function member_info() {
		if(empty($this->session->data['member_id'])) {
			echo '<script>window.location.href="index.php";</script>';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['inc_sidemember'] = $this->load->controller('common/header/inc_sidemember');

		$this->load->model('member/member');

		$data['member'] = $this->model_member_member->getGeneral();

		if(!empty($data['member'])) {
			$data['provinces_list'] = $this->model_member_member->getProvinceList();

			$data['amphurs_list'] = $this->model_member_member->getAmphurList($data['member']['customer_amphur']);

			$data['amphurs_invoice_list'] = $this->model_member_member->getAmphurInvoiceList($data['member']['customer_invoice_province']);

			$data['tumbol_list'] = $this->model_member_member->getTumbolList($data['member']['customer_tumbol']);

			$data['tumbol_invoice_list'] = $this->model_member_member->getTumbolInvoiceList($data['member']['customer_invoice_amphur']);
		}

		$this->response->setOutput($this->load->view('member/member_info', $data));
	}

	public function ajaxChangeProvince() {
		$query = $this->db->query("select * from amphur where PROVINCE_ID = '".$_POST['province_id']."' order by AMPHUR_NAME asc");

		$rows = $query->rows;

		if(!empty($rows)) {
?>
			<option value="">กรุณาเลือก</option>
<?php
			foreach($rows as $r) {
?>
				<option value="<?php echo $r['AMPHUR_ID'];?>"><?php echo $r['AMPHUR_NAME'];?></option>
<?php
			}
		}
	}

	public function ajaxChangeAmphur() {
		$query = $this->db->query("select * from district where AMPHUR_ID = '".$_POST['amphur_id']."' order by DISTRICT_NAME asc");

		$rows = $query->rows;

		if(!empty($rows)) {
?>
			<option value="">กรุณาเลือก</option>
<?php
			foreach($rows as $r) {
?>
				<option value="<?php echo $r['DISTRICT_ID'];?>"><?php echo $r['DISTRICT_NAME'];?></option>
<?php
			}
		}
	}

	public function save_update() {
		$query = $this->db->query("update oc_customer  
			set firstname = '".$_POST['firstname']."',
				lastname = '".$_POST['lastname']."',
				email = '".$_POST['email']."',
				telephone = '".$_POST['telephone']."',
				customer_address1 = '".$_POST['customer_address1']."',
				customer_address2 = '".$_POST['customer_address2']."',
				customer_postcode = '".$_POST['customer_postcode']."',
				customer_province = '".$_POST['customer_province']."',
				customer_amphur = '".$_POST['customer_amphur']."',
				customer_tumbol = '".$_POST['customer_tumbol']."',
				customer_invoice_name = '".$_POST['customer_invoice_name']."',
				customer_invoice_address1 = '".$_POST['customer_invoice_address1']."',
				customer_invoice_address2 = '".$_POST['customer_invoice_address2']."',
				customer_invoice_postcode = '".$_POST['customer_invoice_postcode']."',
				customer_invoice_province = '".$_POST['customer_invoice_province']."',
				customer_invoice_amphur = '".$_POST['customer_invoice_amphur']."',
				customer_invoice_tumbol = '".$_POST['customer_invoice_tumbol']."',
				customer_card_id = '".$_POST['customer_card_id']."',
				customer_datetime_update = '".date('Y-m-d H:i:s')."'
			where customer_id = '".$this->session->data['member_id']."'");
		
		echo '<script>window.location.href="index.php?route=member/member/member_dashboard";</script>';
	}

	public function ajaxChangePassword() {
		$query1 = $this->db->query("select * from oc_customer where email = '".$_POST['email']."'");

		$row1 = $query1->row;

		if(empty($row1)) {
			echo 'ไม่มีอีเมล์นี้ในระบบ';
			exit;
		}

		$query2 = $this->db->query("select * from oc_customer where email = '".$_POST['email']."' and password = '".$_POST['old_password']."'");

		$row2 = $query2->row;

		if(empty($row2)) {
			echo 'รหัสผ่านเดิมไม่ถูกต้อง';
			exit;
		}

		$query3 = $this->db->query("update oc_customer set password = '".$_POST['password']."' where email = '".$_POST['email']."'");

		if(!empty($query3)) {
			echo 'เปลี่ยนรหัสผ่านสำเร็จ';
		}
	}

    // index.php?route=member/member/member_order
    public function member_order() {
		if(empty($this->session->data['member_id'])) {
			echo '<script>window.location.href="index.php";</script>';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['inc_sidemember'] = $this->load->controller('common/header/inc_sidemember');

		$this->load->model('checkout/order');
		$data['memberOrderResultCtrl'] = $this->model_checkout_order->getMemberOrderResult();

		if(!empty($data['memberOrderResultCtrl'])) {
			$data['countOrder'] = count($data['memberOrderResultCtrl']);
		}

		$data['orderProductCtrl'] = $this->model_checkout_order->getOrderResult();

		$data['provinces'] = $this->model_checkout_order->getProvince();
		$data['amphurs'] = $this->model_checkout_order->getAmphur();
		$data['tumbols'] = $this->model_checkout_order->getTumbol();
		
		$this->response->setOutput($this->load->view('member/member_order', $data));
	}

    // index.php?route=member/member/member_password
    public function member_password() {
		if(empty($this->session->data['member_id'])) {
			echo '<script>window.location.href="index.php";</script>';
		}

		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['inc_sidemember'] = $this->load->controller('common/header/inc_sidemember');

		$this->response->setOutput($this->load->view('member/member_password', $data));
	}

    // index.php?route=member/member/member_method
    public function payment_method() {
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['inc_sidemember'] = $this->load->controller('common/header/inc_sidemember');

		$this->response->setOutput($this->load->view('member/member_method', $data));
	}

    // index.php?route=member/member/payment_summary
    public function payment_summary() {
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$data['inc_header'] = $this->load->controller('common/header/inc_header');
		$data['inc_sidemember'] = $this->load->controller('common/header/inc_sidemember');

		$this->response->setOutput($this->load->view('member/payment_summary', $data));
	}

	public function register() {
		if(!empty($_POST['submit']) and $_POST['submit'] != '') {
			$this->db->query("insert into oc_customer (username, email, telephone, password, date_added, status, ip) values ('".$_POST['member_name']."', '".$_POST['member_email']."', '".$_POST['member_phone']."', '".$_POST['member_password']."', '".date('Y-m-d H:i:s')."', '1', '".$_SERVER['REMOTE_ADDR']."')");

			$query = $this->db->query("SELECT * FROM oc_customer ORDER BY customer_id DESC");
			$row = $query->row;

			if(!empty($row)) {
					// ส่งเมล์
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
							<img src="'.HTTPS_SERVER.'asset/images/mail_logo.png" alt="" style="width:400px;"> <br>
							<h1>LANDMART</h1> <h1 style="color: #333;">ยินดีต้อนรับ</h1>
							<hr>
						</div>
						
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							อีเมลฉบับนี้เป็นการแจ้งข้อมูลจากระบบโดยอัตโนมัติกรุณาอย่าตอบกลับหากท่านมีข้อสงสัยหรือต้องการสอบ ถามรายละเอียดเพิ่มเติมกรุณาติดต่อ 09 2929 4998 หรือไลน์ @landmart
							<div class="borderGray" style="border-bottom:2px solid #b3b4b7; padding-bottom:10px; width: 92.2%;"></div>
						</div>
						<br>
						<div class="picklist_print" style="font-family: "Roboto", "Prompt", sans-serif; color:#96989b;">
							ข้อมูลผู้ใช้
							<hr>
							Member ID '.$row['customer_id'].'
							<table width="100%">
								<tr>
									<td width="200">ชื่อผู้ใช้งาน</td><td>'.$row['username'].'</td>
								</tr>
								<tr>
									<td width="200">อีเมล์</td><td>'.$row['email'].'</td>
								</tr>
								<tr>
									<td width="200">เบอร์โทรศัพท์</td><td>'.$row['telephone'].'</td>
								</tr>
							</table>
						</div>
					</body>';	
				//echo $message;

				/*$to = 'landmartthailand@gmail.com, ';
				$query_email = $this->db->query("SELECT * FROM oc_user ORDER BY user_id ASC");
				$rows_email = $query_email->rows;

				if(!empty($rows_email)) {
					foreach($rows_email as $r) {
						$to .= $r['email'].', ';
					}
				}*/
					
				$to = $row['email'].', ';

				if($to != '') {
					$to = substr($to, 0, -2);
				}

				$subject = 'Order : Landmart';

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: Landmart <webmaster@landmart.com>\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
			}
			// end ส่งเมล์

			echo '<script>alert("สมัครสำเร็จแล้ว");window.location.href="index.php";</script>';
		} else {
			echo 'Error';
		}
	}

	public function login() {
		$query = $this->db->query("select * from oc_customer where email = '".$_POST['member_email_login']."' and password = '".$_POST['member_password_login']."'");

		$login = $query->row;

		if(!empty($login)) {
			$this->session->data['member_id'] = $login['customer_id'];

			echo '<script>window.location.href="index.php?route=member/member/member_dashboard";</script>';
		} else {
			echo '<script>alert("Email Or Password Incorrect");window.location.href="index.php";</script>';
		}
	}

	public function logout() {
		unset($this->session->data['member_id']);

		echo '<script>window.location.href="index.php";</script>';
	}
}
