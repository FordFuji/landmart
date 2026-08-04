<?php
class ControllerCommonHeader extends Controller {
	
	public function index() {
		// Analytics
		$this->load->model('setting/extension');

		$data['analytics'] = array();

		$analytics = $this->model_setting_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get('analytics_' . $analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('extension/analytics/' . $analytic['code'], $this->config->get('analytics_' . $analytic['code'] . '_status'));
			}
		}

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts('header');
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', true), $this->customer->getFirstName(), $this->url->link('account/logout', '', true));
		
		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', true);
		$data['register'] = $this->url->link('account/register', '', true);
		$data['login'] = $this->url->link('account/login', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['transaction'] = $this->url->link('account/transaction', '', true);
		$data['download'] = $this->url->link('account/download', '', true);
		$data['logout'] = $this->url->link('account/logout', '', true);
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', true);
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');
		
		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');
		$data['menu'] = $this->load->controller('common/menu');

		$data['categories'] = $this->model_catalog_product->getCategoriesParent();

		$data['categories2'] = $this->model_catalog_product->getCategoriesAll();

		//pre($data['categories2']);

		// $data['categories3'] = $this->model_catalog_product->getCategoriesAll();

		//$data['cartAmount'] = $this->model_catalog_product->getCartOrderAmount();

		$data['cartQTY'] = $this->model_catalog_product->getCartAmount();

		$data['member'] = $this->model_catalog_product->getMember();

		// login google
		/*include_once "helpers/google_src/Google_Client.php";
		include_once "helpers/google_src/contrib/Google_Oauth2Service.php";

		// Google Project API Credentials
		$clientId = '205392047892-jaig8b05dh1qthulci6abltmf8kemkqp.apps.googleusercontent.com';
		$clientSecret = 'SJ9VhdQBHrkhremxzYbTpKfx';
		$redirectUrl = 'https://www.landmart.co.th/demo/index.php?route=common/header/callback_google';

		// Google Client Configuration
		$gClient = new Google_Client();
		$gClient->setApplicationName('Login to Landmart');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		if(!empty($_GET['code'])) {
			$gClient->authenticate();
			$this->session->data['token'] = $gClient->getAccessToken();
			redirect($redirectUrl);
		}

		$token = @$this->session->data['token'];
		if (!empty($token)) {
			$gClient->setAccessToken($token);
		}

		// $authUrl
		$data['authUrl'] = $gClient->createAuthUrl();
		// end login google
		*/

		$data['member_id'] = @$this->session->data['member_id'];

		//pre($data['member_id']);

		if(!empty($data['member_id'])) {
			$query = $this->db->query('select * from oc_customer where customer_id = "'.$data['member_id'].'"');
		
			$row = $query->row;

			if(!empty($row)) {
				$data['firstName'] = $row['firstname'];
			}
		}

		if(!empty($_GET['keyword'])) {
			$data['keyword'] = $_GET['keyword'];
		}

		if(!empty($_GET['route'])) {
			$data['route'] = $_GET['route'];
		} else {
			$data['route'] = '';
		}
		
		if(!empty($_GET['news_id'])) {
			$data['news_id'] = $_GET['news_id'];

			$sql = "SELECT * FROM fd_news WHERE news_id = '".$_GET['news_id']."'";

			$query = $this->db->query($sql);

			$row = $query->row;

			if(!empty($row)) {
				$data['url'] = HTTPS_SERVER."index.php?route=common/news/news_inside&news_id=".$row['news_id'];
				$data['news_topic'] = $row['news_topic'];
				$data['news_description'] = $row['news_description'];
				$data['news_image'] = HTTPS_SERVER.'image/'.$row['news_image'];
			}
		} else {
			$data['news_id'] = 0;
		}

		$sql = "SELECT * FROM fd_text_top_menu WHERE text_top_menu_id = '1'";

		$query = $this->db->query($sql);

		$data['text_top_menu'] = $query->row;
		
		return $this->load->view('common/header', $data);
	}

