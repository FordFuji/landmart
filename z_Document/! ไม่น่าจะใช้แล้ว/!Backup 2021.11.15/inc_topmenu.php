<style>
	.dropdown-menu-form {
		padding: 5px 10px 0;
		max-height: 300px;
		overflow-y: scroll;
	}

	.mainlogo {
		padding: 10px 0px;
	}

	.menu_main_top li {
		list-style: none;
		display: inline-block;
		padding-right: 30px;
		font-weight: 600;
	}

	.menu_main_top li a {
		color: #000;
		text-decoration: none;
	}

	.menu_main_top li a img {
		vertical-align: middle;
	}

	nav {

		position: relative;

	}

	nav>ul>li {
		display: inline-block;
		position: relative;
	}

	nav>menu_main_top>li>a {
		color: #fff;
		display: block;
		padding: 20px 0;
		border-bottom: 3px solid transparent;
		transition: all .3s ease;
	}

	nav>menu_main_top>li:hover>a {
		color: #444;
		border-bottom: 3px solid #444;
	}

	.mega-menu {
		background: #fff;
		visibility: hidden;
		opacity: 0;
		transition: visibility 0s, opacity 0.4s linear;
		position: absolute;
		left: 0;
		width: 100%;
		padding-bottom: 20px;
		z-index: 1;
	}

	.mega-menu h3 {
		color: #444;
	}

	.mega-menu .container {
		display: flex;
	}

	.mega-menu .item {
		flex-grow: 1;
		margin: 0 10px;
	}

	.mega-menu .item img {
		width: 100%;
	}




	.dropdown {
		position: static;
	}

	.dropdown:hover .mega-menu {
		visibility: visible;
		opacity: 1;
		z-index: 2;
	}

	.search_top {
		overflow: hidden;
		width: 100%;
		position: relative;
		margin-left: 0px;
		margin-top: 25px;
		margin-bottom: 25px;
	}

	.search_top input {
		width: 100%;
		background-color: #fff;
		border-radius: 5px;
	}

	.search_top input:focus+button {
		background-color: #000612;
		color: #fff;
	}

	.search_top button {
		position: absolute;
		z-index: 1;
		right: 0px;
		top: 0px;
		line-height: 10px;
		height: 38px;
		border-top-right-radius: 5px;
		border-bottom-right-radius: 5px;
		border: 1px solid #ffcd0a;
		background-color: #ffcd0a;
		-moz-transition: background-color 0.3s ease, width 0.3s ease;
		-o-transition: background-color 0.3s ease, width 0.3s ease;
		-webkit-transition: background-color 0.3s ease, width 0.3s ease;
		transition: background-color 0.3s ease, width 0.3s ease;
		color: #fff;
		padding: 0;
		margin: 0;
		width: 45px;
		font-size: 0.9em;
		text-align: center;
		cursor: pointer;
		letter-spacing: 1px;


		text-transform: uppercase;
	}

	.search_top button:hover {
		width: 120px;
		color: #fff;
	}

	.topmenu_right {
		padding: 10px 0px;
	}

	.topmenu_right li {
		list-style: none;
		display: inline-block;
		vertical-align: middle;
		float: left;
		margin-top: 31px;
	}

	.topmenu_right li a {
		color: #000;
		text-decoration: none;
	}



	.centerag {
		text-align: center;
		margin: 0 auto;
		display: table;
	}

	.sublist_menu {
		width: 25%;
		float: left;
		padding: 20px;
		text-align: left;

	}

	.sublist_menu ul li {
		display: block;
	}

	/* ----- MODAL STYLE ----- */
	.modal-content {
		border-radius: 0;
		border: none;
	}



	.modal-title {
		text-transform: uppercase;
		font-family: 'AvenirHeavy';
		letter-spacing: 1px;
		font-size: 1em;
		padding-top: 7px;
	}

	.nav-link {
		padding: 10px;
	}

	.nav-tabs .nav-link {
		border-radius: 0px;
		color: #000;
		background-color: #f2f2f2;
		width: 50%;
		font-weight: bold;
		text-align: center;
	}

	.nav-tabs {
		border: none;
	}

	.form_fillin label,
	.nav-tabs .nav-item.show .nav-link,
	.nav-tabs .nav-link.active {
		color: #000;
		font-weight: bold;
	}

	.form_fillin {
		padding: 10px;
	}

	.form_fillin h4 {
		text-align: center;
		color: #000;
		font-weight: bold;

	}

	#login_box.fancybox-content {
		padding: 0px !important;
	}

	.title_form {
		background-color: #ffcd0a;
		font-size: 1.5em;
		padding: 20px;
		color: #fff;
	}

	#login_box .fancybox-close-small {
		color: #fff !important;
	}
