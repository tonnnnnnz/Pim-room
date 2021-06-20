<?php 
error_reporting(0);
$title = 'จองห้องประชุม'; //กำหนดไตเติ้ล
session_start();
if ($_SESSION['id'] != '') {
    include 'connect.php';
    $sql = "SELECT * FROM tb_member WHERE id_member = '{$_SESSION['id']}'";
    $rs = $conn->query( $sql )->fetch_assoc() ;
  }
if ($_SESSION['status'] =='admin' || $_SESSION['status'] =='user' || $_SESSION['type'] == 'STUDENT' || $_SESSION['type'] == 'STAFF')  
{
    include 'connect.php';
    include 'function.php';
} else {
    echo "<script>alert('กรุณาลงชื่อเข้าใช้ระบบ'); window.location ='index.php?page=login';</script>";
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
    <link rel="stylesheet" href="css/booking.css">
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
     -->
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
<?php if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'user' || $_SESSION['type'] == 'STUDENT'|| $_SESSION['type'] == 'STAFF') {?> 
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
  
<h3>จองห้องประชุม</h3>
    <div class="container">
        <div class="wrap-container">
            <form method="post" action="booking\action.php?action=add" name="formid">
                <div class="container-1-box">   
                    <label class="number">หมายเลขห้อง</label>
                    <select name="idrooms" id="room">
                    <?php 
                        $meSQL = "SELECT * FROM tb_rooms ORDER BY id_rooms asc";
                        $meQuery = $conn->query($meSQL);
                        while ($meResult = $meQuery->fetch_assoc()){
                    ?> 
                        <option value="<?php echo $meResult['id_rooms'];?>" ><?php echo $meResult['name_rooms'];?></option>
                    <?php } ?>
                    </select>
                </div>   
                <div class="container-1-box">   
                    <label class="name">ชื่อผู้จอง</label>
                <?php if ($_SESSION['status'] =='admin')  { ?>
                    <input type="text" name="membershow" placeholder="" class="long" value="<?php echo $rs['firstname'].'  '.$rs['surname'];?>" disabled />
                    <input type="hidden" name="member" value="<?php echo $rs['firstname'].'  '.$rs['surname'];?>" />
                <?php } else {?>
                    <input type="text" name="membershow" placeholder="" class="long" value="<?php echo ($_SESSION['firstname_th'].' '.$_SESSION['lastname_th']);?>" disabled />
                    <input type="hidden" name="member" value="<?php echo ($_SESSION['firstname_th'].' '.$_SESSION['lastname_th']);?>" />
                <?php } ?> 
                </div>
                <div class="container-1-box">   
                    <label class="department">สาขา</label>
                    <input type="text" name="departmentshow" placeholder="" class="long" value="<?php echo ($_SESSION['dep']);?>" disabled />
                    <input type="hidden" name="department" value="<?php echo ($_SESSION['dep']);?>" />
                </div> 
                <div class="container-1-box">   
                    <label class="topic">วัตถุประสงค์</label>
                    <select name="title" id="title" required>
                        <option value="อ่าน/ติวหนังสือ" selected="selected">อ่าน/ติวหนังสือ</option>
                        <option value="ประชุมงาน/Presentงาน/ทำงานกลุ่ม">ประชุมงาน/Presentงาน/ทำงานกลุ่ม</option>
                        <option value="ถ่ายVDO">ถ่ายVDO</option>
                        <option value="สอนออนไลน์">สอนออนไลน์</option>
                        <option value="อื่นๆ">อื่นๆ</option>
                    </select>
                </div> 
                <div class="container-1-box"> 
                    <label class="amount">จำนวนผู้เข้าใช้</label>
                    <select name="people" id="people" required>
                        <option value="1" data-filter='{"room": ""}'>1</option>
                        <option value="2" data-filter='{"room": ""}'>2</option>
                        <option value="3" data-filter='{"room": ""}'>3</option>
                        <option value="4" data-filter='{"room": ""}'>4</option>
                        <option value="5" data-filter='{"room": ""}'>5</option>
                        <option value="6" data-filter='{"room": ""}' selected="selected">6</option>
                        <option value="7" data-filter='{"room": "1"}'>7</option>
                        <option value="8" data-filter='{"room": "1"}'>8</option>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="date">วันที่ใช้งาน</label>
                    <input name="date" class="date" type="date"  min="<?php echo date('Y-m-d');?>" required>
                </div>
                <div class="container-1-box"> 
                    <label class="starttime">เวลาใช้งาน</label>
                    <!-- <input name="starttime" type="time" class="starttime" required> -->
                    <select class="starttime" id="starttime" name='starttime'required> 
                        <option value="08:01">08:00 น.</option>
                        <option value="08:31">08:30 น.</option>
                        <option value="09:01">09:00 น.</option>
                        <option value="09:31">09:30 น.</option>
                        <option value="10:01">10:00 น.</option>
                        <option value="10:31">10:30 น.</option>
                        <option value="11:01">11:00 น.</option>
                        <option value="11:31">11:30 น.</option>
                        <option value="12:01">12:00 น.</option>
                        <option value="12:31">12:30 น.</option>
                        <option value="13:01">13:00 น.</option>
                        <option value="13:31">13:30 น.</option>
                        <option value="14:01">14:00 น.</option>
                        <option value="14:31">14:30 น.</option>
                        <option value="15:01">15:00 น.</option>
                        <option value="15:31">15:30 น.</option>
                        <option value="16:01">16:00 น.</option>
                        <option value="16:31">16:30 น.</option>
                        <option value="17:01">17:00 น.</option>
                    </select>
                </div>
                <div class="container-1-box"> 
                    <label class="hour">จำนวนชั่วโมง</label>
                    <select name="hour" id="hour" required>
                    <?php if ($_SESSION['level_name'] =='ปริญญาตรี' || $_SESSION['level_name'] =='ปริญญาตรี - iMTM')  { ?>
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                    <?php } else if ($_SESSION['status'] =='admin' || $_SESSION['type'] == 'STAFF' || $_SESSION['level_name'] =='ปริญญาโท'){?>
                        <option value="1" selected="selected">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    <?php } ?> 
                    </select>
                </div>
                <div class="container-1-box">   
                    <label class="other">อื่นๆ</label>
                    <textarea name="other"></textarea>
                </div>
             <?php if ($_SESSION['status'] =='admin')  { ?>
                    <input type="hidden" name="memberid" value="<?php echo $rs['id_member'];?>" />
                    <input type="hidden" name="department" value="<?php echo "เจ้าหน้าที่ห้องสมุด";?>" />
            <?php } else {?>
                    <input type="hidden" name="memberid" value="<?php echo $_SESSION['card_no'];?>" />
                    <input type="hidden" name="department" value="<?php echo $_SESSION['dep']?>" />
             <?php } ?> 
                <div class="container-2-box">
                    <button class="btn-save" type="submit" onclick="document.getElementById('id01').style.display='block'">บันทึก</button>
                    <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
                </div>   
            </form>
        </div>

        <!-- <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
            <div class="w3-container">
                <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
                <p>Some text. Some text. Some text.</p>
                <p>Some text. Some text. Some text.</p>
            </div>
            </div>
        </div> -->
    </div> 

    <!-- Script for Raspon -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="JS/script.js"></script>
    <script>
        localStorage.setItem('room', 'select');
            $('#room').on('change', function() {
                var val = $(this).val();
                localStorage.setItem('room', val);
                $('select#people>option').each(function () {
                    var filter = $(this).data();
                    var elem = $(this);
                    if((filter.filter.room != val) && filter.filter.room !="")  {
                    elem.hide();
                    $('#people').val("4");
                    } else if(filter.filter.room !="") {
                    elem.show();
                    $('#people').val("6");
                    } else {
                    elem.show();
                    }
                });
            });
    </script>
</body>
</html>

<?php		
$conn->close();
?>
                              