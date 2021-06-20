<?php 
$title = 'ห้องประชุม'; //กำหนดไตเติ้ล
session_start();
if ($_SESSION['id'] != '') {
    include 'connect.php';
    $sql = "SELECT * FROM tb_member WHERE id_member = '{$_SESSION['id']}' ";
    $rs = $conn->query( $sql )->fetch_assoc() ;
  }
if ($_SESSION['status'] =='admin' || $_SESSION['status'] =='user' || $_SESSION['type'] == 'STUDENT')  
{
    include 'connect.php';
}
include 'connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/room.css">
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
      <!--  Datatables  -->
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  

<!--  extension responsive  -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

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
<!-- หน้าแรก -->
<?php if ($_GET['action']=='') {
 $meSQL = "SELECT * FROM tb_rooms ORDER BY id_rooms asc";
 $meQuery = $conn->query($meSQL);
 ?> 

<div class="container-table100">
        <div class="wrap-table100">
            <div class="table100">
            <?php   if ($_SESSION['status'] =='admin')  { ?>
                <div class="btnAdd">
                    <button class = "addButton"><a class="addroom" href="index.php?page=setrooms&action=add" role="button"><span>เพิ่มห้องประชุม </span></a></button>
                </div>
            <?php } ?>
                <div class="table-header">
                    <h3>ห้องประชุม</h3>
                </div>          
                <table id = "datatables" class="table table-bordered  display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="table100-head">
                            <td class="column1">ลำดับ</td>
                            <td class="column2">ห้องประชุม</td>
                            <td class="column3">หมายเลขห้อง</td>
                            <td class="column4">จำนวนคน</td>
                            <td class="column5">รายละเอียด</td>
                        <?php   if ($_SESSION['status'] =='admin')  { ?>
                            <td class="column6">จัดการ</td>
                        <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
<?php
    $i=1 ;
    while ($rs = $meQuery->fetch_assoc()){
?>
                            <tr>
                                <td class="column1"><?php echo $i++; ?></td>
                                <td class="column2">
                                    <p>
                                        <a href="images/<?php echo $rs['image_rooms']?>" data-rel="colorbox">
                                        <img src="images/<?php echo $rs['image_rooms']?>" alt="รูปภาพ" class="image_show">
                                    </p>
                                </td>
                                <td class="column3"><?php echo $rs['name_rooms']?></td>
                                <td class="column4"><?php echo $rs['people_rooms']?></td>
                                <td class="column5"><?php echo $rs['detail_rooms']?></td>
                            <?php   if ($_SESSION['status'] =='admin')  { ?>
                                <td class="column6">
                                    <a class="edit" href="index.php?page=setrooms&action=edit&id=<?php echo $rs['id_rooms']; ?>">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    &nbsp;
                                    <a  class="delete" href="rooms/action.php?action=delete&id=<?php echo $rs['id_rooms']; ?>&image=<?php echo $rs['image_rooms']; ?>" OnClick="return chkdel();">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </td>
                            <?php } ?>
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


<!-- เพิ่ม -->
<?php if ($_GET['action']=='add') {?> 
<div class="container">
    <div class="wrap-container">
        <form class="form-horizontal" role="form" name="formregister" method="post" action="rooms\action.php?action=add" enctype="multipart/form-data">
            <h2 class="add">เพิ่มห้องประชุม</h2>
        <div class="container-1-box">   
            <label class="Upload" for="Upload">รูปภาพ</label>
            <input class="Upload" type="file" name="Upload" id="Upload" OnChange="showPreview(this)" accept="image/*" value="" >
            <img class="Upload" id="imgAvatar" src="images/noimages.png" ><p></p>
        </div>
        <div class="container-1-box">   
            <label class="Room Name" for="Name">ชื่อห้อง</label>
            <input type="text" name="Name" id="Name" placeholder="" class="long" value="" required />
        </div>
        <div class="container-1-box">   
            <label class="People" for="People">จำนวนคน</label>
            <input type="number" name="People" id="People" placeholder="" class="long" value="" required />
        </div>
        <div class="container-1-box">   
            <label class="Detail">รายละเอียด</label>
            <textarea id="Detail" name="Detail" required></textarea>
        </div>
        <div class="container-2-box">
            <button class="btn-save" type="submit">บันทึก</button>
            <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
        </div>
        </form>
    </div>
</div>
<?php }?>


<!-- แก้ไข -->
<?php if ($_GET['action']=='edit') { 
		$meSQL = "SELECT * FROM tb_rooms WHERE id_rooms ='{$_GET['id']}' ";
		$meQuery = $conn->query($meSQL);
    if ($meQuery == TRUE) {
        $meResult = $meQuery->fetch_assoc();
    } else {
        echo $conn->error;
    }
?> 
<div class="container">
    <div class="wrap-container">           
        <form class="form-horizontal" role="form" name="formregister" method="post" action="rooms\action.php?action=edit" enctype="multipart/form-data">
                <!-- <div class="page-header"><h1>แก้ไขห้องประชุม</h1></div> -->
                <h2 class="editroom">แก้ไขห้องประชุม</h2>
            <div class="container-1-box">   
                <label class="Upload" for="Upload">รูปภาพ</label>
                <input class="Upload" type="file" name="Upload" id="Upload" OnChange="showPreview(this)" accept="image/*" value="<?php echo $meResult['image_rooms'];?>">
                <img class="Upload" id="imgAvatar" src="images/<?php echo $meResult['image_rooms'];?>"><p></p>
            </div>
            <div class="container-1-box">   
                <label class="Room Name" for="Name">ชื่อห้อง</label>
                <input type="text" name="Name" id="Name" placeholder="" class="long" value="<?php echo $meResult['name_rooms'];?>" required />
            </div>
            <div class="container-1-box">   
                <label class="People" for="People">จำนวนคน</label>
                <input type="number" name="People" id="People" placeholder="" class="long" value="<?php echo $meResult['people_rooms'];?>" required />
            </div>
            <div class="container-1-box">   
                <label class="Detail">รายละเอียด</label>
                <textarea id="Detail" name="Detail" required><?php echo $meResult['detail_rooms'];?></textarea>
            </div>
            <div class="container-2-box">
                <button class="btn-save" type="submit">บันทึก</button>
                <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
            </div>
            <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
            <input type="hidden" name="hdnOldFile" value="<?php echo $meResult['image_rooms'];?>">
        </form>
    </div>
</div>
<?php }?>

    <!-- Script for Raspon -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="JS/script.js"></script>
    <script src="JS/back2top.js"></script>
     <!--   Datatables-->
     <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>  
      
      <!-- extension responsive -->
      <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  
  
    <script>
        $(document).ready(function(){
            $('#datatables').DataTable({
                "pagingType" : "full_numbers",
                "lengthMenu":[
                    [5,10,15,20,-1],
                    [5,10,15,20,"All"]
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
        function showPreview(ele)
        {
                $('#imgAvatar').attr('src', ele.value); // for IE
                if (ele.files && ele.files[0]) {
                
                    var reader = new FileReader();
                    
                    reader.onload = function (e) {
                        $('#imgAvatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(ele.files[0]);
                }
        }
    </script>  
    <script language="JavaScript">
        function chkdel(){if(confirm('ต้องการลบหรือไม่')){
            return true;
        }else{
            return false;
        }
        }
    </script> 
</body>
</html>

<?php		
$conn->close();
?>