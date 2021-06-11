<?php 
session_start();
$title = 'รายงาน'; //กำหนดไตเติ้ล
if ($_SESSION['id'] != '') {
    include 'connect.php';
    $sql = "SELECT * FROM tb_member WHERE id_member = '{$_SESSION['id']}' ";
    $rs = $conn->query( $sql )->fetch_assoc() ;
  }
if ($_SESSION['status'] =='admin')  
{
    include 'connect.php';
    include 'function.php';
} else {
    echo "<script>alert('คุณไม่มีสิทธิในการเข้าถึง!'); window.location ='index.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/report.css">
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <title><?php echo $title; ?></title>
</head>
<body>
    <!-- Start nav-bar -->
    <nav>
      <ul class="menu">
          <li class="logo"><a class="list" href="index.php?page=home"><img src="images/Logo_PIM.png" alt="PIM Logo"></a></li>
          <li class="brand"><a class="list" href="index.php?page=home">ระบบจองห้องประชุม</a></li>
          <li class="item"><a class="list" href="index.php?page=booking">จองห้องประชุม</a></li>
          <li class="item"><a class="list" href="index.php?page=rooms">ห้องประชุม</a></li>
<?php if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'user' || $_SESSION['type'] == 'STUDENT' || $_SESSION['type'] == 'STAFF') {?> 
          <li class="item">
            <a class="list" href="index.php?page=mybooking">รายการจอง</a>
          </li>
<?php } ?> 
<?php   if ($_SESSION['status'] =='admin')  { ?>
          <li class="item"><a class="list" href="index.php?page=member">สมาชิก</a></li>
          <li class="item"><a class="list" href="index.php?page=report">รายงาน</a></li>
<?php } ?> 

<?php if ($_SESSION['id'] != '' || $_SESSION['status'] != '') {?>
	<?php 	if ($_SESSION['status'] == 'admin') {
	$sql2 = "SELECT COUNT(id) AS count1 FROM tb_event WHERE status = 0 ";
	$rs2 = $conn->query($sql2)->fetch_assoc();?>
		      <li class="item">
                <a class="list" href="index.php?page=report&report=0"><i class="fas fa-bell"></i></a>
            <?php 	if ($rs2['count1']!=0) { ?>
                <span class="notify2"><?php echo $rs2['count1'];?></span>
            <?php } ?>
              </li>
	<?php } ?>
      <li class="item out">
        <a class="logout" href="#">
          <span class="user-info">
<?php 
echo $rs['title'].$rs['firstname'].'  '.$rs['surname'];
echo ($_SESSION['firstname_th'].' '.$_SESSION['lastname_th']);
?>									
				  </span>
          <i class="ace-icon fa fa-caret-down"></i>
        </a>

        <ul class="dropdown-out">
          <li class="item-drop">
            <a href="member/logout.php">
              <i class="ace-icon fa fa-power-off"></i>
              ออกจากระบบ
            </a>
					</li>
        </ul>
      </li>
<?php } else {?>
		      <li class="item-button"><a class="list" href="index.php?page=login">เข้าสู่ระบบ</a></li>
          
<?php } ?>

		      <li class="toggle"><a href="#"><i class="fas fa-bars"></i></a></li>	
      </ul>
  </nav>
  <!-- End nav-bar  -->


