<?php
session_start();
if ($_SESSION['status']!='admin') {
	echo "<script>alert('session ผิดผลาด'); window.location ='../index.php';</script>";
	exit();
} else {
include '../connect.php';    
}

// เพิ่มข้อมูล
if ($_GET['action']=='add'){
date_default_timezone_set('Asia/Bangkok');
	if (strlen($_POST['username'])<5) {
		echo "<script>alert('ชื่อผู้ใช้ต้องมากกว่า 5 ตัวอักษร'); history.back(-1);</script>";
		exit();
    }			
	if (strlen($_POST['password'])<6) {
		echo "<script>alert('รหัสผ่านต้องมากกว่า 6 ตัวอักษร'); history.back(-1);</script>";
		exit();
    }
	if($_POST["password"] != $_POST["conpassword"]){
		echo "<script>alert('รหัสผ่านไม่ตรงกัน'); window.history.back();</script>";
		exit();
    }
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		echo "<script>alert('อีเมลล์ไม่ถูกต้อง');history.back(-1);</script>";
		exit();
    }
	
	$meSQL = "SELECT * FROM tb_member WHERE username = '".trim($_POST['username'])."' ";
	$meQuery = $conn->query($meSQL);
	$meResult = mysqli_fetch_array($meQuery,MYSQLI_ASSOC);
	if($meResult)
	{
			echo "<script>alert('ชื่อผู้ใช้นี้ มีในระบบแล้ว');window.history.back();</script>";
	}else{
		$create_date = date('Y-m-d H:i:s');
		$meSQL = "INSERT INTO tb_member (username,password,ntitle,firstname,surname,position,phone,email,status,active,create_date) VALUES ('".$_POST["username"]."','".$_POST["password"]."','".$_POST["title"]."','".$_POST["firstname"]."','".$_POST["surname"]."','".$_POST["position"]."','".$_POST["phone"]."','".$_POST["email"]."','".$_POST["status"]."','".$_POST["active"]."','".$create_date."')";
		$meQuery = $conn->query($meSQL);		
		
		if ($meQuery == TRUE) {
			echo "<script>alert('สมัครเสร็จเรียบร้อยแล้ว'); window.location ='../index.php?page=member';</script>";
        } else {
			echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่');history.back(-1);</script>";
			exit();
        }
	}		
}

// แก้ไขข้อมูล
if ($_GET['action']=='edit'){
	if (strlen($_POST['username'])<5) {
		echo "<script>alert('ชื่อผู้ใช้ต้องมากกว่า 5 ตัวอักษร'); history.back(-1);</script>";
		exit();
    }			
	if (strlen($_POST['password'])<6) {
		echo "<script>alert('รหัสผ่านต้องมากกว่า 6 ตัวอักษร'); history.back(-1);</script>";
		exit();
    }
	if($_POST["password"] != $_POST["conpassword"])
	{
		echo "<script>alert('รหัสผ่านไม่ตรงกัน'); window.history.back();</script>";
		exit();
    }
        	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		echo "<script>alert('อีเมลล์ไม่ถูกต้อง');history.back(-1);</script>";
		exit();
    }
$meSQL = "UPDATE tb_member ";
$meSQL .="SET username='{$_POST['username']}',"
. "password='{$_POST['password']}',"
. "ntitle='{$_POST['title']}',"
. "firstname='{$_POST['firstname']}',"
. "surname='{$_POST['surname']}',"
. "position='{$_POST['position']}',"
. "phone='{$_POST['phone']}',"
. "email='{$_POST['email']}',"
. "status='{$_POST['status']}',"
. "active='{$_POST['active']}' ";
$meSQL .= "WHERE id_member='{$_POST['id']}' ";
$meQuery = $conn->query($meSQL);			
	if ($meQuery == TRUE) {
		echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location ='../index.php?page=member';</script>";
        } else {
		echo "<script>alert('มีปัญหาการบันทึกข้อมูล กรุณากลับไปบันทึกใหม่');history.back(-1);</script>";
		exit();
        }
}	

//ลบข้อมูล
if ($_GET['action']=='delete'){
        $meSQL = "DELETE FROM tb_member ";
        $meSQL .= "WHERE id_member='{$_GET['id']}' ";
        $meQuery = $conn->query($meSQL);
        if ($meQuery == TRUE) {
			echo "<script>alert('ลบข้อมูลสำเร็จ'); window.location ='../index.php?page=member';</script>";
        } else {
			echo "<script>alert('มีปัญหาการลบข้อมูล '); history.back(-1);</script>";
			exit();
        }
}
$conn->close();
?>