</style>
<!--PC-->
<div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
<div class="navbg_menu_black">
	<div class="container-fluid">
	
			<div class="row">
				<div class="col-sm-3">
					<div class="mainlogo">
						<a href="index.php"><img src="images/logo_white.svg" class="img-fluid"></a>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="search_top">

						<input type='text' placeholder="ค้นหาสินค้าทั้งหมด" class="form-control">

						<button class="icon-sub-m">
							<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
								class="bi bi-search" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
								<path fill-rule="evenodd"
									d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
							</svg></button>
					</div>
				</div>
				<div class="col-sm-3">
					<div class="right_ConMenu">
						<li>
							<div class="cartNew">
								<img src="images/cartNew.svg" alt=""> <span class="numberCartN">2</span>
							</div>
						</li>
						<!-- COPY ไปตั้งแต่ตรงนี้นะ -->
						<li>
							<div class="registertoptop">
							<a class="link_menutop" href="#">
							<div class="accNew">
									<span class="whiteSM">เข้าสู่ระบบ/</span><br>
									<span class="bigYellow"> สมัครสมาชิก</span> <br>
									<span class="logOutst">
										<i class="fas fa-caret-down"></i> ออกจากระบบ
									</span>

								</div>
							</a>
								<div class="bg_pop_menutop">	
								<nav>
											<div class="nav nav-tabs" id="nav-tab" role="tablist">
												<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">เข้าสู่ระบบ</a>
												<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">สมัครสมาชิก</a>
											</div>
										</nav>
										<div class="tab-content" id="nav-tabContent">
											<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
												<div class="form_fillin">
													<h4>เข้าสู่ระบบ</h4>
													<label>อีเมล</label>
													<form action="index.php?route=member/member/login" method="post">
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-envelope" viewBox="0 0 16 16">
																	<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
																</svg></span>
														</div>
														<input type="email" class="form-control" placeholder="กรอกชื่อผู้ใช้หรืออีเมลของท่าน" aria-label="Username" aria-describedby="basic-addon1" name="member_email_login" required>
													</div>
													<label>รหัสผ่าน</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-eye-slash" viewBox="0 0 16 16">
																	<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" />
																	<path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z" />
																	<path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884l-12-12 .708-.708 12 12-.708.708z" />
																</svg></span>
														</div>
														<input type="password" class="form-control" placeholder="กรอกรหัสผ่านของท่าน" aria-label="password" aria-describedby="basic-addon1" name="member_password_login" required>
													</div>
												
													<div class="row">
														<div class="col-md-6">
														<span class="checkRemember">
													<input type="checkbox" aria-label="Checkbox for following text input"> บันทึกการเข้าสู่ระบบ
													</span>
														</div>
														<div class="col-md-6">
														<a href="#" class="forgetpass">ลืมรหัสผ่าน ?</a>
														</div>
													</div>
												
												
												
													<br>
													<input type="submit" name="submit" class="btn btn-yellow" value="เข้าสู่ระบบ">
													</form>
													
													<div class="orlogin mt-3 mb-3">หรือ</div>
													<div class="row">
														<div class="col-md-6 padright">
															<a href="javascript:void(0);" onclick="fbLogin();" style="color: white;" class="btn btn-facebook"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3a5fa7" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
