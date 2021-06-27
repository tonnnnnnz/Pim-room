<?php
session_start();
if ($_SESSION['status']!='admin' and $_SESSION['status']!='user' and $_SESSION['type'] != 'STUDENT' and $_SESSION['type'] != 'STAFF') {
	echo "<script>alert('session ผิดผลาด'); window.location ='../index.php';</script>";
	exit();
} else {
include '../connect.php'; 
include '../function.php';
}

//ใช้สำหรับ Form Email
$meSQL = "SELECT * FROM tb_rooms WHERE id_rooms = '{$_POST['idrooms']}'";
$meResult = $conn->query($meSQL)->fetch_assoc();
$room = $meResult['name_rooms'];
$email = $_POST['email'];
$date = thai_date(strtotime($_POST['date']));

//เพิ่มข้อมูล
if ($_GET['action']=='add'){
// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	$strYear = date('Y',strtotime($_POST['date']));
	$strMonth= date('m',strtotime($_POST['date']));
	$strDay= date('d',strtotime($_POST['date']));
	$startdate = $strYear.'-'.$strMonth.'-'.$strDay.'T'.$_POST['starttime'];
	$startt = $_POST['starttime'];

	$endstrYear = date('Y',strtotime($_POST['date']));
	$endstrMonth= date('m',strtotime($_POST['date']));
	$endstrDay= date('d',strtotime($_POST['date']));
		if ($_POST['hour'] == '1') {
			$endt = date('H:i', strtotime('+59 minutes', strtotime($_POST['starttime'])));
		} else if ($_POST['hour'] == '2') {
			$endt = date('H:i', strtotime('+119 minutes', strtotime($_POST['starttime'])));
		} else if ($_POST['hour'] == '3') {
			$endt = date('H:i', strtotime('+179 minutes', strtotime($_POST['starttime'])));
		} else {
			$endt = date('H:i', strtotime('+239 minutes', strtotime($_POST['starttime'])));
		}
	$enddate = $endstrYear.'-'.$endstrMonth.'-'.$endstrDay.'T'.$endt;

	$color = '#1e90ff';

//เช็คห้อง
$sql ="SELECT * FROM tb_event  WHERE rooms = '{$_POST['idrooms']}' 
		AND (status = '" . "0" . "' or status = '" . "1" . "')
		AND (
			(start BETWEEN '" . $startdate . "' AND '" . $enddate . "')
			OR 
			(end BETWEEN '" . $startdate . "' AND '" . $enddate . "')
			OR 
			('" . $startdate . "' BETWEEN start  AND end)
			OR 
			('" . $enddate . "' BETWEEN  start  AND end )
		)";

	$meResult = $conn->query( $sql )->fetch_assoc() ; 
	if($row = $meResult){
		echo "<script>alert('ห้องประชุมมีผู้ใช้งานในช่วงเวลา ". $_POST['starttime'] ." - ". $endt ." น. กรุณาตรวจสอบอีกครั้ง!'); history.back(-1);</script>";
	} else {
		$sql = "SELECT * FROM tb_rooms WHERE id_rooms = '{$_POST['idrooms']}' ";
		$meResult = $conn->query( $sql )->fetch_assoc() ;  

		$meSQL = "INSERT INTO tb_event (id_member,status,rooms,title,people,start,end,color,hour,member,department,other) VALUES ('".$_POST['memberid']."','0','".$_POST['idrooms']."','".$_POST['title']."','".$_POST['people']."','".$startdate."','".$enddate."','".$color."','".$_POST['hour']."','".$_POST['member']."','".$_POST['department']."','".$_POST['other']."')";
		$meQuery = $conn->query($meSQL);		
		if ($meQuery == TRUE) {
			$sub = "ยืนยันข้อมูลการจองห้องประชุม";
			// include 'send_email.php';
			echo "<script>alert('ยืนยันการจองห้องประชุม ".$room."\\nวันที่ ".$date." เวลา ".$startt." - ".$endt." น. สำเร็จ\\nกรุณาติดต่อเคาน์เตอร์บริการก่อนเข้าใช้งาน'); 
			window.location ='../index.php?page=mybooking';</script>";
		} else {
			echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่'); history.back(-1);</script>"; 
			exit();
		}
	}
}	


