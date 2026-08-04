<?php
class ModelCatalogNews extends Model {
	public function getNews1() {
        $query = $this->db->query("SELECT * FROM fd_news ORDER BY news_id DESC LIMIT 0, 2");

        return $query->rows;
    }

    public function getNews2() {
        $query = $this->db->query("SELECT * FROM fd_news ORDER BY news_id DESC LIMIT 1, 1000");

        return $query->rows;
    }

    public function getNews3() {
        $query = $this->db->query("SELECT * FROM fd_news ORDER BY news_id DESC LIMIT 0, 1");

        return $query->row;
    }

    public function getNews4() {
        $query = $this->db->query("SELECT * FROM fd_news ORDER BY news_id DESC LIMIT 1, 1000");

        return $query->rows;
    }

    public function getNewsRecord() {
        $query = $this->db->query("SELECT * FROM fd_news WHERE news_id = '".$_GET['news_id']."'");

        return $query->row;
    }
}