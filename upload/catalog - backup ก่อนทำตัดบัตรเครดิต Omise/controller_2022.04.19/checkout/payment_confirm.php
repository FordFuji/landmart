<?php
class ControllerCheckoutPaymentConfirm extends Controller {
	
    public function index() {
        $data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

        $query = $this->db->query('select * from oc_order where invoice_no = "'.@$_GET['invoice_no'].'"');
        $data['row'] = $query->row;

        $this->response->setOutput($this->load->view('checkout/payment_confirm', $data));
    }

    public function setPaymentConfirm() {
        if(move_uploaded_file($_FILES['payment_image']['tmp_name'], 'uploads_payment/'.$_FILES['payment_image']['name'])) {
            /*$this->db->query('INSERT INTO fd_payment(
                invoice_no,
                payment_total,
                payment_name_surname,
                payment_image,
                payment_datetime_create
            ) VALUES (
                "'.$_POST['invoice_no'].'",
                "'.$_POST['payment_total'].'",
                "'.$_POST['payment_name_surname'].'",
                "uploads_payment/'.$_FILES['payment_image']['name'].'",
                "'.$_POST['date_'].' '.$_POST['time_'].'"
            )');*/

            $this->db->query('INSERT INTO fd_payment(
                invoice_no,
                payment_total,
                payment_image,
                payment_datetime_create
            ) VALUES (
                "'.$_POST['invoice_no'].'",
                "'.$_POST['payment_total'].'",
                "uploads_payment/'.$_FILES['payment_image']['name'].'",
                "'.$_POST['date_'].' '.$_POST['time_'].'"
            )');

            // เปลี่ยน Status
            $query = $this->db->query('SELECT * FROM oc_order WHERE invoice_no = "'.$_POST['invoice_no'].'"');

            $rows = $query->rows;

            if(!empty($rows)) {
                foreach($rows as $r) {
                    $this->db->query('UPDATE oc_order_product SET 
                        oc_order_product.status = "2",
                        oc_order_product.datetime_processing = "'.date('Y-m-d H:i:s').'"
                        WHERE oc_order_product.order_id = "'.$r['order_id'].'"
                    ');
                }
            }

            // ford ส่งเมล์ จุดที่ 2
            $query = $this->db->query("SELECT * FROM oc_order WHERE invoice_no = '".$_POST['invoice_no']."'");
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
                $message .= '<tr><th>Date<br>วันที่</th><th>Order Number<br>เลขที่ Order</th><th>Invoice Number<br>เลขที่กำกับภาษี</th><th>Shipping Provider<br>ขนส่ง</th><th>Payment Method<br>วิธีการจ่ายเงิน</th></tr>';

                $query_order = $this->db->query("SELECT *, oc_order_product.total AS item_total FROM oc_order_product INNER JOIN oc_order ON oc_order_product.order_id = oc_order.order_id WHERE oc_order_product.order_id = '".$row['order_id']."'");

				$rows_order = $query_order->rows;

				if(!empty($rows_order)) {
					foreach($rows_order as $r) {
						if($r['payment_method'] == 'จองสินค้า 50%') {
							$shipping_provider = 'Business Ideas';
						} elseif($r['payment_method'] == 'บัตรเครดิต / บัตรเดบิต') {
							$shipping_provider = 'Business Ideas';
						} elseif($r['payment_method'] == 'COD') {
							$shipping_provider = 'Flash Express';
						} else {
							$shipping_provider = 'Business Ideas';
						}

						$query_payment = $this->db->query("SELECT * FROM fd_payment WHERE invoice_no = '".$r['invoice_no']."' ORDER BY payment_id DESC LIMIT 1");
						$row_payment = $query_payment->row;
						
						$message .= '<tr><td>'.$row_payment['payment_datetime_create'].'</td><td>'.$r['invoice_no'].'</td><td>'.$r['processing_invoice'].'</td><td>'.$shipping_provider.'</td><td>'.$r['payment_method'].'</td></tr>';
					}
				}

				$message .= '</table>';
				$message .= '<br>';

                $message .= '<table border="1" width="100%" style="border-collapse: collapse;">';
                $message .= '<tr><th>Product Name<br>ชื่อสินค้า</th><th>Product Price<br>ราคาสินค้า</th><th>Shipping Fee<br>ค่าขนส่ง</th><th>Paid Price<br>ชำระเงินแล้ว</th><th>Paid at Door<br>จ่ายเงินที่บ้าน</th></tr>';
                
				if(!empty($rows_order)) {
					$i = 0;
					foreach($rows_order as $r) {
						if($i == 0) {
							$product_price = $r['item_total'];
							$shipping_fee = $r['shipping_price'];
							$paid_price = $r['item_total'] + $r['shipping_price'];
							$paid_at_door = 0;
						} else {
							$product_price = $r['item_total'];
							$shipping_fee = 0;
							$paid_price = $r['item_total'];
							$paid_at_door = 0;
						}

						$message .= '<tr><td>'.$r['name'].'</td><td>'.number_format($product_price, 2, '.', ',').'</td><td>'.number_format($shipping_fee, 2, '.', ',').'</td><td>'.number_format($paid_price, 2, '.', ',').'</td><td>'.number_format($paid_at_door, 2, '.', ',').'</td></tr>';

						$i++;
					}
				}

				$message .= '</table>';
				//echo $message;
				
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

				//$to = 'landmart.online1@gmail.com, nirvanaford94@gmail.com';
				$subject = 'อีเมล์ ใบชำระเงิน : Landmart';
				/*$headers = 'From: webmaster@landmart.com' . "\r\n" .
					'Reply-To: webmaster@landmart.com' . "\r\n" .
					'X-Mailer: PHP/' . phpversion();*/

				$headers  = 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				$headers .= "From: webmaster@landmart.com\r\n"."X-Mailer: php";

				mail($to, $subject, $message, $headers);
				// end template email
			}
            // End ford ส่งเมล์ จุดที่ 2

            echo '<script>alert("ส่งข้อมูลการจ่ายเงินเรียบร้อย");window.location.href="index.php";</script>';
        }
    }
}