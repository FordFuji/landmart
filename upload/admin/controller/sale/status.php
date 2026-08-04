<?php
class ControllerSaleStatus extends Controller {
    public function index() {
		$data['user_token'] = $_GET['user_token'];

		$this->load->model('sale/order');

		// Pending รอการชำระเงิน
		$pending = $this->model_sale_order->countProductPending();

		if(!empty($pending)) {
			$data['count_pending'] = count($pending);
		} else {
			$data['count_pending'] = 0;
		}

		// Processing รอการดำเนินการ
		$processing = $this->model_sale_order->countProductProcessing();

		if(!empty($processing)) {
			$data['count_processing'] = count($processing);
		} else {
			$data['count_processing'] = 0;
		}

		// Processing ทั้งหมด
		$complete = $this->model_sale_order->countProductProcessingComplete();

		if(!empty($complete)) {
			$data['count_complete'] = count($complete);
		} else {
			$data['count_complete'] = 0;
		}

		// Processed พร้อมจัดส่ง
		$processed = $this->model_sale_order->countProductProcessed();

		if(!empty($processed)) {
			$data['count_processed'] = count($complete) + count($processed);
		} else {
			$data['count_processed'] = 0;
		}

		// Shipped จัดส่งแล้ว
		$shipped = $this->model_sale_order->countProductShipped();

		if(!empty($shipped)) {
			$data['count_shipped'] = count($shipped);
		} else {
			$data['count_shipped'] = 0;
		}

		// Canceled ยกเลิก
		$canceled = $this->model_sale_order->countProductCanceled();

		if(!empty($canceled)) {
			$data['count_canceled'] = count($canceled);
		} else {
			$data['count_canceled'] = 0;
		}

		// All ทั้งหมด
		$all = $this->model_sale_order->countProductAll();

		if(!empty($all)) {
			$data['count_all'] = count($all);
		} else {
			$data['count_all'] = 0;
		}

		return $this->load->view('order/status', $data);
	}
}