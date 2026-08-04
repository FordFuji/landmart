<?php
class ModelCatalogCategory extends Model {
	public function getCategory($category_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row;
	}

	public function getCategories($parent_id = 0) {
		if(!empty($_GET['category1_id'])) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . $_GET['category1_id'] . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
		} else {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
		}

		return $query->rows;
	}

	public function getCategoryFilters($category_id) {
		$implode = array();

		$query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$implode[] = (int)$result['filter_id'];
		}

		$filter_group_data = array();

		if ($implode) {
			$filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

			foreach ($filter_group_query->rows as $filter_group) {
				$filter_data = array();

				$filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int)$filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

				foreach ($filter_query->rows as $filter) {
					$filter_data[] = array(
						'filter_id' => $filter['filter_id'],
						'name'      => $filter['name']
					);
				}

				if ($filter_data) {
					$filter_group_data[] = array(
						'filter_group_id' => $filter_group['filter_group_id'],
						'name'            => $filter_group['name'],
						'filter'          => $filter_data
					);
				}
			}
		}

		return $filter_group_data;
	}

	public function getCategoryLayoutId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");

		if ($query->num_rows) {
			return $query->row['layout_id'];
		} else {
			return 0;
		}
	}

	public function getTotalCategoriesByCategoryId($parent_id = 0) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND c.status = '1'");

		return $query->row['total'];
	}

	public function getCategoriesByCategoryIdRow($parent_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->row;
	}

	public function getProductsCustom($category_id) {
		$query = $this->db->query("select * from oc_category_description inner join oc_category on oc_category_description.category_id = oc_category.category_id where oc_category_description.category_id = '".$category_id."'");

		return $query->rows;
	}

	public function getBrandsAndWarrantyAndPrice($brand_id_array) {
		$where_warranty = '';
		$where_brand = '';
		if(!empty($brand_id_array)) {
			foreach($brand_id_array as $brand) {
				if(strpos($brand, '_day') != -1) {
					// เป็นการรับประกัน
					if($brand == '0-59_day') {
						$where_warranty .= '(w.warranty_day >= 0 AND w.warranty_day <= 59) OR ';
					} elseif($brand == '60-179_day') {
						$where_warranty .= '(w.warranty_day >= 60 AND w.warranty_day <= 179) OR ';
					} elseif($brand == '180-269_day') {
						$where_warranty .= '(w.warranty_day >= 180 AND w.warranty_day <= 269) OR ';
					} elseif($brand == '270-364_day') {
						$where_warranty .= '(w.warranty_day >= 270 AND w.warranty_day <= 364) OR ';
					} elseif($brand == '365-729_day') {
						$where_warranty .= '(w.warranty_day >= 365 AND w.warranty_day <= 729) OR ';
					} elseif($brand == '730-1094_day') {
						$where_warranty .= '(w.warranty_day >= 730 AND w.warranty_day <= 1094) OR ';
					} elseif($brand == '1095-1459_day') {
						$where_warranty .= '(w.warranty_day >= 1095 AND w.warranty_day <= 1459) OR ';
					} elseif($brand == '1460-1825_day') {
						$where_warranty .= '(w.warranty_day >= 1460 AND w.warranty_day <= 1825) OR ';
					}
				} else {
					// เป็น Brand
					$where_brand .= 'p.manufacturer_id = "'.$brand.'" OR ';
				}
			}
		}

		if($where_warranty != '') {
			$where_warranty = substr($where_warranty, 0, -4);
			$where_warranty = '('.$where_warranty.') AND ';
		}

		if($where_brand != '') {
			$where_brand = substr($where_brand, 0, -4);
			$where_brand = '('.$where_brand.') AND ';
		}

		if(!empty($_GET['price_begin']) and !empty($_GET['price_end'])) {
			$where_price = '(p.price >= "'.$_GET['price_begin'].'" AND p.price <= "'.$_GET['price_end'].'") AND ';
		} else {
			$where_price = '';
		}

		$query = $this->db->query("SELECT *, p.price AS price_, p.product_id as product_id_, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM oc_product p inner join oc_product_description on p.product_id = oc_product_description.product_id INNER JOIN fd_warranty w ON p.product_id = w.product_id left join oc_product_special ps on p.product_id = ps.product_id where ".$where_brand." ".$where_warranty." ".$where_price." p.status = '1' order by sort_order asc");

		return $query->rows;
	}

	public function getProduct2Category($category1_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . $category1_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

		return $query->rows;
	}
}