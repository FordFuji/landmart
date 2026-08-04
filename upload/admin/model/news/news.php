<?php
class ModelNewsNews extends Model {
	public function getNews() {
		$query = $this->db->query("SELECT * FROM fd_news ORDER BY news_id ASC");

		return $query->rows;
	}

	public function addNews() {
		$this->db->query("INSERT INTO fd_news(news_datetime, news_image, news_topic, news_description, news_detail, news_embed_video, news_datetime_create, news_datetime_update) VALUES ('".$_POST['news_datetime']."', '".$_POST['news_image']."', '".$_POST['news_topic']."', '".$_POST['news_description']."', '".$_POST['news_detail']."', '".$_POST['news_embed_video']."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."')");
	}

	public function getNewsSingle() {
		$query = $this->db->query("SELECT * FROM fd_news WHERE news_id = '".@$_GET['id']."'");

		return $query->row;
	}

	public function editNews() {
		$this->db->query("UPDATE fd_news SET news_datetime = '".$_POST['news_datetime']."', news_image = '".$_POST['news_image']."', news_topic = '".$_POST['news_topic']."', news_description = '".$_POST['news_description']."', news_embed_video = '".$_POST['news_embed_video']."', news_detail = '".$_POST['news_detail']."', news_datetime_update = '".date('Y-m-d H:i:s')."' WHERE news_id = '".$_GET['id']."'");
	}

	public function deleteNews($news_id) {
		$this->db->query("DELETE FROM fd_news WHERE news_id = '".$news_id."'");
	}
}