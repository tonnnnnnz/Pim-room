<?php require("phpmailer\PHPMailerAutoload.php");?>
<?php
header('Content-Type: text/html; charset=utf-8');

$mail = new PHPMailer;
$mail->CharSet = "utf-8";
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 25;
$mail->SMTPSecure = 'tls';
$mail->SMTPAuth = true;


$gmail_username = 'pim.room.reservation@gmail.com'; // gmail ที่ใช้ส่ง
$gmail_password = '123456pim'; // รหัสผ่าน gmail
// ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1


$sender = 'PIM Room Reservation'; // ชื่อผู้ส่ง
$email_sender = 'pim.room.reservation@gmail.com'; // เมล์ผู้ส่ง 
$email_receiver = $email; // เมล์ผู้รับ ***
$subject = $sub; // หัวข้อเมล์


$mail->Username = $gmail_username;
$mail->Password = $gmail_password;
$mail->setFrom($email_sender, $sender);
$mail->addAddress($email_receiver);
$mail->Subject = $subject;

// $email_content = "วันที่".$date ."\n";
$email_content = "
<!DOCTYPE html>
<html>
	<head>
		<meta charset=utf-8'/>
		<title>ทดสอบการส่ง Email</title>
	</head>
	<body>
		<h1 style='background: #221f53;padding: 10px 0 10px 10px;margin-bottom:10px;font-size:30px;color:white;' >
			<img src='https://upload.wikimedia.org/wikipedia/th/1/16/Logo_PIM.png' style='width: 45px; height: 40px;'>
			PIM Room Reservation
		</h1>
		<div style='padding:20px;'>
			<div>				
				<h2>ข้อมูลการจอง : <strong style='color:#0000ff;'></strong></h2>
				<p>ยืนยันการจองห้องประชุม ".$room."</p>
				<p>วันที่ ".$date." เวลา ".$startt." - ".$endt." น. สำเร็จ</p>
				<p>กรุณาติดต่อเคาน์เตอร์บริการก่อนเข้าใช้งาน</p>
			</div>
			<div style='margin-top:30px;'>
				<hr>
				<address>
					<h4>ติดต่อสอบถาม</h4>
					<p>ห้องสมุดสถาบันการจัดการปัญญาภิวัฒน์</p>
					<p>Tel: 0 2855 0381-82</p>
				</address>
			</div>
		</div>
		<div style='background: #221f53;color: #dddada;padding:10px;'>
			<div style='text-align:center'> 
				2021 © PIM Room Reservation
			</div>
		</div>
	</body>
</html>
";

//  ถ้ามี email ผู้รับ
if($email_receiver){
	$mail->msgHTML($email_content);

	if (!$mail->send()) {  // สั่งให้ส่ง email
		// กรณีส่ง email ไม่สำเร็จ
		echo "<h3 class='text-center'>ระบบมีปัญหา กรุณาลองใหม่อีกครั้ง</h3>";
		echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
	}	
}
?>