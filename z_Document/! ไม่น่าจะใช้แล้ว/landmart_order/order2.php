<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head><?php require('inc_header.php'); ?>
</head>
<style>
    .order_status li:nth-child(3) {
        border: 2px solid var(--lightgray);
    }

    .order_status li:nth-child(3) a {
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
                    <th class="text-center">
                        <input type="checkbox" class="selectAll" />
                    </th>
                    <th>หมายเลขการสั่งซื้อ: <a href="order2_detail.php"><span class="ordernumber">00004324234</span></a> </th>
                    <th colspan="2" >ประเภทสินค้า : Powertools+Smartfarm</th>
                    <th  class="text-right">ชื่อผู้ซื้อ:<a href="order2_detail.php"> <span class="ordernumber">สิทธิพล
                            สนองมือ </span></a></th>
                </tr>

            </thead>
            <tbody>
                <tr class="bornone">
                    <td class="text-center">
                        <input type="checkbox" id="1" />
                    </td>
                    <td> แพ็คเกจ <br> (2 รายการสินค้า)</td>
                    <td>หมายเลขติดตามพัสดุ <br> <span class="ordernumber">000043242322 </span></td>
                    <td style="min-width: 150px;">ประเภทการจัดส่ง <br> Standard</td>
                    <td>หมายเลขใบกำกับสินค้า (อินวอยซ์) : <br> (1)CS4324324/0042 (2) CS4234324(0055)</td>

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
                                </svg> * 1 <br> <input type="checkbox" id="2" />
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

                    <td class="text-center">
                        <div class="bigprice">19 Apr 2021 <br> 16:25 </div>
                        <div class="smtxtg2"> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Invoice Printed <br> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Picking List Printed

                        </div>
                    </td>

                    <td class="text-center" colspan="2" style="vertical-align:middle;">

                        <div class="smtxtg2">CE4324324
                            <div class="btn_group_order">
                                <a href="#" class="btn btn-cancel-invoice">แก้ไข</a>
                                <a href="#" class="btn btn-confirm">ยืนยัน</a>
                            </div>
                        </div>
                    </td>
                </tr>

                <tr>

                    <td>
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-seam" viewBox="0 0 16 16">
                                    <path
                                        d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg> * 2 <br> <input type="checkbox" id="3" />
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
                    <td class="text-center">
                        <div class="bigprice">19 Apr 2021 <br> 16:25 </div>
                        <div class="smtxtg2"> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Invoice Printed <br> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Picking List Printed

                        </div>
                    </td>
                    <td colspan="2" class="text-center" style="vertical-align:middle;">

                        <div class="btn_group_order">
                        <a data-fancybox data-src="#tracking_box" href="javascript:;" class="btn btn-confirm"
                                data-width="900" data-height="350">
                                ใส่รหัสติดตามสินค้า
                            </a>
                        </div>

                    </td>
                </tr>

            </tbody>
        </table>

        <table class="table table_box_c table-bordered mt-4">
            <thead>
                <tr>
                    <th class="text-center">
                        <input type="checkbox" class="selectAll" />
                    </th>
                    <th>หมายเลขการสั่งซื้อ: <a href="order2_detail.php"><span class="ordernumber">00004324234</span></a> </th>
                    <th colspan="2" >ประเภทสินค้า : Powertools+Smartfarm</th>
                    <th class="text-right">ชื่อผู้ซื้อ: <a href="order2_detail.php"><span class="ordernumber">สิทธิพล
                            สนองมือ </span></a></th>
                </tr>

            </thead>
            <tbody>
                <tr class="bornone">
                    <td class="text-center">
                        <input type="checkbox" id="1" />
                    </td>
                    <td> แพ็คเกจ <br> (2 รายการสินค้า)</td>
                    <td>หมายเลขติดตามพัสดุ <br> <span class="ordernumber">000043242322 </span></td>
                    <td style="min-width: 150px;">ประเภทการจัดส่ง <br> Standard</td>
                    <td>หมายเลขใบกำกับสินค้า (อินวอยซ์) : <br> (1)CS4324324/0042 (2) CS4234324(0055)</td>

                </tr>
                <tr>
                    <td rowspan="2">2</td>
                    <td>
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-box-seam" viewBox="0 0 16 16">
                                    <path
                                        d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                </svg> * 1 <br> <input type="checkbox" id="2" />
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
                    <td class="text-center">
                        <div class="bigprice">19 Apr 2021 <br> 16:25 </div>
                        <div class="smtxtg2"> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Invoice Printed <br> <svg xmlns="http://www.w3.org/2000/svg" width="9" height="9"
                                fill="#35b45b" class="bi bi-circle-fill" viewBox="0 0 16 16">
                                <circle cx="8" cy="8" r="8" />
                            </svg> Picking List Printed

                        </div>
                    </td>
                    <td colspan="2" class="text-center" style="vertical-align:middle;">

                        <div class="btn_group_order">

                            <a data-fancybox data-src="#tracking_box" href="javascript:;" class="btn btn-confirm"
                                data-width="900" data-height="350">
                                ใส่รหัสติดตามสินค้า
                            </a>
                        </div>
    
            </td>
            </tr>


            </tbody>
            </table>


    </div>



    <div style="display: none;" id="tracking_box">
        <h2>กรุณาใส่หมายเลขใบกำกับสินค้า</h2>
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
                    <td>1/2</td>
                    <td> Delivery by LANDMART : Business Idea <br> สามารถนำรหัสเช็คสถานะการจัดส่งได้ที่ <br> <a
                            href="http://www.business-idea.co.th/tracking">www.business-idea.co.th/tracking</a></td>
                    <td><input type="text" class="form-control"></td>
                </tr>
            </tbody>
        </table>
        <div class="group_bottom">
            <div class="row">
                <div class="col text-md-right">
                    <a href="#" class="btn btn-sq-no">ปิด</a>
                    <a href="#" class="btn btn-sq-blue">บันทึกเลขติดตามสินค้า</a>
                </div>
            </div>
        </div>

    </div>






</body>



</html>