<!-- Start table -->
<?php if ($_GET['action']=='') { ?>
<div class="container-table100">
    <div class="wrap-table100">
        <div class="btnExport">
            <button class="buttonexcel" id='DLtoExcel'>
                <span>
                    <i class="fas fa-file-excel"></i> Export to Excel
                </span>
            </button>
        </div>
        <div class="table100">
            <div class="form-group" style="float: right;">
                <form action="" method="post" class="formstatus">
                    <label class="text-warning bigger-140 blue" for="link"> ค้นหาจากสถานะ </label>
                    <select class="selectstatus" name="selectstatus" onchange="this.options[this.selectedIndex].value; document.getElementsByClassName('substatus')[0].click();">
                        <option value="" <?php if ($_GET['report'] == '') {echo 'selected';} ?> >ทั้งหมด</option>
                        <option value="0" <?php if ($_GET['report'] == '0') {echo 'selected';} ?> >รออนุมัติ</option>
                        <option value="1" <?php if ($_GET['report'] == '1') {echo 'selected';} ?> >อนุมัติ</option>
                        <option value="2" <?php if ($_GET['report'] == '2') {echo 'selected';} ?> >ไม่อนุมัติ</option>
                        <option value="3" <?php if ($_GET['report'] == '3') {echo 'selected';} ?> >ยกเลิก</option>
                    </select>
                    <button class="substatus" type="submit" name="substatus" hidden> ค้นหา </button>
                </form>
            </div>
<?php
if (isset($_POST['substatus']))
{
		if ($_POST['selectstatus']!='' )
		{
			echo "<script> window.location = 'index.php?page=report&report=".$_POST['selectstatus']."'</script>"; 
		} else { 
			echo "<script> window.location = 'index.php?page=report'</script>"; 
		}
}
	if (isset($_GET['report'])) {
	$meSQL = "SELECT * FROM tb_event LEFT JOIN tb_rooms ON tb_event.rooms = tb_rooms.id_rooms WHERE status = {$_GET['report']} ORDER BY id DESC";
	} else {	
	$meSQL = "SELECT * FROM tb_event LEFT JOIN tb_rooms ON tb_event.rooms = tb_rooms.id_rooms ORDER BY id DESC";
	}
	$meQuery = $conn->query($meSQL);
?>
            <div class="table-header">
                <h3>รายงาน</h3>
            </div>
            
            <table id = 'datatables'>
                <thead>
                    <tr class="table100-head">
                        <th class="column1">ลำดับ</th>
                        <th class="column2">ผู้จอง</th>
                        <th class="column3">สาขา</th>
                        <th class="column4">ห้องประชุม</th>
                        <th class="column5">วัตถุประสงค์</th>
                        <th class="column6">วันที่ใช้งาน</th>
                        <th class="column7">เวลา</th>
                        <th class="column8">สถานะ</th>
                        <th class="column9">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i=1 ;
                    while ($rs = $meQuery->fetch_assoc()){
                ?>
                        <tr>
                            <td class="column1"><?php echo $i++; ?></td>
                            <td class="column2"><?php echo $rs['member'];?></td>
                            <td class="column3"><?php echo $rs['department'];?></td>
                            <td class="column4"><?php echo $rs['name_rooms'];?></td>
                            <td class="column5"><?php echo $rs['title'];?></td>
                            <td class="column6"><?php $dateData=$rs['start']; echo thai_date(strtotime($dateData)); ?></td>
                            <td class="column7"><?php $startTime=$rs['start']; $endTime=$rs['end']; echo thai_time(strtotime($startTime)).'-'.thai_time(strtotime($endTime)); ?></td>
                            <td class="column8"><?php 
                                if ($rs['status']=='1'){echo '<p class="approve">','อนุมัติ','</p>';} 
                                else if ($rs['status']=='2'){echo '<p class="disapprove">','ไม่อนุมัติ','</p>';} 
                                else if ($rs['status']=='3'){echo '<p class="cancel">','ยกเลิก','</p>';} 
                                else {echo '<p class="wait">','รออนุมัติ','</p>';}?>
                            </td>
                            <td class="column9">
                                <a class="edit" href="index.php?page=report&action=edit&id=<?php echo $rs['id']; ?>&report=<?php echo $_GET['report']; ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                &nbsp;
                                <a class="delete" href="report/action.php?action=delete&id=<?php echo $rs['id']; ?>&report=<?php echo $_GET['report']; ?>" OnClick="return chkdel();">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                <?php } ?>  
                </tbody>
            </table>
            <button type="button" class="btn-danger" id="btn-back-to-top">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>
    </div>
</div>
         
<?php } ?>              
    <!-- End table -->

    <!-- แก้ไข -->
