<?php
class ModelCareerCareer extends Model {
	public function getCareerCategory() {
		$query = $this->db->query("SELECT * FROM fd_career_category ORDER BY career_category_id ASC");

		return $query->rows;
	}

	public function getCareerCategoryRecord() {
		$query = $this->db->query("SELECT * FROM fd_career_category WHERE career_category_id = '".$_GET['id']."'");

		return $query->row;
	}

	public function addCareerCategory() {
		$this->db->query("INSERT INTO fd_career_category(career_category_name, career_category_datetime_create, career_category_datetime_update) VALUES ('".$_POST['career_category_name']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
	}

	public function editCareerCategory() {
		$this->db->query("UPDATE fd_career_category SET career_category_name = '".$_POST['career_category_name']."',career_category_datetime_update = '".date('Y-m-d H:i:s')."' WHERE career_category_id = '".$_GET['id']."'");
	}

	public function deleteCareerCategory($career_category_id) {
		$this->db->query("DELETE FROM fd_career_category WHERE career_category_id = '".$career_category_id."'");
	}

	public function getCareer() {
		$query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id ORDER BY fd_career.career_id ASC");

		return $query->rows;
	}

	public function getCareerRecord() {
		$query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id WHERE fd_career.career_id = '".$_GET['id']."'");

		return $query->row;
	}

	public function addCareer() {
		$this->db->query("INSERT INTO fd_career(career_category_id, career_name, career_amount, career_detail, career_applicant_property, career_but_now, career_new, career_datetime_create, career_datetime_update) VALUES('".$_POST['career_category_id']."', '".$_POST['career_name']."', '".$_POST['career_amount']."', '".$_POST['career_detail']."', '".$_POST['career_applicant_property']."', '".$_POST['career_but_now']."', '".$_POST['career_new']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
	}

	public function editCareer() {
		$this->db->query("UPDATE fd_career SET career_category_id = '".$_POST['career_category_id']."', career_name = '".$_POST['career_name']."', career_amount = '".$_POST['career_amount']."', career_detail = '".$_POST['career_detail']."', career_applicant_property = '".$_POST['career_applicant_property']."', career_but_now = '".$_POST['career_but_now']."', career_new = '".$_POST['career_new']."', career_datetime_update = '".date('Y-m-d H:i:s')."' WHERE career_id = '".$_GET['id']."'");
	}

	public function deleteCareer($career_id) {
		$this->db->query("DELETE FROM fd_career WHERE career_id = '".$career_id."'");
	}

	public function getFormApplication() {
		$query = $this->db->query("SELECT * FROM fd_application ORDER BY application_id DESC");

		return $query->rows;
	}
}
