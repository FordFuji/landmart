<?php
class ModelCatalogProduct extends Model {
	public function updateViewed($product_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
	}

	public function getBusinessHoursRecord() {
		$query = $this->db->query("select * from fd_business_hours where business_hours_id = '1'");

		return $query->row;
	}

	public function getProduct($product_id) {
		//$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return array(
				'product_id'       => $query->row['product_id'],
				'product_banner_image' => $query->row['product_banner_image'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_title'       => $query->row['meta_title'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'product_landmart' => $query->row['product_landmart'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
			);
		} else {
			return false;
		}
	}

	public function getProducts($data = array()) {
		if(!empty($_GET['keyword'])) {
			$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
				} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}

				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
				} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
			} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) INNER JOIN oc_product_to_category ON p2s.product_id = oc_product_to_category.product_id INNER JOIN oc_category_description ON oc_product_to_category.category_id = oc_category_description.category_id INNER JOIN oc_product ON p2s.product_id = oc_product.product_id WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}

				if (!empty($data['filter_filter'])) {
					$implode = array();

					$filters = explode(',', $data['filter_filter']);

					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}

					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
				}
			}

			$sql .= " AND (pd.name LIKE '%".$_GET['keyword']."%' OR oc_category_description.name LIKE '%".$_GET['keyword']."%' OR oc_category_description.name2 LIKE '%".$_GET['keyword']."%' OR oc_product.model LIKE '%".$_GET['keyword']."%') ";

			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";

				if (!empty($data['filter_name'])) {
					$implode = array();

					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

					foreach ($words as $word) {
						$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
					}

					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}

					if (!empty($data['filter_description'])) {
						$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
					}
				}

				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}

				if (!empty($data['filter_tag'])) {
					$implode = array();

					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

					foreach ($words as $word) {
						$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
					}

					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}

				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}

				$sql .= ")";
			}

			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}

			$sql .= " GROUP BY p.product_id";

			$sort_data = array(
				'pd.name',
				'p.model',
				'p.quantity',
				'p.price',
				'rating',
				'p.sort_order',
				'p.date_added'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} elseif ($data['sort'] == 'p.price') {
					$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				// แก้ที่ Limit ไว้ 15 รายการ
				//$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$product_data = array();

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
		} elseif(!empty($_GET['category1_id'])) {
			$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, p2c.category_id";

			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
				} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}

				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
				} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
			} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

			if (!empty($data['filter_category_id'])) {
				/*if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}*/

				//$sql .= " AND p2c.category_id1 = '" . $_GET['category1_id'] . "'";

				if (!empty($data['filter_filter'])) {
					$implode = array();

					$filters = explode(',', $data['filter_filter']);

					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}

					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
				}
			}

			//$sql .= " AND pd.name LIKE '%".$_GET['keyword']."%' ";

			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";

				if (!empty($data['filter_name'])) {
					$implode = array();

					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

					foreach ($words as $word) {
						$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
					}

					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}

					if (!empty($data['filter_description'])) {
						$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
					}
				}

				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}

				if (!empty($data['filter_tag'])) {
					$implode = array();

					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

					foreach ($words as $word) {
						$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
					}

					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}

				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}

				$sql .= ")";
			}

			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}

			$sql .= " GROUP BY p.product_id";

			$sort_data = array(
				'pd.name',
				'p.model',
				'p.quantity',
				'p.price',
				'rating',
				'p.sort_order',
				'p.date_added'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} elseif ($data['sort'] == 'p.price') {
					$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$product_data = array();

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
		} else {
			$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
				} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}

				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
				} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
			} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}

			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
				} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}

				if (!empty($data['filter_filter'])) {
					$implode = array();

					$filters = explode(',', $data['filter_filter']);

					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}

					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
				}
			}

			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";

				if (!empty($data['filter_name'])) {
					$implode = array();

					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

					foreach ($words as $word) {
						$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
					}

					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}

					if (!empty($data['filter_description'])) {
						$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
					}
				}

				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}

				if (!empty($data['filter_tag'])) {
					$implode = array();

					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

					foreach ($words as $word) {
						$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
					}

					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}

				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}

				$sql .= ")";
			}

			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}

			$sql .= " GROUP BY p.product_id";

			$sort_data = array(
				'pd.name',
				'p.model',
				'p.quantity',
				'p.price',
				'rating',
				'p.sort_order',
				'p.date_added'
			);

			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
				} elseif ($data['sort'] == 'p.price') {
					$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
				} else {
					$sql .= " ORDER BY " . $data['sort'];
				}
			} else {
				$sql .= " ORDER BY p.sort_order";
			}

			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
			} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}

			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}

				// แก้ SQL Limit = 15
				//$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}

			$product_data = array();

			$query = $this->db->query($sql);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
		}

		return $product_data;
	}

	public function getProductSpecials($data = array()) {
		$sql = "SELECT DISTINCT ps.product_id, (SELECT AVG(rating) FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) GROUP BY ps.product_id";

		$sort_data = array(
			'pd.name',
			'p.model',
			'ps.price',
			'rating',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
				$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
			} else {
				$sql .= " ORDER BY " . $data['sort'];
			}
		} else {
			$sql .= " ORDER BY p.sort_order";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC, LCASE(pd.name) DESC";
		} else {
			$sql .= " ASC, LCASE(pd.name) ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$product_data = array();

		$query = $this->db->query($sql);

		foreach ($query->rows as $result) {
			$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
		}

		return $product_data;
	}

	public function getLatestProducts($limit) {
		$product_data = $this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getPopularProducts($limit) {
		$product_data = $this->cache->get('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
	
		if (!$product_data) {
			$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
	
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			$this->cache->set('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}
		
		return $product_data;
	}

	public function getBestSellerProducts($limit) {
		$product_data = $this->cache->get('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);

		if (!$product_data) {
			$product_data = array();

			$query = $this->db->query("SELECT op.product_id, SUM(op.quantity) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id > '0' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT " . (int)$limit);

			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}

			$this->cache->set('product.bestseller.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
		}

		return $product_data;
	}

	public function getProductAttributes($product_id) {
		$product_attribute_group_data = array();

		$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");

		foreach ($product_attribute_group_query->rows as $product_attribute_group) {
			$product_attribute_data = array();

			$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");

			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_data[] = array(
					'attribute_id' => $product_attribute['attribute_id'],
					'name'         => $product_attribute['name'],
					'text'         => $product_attribute['text']
				);
			}

			$product_attribute_group_data[] = array(
				'attribute_group_id' => $product_attribute_group['attribute_group_id'],
				'name'               => $product_attribute_group['name'],
				'attribute'          => $product_attribute_data
			);
		}

		return $product_attribute_group_data;
	}

	public function getProductOptions($product_id) {
		$product_option_data = array();

		$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");

		foreach ($product_option_query->rows as $product_option) {
			$product_option_value_data = array();

			$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");

			foreach ($product_option_value_query->rows as $product_option_value) {
				$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'name'                    => $product_option_value['name'],
					'image'                   => $product_option_value['image'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'weight'                  => $product_option_value['weight'],
					'weight_prefix'           => $product_option_value['weight_prefix']
				);
			}

			$product_option_data[] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => $product_option['value'],
				'required'             => $product_option['required']
			);
		}

		return $product_option_data;
	}

	public function getProductDiscounts($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");

		return $query->rows;
	}

	public function getProductImages($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getProductRelated($product_id) {
		$product_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		foreach ($query->rows as $result) {
			$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
		}

		return $product_data;
	}

	public function getWarrantyShippingConditionRecord() {
		$query = $this->db->query("select * from fd_warranty where product_id = '".$_GET['product_id']."'");

		return $query->row;
	}

	public function getProductLayoutId($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getCategories($product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");

		return $query->rows;
	}

	public function getTotalProducts($data = array()) {
		$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
			} else {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
			}

			if (!empty($data['filter_filter'])) {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
			} else {
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
			}
		} else {
			$sql .= " FROM " . DB_PREFIX . "product p";
		}

		$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

		if (!empty($data['filter_category_id'])) {
			if (!empty($data['filter_sub_category'])) {
				$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
			} else {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}

			if (!empty($data['filter_filter'])) {
				$implode = array();

				$filters = explode(',', $data['filter_filter']);

				foreach ($filters as $filter_id) {
					$implode[] = (int)$filter_id;
				}

				$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
			}
		}

		if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
			$sql .= " AND (";

			if (!empty($data['filter_name'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

				foreach ($words as $word) {
					$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}

				if (!empty($data['filter_description'])) {
					$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
				}
			}

			if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
				$sql .= " OR ";
			}

			if (!empty($data['filter_tag'])) {
				$implode = array();

				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));

				foreach ($words as $word) {
					$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
				}

				if ($implode) {
					$sql .= " " . implode(" AND ", $implode) . "";
				}
			}

			if (!empty($data['filter_name'])) {
				$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
			}

			$sql .= ")";
		}

		if (!empty($data['filter_manufacturer_id'])) {
			$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getProfile($product_id, $recurring_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "product_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.product_id = '" . (int)$product_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

		return $query->row;
	}

	public function getProfiles($product_id) {
		$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "product_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.product_id = " . (int)$product_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getTotalProductSpecials() {
		$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");

		if (isset($query->row['total'])) {
			return $query->row['total'];
		} else {
			return 0;
		}
	}

	public function getCategoriesParent() {
		$query = $this->db->query("select * from oc_category inner join oc_category_description on oc_category.category_id = oc_category_description.category_id where oc_category.parent_id = '0' order by oc_category.sort_order asc");

		return $query->rows;
	}

	public function getCategoriesAll() {
		$query = $this->db->query("select * from oc_category inner join oc_category_description on oc_category.category_id = oc_category_description.category_id order by oc_category.sort_order asc");

		return $query->rows;
	}

	public function getProductPromotion() {
		$query = $this->db->query("select * from oc_product inner join oc_product_description on oc_product.product_id = oc_product_description.product_id where oc_product_description.tag = 'สินค้าโปรโมชัน' order by sort_order asc limit 10");

		return $query->rows;
	}

	public function getBanners() {
		$query = $this->db->query("select * from oc_banner inner join oc_banner_image on oc_banner.banner_id = oc_banner_image.banner_id order by sort_order asc");

		return $query->rows;
	}

	public function productPromotion() {
		$query = $this->db->query("select * from oc_product inner join oc_product_description on oc_product.product_id = oc_product_description.product_id where tag = 'สินค้าโปรโมชัน' order by sort_order asc");

		return $query->rows;
	}

	public function getBannerMobiles() {
		$query = $this->db->query("select * from oc_banner inner join oc_banner_image on oc_banner.banner_id = oc_banner_image.banner_id where oc_banner.banner_id = '16' order by sort_order asc");

		return $query->rows;
	}

	public function getProductToCategory() {
		//$query = $this->db->query("select *, oc_product.image as product_image, oc_product_description.name as product_name, (SELECT price FROM oc_product_special ps WHERE ps.product_id = oc_product.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special from oc_product_to_category inner join oc_product on oc_product_to_category.product_id = oc_product.product_id inner join oc_product_description on oc_product.product_id = oc_product_description.product_id inner join oc_category on oc_product_to_category.category_id = oc_category.category_id inner join oc_category_description on oc_category.category_id = oc_category_description.category_id where oc_product.status = '1' order by oc_product.sort_order asc");

		$query = $this->db->query("select *, oc_product.image as product_image, oc_product_description.name as product_name, (SELECT price FROM oc_product_special ps WHERE ps.product_id = oc_product.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special from oc_product_to_category inner join oc_product on oc_product_to_category.product_id = oc_product.product_id inner join oc_product_description on oc_product.product_id = oc_product_description.product_id inner join oc_category on oc_product_to_category.category_id = oc_category.category_id inner join oc_category_description on oc_category.category_id = oc_category_description.category_id where oc_product.status = '1' order by oc_product.sort_order asc");

		return $query->rows;
	}

	public function getProductDescription($product_id) {
		$query = $this->db->query("select * from oc_product inner join oc_product_description on oc_product.product_id = oc_product_description.product_id where oc_product.product_id = '".$product_id."'");

		return $query->row;
	}

	public function getCartOrderAmount() {
		$query = $this->db->query("select sum(quantity) as quantity_ from oc_cart where session_id = '".$this->session->getId()."'");

		return $query->row;
	}

	public function getManufacturersList() {
		$query = $this->db->query("select * from oc_manufacturer order by sort_order asc");

		return $query->rows;
	}

	public function getQuantity($product_id) {
		$query = $this->db->query("select * from oc_product where product_id = '".$product_id."'");

		return $query->row;
	}

	public function getCartList() {
		$query = $this->db->query("select *, oc_product.product_id as product_id, oc_product_description.name as product_name, oc_cart.quantity as quantity_, oc_option_value_description.name as option_name, oc_product.price as product_price, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = oc_product.product_id AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special from oc_cart inner join oc_product on oc_cart.product_id = oc_product.product_id inner join oc_product_description on oc_cart.product_id = oc_product_description.product_id left join oc_product_option_value on oc_product.product_id = oc_product_option_value.product_id left join oc_option_value_description on oc_product_option_value.option_value_id = oc_option_value_description.option_value_id where oc_cart.session_id = '".$this->session->getId()."' GROUP BY oc_cart.cart_id ORDER BY oc_cart.cart_id ASC");

		return $query->rows;
	}

	public function getMember() {
		$query = $this->db->query("select * from oc_customer where oc_customer.customer_id = '".@$this->session->data['member_id']."'");

		return $query->row;
	}

	public function getWarranty($product_id) {
		$query = $this->db->query("select * from fd_warranty where product_id = '".$product_id."'");

		return $query->row;
	}

	public function getProductSimilar($product_id) {
		$query = $this->db->query("select *, oc_stock_status.name as oss_name, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = oc_product.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special from oc_product_to_category inner join oc_category on oc_product_to_category.category_id = oc_category.category_id inner join oc_product on oc_product_to_category.product_id = oc_product.product_id inner join oc_product_description on oc_product.product_id = oc_product_description.product_id inner join oc_stock_status on oc_product.stock_status_id = oc_stock_status.stock_status_id where oc_product.product_id != '".$product_id."' group by oc_product.product_id order by rand() limit 3");

		return $query->rows;
	}

	public function getMemberValue() {
		$query = $this->db->query("select * from oc_customer where customer_id = '".@$this->session->data['member_id']."'");

		return $query->row;
	}

	public function getProvinceList() {
		$query = $this->db->query("select * from province order by PROVINCE_NAME asc");

		return $query->rows;
	}

	public function getAmphurList($customer_province = '') {
		if($customer_province == '') {
			$customer_province = @$_POST['province_id'];
		}

		$query = $this->db->query("select * from amphur where PROVINCE_ID = '".$customer_province."' order by AMPHUR_NAME asc");

		return $query->rows;
	}

	public function getAmphurInvoiceList($customer_invoice_province = '') {
		if($customer_invoice_province == '') {
			$customer_invoice_province = @$_POST['province_id'];
		}

		$query = $this->db->query("select * from amphur where PROVINCE_ID = '".$customer_invoice_province."' order by AMPHUR_NAME asc");

		return $query->rows;
	}

	public function getTumbolList($customer_amphur = '') {
		if($customer_amphur == '') {
			$customer_amphur = @$_POST['amphur_id'];
		}

		$query = $this->db->query("select * from district order by DISTRICT_NAME asc");

		return $query->rows;
	}

	public function getTumbolInvoiceList($customer_invoice_amphur = '') {
		if($customer_invoice_amphur == '') {
			$customer_invoice_amphur = @$_POST['amphur_id'];
		}

		$query = $this->db->query("select * from district where AMPHUR_ID = '".$customer_invoice_amphur."' order by DISTRICT_NAME asc");

		return $query->rows;
	}

	public function getProductRecord($product_id) {
		$query = $this->db->query("select * from oc_product where product_id = '".$product_id."'");

		$row = $query->row;

		if(!empty($row) and $row['shipping'] == '1') {
			return $row['shipping_price'];
		} else {
			return 0;
		}
	}

	public function getProductCondition($product_id) {
		$query = $this->db->query("SELECT * FROM fd_warranty WHERE product_id = '".$product_id."'");

		return $query->row;
	}

	public function isProductSizeColor($product_id) {
		/*$query = $this->db->query("SELECT * FROM fd_product_color_size WHERE product_id = '".$product_id."'");

		$count = count($query->rows);

		if($count > 1) {
			return true;
		} else {
			return false;
		}*/

		$query = $this->db->query("SELECT * FROM oc_product_option_value WHERE product_id = '".$product_id."'");

		$count = count($query->rows);

		if($count > 1) {
			return true;
		} else {
			return false;
		}
	}

	public function getProductSizeColor() {
		$query = $this->db->query("SELECT *, oc_option_value_description.name AS name_option, oc_product.price AS price_product, oc_product_option_value.price AS price_option FROM oc_product_option_value INNER JOIN oc_option_value_description ON oc_product_option_value.option_value_id = oc_option_value_description.option_value_id INNER JOIN oc_product_description ON oc_product_option_value.product_id = oc_product_description.product_id INNER JOIN oc_product ON oc_product_option_value.product_id = oc_product.product_id GROUP BY oc_product_option_value.product_option_value_id ORDER BY oc_product_option_value.product_option_value_id ASC");

		return $query->rows;
	}

	public function getProductOptionValue($product_option_value) {
		$query = $this->db->query("SELECT *, oc_option_value_description.name as option_name FROM oc_product_option_value INNER JOIN oc_option_value_description on oc_product_option_value.option_value_id = oc_option_value_description.option_value_id WHERE product_option_value_id = '".$product_option_value."'");

		return $query->row;
	}

	public function getProductSeries() {
		$query = $this->db->query("SELECT * FROM oc_category INNER JOIN oc_category_description ON oc_category.category_id = oc_category_description.category_id WHERE oc_category.parent_id = '0' ORDER BY oc_category.sort_order ASC");

		return $query->rows;
	}

	public function getTransport() {
		$query = $this->db->query("SELECT * FROM fd_transport ORDER BY transport_id ASC");

		return $query->rows;
	}

	public function getShippingProduct($product_id) {
		$query = $this->db->query("SELECT * FROM oc_product WHERE product_id = '".$product_id."'");

		$row = $query->row;

		if(!empty($row)) {
			return @$row['method_product'];
		}
	}

	public function getPaymentMethod() {
		$query = $this->db->query("select * from oc_cart inner join oc_product on oc_cart.product_id = oc_product.product_id where oc_cart.session_id = '".$this->session->getId()."'");

		$rows = $query->rows;

		if(!empty($rows)) {
			$payment_method = '';

			$count_payment_method = count($rows);

			$cod_50 = 0;
			foreach($rows as $r) {
				if(@$r['method_product'] == 'COD 50%') {
					$cod_50++;
				}
			}

			$cod = 0;
			foreach($rows as $r) {
				if(@$r['method_product'] == 'COD') {
					$cod++;
				}
			}

			if($count_payment_method == $cod_50) {
				return 'COD 50%';
			} elseif($count_payment_method == $cod) {
				return 'COD';
			} else {
				return 'Normal';
			}
		}
	}

	public function getProductOption() {
		$query = $this->db->query("SELECT * FROM oc_product_option_value INNER JOIN oc_option_value_description ON oc_product_option_value.option_value_id = oc_option_value_description.option_value_id WHERE oc_product_option_value.product_id = '".$_GET['product_id']."' ORDER BY oc_product_option_value.option_value_id ASC");

		return $query->rows;
	}

	public function getBankAccount() {
		$query = $this->db->query("SELECT * FROM fd_bank_account WHERE bank_account_id = '1'");

		return $query->row;
	}

	public function getCartAmount() {
		$query = $this->db->query("SELECT * FROM oc_cart WHERE session_id = '".$this->session->getId()."'");

		$rows = $query->rows;

		$qty = 0;
		if(!empty($rows)) {
			foreach($rows as $r) {
				$qty += $r['quantity'];
			}
		}

		return $qty;
	}
}
