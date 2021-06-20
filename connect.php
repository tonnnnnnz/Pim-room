<?php
$conn = mysqli_connect("localhost", "root", "", "pim_room");
// $conn = mysqli_connect("us-cdbr-east-04.cleardb.com", "b97782d02d1446", "ced0486c", "heroku_11a0afe168f6dca");
mysqli_set_charset($conn, 'utf8');
if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
//config
// $org = "<i class='ace-icon glyphicon glyphicon-lock'></i>".'  Way IT Echo' ; //ชื่อหน่วยงาน
// $boss = 'หัวหน้าสำนักปลัด' ; //ชื่อตำแหน่งหัวหน้าใช้ในปริ้นหนังสือ
?>