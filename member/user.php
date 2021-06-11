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