<?php
session_start();
if ($_SESSION['status']!='admin') {
	echo "<script>alert('session ผิดผลาด'); window.location ='../index.php';</script>";
	exit();
} else {
include '../connect.php'; 
include '../function.php';
}

//แก้ไขข้อมูล
if ($_GET['action']=='edit'){
// $sql = "SELECT * FROM tb_rooms WHERE id_rooms = '{$_POST['idrooms']}' ";
// $meResult = $conn->query( $sql )->fetch_assoc() ;   

$strYear = date('Y',strtotime($_POST['date']));
$strMonth= date('m',strtotime($_POST['date']));
$strDay= date('d',strtotime($_POST['date']));
$startdate = $strYear.'-'.$strMonth.'-'.$strDay.'T'.$_POST['starttime'].':00';

$endstrYear = date('Y',strtotime($_POST['date']));
$endstrMonth= date('m',strtotime($_POST['date']));
$endstrDay= date('d',strtotime($_POST['date']));
if ($_POST['hour'] == '1') {
	$endt = date('H:i:s', strtotime('+59 minutes', strtotime($_POST['starttime'])));
} else if ($_POST['hour'] == '2') {
	$endt = date('H:i:s', strtotime('+119 minutes', strtotime($_POST['starttime'])));
} else if ($_POST['hour'] == '3') {
	$endt = date('H:i:s', strtotime('+179 minutes', strtotime($_POST['starttime'])));
} else {
	$endt = date('H:i:s', strtotime('+239 minutes', strtotime($_POST['starttime'])));
}
$enddate = $endstrYear.'-'.$endstrMonth.'-'.$endstrDay.'T'.$endt;

$sql = "SELECT * FROM tb_rooms WHERE id_rooms = '{$_POST['idrooms']}' ";
		$meResult = $conn->query( $sql )->fetch_assoc() ;    

		$meSQL = "UPDATE tb_event ";
		$meSQL .="SET rooms='{$_POST['idrooms']}',"
		. "title='{$_POST['title']}',"
		. "start='{$startdate}',"
		. "end='{$enddate}',"
		. "hour='{$_POST['hour']}',"
		. "people='{$_POST['people']}',"
		. "other='{$_POST['other']}',"
		. "status='{$_POST['status']}' ";

		$meSQL .= "WHERE id ='{$_POST['id']}' ";
		$meQuery = $conn->query($meSQL);			
			if ($meQuery == TRUE) {
				if ($_GET['report'] != '') {
					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location ='../index.php?page=report&report=".$_GET['report']."';</script>";
					} else { echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location ='../index.php?page=report';</script>"; }
			} else {
				echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่'); history.back(-1);</script>";
				exit();
			}

// $sql ="SELECT * FROM tb_event  WHERE rooms = '{$_POST['idrooms']}'
// 		AND (status = '" . "0" . "' or status = '" . "1" . "')
// 		AND (
// 			(start BETWEEN '" . $startdate . "' AND '" . $enddate . "')
// 			OR 
// 			(end BETWEEN '" . $startdate . "' AND '" . $enddate . "')
// 			OR 
// 			('" . $startdate . "' BETWEEN start  AND end)
// 			OR 
// 			('" . $enddate . "' BETWEEN  start  AND end )
// 		)";

// 	$meResult = $conn->query( $sql )->fetch_assoc() ; 

// 	if($row = $meResult){
// 		// echo "ห้องมีผู้ใช้งาน ช่วงเวลา ". $_POST['starttime'].':00' ." - ". $endt ." น. กรุณาตรวจสอบอีกครั้ง!";
// 		echo "<script>alert('ห้องประชุมมีผู้ใช้งานในช่วงเวลา ". $_POST['starttime'].':00' ." - ". $endt ." น. กรุณาตรวจสอบอีกครั้ง!'); history.back(-1);</script>";
// 	} else {
// 		$sql = "SELECT * FROM tb_rooms WHERE id_rooms = '{$_POST['idrooms']}' ";
// 		$meResult = $conn->query( $sql )->fetch_assoc() ;    

// 		$meSQL = "UPDATE tb_event ";
// 		$meSQL .="SET rooms='{$_POST['idrooms']}',"
// 		. "title='{$_POST['title']}',"
// 		. "start='{$startdate}',"
// 		. "end='{$enddate}',"
// 		. "hour='{$_POST['hour']}',"
// 		. "people='{$_POST['people']}',"
// 		. "other='{$_POST['other']}',"
// 		. "status='{$_POST['status']}' ";

// 		$meSQL .= "WHERE id ='{$_POST['id']}' ";
// 		$meQuery = $conn->query($meSQL);			
// 			if ($meQuery == TRUE) {
// 				if ($_GET['report'] != '') {
// 					echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location ='../index.php?page=report&report=".$_GET['report']."';</script>";
// 					} else { echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location ='../index.php?page=report';</script>"; }
// 			} else {
// 				echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่'); history.back(-1);</script>";
// 				exit();
// 			}
// 	}
}	

//ลบข้อมูล
if ($_GET['action']=='delete'){
	$meSQL = "DELETE FROM tb_event ";
	$meSQL .= "WHERE id='{$_GET['id']}' ";
	$meQuery = $conn->query($meSQL);
	if ($meQuery == TRUE) {
		if ($_GET['report'] != '') {
			echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว');window.location ='../index.php?page=report&report=".$_GET['report']."';</script>";
			} else { echo "<script>alert('ลบข้อมูลเรียบร้อยแล้ว');window.location ='../index.php?page=report';</script>"; }
	} else {
		echo "<script>alert('มีปัญหาการลบข้อมูล '); history.back(-1);</script>";
		exit();
	}
}	
//ปิด
$conn->close();
?>