	public function callback_google() {
		// Include the google api php libraries
		/*include_once "helpers/google_src/Google_Client.php";
		include_once "helpers/google_src/contrib/Google_Oauth2Service.php";
		
		// Google Project API Credentials
		$clientId = '205392047892-jaig8b05dh1qthulci6abltmf8kemkqp.apps.googleusercontent.com';
		$clientSecret = 'SJ9VhdQBHrkhremxzYbTpKfx';
		$redirectUrl = 'https://landmart.co.th/demo/index.php?route=common/header/callback_google';
		
		// Google Client Configuration
		$gClient = new Google_Client();
		$gClient->setApplicationName('Login to Landmart');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		if ($_GET['code'] != '') {
			$gClient->authenticate();
			$this->session->data['token'] = $gClient->getAccessToken();
			redirect($redirectUrl);
		}
		
		$token = $this->session->data['token'];
		if (!empty($token)) {
			$gClient->setAccessToken($token);
		}
		
		if ($gClient->getAccessToken()) {
			$userProfile = $google_oauthV2->userinfo->get();
			// Preparing data for database insertion
			$userData['oauth_provider'] = 'google';
			$userData['oauth_uid'] = $userProfile['id'];
			$userData['first_name'] = $userProfile['given_name'];
			$userData['last_name'] = $userProfile['family_name'];
			$userData['email'] = $userProfile['email'];
			
			$email = $userData['email'];
			$name = $userData['first_name'];
			$surname = $userData['last_name'];
			//$userData['gender'] = @$userProfile['gender'];
			//$userData['locale'] = $userProfile['locale'];
			//$userData['profile_url'] = @$userProfile['link'];
			$userData['picture_url'] = $userProfile['picture'];

			$picture = $userData['picture_url'];

			$this->load->model('member/member');
			
			$insert_update_data_member = $this->model_member_member->insertUpdateGoogle($email, $name, $surname);

			$this->response->redirect($this->url->link('index.php', '', ''));
		} else {
			$authUrl = $gClient->createAuthUrl();
		}*/

		$email = $_POST['email'];
		$name = $_POST['fname'];
		$surname = $_POST['lname'];

		$this->load->model('member/member');
			
		$insert_update_data_member = $this->model_member_member->insertUpdateGoogle($email, $name, $surname);

		//$this->response->redirect($this->url->link('common/home', '', ''));
	}

	public function inc_header() {

		return $this->load->view('common/inc_header');
	}

	public function inc_sidemember() {

		return $this->load->view('common/inc_sidemember');
	}

	/* รอหน้า กรอก Email
	public function ajaxLoginFacebookNotEmail() {
		$name = explode(' ', $this->input->post('name'));
		
		$this->session->data['member_first_name'] = $name[0];
		$this->session->data['member_last_name'] = $name[1];	
	}

	public function ajaxLoginFacebookEnterEmail() {
		$this->db->where('member_email', $this->input->post('member_email'));
		$query = $this->db->get('ci_member');
		
		$row = $query->row();
		
		if(!empty($row)) {
			// update
			$data = array(
				'member_first_name' => $this->session->userdata('member_first_name'),
				'member_last_name' => $this->session->userdata('member_last_name')
			);
			
			$where = array(
				'member_email' => $this->input->post('member_email')
			);
			
			$this->db->update('ci_member', $data, $where);
		} else {
			// insert
			$data = array(
				'member_first_name' => $this->session->userdata('member_first_name'),
				'member_last_name' => $this->session->userdata('member_last_name'),
				'member_email' => $this->input->post('member_email')
			);
			
			$this->db->insert('ci_member', $data);
		}
		
		$this->db->where('member_email', $this->input->post('member_email'));
		$query = $this->db->get('ci_member');
		
		$row = $query->row();
		
		if(!empty($row)) {
			$data = array(
				'member_id' => $row->member_id,
				'member_email' => $row->member_email
			);
			
			$this->session->set_userdata($data);
			
			$data_unset = array(
				'member_first_name',
				'member_last_name'
			);
			
			$this->session->unset_userdata($data_unset);
		}
	} รอหน้า กรอก Email */

	public function ajaxLoginFacebook() {
		$query = $this->db->query('select * from oc_customer where email = "'.$_POST['member_email'].'"');
		
		$row = $query->row;

		if(!empty($row)) {
			// update Email
			$name = explode(' ', $_POST['member_name']);

			$query = $this->db->query('update oc_customer set firstname = "'.$name[0].'", lastname = "'.$name[1].'" where email = "'.$_POST['member_email'].'"');
		} else {
			// insert Email
			$name = explode(' ', $_POST['member_name']);

			$query = $this->db->query('insert into oc_customer(email, firstname, lastname) values ("'.$_POST['member_email'].'", "'.$name[0].'", "'.$name[1].'")');
		}
		
		$query = $this->db->query('select * from oc_customer where email = "'.$_POST['member_email'].'"');
		$row = $query->row;
		
		if(!empty($row)) {
			$this->session->data['member_id'] = $row['customer_id'];	
		}
	}
}
