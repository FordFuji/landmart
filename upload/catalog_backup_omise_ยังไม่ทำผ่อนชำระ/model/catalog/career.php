<?php
class ModelCatalogCareer extends Model {
	public function getCareerCategory() {
        $query = $this->db->query("SELECT * FROM fd_career_category ORDER BY career_category_id DESC");

        return $query->rows;
    }

    public function getCareer() {
        if(!empty($_POST['submit_search'])) {
            if(!empty($_POST['career_name']) and $_POST['career_name'] != '' and !empty($_POST['career_category_id']) and $_POST['career_category_id'] != '') {
                $query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id WHERE fd_career.career_name LIKE '%".$_POST['career_name']."%' and fd_career.career_category_id = '".$_POST['career_category_id']."' ORDER BY fd_career.career_id DESC");
            } else {
                if(!empty($_POST['career_name']) and $_POST['career_name'] != '') {
                    $query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id WHERE fd_career.career_name LIKE '%".$_POST['career_name']."%' ORDER BY fd_career.career_id DESC");
                } elseif(!empty($_POST['career_category_id']) and $_POST['career_category_id'] != '') {
                    $query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id WHERE fd_career.career_category_id = '".$_POST['career_category_id']."' ORDER BY fd_career.career_id DESC");
                } else {
                    $query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id ORDER BY career_id DESC");
                }
            }
        } else {
            $query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id ORDER BY career_id DESC");
        }

        return $query->rows;
    }

    public function getCareerRecord() {
        $query = $this->db->query("SELECT * FROM fd_career INNER JOIN fd_career_category ON fd_career.career_category_id = fd_career_category.career_category_id WHERE fd_career.career_id = '".$_GET['career_id']."'");

        return $query->row;
    }
}