</svg> เข้าสู่ระบบด้วย <br><span style="color:#3a5fa7;">Facebook</span></a>
														</div>
														<div class="col-md-6 padleft" onclick="onLoadGoogleCallback();" id="signin">	
															<a style="color: white;" class="btn btn-googleplus"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#d54e3e" class="bi bi-google" viewBox="0 0 16 16">
  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
</svg> เข้าสู่ระบบด้วย <br> <span style="color:#d54e3e;">Google+</span></a><script src="https://apis.google.com/js/platform.js?onload=onLoad" async="" defer="" gapi_processed="true"></script></div>
													</div>
												<br>
											
												</div>
											</div>
											<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
												<div class="form_fillin">
													<form action="index.php?route=member/member/register" method="post" onsubmit="return checkConfirmPassword();">
													<h4>สมัครสมาชิก</h4>
													<label>ชื่อผู้ใช้งาน</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-person" viewBox="0 0 16 16">
																	<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
																</svg></span>
														</div>
														<input type="text" name="member_name" class="form-control" placeholder="กรอกชื่อผู้ใช้ของท่าน" aria-label="Username" aria-describedby="basic-addon1" required>
													</div>
													<label>อีเมล</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-envelope" viewBox="0 0 16 16">
																	<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-4.758 2.855L15 11.114v-5.73zm-.034 6.878L9.271 8.82 8 9.583 6.728 8.82l-5.694 3.44A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.739zM1 11.114l4.758-2.876L1 5.383v5.73z" />
																</svg></span>
														</div>
														<input type="email" name="member_email" class="form-control" placeholder="กรอกอีเมลของท่าน" aria-label="Email" aria-describedby="basic-addon1" required>
													</div>
													<label>เบอร์โทรติดต่อ</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-telephone" viewBox="0 0 16 16">
																	<path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
																</svg></span>
														</div>
														<input type="text" name="member_phone" class="form-control" placeholder="กรอกเบอร์โทรติดต่อของท่าน" aria-label="Tel" aria-describedby="basic-addon1" required>
													</div>
													<label>รหัสผ่าน</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-eye-slash" viewBox="0 0 16 16">
																	<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" />
																	<path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z" />
																	<path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884l-12-12 .708-.708 12 12-.708.708z" />
																</svg></span>
														</div>
														<input type="password" name="member_password" id="member_password" class="form-control" placeholder="กรอกรหัสผ่านของท่าน" aria-label="password" aria-describedby="basic-addon1" required>
													</div>
													<label>ยืนยันรหัสผ่าน</label>
													<div class="input-group mb-3">
														<div class="input-group-prepend">
															<span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="#c0c0c0" class="bi bi-eye-slash" viewBox="0 0 16 16">
																	<path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7.028 7.028 0 0 0-2.79.588l.77.771A5.944 5.944 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.134 13.134 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.165.165-.337.328-.517.486l.708.709z" />
																	<path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829l.822.822zm-2.943 1.299l.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829z" />
																	<path d="M3.35 5.47c-.18.16-.353.322-.518.487A13.134 13.134 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7.029 7.029 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884l-12-12 .708-.708 12 12-.708.708z" />
																</svg></span>
														</div>
														<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="กรอกรหัสผ่านของท่าน" aria-label="password" aria-describedby="basic-addon1" required>
													</div>

													<br>

													<input type="submit" name="submit" class="btn btn-yellow" value="สมัครสมาชิก">
																<br>
													</form>

													<div class="orlogin mt-3 mb-3">หรือ</div>
													<div class="row">
														<div class="col-md-6 padright">
															<a href="javascript:void(0);" onclick="fbLogin();" style="color: white;" class="btn btn-facebook"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#3a5fa7" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
</svg> เข้าสู่ระบบด้วย <br><span style="color:#3a5fa7;">Facebook</span></a>
														</div>
														<div class="col-md-6 padleft" onclick="onLoadGoogleCallback();" id="signin">	
															<a style="color: white;" class="btn btn-googleplus"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#d54e3e" class="bi bi-google" viewBox="0 0 16 16">
  <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
