<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head><?php require('inc_header.php'); ?>
</head>
<style>
    .list_status_sec ul li:nth-child(1) {
        border: 2px solid var(--white);
    }
    .list_status_sec ul li:nth-child(1)  a{
        color: var(--blue);
    }
    .order_status li:nth-child(6) {
        border: 2px solid var(--lightgray);
    }

    .order_status li:nth-child(6) a {
        color: var(--blue);
    }

</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="title_order">
                    <h1>คำสั่งซื้อ</h1>
                    <span>รายละเอียดทั่วไปของคำสั่งซื้อ</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="order_status">
                    <li>
                        <a href="index.php">
                            รอการชำระเงิน (2)
                        </a>
                    </li>
                    <li>
                        <a href="order1.php">
                            กำลังดำเนินการ (0 )ทั้งหมด (3)
                        </a>
                    </li>
                    <li>
                        <a href="order2.php">
                            พร้อมจัดส่ง (3)
                        </a>
                    </li>
                    <li>
                        <a href="order3.php">
                            จัดส่งแล้ว (1)
                        </a>
                    </li>
                    <li>
                        <a href="order4.php">
                            ยกเลิก (0)
                        </a>
                    </li>
                    <li>
                        <a href="order5.php">
                            ประวัติการขาย (140)
                        </a>
                    </li>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <div class="bggray">
                    <div class="list_status_sec">
                        <ul>
                            <li><a href="#">
                               แบบเก็บเงินปลายทาง COD  (4)
                            </a></li>
                            <li><a href="#">
                                ชำระผ่านบัตรเครดิต (32)
                            </a></li>
                            <li><a href="#">ชำระผ่านธนาคาร (12)</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-gutters mt-3">
            <div class="col-md-3">
                <div class="select_print">
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            พิมพ์ฉลากสำหรับจัดส่ง
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"> <input class="form-check-input" type="checkbox" value=""
                                    id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    พิมพ์ฉลากสำหรับจัดส่ง
                                </label> </a>

                            <div class="btn_pint_group"> <a href="#" class="btn btn-cancel">ยกเลิก</a>
                                <a href="#" class="btn btn-print">พิมพ์</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="selectbox_status">
                    <div class="dropdown">
                        <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            สถานะ
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#"> ยกเลิกออเดอร์</a>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <table class="table table_box_c table-bordered mt-4">
            <thead>
                <tr>


                    <th colspan="2">หมายเลขการสั่งซื้อ: <span class="ordernumber">00004324234</span></th>
                    <th colspan="2">ประเภทสินค้า : Powertools+Smartfarm</th>
                    <th class="text-right">ชื่อผู้ซื้อ: <span class="ordernumber"> ลิซ่า </span></th>
                </tr>

            </thead>
            <tbody>
                <tr class="bornone">

                    <td> แพ็คเกจ <br> (2 รายการสินค้า)</td>
                    <td style="min-width: 150px;">หมายเลขติดตามพัสดุ : <br> <span class="ordernumber">000043242322
                        </span></td>
                    <td colspan="2">ประเภทการจัดส่ง : <br> Standard</td>
                    <td colspan="2">หมายเลขใบกำกับสินค้า (อินวอยซ์) : <br> CS4324324/0042 </td>

                </tr>
                <tr>
                    <td rowspan="2">1</td>
                    <td>
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-seam" viewBox="0 0 16 16">
                                    <path
                                        d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg> * 1 <br> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="#9f9f9f" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z" />
                                </svg>
                            </div>
                            <div class="col-md-2">
                                <img src="images/producttest.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="productcontent">
                                    <h4>เครื่องสีข้าว 3 ระบบ + มอเตอร์ 3 แรง (สีข้าว, บด, สับ)</h4>
                                    <span class="smtxt">LANDMART</span> <br>
                                    <span class="smtxtg">รุ่น LM-6N2018-9FC21</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="text-center" style="vertical-align:middle;">
                        <div class="bigprice">19 Apr 2021 <br> 16:25 </div>
                        <span class="lightgray">COD</span>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                    <div class="bigprice">3 May 2021 <br> 17:25 </div>
                        <div class="smtxtg2"> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Complete

                        </div>
                    </td>

                    <td class="text-center" colspan="2" style="vertical-align:middle;">

                    <div class="smtxtg2">TH432432RT4 <br>
                            <span class="bluetxt"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                    <path
                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                </svg> ทำการจัดส่งแล้ว</span> <br>
                                <a data-fancybox data-src="#checkstatus_box" href="javascript:;" class="btn btn-confirm"
                            data-width="900" data-height="450">
                            ตรวจสอบสถานะการจัดส่ง
                        </a>
                        </div>
                    </td>
                </tr>


            </tbody>

        </table>

        <table class="table table_box_c table-bordered mt-4">
            <thead>
                <tr>


                    <th colspan="2">หมายเลขการสั่งซื้อ: <span class="ordernumber">00004324234</span></th>
                    <th colspan="2">ประเภทสินค้า : Powertools+Smartfarm</th>
                    <th class="text-right">ชื่อผู้ซื้อ: <span class="ordernumber"> ลิซ่า </span></th>
                </tr>

            </thead>
            <tbody>
                <tr class="bornone">

                    <td> แพ็คเกจ <br> (2 รายการสินค้า)</td>
                    <td style="min-width: 150px;">หมายเลขติดตามพัสดุ : <br> <span class="ordernumber">000043242322
                        </span></td>
                    <td colspan="2">ประเภทการจัดส่ง : <br> Standard</td>
                    <td colspan="2">หมายเลขใบกำกับสินค้า (อินวอยซ์) : <br> CS4324324/0042 </td>

                </tr>
                <tr>
                    <td rowspan="2">1</td>
                    <td>
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-seam" viewBox="0 0 16 16">
                                    <path
                                        d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg> * 1 <br> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="#9f9f9f" class="bi bi-x-lg" viewBox="0 0 16 16">
                                    <path
                                        d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z" />
                                </svg>
                            </div>
                            <div class="col-md-2">
                                <img src="images/producttest.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-8">
                                <div class="productcontent">
                                    <h4>เครื่องสีข้าว 3 ระบบ + มอเตอร์ 3 แรง (สีข้าว, บด, สับ)</h4>
                                    <span class="smtxt">LANDMART</span> <br>
                                    <span class="smtxtg">รุ่น LM-6N2018-9FC21</span>
                                </div>
                            </div>
                        </div>
                    </td>

                    <td class="text-center" style="vertical-align:middle;">
                        <div class="bigprice">19 Apr 2021 <br> 16:25 </div>
                        <span class="lightgray">COD</span>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                    <div class="bigprice">3 May 2021 <br> 17:25 </div>
                        <div class="smtxtg2"> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Complete

                        </div>
                    </td>

                    <td class="text-center" colspan="2" style="vertical-align:middle;">

                    <div class="smtxtg2">TH432432RT4 <br>
                            <span class="bluetxt"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                    <path
                                        d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z" />
                                </svg> ทำการจัดส่งแล้ว</span> <br>
                                <a data-fancybox data-src="#checkstatus_box" href="javascript:;" class="btn btn-confirm"
                            data-width="900" data-height="450">
                            ตรวจสอบสถานะการจัดส่ง
                        </a>
                        </div>
                    </td>
                </tr>


            </tbody>

        </table>

        <div class="page_each_c">
        <div class="row mt-5 mb-5">
            <div class="col-md-6">
               
          <span class="showpage">
          ทั้งหมด 1 
          </span> 
                <select class="form-select form-control" aria-label="Default select example">
                    <option selected>10</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
              
                
            </div>
            <div class="col-md-6">
            <nav aria-label="...">
                    <ul class="pagination">
                        <li class="page-ite">
                            <a class="page-link" href="#" tabindex="-1"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="14" height="14" fill="currentColor" class="bi bi-caret-left-fill"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                </svg></a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link" href="#">1 </a>
                        </li>
                        <li class="page-item">
                            <a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    fill="currentColor" class="bi bi-caret-right-fill" viewBox="0 0 16 16">
                                    <path
                                        d="m12.14 8.753-5.482 4.796c-.646.566-1.658.106-1.658-.753V3.204a1 1 0 0 1 1.659-.753l5.48 4.796a1 1 0 0 1 0 1.506z" />
                                </svg></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

    </div>
    </div>



    <div style="display: none;" id="checkstatus_box">
        <h2>ชื่อผู้ซื้อ : <span class="bluetxt">สิทธิพล สนองมือ</span></h2>
       
        <div class="row no-gutters">
            <div class="col-md-2">
                สหกรณ์โพนยางคำ
            </div>
            <div class="col-md-2">
                สกลนคร  <br> เมืองสกลนคร
            </div>
            <div class="col-md-2">
                48000 <br> 
                Thailand
            </div>
            <div class="col-md-2">
                โทร : 0988888888
            </div>
        </div>
        <br>
        <table class="table table-invoice-fill table-bordered">
            <thead>
                <tr>
                    <th>หมายเลขคำสั่งซื้อ</th>
                    <th>สินค้า</th>
                    <th>ผู้ให้บริการ</th>
                    <th>หมายเลข Tracking</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>00000032</td>
                    <td> <div class="row no-gutters">
                           
                            <div class="col-md-3">
                                <img src="images/producttest.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="productcontent">
                                    <h4>เครื่องสีข้าว 3 ระบบ + มอเตอร์ 3 แรง (สีข้าว, บด, สับ)</h4>
                                    <span class="smtxt">LANDMART</span> <br>
                                    <span class="smtxtg">รุ่น LM-6N2018-9FC21</span>
                                </div>
                            </div>
                        </div></td>
                    <td> Delivery by LANDMART : Business Idea <br> สามารถนำรหัสเช็คสถานะการจัดส่งได้ที่ <br> <a
                            href="http://www.business-idea.co.th/tracking">www.business-idea.co.th/tracking</a></td>
                    <td>CEI534324234</td>
                </tr>
                <tr>
                    <td></td>
                    <td> <div class="row no-gutters">
                           
                            <div class="col-md-3">
                                <img src="images/producttest.jpg" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-9">
                                <div class="productcontent">
                                    <h4>เครื่องสีข้าว 3 ระบบ + มอเตอร์ 3 แรง (สีข้าว, บด, สับ)</h4>
                                    <span class="smtxt">LANDMART</span> <br>
                                    <span class="smtxtg">รุ่น LM-6N2018-9FC21</span>
                                </div>
                            </div>
                        </div></td>
                    <td> Delivery by LANDMART : Business Idea <br> สามารถนำรหัสเช็คสถานะการจัดส่งได้ที่ <br> <a
                            href="http://www.business-idea.co.th/tracking">www.business-idea.co.th/tracking</a></td>
                    <td>CEI534324234</td>
                </tr>
            </tbody>
        </table>
      

    </div>






</body>



</html>