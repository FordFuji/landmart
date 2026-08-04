<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php require('inc_header.php'); ?>



</head>
<style>
   .checkbox input[type=checkbox],
        .checkbox-inline input[type=checkbox],
        .radio input[type=radio],
        .radio-inline input[type=radio] {
            margin-top: 1em;
        }

        input[type='radio'] {
            width: 15px;
            height: 15px;
        }

        .paymentbank {
            text-align: left;
        }

        .txtbank {
            padding-left: 25px;
        }

        .ui-widget {
            font-size: 1.1em;
        }

        .ui-widget .ui-widget {
            font-size: 1em;
        }

        .ui-widget input,
        .ui-widget select,
        .ui-widget textarea,
        .ui-widget button {
            font-size: 1em;
        }

        .ui-widget-content {
            border: 1px solid #555555;
            background: white;
            color: black;
        }

        .ui-widget-content a {
            color: black;
        }

        .ui-datepicker .ui-datepicker-title {
            color: white;
        }

        .ui-widget-header {
            border: 1px solid #fac4c7;
            background-color: black;
            font-weight: bold;
            background-image: none;
        }

        .ui-widget-header a {
            color: black;
        }

        .ui-state-default,
        .ui-widget-content .ui-state-default,
        .ui-widget-header .ui-state-default {
            border: 1px solid #444444;
            background: white;
            font-weight: normal;
            color: black;
        }

        .ui-state-default a,
        .ui-state-default a:link,
        .ui-state-default a:visited {
            color: black;
            text-decoration: none;
        }

        .ui-state-hover,
        .ui-widget-content .ui-state-hover,
        .ui-widget-header .ui-state-hover,
        .ui-state-focus,
        .ui-widget-content .ui-state-focus,
        .ui-widget-header .ui-state-focus {
            border: 1px solid #858585;
            background: #858585;
            font-weight: normal;
            color: #ffffff;
        }

        .ui-state-hover a,
        .ui-state-hover a:hover {
            color: black;
            text-decoration: none;
        }

        .ui-state-active,
        .ui-widget-content .ui-state-active,
        .ui-widget-header .ui-state-active {
            border: 1px solid #858585;
            background: #858585 font-weight: normal;
            color: black;
        }

        .ui-state-active a,
        .ui-state-active a:link,
        .ui-state-active a:visited {
            color: black;
            text-decoration: none;
        }

        .ui-widget:active {
            outline: none;
        }

        .file-input-wrapper .file-input-button {
            color: #858585;
            border: 1px solid  #008358;
            border-radius: 50px;
            background-color: transparent;
            box-sizing: border-box;
            display: inline;
            display: inline-block;
            font-size: 1em;
            font-weight: 400;
            padding-top: 3px;
            padding: 10px 50px;
            text-align: center;
            transition: color 500ms, background-color 500ms;
            -moz-transition: color 500ms, background-color 500ms;
            -webkit-transition: color 500ms, background-color 500ms;
            -o-transition: color 500ms, background-color 500ms;
            -ie-transition: color 500ms, background-color 500ms;
            margin-top: 20px;
        }

        .file-input-wrapper .file-input-button:hover {
            background-color: #008358;
            text-decoration: none;
            cursor: pointer;
            color: white;
        }

        .file-input-wrapper input {
            display: none;
        }
</style>

<body>
	<?php require('inc_topmenu.php'); ?>
	<div class="bgbodygray">
		<div class="container-fluid">

			<div class="wrapper_pad">
				<div class="content_wrap">
					<div class="row pt-3 mb-3">
						<div class="col">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
									<li class="breadcrumb-item active" aria-current="page">แจ้งชำระเงิน
									</li>
								</ol>
							</nav>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<div class="boxwhite">
							           <h3 class="text-center">แจ้งชำระเงิน</h3>
								           <div class="formlist">
                                <label>รหัสการสั่งซื้อ</label>
                                <input id="textinput" name="textinput" type="text" class="form-control input-md">
                                <label>รายละเอียดการชำระเงิน</label>
                                <select id="selectbasic" name="selectbasic" class="form-control">
                                    <option value="1">Option one</option>
                                    <option value="2">Option two</option>
                                </select>
                                <label>จำนวนเงิน</label>
                                <input id="textinput" name="textinput" type="text" class="form-control input-md">
                                <label>ชื่อ-นามสกุล</label>
                                <input id="textinput" name="textinput" type="text" class="form-control input-md">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>วันที่ชำระเงิน</label>
                                        <form action="example.php" method="post">
                                            <input autocomplete="off" class="datepicker form-control " placeholder="DD/MM/YY" /> </form>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>เวลาที่ชำระเงิน</label>
                                        <input id="textinput" name="textinput" type="text" class="form-control input-md"> </div>
                                </div>
                                <div class="file-input-wrapper">
                                    <label for="upload-file" class="file-input-button">เลือกไฟล์</label>
                                    <input id="upload-file" type="file" name="image" />
                                    <br>

                                    <p>คลิกเพื่ออัพโหลดรูปภาพ อย่างน้อย 1 ภาพ </p> 
                                    
                                    
                                  
                            </div>
                            
                            <div class="btncenter">
                                 <center><a href="#" class="btn btn-yellow-width spacetop">แจ้งชำระเงิน</a></center> 
                             
                            </div>
                               </div>
                 
							</div>
						</div>
					</div>

				</div>
			</div>

		</div>
		<br>
	</div>
	<?php require('inc_footer.php'); ?>

  <script>
        $(document).ready(function() {
            $(function() {
                $('.datepicker').datepicker({
                    dateFormat: 'dd/mm/yy',
                    showButtonPanel: false,
                    changeMonth: false,
                    changeYear: false,
                    /*showOn: "button",
							                                                                                 buttonImage: "images/calendar.gif",
							                                                                                 buttonImageOnly: true,
							                                                                                 minDate: '+1D',
							                                                                                 maxDate: '+3M',*/
                    inline: true
                });
            });
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['January', 'Februaly', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sathurday'],
                dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat'],
                dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
        });

    </script>
</body>





</html>