//แก้ไขข้อมูล
if ($_GET['action']=='edit'){ 
	$strYear = date('Y',strtotime($_POST['date']));
	$strMonth= date('m',strtotime($_POST['date']));
	$strDay= date('d',strtotime($_POST['date']));
	$startdate = $strYear.'-'.$strMonth.'-'.$strDay.'T'.$_POST['starttime'];
	$startt = $_POST['starttime'];

	$endstrYear = date('Y',strtotime($_POST['date']));
	$endstrMonth= date('m',strtotime($_POST['date']));
	$endstrDay= date('d',strtotime($_POST['date']));
		if ($_POST['hour'] == '1') {
			$endt = date('H:i', strtotime('+59 minutes', strtotime($_POST['starttime'])));
		} else if ($_POST['hour'] == '2') {
			$endt = date('H:i', strtotime('+119 minutes', strtotime($_POST['starttime'])));
		} else if ($_POST['hour'] == '3') {
			$endt = date('H:i', strtotime('+179 minutes', strtotime($_POST['starttime'])));
		} else {
			$endt = date('H:i', strtotime('+239 minutes', strtotime($_POST['starttime'])));
		}
	$enddate = $endstrYear.'-'.$endstrMonth.'-'.$endstrDay.'T'.$endt;

	$sql ="SELECT * FROM tb_event  WHERE rooms = '{$_POST['idrooms']}'
			AND id != '{$_POST['id']}'
			AND (status = '" . "0" . "' or status = '" . "1" . "')
			AND (
				(start BETWEEN '" . $startdate . "' AND '" . $enddate . "')
				OR 
				(end BETWEEN '" . $startdate . "' AND '" . $enddate . "')
				OR 
				('" . $startdate . "' BETWEEN start  AND end)
				OR 
				('" . $enddate . "' BETWEEN  start  AND end )
			)";

	$meResult = $conn->query( $sql )->fetch_assoc() ; 
	if($row = $meResult){
		echo "<script>alert('ห้องประชุมมีผู้ใช้งานในช่วงเวลา ". $_POST['starttime'] ." - ". $endt ." น. กรุณาตรวจสอบอีกครั้ง!'); history.back(-1);</script>";
	} else {
		$sql = "SELECT * FROM tb_rooms WHERE id_rooms = '{$_POST['idrooms']}' ";
		$meResult = $conn->query( $sql )->fetch_assoc() ;  

		$meSQL = "UPDATE tb_event ";
		$meSQL .="SET rooms='{$_POST['idrooms']}',"
		. "title='{$_POST['title']}',"
		. "start='{$startdate}',"
		. "end='{$enddate}',"
		. "color='{$color}',"
		. "hour='{$_POST['hour']}',"
		. "people='{$_POST['people']}',"
		. "other='{$_POST['other']}'";
		$meSQL .= "WHERE id ='{$_POST['id']}' ";
		$meQuery = $conn->query($meSQL);			
			if ($meQuery == TRUE) {
				$sub = "แก้ไขข้อมูลการจองห้องประชุม";
				// include 'send_email.php';
				echo "<script>alert('แก้ไขการจองห้องประชุม ".$room."\\nวันที่ ".$date." เวลา ".$startt." - ".$endt." น. สำเร็จ\\nกรุณาติดต่อเคาน์เตอร์บริการก่อนเข้าใช้งาน');  window.location ='../index.php?page=mybooking';</script>";
			} else {
				echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่'); history.back(-1);</script>";
				exit();
			}
	} 
}	


//เปลี่ยนสถานะ
if ($_GET['action']=='change'){
		if ($_GET['status']=='0'){
			$meSQL = "UPDATE tb_event ";
			$meSQL .="SET status='3',"
			. "color='#ad2121'";
		} else if($_GET['status']=='3'){
			$meSQL = "UPDATE tb_event ";
			$meSQL .="SET status='0',"
			. "color='#1e90ff'";
		}
$meSQL .= "WHERE id ='{$_GET['id']}' ";
$meQuery = $conn->query($meSQL);			
	if ($meQuery == TRUE) {
		echo "<script>window.location ='../index.php?page=mybooking';</script>";
        } else {
		echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่');history.back(-1);</script>";
		exit();
        }
}	
//ปิด
$conn->close();
?>