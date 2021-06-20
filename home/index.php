<?php 
error_reporting(0);
$title = 'ระบบจองห้องประชุม'; 
session_start();
if ($_SESSION['id'] != '') {
  include 'connect.php';
  $sql = "SELECT * FROM tb_member WHERE id_member = '{$_SESSION['id']}' ";
  $rs = $conn->query( $sql )->fetch_assoc() ;
}
if ($_SESSION['status'] =='admin' || $_SESSION['status'] =='user' || $_SESSION['type'] == 'STUDENT')  
{
    include 'connect.php';
    include 'function.php';
}
include 'connect.php';  
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");

// fetch data to calendar
$data = array(); 
$query = "SELECT * FROM tb_event INNER JOIN tb_rooms ON tb_event.rooms=tb_rooms.id_rooms;";
if ($event = $conn->query($query)) {
    while ($obj = $event->fetch_object()) {
      if ($obj->status == 0 || $obj->status == 1) {
        $data[] = array(
          'id' => $obj->id,
          'title'=> $obj->name_rooms,
          'start'=> $obj->start,
          'end'=> $obj->end,
          "color"=> $obj->color,
          'extendedProps' => array(
            'department' => $obj->department,
            'name' => $obj->member,
            'objective' => $obj->title,
            'amount' => $obj->people,
            'other' => $obj->other
          )
          
          );
          // echo '<pre>';
          //   print_r($obj);
          // echo '</pre>';
      }
      
    }
    $event->close();  
}
     
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <!-- calendar -->
    <link rel="stylesheet" href="fullcalendar-5.5.1/lib/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <script src='fullcalendar-5.5.1/lib/main.js'></script>
    <title><?php echo $title; ?></title>
</head>
<style>
  
</style>
<body>
    <!-- Start nav-bar -->
    <nav>
      <ul class="menu">
          <li class="logo"><a class="list" href="index.php?page=home"><img src="images/Logo_PIM.png" alt="PIM Logo"></a></li>
          <li class="brand"><a class="list" href="index.php?page=home">ระบบจองห้องประชุม</a></li>
          <li class="item"><a class="list" href="index.php?page=booking">จองห้องประชุม</a></li>
          <li class="item"><a class="list" href="index.php?page=rooms">ห้องประชุม</a></li>
<?php if ($_SESSION['status'] == 'admin' || $_SESSION['type'] == 'STUDENT' || $_SESSION['type'] == 'STAFF') {?> 
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
                <span class="notify1"><?php echo $rs2['count1'];?></span>
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

  <!-- ตารางปฎิทิน -->
  <div class="con-cal">
      <div id='calendar'></div>
      <div class="guidance">
          <p class="identity">สถานะการเข้าใช้งาน</p>
          <div class="room">
              <p class="wait"></p>
              <p class="note">อนุมัต/รอใช้งาน</p>
          </div>
          <div class="room">
              <p class="in"></p>
              <p class="note">เข้าใช้งานแล้ว</p>
          </div>
      </div> 

    <div id="id01" class="w3-modal">
      <div class="w3-modal-content">
        <div class="w3-container">
          <span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-display-topright">&times;</span>
          <div class="modal-content">
            <div class="modal-header">
              <h3>รายการจองห้องประชุม</h3>
            </div>
            <div id="modalTitle" class="modal-body" style="font-size: 16px;">
              <table>
                <tbody>
                  <tr>
                    <th>ผู้จอง</th>
                    <td id="name"></td>
                  </tr>
                  <tr>
                    <th>คณะ</th>
                    <td id="dep"></td>
                  </tr>
                  <tr>
                    <th>ห้องประชุม</th>
                    <td id="room"></td>
                  </tr>
                  <tr>
                    <th>วัตถุประสงค์</th>
                    <td id="obj"></td>
                  </tr>
                  <tr>
                    <th>จำนวนผู้เข้าใช้</th>
                    <td id="people"></td>
                  </tr>
                  <tr>
                    <th>เริ่มเวลา</th>
                    <td id="start"></td>
                  </tr>
                  <tr>
                    <th>สิ้นสุดเวลา</th>
                    <td id="end"></td>
                  </tr>
                  <tr>
                    <th>อื่นๆ</th>
                    <td id="other"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script for Raspon -->
  
  <script>
    <?php
    date_default_timezone_set('Asia/Bangkok');
    $today = date("Y-m-d"); // Use this format
    ?>
    var calendar;
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
          },
          initialView: 'dayGridMonth',
          defaultDate: <?php echo "'" . $today . "'"; ?>,
          businessHours: true,
          locale: 'th',
          selectable: true,
          dayMaxEvents: true,
          displayEventTime: true,
          displayEventEnd: true,
          eventTimeFormat: { // รูปแบบการแสดงของเวลา เช่น '14:30' 
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
          },
          eventClick: function(arg) {
            document.getElementById('id01').style.display='block'

            var star_t = arg.event.start.toTimeString().split(" ")[0]
            var en_d = arg.event.end.toTimeString().split(" ")[0]

            $('#dep').html(arg.event.extendedProps['department'])
            $('#name').html(arg.event.extendedProps['name'])
            $('#room').html(arg.event.title)
            $('#obj').html(arg.event.extendedProps['objective'])
            $('#people').html(arg.event.extendedProps['amount'])
            $('#start').html(star_t.split(":")[0]+":"+star_t.split(":")[1])
            $('#end').html(en_d.split(":")[0]+":"+en_d.split(":")[1])
            $('#other').html(arg.event.extendedProps['other'])
          },
          events: <?php echo json_encode($data)?>
        });
        calendar.render();
      });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="JS/script.js"></script>
</body>
</html>