<?php if ($_GET['action']=='edit') { 
    $meSQL = "SELECT * FROM tb_event WHERE id ='{$_GET['id']}' ";
    $meQuery = $conn->query($meSQL);
if ($meQuery == TRUE) {
    $meResult2 = $meQuery->fetch_assoc();
} else {
    echo $conn->error;
}
?> 
<div class="container">
        <div class="wrap-container">
        <form method="post" action="report\action.php?action=edit&report=<?php echo $_GET['report'];?>">
            <div class="table-header">
                    <h3 class = "edit">แก้ไข</h3>
            </div>
                <div class="container-1-box">   
                    <label class="number">หมายเลขห้อง</label>
                    <select name="idrooms" id="room">
                    <?php 
                    $meSQL = "SELECT * FROM tb_rooms ORDER BY id_rooms asc";
                    $meQuery = $conn->query($meSQL);
                    while ($meResult = $meQuery->fetch_assoc()){
                    ?> 
                        <option value="<?php echo $meResult['id_rooms'];?>" <?php if ($meResult['id_rooms'] == $meResult2['rooms']) {echo 'selected';}?>>
                            <?php echo $meResult['name_rooms'];?>
                        </option>
                    <?php } ?>
                    </select>
                </div>   
                <div class="container-1-box">   
                    <label class="name">ชื่อผู้จอง</label>
                    <input type="text" name="membershow" placeholder="" class="long" value="<?php echo $meResult2['member'];?>" disabled />
                    <input type="hidden" name="member" value="<?php echo $meResult2['member'];?>" />
                </div>
                <div class="container-1-box">   
                    <label class="department">สาขา</label>
                    <input type="text" name="departmentshow" placeholder="" class="long" value="<?php echo $meResult2['department'];?>" disabled />
                    <input type="hidden" name="department" value="<?php echo $meResult2['department'];?>" />
                </div> 
                <div class="container-1-box">   
                    <label class="topic">วัตถุประสงค์</label>
                    <!-- <input name="title" class="long" value="<?php echo $meResult2['title'];?>" required> -->
                    <select name="title" id="title" required>
                        <option value="อ่าน/ติวหนังสือ" <?php if ($meResult2['title'] == 'อ่าน/ติวหนังสือ') {echo 'selected';}?>>อ่าน/ติวหนังสือ</option>
                        <option value="ประชุมงาน/Presentงาน/ทำงานกลุ่ม" <?php if ($meResult2['title'] == 'ประชุมงาน/Presentงาน/ทำงานกลุ่ม') {echo 'selected';}?>>ประชุมงาน/Presentงาน/ทำงานกลุ่ม</option>
                        <option value="ถ่ายVDO" <?php if ($meResult2['title'] == 'ถ่ายVDO') {echo 'selected';}?>>ถ่ายVDO</option>
                        <option value="สอนออนไลน์" <?php if ($meResult2['title'] == 'สอนออนไลน์') {echo 'selected';}?>>สอนออนไลน์</option>
                        <option value="อื่นๆ" <?php if ($meResult2['title'] == 'อื่นๆ') {echo 'selected';}?>>อื่นๆ</option>
                    </select>
                </div> 
                <div class="container-1-box"> 
                    <label class="amount">จำนวนผู้เข้าใช้</label>
                    <select name="people" id="room" required>
                        <option value="1" <?php if ($meResult2['people'] == '1') {echo 'selected';}?>>1</option>
                        <option value="2" <?php if ($meResult2['people'] == '2') {echo 'selected';}?>>2</option>
                        <option value="3" <?php if ($meResult2['people'] == '3') {echo 'selected';}?>>3</option>
                        <option value="4" <?php if ($meResult2['people'] == '4') {echo 'selected';}?>>4</option>
                        <option value="5" <?php if ($meResult2['people'] == '5') {echo 'selected';}?>>5</option>
                        <option value="6" <?php if ($meResult2['people'] == '6') {echo 'selected';}?>>6</option>
                        <option value="7" <?php if ($meResult2['people'] == '7') {echo 'selected';}?>>7</option>
                        <option value="8" <?php if ($meResult2['people'] == '8') {echo 'selected';}?>>8</option>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="date">วันที่ใช้งาน</label>
                    <input name="date" class="date" type="date" value="<?php $start = date('Y-m-d',strtotime($meResult2['start']));echo $start;?>" required>
                </div>
                <div class="container-1-box"> 
                    <label class="starttime">เวลาใช้งาน</label>
                    <!-- <input name="starttime" type="time" class="starttime" value="<?php $starttime = date('H:i',strtotime($meResult2['start']));echo $starttime;?>" required> -->
                    <select class="starttime" id="starttime" name='starttime'required> 
                        <option value="08:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '08:00:00') {echo 'selected';}?>>8:00 น.</option>
                        <option value="08:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '08:30') {echo 'selected';}?>>8:30 น.</option>
                        <option value="09:01"<?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '09:00') {echo 'selected';}?>>9:00 น.</option>
                        <option value="09:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '09:30') {echo 'selected';}?>>9:30 น.</option>
                        <option value="10:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '10:00') {echo 'selected';}?>>10:00 น.</option>
                        <option value="10:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '10:30') {echo 'selected';}?>>10:30 น.</option>
                        <option value="11:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '11:00') {echo 'selected';}?>>11:00 น.</option>
                        <option value="11:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '11:30') {echo 'selected';}?>>11:30 น.</option>
                        <option value="12:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '12:00') {echo 'selected';}?>>12:00 น.</option>
                        <option value="12:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '12:30') {echo 'selected';}?>>12:30 น.</option>
                        <option value="13:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '13:00') {echo 'selected';}?>>13:00 น.</option>
                        <option value="13:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '13:30') {echo 'selected';}?>>13:30 น.</option>
                        <option value="14:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '14:00') {echo 'selected';}?>>14:00 น.</option>
                        <option value="14:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '14:30') {echo 'selected';}?>>14:30 น.</option>
                        <option value="15:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '15:00') {echo 'selected';}?>>15:00 น.</option>
                        <option value="15:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '15:30') {echo 'selected';}?>>15:30 น.</option>
                        <option value="16:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '16:00') {echo 'selected';}?>>16:00 น.</option>
                        <option value="16:31" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '16:30') {echo 'selected';}?>>16:30 น.</option>
                        <option value="17:01" <?php if ($starttime = date('H:i',strtotime($meResult2['start'])) == '17:00') {echo 'selected';}?>>17:00 น.</option>
                        <!-- <option value="17:30">17:30</option>
                        <option value="18:00">18:00</option>  -->
                    </select>
                </div>
                <div class="container-1-box"> 
                    <label class="hour">จำนวนชั่วโมง</label>
                    <select name="hour" id="hour" required>
                    <?php if ($_SESSION['level_name'] =='ปริญญาตรี' || $_SESSION['level_name'] =='ปริญญาตรี - iMTM')  { ?>
                        <option value="1" <?php if ($meResult2['hour'] == '1') {echo 'selected';}?>>1</option>
                        <option value="2" <?php if ($meResult2['hour'] == '2') {echo 'selected';}?>>2</option>
                    <?php } else if ($_SESSION['status'] =='admin' || $_SESSION['type'] == 'STAFF' || $_SESSION['level_name'] =='ปริญญาโท'){?>
                        <option value="1" <?php if ($meResult2['hour'] == '1') {echo 'selected';}?>>1</option>
                        <option value="2" <?php if ($meResult2['hour'] == '2') {echo 'selected';}?>>2</option>
                        <option value="3" <?php if ($meResult2['hour'] == '3') {echo 'selected';}?>>3</option>
                        <option value="4" <?php if ($meResult2['hour'] == '4') {echo 'selected';}?>>4</option>
                    <?php } ?> 
                    </select>
                </div>
                <div class="container-1-box">   
                    <label class="other">อื่นๆ</label>
                    <textarea name="other"><?php echo $meResult2['other'];?></textarea>
                </div>
                <div class="container-1-box">
                    <label class="state" for="status" required> สถานะ </label>
                    <select name="status" id="status" >
                        <option value="0" <?php if ($meResult2['status'] == '0') {echo 'selected';}?>>รออนุมัติ</option>
                        <option value="1" <?php if ($meResult2['status'] == '1') {echo 'selected';}?>>อนุมัติ</option>
                        <option value="2" <?php if ($meResult2['status'] == '2') {echo 'selected';}?>>ไม่อนุมัติ</option>
                        <option value="3" <?php if ($meResult2['status'] == '3') {echo 'selected';}?>>ยกเลิก</option>
                    </select>
                </div>
                <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
                <div class="container-2-box">
                    <button class="btn-save" type="submit">บันทึก</button>
                    <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
                </div>
            </form>
        </div>
</div>
<?php } ?> 

    <!-- Script for Raspon -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="JS/script.js"></script>
    <script src="JS/back2top.js"></script>
    <script src="JS/excelexportjs.js"></script>
    <script language="JavaScript">
        function chkdel(){if(confirm('ต้องการลบรายการนี้หรือไม่')){
            return true;
        }else{
            return false;
        }
        }
    </script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#datatables').DataTable({
                "pagingType" : "full_numbers",
                "lengthMenu":[
                    [10,30,50,80,-1],
                    [10,30,50,80,"All"]
                ],
                responsive:true,
                language:{
                    search: "_INPUT_",
                    searchPlaceholder:"Search Records"
                }
            });
        })
    </script>
    <script type="text/javascript">
            var $btnDLtoExcel = $('#DLtoExcel');
            $btnDLtoExcel.on('click', function () {
              $("#datatables").excelexportjs({
                  containerid: "datatables"
                  ,datatype: 'table'
              });
            });
    </script>
</body>
</html>
					
<?php		
$conn->close();
?>
                              