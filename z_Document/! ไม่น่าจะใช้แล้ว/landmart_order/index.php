<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head><?php require('inc_header.php'); ?>
</head>
<style>
    .order_status li:nth-child(1) {
        border: 2px solid var(--lightgray);
    }

    .order_status li:nth-child(1) a {
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
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="selectbox_status">
                                <div class="dropdown">
                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                <th>หมายเลขการสั่งซื้อ: <span class="ordernumber">00004324234</span> </th>
                                <th>ประเภทสินค้า : Powertools+Smartfarm</th>
                                <th colspan="3" class="text-right">ชื่อผู้ซื้อ: <span class="ordernumber">สิทธิพล
                                        สนองมือ </span></th>
                            </tr>

                        </thead>
                        <tbody>
                            <tr class="bornone">
                                <td class="text-center">
                                    <input type="checkbox" id="1" />
                                </td>
                                <td> แพ็คเกจ <br> (2 รายการสินค้า)</td>
                                <td>หมายเลขติดตามพัสดุ <br> <span class="ordernumber">000043242322 </span></td>
                                <td colspan="3">ประเภทการจัดส่ง <br> Standard</td>

                            </tr>
                            <tr>
                                <td>1</td>
                                <td>
                                    <div class="row no-gutters">
                                        <div class="col-md-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-box-seam" viewBox="0 0 16 16">
                                                <path
                                                    d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                            </svg> * 1
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
                                    <div class="bigprice">8,990.00</div>
                                    <div class="smtxtg">รอการชำระเงิน</div>
                                </td>
                                <td class="text-center">
                                    <div class="bigprice">8,990.00</div>
                                    <div class="smtxtg2">รวมค่าจัดส่ง</div>
                                </td>
                                <td class="text-center">
                                    <div class="bigprice">19 Apr 2021 <br> 16:25 </div>
                                    <div class="smtxtg2">Invoice printed <br> Picking list printed</div>
                                </td>
                            </tr>

                        </tbody>
                    </table>


    </div>

    
  
</body>

</html>