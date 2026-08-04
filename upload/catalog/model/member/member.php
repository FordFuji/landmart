<?php
class ModelMemberMember extends Model {
	public function getGeneral() {
		$query = $this->db->query("select * from oc_customer where customer_id = '".$this->session->data['member_id']."'");

		return $query->row;
	}

	public function getProvinceRecord($province_id) {
		$query = $this->db->query("select * from province where PROVINCE_ID = '".$province_id."'");

		return $query->row;
	}

	public function getAmphurRecord($amphur_id) {
		$query = $this->db->query("select * from amphur where AMPHUR_ID = '".$amphur_id."'");

		return $query->row;
	}

	public function getDistrictRecord($district_id) {
		$query = $this->db->query("select * from district where DISTRICT_ID = '".$district_id."'");

		return $query->row;
	}

	public function getProvinceList() {
		$query = $this->db->query("select * from province order by PROVINCE_NAME asc");

		return $query->rows;
	}

	public function getAmphurList() {
		$query = $this->db->query("select * from amphur order by AMPHUR_NAME asc");

		return $query->rows;
	}

	public function getAmphurInvoiceList($customer_invoice_province) {
		$query = $this->db->query("select * from amphur where PROVINCE_ID = '".$customer_invoice_province."' order by AMPHUR_NAME asc");

		return $query->rows;
	}

	public function getTumbolList() {
		$query = $this->db->query("select * from district order by DISTRICT_NAME asc");

		return $query->rows;
	}

	public function getTumbolInvoiceList($customer_invoice_amphur) {
		$query = $this->db->query("select * from district where AMPHUR_ID = '".$customer_invoice_amphur."' order by DISTRICT_NAME asc");

		return $query->rows;
	}

	public function insertUpdateGoogle($email, $name, $surname) {
		$query = $this->db->query("SELECT * FROM oc_customer WHERE email = '".$email."'");

		$row = $query->row;

		if(!empty($row)) {
			// update
			$this->db->query("UPDATE oc_customer SET firstname = '".$name."', lastname = '".$surname."', customer_datetime_update = '".date('Y-m-d H:i:s')."' WHERE email = '".$email."'");

			$this->session->data['member_id'] = $row['customer_id'];
		} else {
			// insert
			$this->db->query("INSERT INTO oc_customer(firstname, lastname, customer_datetime_update, email) VALUES('".$name."', '".$surname."', '".date('Y-m-d H:i:s')."', '".$email."')");

			$query = $this->db->query("SELECT * FROM oc_customer ORDER BY customer_id DESC LIMIT 1");

			$row = $query->row;

			$this->session->data['member_id'] = $row['customer_id'];
		}

		echo json_encode($row);
	}
}