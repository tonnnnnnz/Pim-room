<?php 
session_start();
$title = 'ระบบสมาชิก'; 
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
    <link rel="stylesheet" href="css/member.css">
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
    <script src='fullcalendar-5.5.1/lib/main.js'></script>
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
<?php if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'user' || $_SESSION['type'] == 'STUDENT') {?> 
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
<?php if ($_GET['action']=='') {
    $meSQL = "SELECT * FROM tb_member ORDER BY id_member asc";
    $meQuery = $conn->query($meSQL);
    
?> 

    <div class="container-table100">
            <div class="wrap-table100">
                <div class="table100">
                    <div class="btnAdd">
                        <button class = "addButton"><a class="addmember" href="index.php?page=member&action=add" role="button"><span>เพิ่มสมาชิก</a></span></button>
                    </div>
                    <div class="table-header">
                        <h3>ระบบสมาชิก</h3>
                    </div>
                    <table id = "datatables">
                        <thead>
                            <tr class="table100-head">
                                <th class="column1">ลำดับ</th>
                                <th class="column2">ชื่อผู้ใช้</th>
                                <th class="column3">ชื่อ - นามสกุล</th>
                                <th class="column4">ตำแหน่ง</th>
                                <th class="column5">เบอร์โทรศัพท์</th>
                                <th class="column6">ระดับสิทธิ์</th>
                                <th class="column7">สถานะ</th>
                                <th class="column8">เข้าระบบล่าสุด</th>
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
                                <td class="column2"><?php echo $rs['username']?></td>
                                <td class="column3"><?php 
                                    $title = $rs['ntitle']; 
                                    $firstname = $rs['firstname']; 
                                    $surname = $rs['surname'];
                                    echo $title .$firstname .'&nbsp;&nbsp;' .$surname;?>
                                </td>
                                <td class="column4"><?php echo $rs['position']?></td>
                                <td class="column5"><?php echo $rs['phone']?></td>
                                <td class="column6"><?php echo $rs['status']?></td>
                                <td class="column7"><?php 
                                    $rs['active'];
                                    if ($rs['active'] == 1){echo '<i class="fas fa-check"></i>';} 
                                    else {echo '<i class="fas fa-minus-circle"></i>';}?>
                                </td>
                                <td class="column8"><?php $dateLog=$rs['login_date']; echo thai_date_and_time(strtotime($dateLog)); ?></td>
                                <td class="column9">
                                    <a href="index.php?page=member&action=edit&id=<?php echo $rs['id_member']; ?>" class="edit">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    &nbsp;
                                    <a href="member/action.php?action=delete&id=<?php echo $rs['id_member']; ?>" class="delete" OnClick="return chkdel();">
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

<!-- เพิ่ม -->
<?php if ($_GET['action']=='add') {?> 
<!-- Start Section -->
<div class="container">
        <div class="wrap-container">
            <form class="form-horizontal" role="form" name="formregister" method="post" action="member\action.php?action=add">
                <h2 class="add">เพิ่มสมาชิก</h2>
                <div class="container-1-box">   
                    <label class="username">ชื่อผู้ใช้</label>
                    <input name="username" class="long" type="text" placeholder="Username" value="" required>
                </div>
                <div class="container-1-box">   
                    <label class="password">รหัสผ่าน</label>
                    <input name="password" class="long" type="password" placeholder="Password" value="" required>
                </div>
                <div class="container-1-box">   
                    <label class="conpass">ยืนยันรหัสผ่าน</label>
                    <input name="conpassword" class="long" type="password" placeholder="Password" value="" required>
                </div>
                <div class="container-1-box">   
                    <label class="title">คำนำหน้า</label>
                    <select name="title" id="title" required>
                        <option value="นาย">นาย</option>
                        <option value="นางสาว">นางสาว</option>
                        <option value="นาง">นาง</option>
                </select>
                </div>
                <div class="container-1-box">   
                    <label class="firstname">ชื่อ</label>
                    <input type="text"  name="firstname" placeholder="Firstname" class="long" value="" required />
                </div>
                <div class="container-1-box">   
                    <label class="surname">นามสกุล</label>
                    <input type="text" name="surname" placeholder="Surtname" class="long" value="" required />
                </div>
                <div class="container-1-box">   
                    <label class="position">ตำแหน่ง</label>
                    <input type="text" name="position" placeholder="Position" class="long" value="" required />
                </div>
                <div class="container-1-box">   
                    <label class="phone">เบอร์โทรศัพท์</label>
                    <input type="text" name="phone" placeholder="Phone" class="long" value="" required />
                </div>
                <div class="container-1-box">   
                    <label class="email">อีเมลล์</label>
                    <input type="text" name="email" placeholder="Email" class="long" value="" required />
                </div>
                <div class="container-1-box">   
                    <label class="status">ระดับสิทธิ์</label>
                    <select name="status" id="status" required>
                        <option value="admin" selected>admin</option>
                </select>
                </div>
            <div class="container-1-box">   
                <label class="active">สถานะ</label>
                <select name="active" id="active" >
                        <option value="1">ใช้งานได้</option>
                        <option value="0">รอการยืนยัน</option>
                </select>
            </div>
            <div class="container-2-box">
                <button class="btn-save" type="submit">บันทึก</button>
                <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
            </div>
            </form>
        </div>
    </div>
<!-- End Section -->
<?php }?>

<!-- แก้ไข -->
<?php if ($_GET['action']=='edit') { 
		$meSQL = "SELECT * FROM tb_member WHERE id_member='{$_GET['id']}' ";
		$meQuery = $conn->query($meSQL);
    if ($meQuery == TRUE) {
        $meResult = $meQuery->fetch_assoc();
    } else {
        echo $conn->error;
    }
    ?>  
<!-- Start Section -->
<div class="container">
        <div class="wrap-container">
            <form class="form-horizontal" role="form" name="formregister" method="post" action="member\action.php?action=edit">
                <h2 class="add">แก้ไขสมาชิก</h2>
                <div class="container-1-box">   
                    <label class="username">ชื่อผู้ใช้</label>
                    <input name="username" class="long" type="text" placeholder="Username" value="<?php echo $meResult['username'];?>" required>
                </div>
                <div class="container-1-box">   
                    <label class="password">รหัสผ่าน</label>
                    <input name="password" class="long" type="password" placeholder="Password" value="<?php echo $meResult['password'];?>" required>
                </div>
                <div class="container-1-box">   
                    <label class="conpass">ยืนยันรหัสผ่าน</label>
                    <input name="conpassword" class="long" type="password" placeholder="Password" value="<?php echo $meResult['password'];?>" required>
                </div>
                <div class="container-1-box">   
                    <label class="title">คำนำหน้า</label>
                    <select name="title" id="title" required>
                        <option value="นาย" <?php if ($meResult['ntitle'] == 'นาย') {echo 'selected';}?>>นาย</option>
                        <option value="นางสาว" <?php if ($meResult['ntitle'] == 'นางสาว') {echo 'selected';}?>>นางสาว</option>
                        <option value="นาง" <?php if ($meResult['ntitle'] == 'นาง') {echo 'selected';}?>>นาง</option>
                </select>
                </div>
                <div class="container-1-box">   
                    <label class="firstname">ชื่อ</label>
                    <input type="text"  name="firstname" placeholder="Firstname" class="long" value="<?php echo $meResult['firstname'];?>" required />
                </div>
                <div class="container-1-box">   
                    <label class="surname">นามสกุล</label>
                    <input type="text" name="surname" placeholder="Surtname" class="long" value="<?php echo $meResult['surname'];?>" required />
                </div>
                <div class="container-1-box">   
                    <label class="position">ตำแหน่ง</label>
                    <input type="text" name="position" placeholder="Position" class="long" value="<?php echo $meResult['position'];?>" required />
                </div>
                <div class="container-1-box">   
                    <label class="phone">เบอร์โทรศัพท์</label>
                    <input type="text" name="phone" placeholder="Phone" class="long" value="<?php echo $meResult['phone'];?>" required />
                </div>
                <div class="container-1-box">   
                    <label class="email">อีเมลล์</label>
                    <input type="text" name="email" placeholder="Email" class="long" value="<?php echo $meResult['email'];?>" required />
                </div>
                <div class="container-1-box">   
                    <label class="status">ระดับสิทธิ์</label>
                    <select name="status" id="status" required>
                        <option value="admin" selected>admin</option>
                </select>
                </div>
            <div class="container-1-box">   
                <label class="active">สถานะ</label>
                <select name="active" id="active" >
                        <option value="1" <?php if ($meResult['active'] == '1') {echo 'selected';}?>>ใช้งานได้</option>
                        <option value="0" <?php if ($meResult['active'] == '0') {echo 'selected';}?>>รอการยืนยัน</option>
                </select>
            </div>
            <div class="container-2-box">
                <button class="btn-save" type="submit">บันทึก</button>
                <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
            </form>
        </div>
    </div>
<!-- End Section -->
<?php } ?>    

    <!-- Script for Raspon -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="JS/script.js"></script>
    <script src="JS/back2top.js"></script>
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
                    [5,10,30,50,-1],
                    [5,10,30,50,"All"]
                ],
                responsive:true,
                language:{
                    search: "_INPUT_",
                    searchPlaceholder:"Search Records"
                }
            });
        })
    </script>
</body>
</html>

<?php		
$conn->close();
?>