</svg> เข้าสู่ระบบด้วย <br> <span style="color:#d54e3e;">Google+</span></a><script src="https://apis.google.com/js/platform.js?onload=onLoad" async="" defer="" gapi_processed="true"></script></div>
													</div>
												</div>
											</div>
										</div>
								</div>
							</div>
						</li>
					</div>
				</div>
			
			</div>

		</div>
	</div>


	<div class="navbg_menu">
		<div class="content_wrap">
			<div class="menu_main_top">
				<li>
					<div class="cd-dropdown-wrapper">
						<a class="cd-dropdown-trigger" href="#0"> <svg xmlns="http://www.w3.org/2000/svg"
								style="vertical-align: text-bottom;" width="20" height="20" fill="currentColor"
								class="bi bi-list" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
							</svg> หมวดหมู่สินค้า</a>
						<nav class="cd-dropdown">

							<ul class="cd-dropdown-content">
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">เครื่องมือการเกษตร</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
									</ul>
									<!-- .cd-dropdown-icons -->
								</li>
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">ระบบน้ำ</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												ปั้มน้ำ
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												ท่อพีพี
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												สปริงเกอร์
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												อุปกรณ์ประปา
											</a>
										</li>
									</ul>
								</li>
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">เครื่องมือช่าง</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
									</ul>
								</li>
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">เครื่องใช้ในครัวเรือน</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
									</ul>
								</li>
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">เครื่องใช้อุตสาหกรรม</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
									</ul>
								</li>
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">อุปกรณ์ฟาร์มเลี้ยงสัตว์</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
									</ul>
								</li>
								<li class="has-children">
									<a href="https://codyhouse.co/?p=748">อุปกรณ์เอ้าดอร์</a>
									<ul class="cd-dropdown-icons is-hidden">
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
										<li>
											<a class="cd-dropdown-item item-1" href="#">
												test
											</a>
										</li>
									</ul>
								</li>
								<!-- .has-children -->

							</ul>

						</nav>
						<!-- .cd-dropdown -->
					</div>
					<!-- .cd-dropdown-wrapper -->



				</li>
				<li><a href="#">
						โปรโมชั่นและอัพเดท
					</a></li>
				<li><a href="#"><img src="images/careerNew.svg" class="smsizeB"> สมัครงาน</a></li>
				<li><a href="#"><img src="images/b2bNew.svg" class="smsizeB"> ขายสินค้ากับเรา</a></li>
			</div>
			<div class="Text_we">
				"เราจะเติบโตไปด้วยกัน"
			</div>
		</div>
	</div>

	<!-- <div class="content_wrap">
			<div class="row">
				<div class="col-sm-12">
					<div class="centerag">

						<ul class="series_menu">
							<li><a href="#"><img src="images/newd/logo_serie1.png" alt=""></a></li>
							<li><a href="#"><img src="images/newd/logo_serie2.png" alt=""></a></li>
							<li><a href="#"><img src="images/newd/logo_serie3.png" alt=""></a></li>
							<li><a href="#"><img src="images/newd/logo_series_new_03.png" alt="" style="width:45px;"></a></li>
							<li><a href="#"><img src="images/newd/logo_serie7.png" alt=""></a></li>
							<li><a href="#"><img src="images/newd/logo_series_new_06.png" alt=""></a></li>
							<li><a href="#"><img src="images/newd/logo_series_new_08.png" alt=""></a></li>
						</ul>
					</div>

				</div>
			</div>
		</div> -->


</div>


