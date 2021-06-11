<meta charset="utf-8">
<?php
session_start(); 
ob_start();
echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

if($_POST['username'] == "") {                   
echo "<script>alert('กรุณาใส่ชื่อผู้ใช้');window.location ='../index.php?page=login'';</script>";
} else if($_POST['password'] == "") {        
echo "<script>alert('กรุณาใส่รหัสผ่าน'); window.location ='../index.php?page=login'';</script>";
} else {                                             
include("../connect.php");
$username = $_POST['username'];
$password = $_POST['password'];

	require_once("nusoap/nusoap_helper.php");

	$client = new nusoap_client("https://ws.pim.ac.th/webservice/wscenters.php?wsdl", 'wsdl');
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = FALSE;

	$params = array();
	$params = array(
		'strName' => $username,
		'strPass' => $password
	);

	$data = $client->call("AuthenLDAPCenterForILS", $params);
	$obj  = @$data;

	

	$meSQL = "SELECT id_member,username,status,active FROM tb_member WHERE username='{$username}' AND password='{$password}'";
    $result = $conn->query($meSQL);

	if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	if ($row['active'] != 1) {echo "<script>alert('อยู่ระหว่างตรวจสอบข้อมูลการสมัคร'); window.location ='../index.php';</script>";}
	$_SESSION['id'] = $row['id_member'];
	$_SESSION['username'] = $row['username'];
	$_SESSION['status'] = $row['status'];

		if(isset($_COOKIE["userlogin"])) {
			setcookie ("userlogin","");
		}
		if(isset($_COOKIE["passwordform"])) {
			setcookie ("passwordform","");
		}

		$ldate = date('Y-m-d H:i:s');
		$meSQL2 = "UPDATE tb_member ";
		$meSQL2 .="SET login_date='{$ldate}',"
		. "login_times=login_times+1 ";
		$meSQL2 .= "WHERE id_member='{$row['id_member']}' ";
		$meQuery2 = $conn->query($meSQL2);

		echo "<script>window.location ='../index.php';</script>";
	} elseif ($j = json_encode($obj)) {
		if ($data[0]['LOGINSTATUS'] == 'PASS') {
			$_SESSION['status'] = $data[0]['LOGINSTATUS'];
			$_SESSION['type'] = $data[0]['LOGINTYPE'];
			$_SESSION['firstname_th'] = $data[0]['FIRSTNAME_TH'];
			$_SESSION['lastname_th'] = $data[0]['LASTNAME_TH'];
			$_SESSION['card_no'] = $data[0]['CARD_NO'];
			$_SESSION['dep'] = $data[0]['DEPARTMENT_NAME'];
			$_SESSION['level_name'] = $data[0]['LEVELNAME'];
			$_SESSION['card_csn'] = $data[0]['CARDCSNNO'];
			echo "<script>window.location ='../index.php';</script>";
		} else {
			echo "<script>alert('ไม่สามารถเข้าสู่ระบบได้เนื่องชื่อผู้ใช้งานหรือรหัสผ่านผิดพลาด'); window.location ='../index.php?page=login';</script>";
		}

	} else {
		echo "<script>alert('ไม่สามารถเข้าสู่ระบบได้เนื่องชื่อผู้ใช้งานหรือรหัสผ่านผิดพลาด'); window.location ='../index.php?page=login';</script>";
    }
}
ob_end_flush();
$conn->close();
?>