<!--MOBILE-->
<div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
	<div class="container-fluid nopad">
		<div class="blackbgMb">
			<div class="row">
				<div class="col-2">
					<div data-toggle="modal" data-target="#myModal" class="menumobileslide">
						<svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" fill="#fff" class="bi bi-list"
							viewBox="0 0 16 16">
							<path fill-rule="evenodd"
								d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
						</svg>
					</div>
					<!-- Modal -->
					<div class="modal left fade" id="myModal" tabindex="-1" role="dialog"
						aria-labelledby="myModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">

								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
											aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="26"
												height="26" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
												<path fill-rule="evenodd"
													d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
											</svg></span></button>

								</div>

								<div class="modal-body" style="padding:0px;">
									<div id="menu" class="">
										<div class="menu-box">
											<div class="menu-wrapper-inner">
												<div class="menu-wrapper">
													<div class="menu-slider">
														<div class="menu">
															<ul>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="1">หมวดหมู่สินค้า</a>
																		<span class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="">โปรโมชั่นและอัพเดท</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="">สมัครงาน</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="">ขายสินค้ากับเรา</a></div>
																</li>
																<div class="tab_help">
																	ศูนย์บริการลูกค้า
																</div>
																<li>
																	<div class="menu-item"><a href="#">แจ้งชำระเงิน </a>
																	</div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">การสมัครสมาชิก
																		</a></div>
																</li>

																<li>
																	<div class="menu-item"><a href="#">การสั่งซื้อสินค้า
																		</a></div>
																</li>

																<li>
																	<div class="menu-item"><a href="#">การชำระเงิน</a>
																	</div>
																</li>
																<li>
																	<div class="menu-item"><a
																			href="#">เช็คสถานะการจัดส่ง</a></div>
																</li>

																<li>
																	<div class="menu-item"><a
																			href="#">คำถามที่พบบ่อย</a></div>
																</li>
															</ul>
														</div>
														<div class="submenu menu" data-menu="1">
															<div class="submenu-back">
																<div class="menu-item">
																	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span>
																	<a href="#" class="menu-back">Back</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="2">เครื่องมือการเกษตร</a> <span
																			class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="3">ระบบน้ำ</a> <span
																			class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="4">เครื่องมือช่าง</a> <span
																			class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="5">เครื่องใช้ในครัวเรือน</a>
																		<span class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="6">เครื่องใช้อุตสาหกรรม</a>
																		<span class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="7">อุปกรณ์ฟาร์มเลี้ยงสัตว์</a>
																		<span class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#"
																			class="menu-anchor"
																			data-menu="8">อุปกรณ์เอ้าดอร์</a>
																		<span class="detail"><svg
																				xmlns="http://www.w3.org/2000/svg"
																				width="16" height="16"
																				fill="currentColor"
																				class="bi bi-chevron-right"
																				viewBox="0 0 16 16">
																				<path fill-rule="evenodd"
																					d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
																			</svg></span></div>
																</li>
															</ul>
														</div>



														<div class="submenu menu" data-menu="2">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">เครื่องมือการเกษตร</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">เกษตรในครัวเรือน</a>
																	</div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">ระบบน้ำมัน</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">อุปกรณ์เกษตรและสินค้าอื่นๆ</a></div>
																</li>
																
															</ul>
														</div>

														<div class="submenu menu" data-menu="3">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">ระบบน้ำ</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">ปั้มน้ำ</a>
																	</div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">ท่อพีพี</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">สปริงเกอร์</a></div>
																</li>
																
															</ul>
														</div>
														<div class="submenu menu" data-menu="4">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">เครื่องมือช่าง</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">ปั้มลม</a>
																	</div>
																</li>
																<li>
																	<div class="menu-item"><a href="#">เครื่องปั่นไฟ</a></div>
																</li>
																
																
															</ul>
														</div>
														<div class="submenu menu" data-menu="5">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">เครื่องใช้ในครัวเรือน</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
															
																
																
															</ul>
														</div>
														<div class="submenu menu" data-menu="6">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">เครื่องใช้อุตสาหกรรม</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																
															</ul>
														</div>
														<div class="submenu menu" data-menu="7">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">อุปกรณ์ฟาร์มเลี้ยงสัตว์</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																
															</ul>
														</div>
														<div class="submenu menu" data-menu="8">
															<div class="submenu-back">
																<div class="menu-item">	<span class="detail back">
																		<svg xmlns="http://www.w3.org/2000/svg"
																			width="16" height="16" fill="currentColor"
																			class="bi bi-chevron-left"
																			viewBox="0 0 16 16">
																			<path fill-rule="evenodd"
																				d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z" />
																		</svg>
																	</span><a
																		href="#" class="menu-back">อุปกรณ์เอ้าดอร์</a></div>
															</div>
															<ul>
																<li>
																	<div class="menu-item"><a
																			href="product_index.php">ดูทั้งหมด</a></div>
																</li>
																
															</ul>
														</div>
														


														<div class="clear"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div><!-- modal-content -->
						</div><!-- modal-dialog -->
					</div><!-- modal -->


				</div>
				<div class="col-7 padright">
					<div class="mainlogo_mobile">
						<a href="index.php"> <img src="images/logo_white.svg" class="img-fluid"></a>
					</div>

				</div>
				<div class="col-3">
					<div class="mobile_top">
						<ul>
							<li class="ACCmb"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
										fill="#fff" class="bi bi-person" viewBox="0 0 16 16">
										<path
											d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
									</svg></a></li>
							<li class="cart_top"><a href="#"><img src="images/cartNew.svg" alt=""> <span
										class="numberCartN">2</span></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="search_mobile">
						<input type='text' placeholder="ค้นหาสินค้าทั้งหมด" class="form-control"> <a href="#"
							class="search-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
								fill="#000" class="bi bi-search" viewBox="0 0 16 16">
								<path fill-rule="evenodd"
									d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
								<path fill-rule="evenodd"
									d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
							</svg></a>
					</div>
				</div>
			</div>
		</div>


		<div class="row">
			<div class="col">
				<div class="menutop_scroll">
					<li>
						<a href='#'><img src="images/newd/icon_menu1.png"> เกษตร</a>
					</li>
					<li>
						<a href='#'><img src="images/newd/icon_menu2.png"> ระบบน้ำ</a>
					</li>
					<li>
						<a href='#'><img src="images/newd/icon_menu3.png"> เครื่องมือช่าง</a>
					</li>
					<li>
						<a href='#'><img src="images/newd/icon_menu4.png"> บ้านและสวน</a>
					</li>
					<li>
						<a href='#'><img src="images/newd/icon_menu5.png"> ของใช้อุตสาหกรรม</a>
					</li>
					<li>
						<a href='#'><img src="images/newd/icon_menu6.png"> ตกปลา-เลี้ยงสัตว์</a>
					</li>
					<li>
						<a href='#'><img src="images/newd/icon_menu7.png"> ใช้ชีวิตภายนอก</a>
					</li>
				</div>

			</div>
		</div>
	</div>



</div>
<script>
	var menu_width;

	jQuery(document).ready(
		function () {

			initMenu();

		});

	function initMenu() {
		menu_width = $("#menu .menu").width();

		$(".menu-back").click(function () {

			var _pos = $(".menu-slider").position().left + menu_width;
			var _obj = $(this).closest(".submenu");

			$(".menu-slider").stop().animate({
				left: _pos
			}, 300, function () {
				_obj.hide();
			});

			return false;
		});

		$(".menu-anchor").click(function () {
			var _d = $(this).data('menu');
			$(".submenu").each(function () {

				var _d_check = $(this).data('menu');

				if (_d_check == _d) {
					$(this).show();
					var _pos = $(".menu-slider").position().left - menu_width;

					$(".menu-slider").stop(true, true).animate({
						left: _pos
					}, 300);
					return false;
				}
			});

			return false;
		});

	}
</script>
<script>
	$(document).ready(function() {
		$('.link_menutop').click(function() {
			if ($(this).parent().find(".bg_pop_menutop").is(":hidden")) {
				$(".bg_pop_menutop").slideUp();
				$(this).parent().find(".bg_pop_menutop").slideDown();
			} else {
				$(this).parent().find(".bg_pop_menutop").slideUp();
			}
		});
	});

</script>
<!-- <script>
	$("document").ready(function() {

		$('.dropdown-menu').on('click', function(e) {
			if ($(this).hasClass('dropdown-menu-form')) {
				e.stopPropagation();
			}
		});
	});

</script> -->