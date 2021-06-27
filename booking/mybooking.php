<?php
session_start();
$title = 'รายการของฉัน'; //กำหนดไตเติ้ล
if ($_SESSION['id'] != '') {
    include 'connect.php';
    $sql = "SELECT * FROM tb_member WHERE id_member = '{$_SESSION['id']}'";
    $rs = $conn->query($sql)->fetch_assoc();
}
if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'user' || $_SESSION['type'] == 'STUDENT' || $_SESSION['type'] == 'STAFF') {
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
    <link rel="stylesheet" href="css/mybooking.css">
    <link rel="icon" type="image" sizes="16x16" href="images/Logo_PIM.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <!--  Datatables  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>  

    <!--  extension responsive  -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="JS/script.js"></script>
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
            <?php if ($_SESSION['status'] == 'admin' || $_SESSION['status'] == 'user' || $_SESSION['type'] == 'STUDENT' || $_SESSION['type'] == 'STAFF') { ?>
                <li class="item">
                    <a class="list" href="index.php?page=mybooking">รายการจอง</a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['status'] == 'admin') { ?>
                <li class="item"><a class="list" href="index.php?page=member">สมาชิก</a></li>
                <li class="item"><a class="list" href="index.php?page=report">รายงาน</a></li>
            <?php } ?>

            <?php if ($_SESSION['id'] != '' || $_SESSION['status'] != '') { ?>
                <?php if ($_SESSION['status'] == 'admin') {
                    $sql2 = "SELECT COUNT(id) AS count1 FROM tb_event WHERE status = 0 ";
                    $rs2 = $conn->query($sql2)->fetch_assoc(); ?>
                    <li class="item">
                        <a class="list" href="index.php?page=report&report=0"><i class="fas fa-bell"></i></a>
                        <?php if ($rs2['count1'] != 0) { ?>
                            <span class="notify2"><?php echo $rs2['count1']; ?></span>
                        <?php } ?>
                    </li>
                <?php } ?>
                <li class="item out">
                    <a class="logout" href="#">
                        <span class="user-info">
                            <?php
                            echo $rs['title'] . $rs['firstname'] . '  ' . $rs['surname'];
                            echo ($_SESSION['firstname_th'] . ' ' . $_SESSION['lastname_th']);
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
            <?php } else { ?>
                <li class="item-button"><a class="list" href="index.php?page=login">เข้าสู่ระบบ</a></li>

            <?php } ?>

            <li class="toggle"><a href="#"><i class="fas fa-bars"></i></a></li>
        </ul>
    </nav>
    <!-- End nav-bar  -->

    <!-- Start table -->
    <div class="container-table100">
        <div class="wrap-table100">
            <div class="table100">
                <?php if ($_GET['action'] == '') {
                    if ($_SESSION['type'] == 'STUDENT' || $_SESSION['type'] == 'STAFF') {
                        $meSQL = "SELECT * FROM tb_event LEFT JOIN tb_rooms ON tb_event.rooms = tb_rooms.id_rooms WHERE id_member = {$_SESSION['card_no']} ORDER BY id DESC";
                    } else {
                        $meSQL = "SELECT * FROM tb_event LEFT JOIN tb_rooms ON tb_event.rooms = tb_rooms.id_rooms WHERE id_member = {$_SESSION['id']} ORDER BY id DESC";
                    }
                    $meQuery = $conn->query($meSQL);
                ?> 

                        <h3>รายการจองของฉัน</h3>
            </div>
            <div>
                <table id="datatables" class="table table-bordered  display nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr class="table100-head">
                            <th class="column1">ลำดับ</th>
                            <th class="column2">ห้องประชุม</th>
                            <th class="column3">วัตถุประสงค์</th>
                            <th class="column4">วันที่ใช้งาน</th>
                            <th class="column5">เวลา</th>
                            <th class="column6">สถานะ</th>
                            <th class="column7">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        while ($rs = $meQuery->fetch_assoc()) {
                        ?>
                            <tr>
                                <td class="column1"><?php echo $i++; ?></td>
                                <td class="column2"><?php echo $rs['name_rooms']; ?></td>
                                <td class="column3"><?php echo $rs['title']; ?></td>
                                <td class="column4"><?php $dateData = $rs['start']; echo thai_date(strtotime($dateData)); ?></td>
                                <td class="column5"><?php $startTime = $rs['start'];
                                                          $endTime = $rs['end'];echo thai_time(strtotime($startTime)) . '-' . thai_time(strtotime($endTime)); ?></td>
                                <td class="column6">
                                    <?php
                                    if ($rs['status'] == '1') {
                                        echo '<p class="approve">', 'เข้าใช้งาน', '</p>';
                                    } else if ($rs['status'] == '2') {
                                        echo '<p class="disapprove">', 'ไม่เข้าใช้งาน', '</p>';
                                    } else if ($rs['status'] == '3') {
                                        echo '<p class="cancel">', 'ยกเลิก', '</p>';
                                    } else {
                                        echo '<p class="wait">', 'อนุมัติ/รอเข้าใช้งาน', '</p>';
                                    }
                                    ?>
                                </td>
                                <td class="column7">
                                    <div>
                                        <?php if ($rs['status'] == '0' || $rs['status'] == '3') { ?>
                                            <a class="green" href="index.php?page=mybooking&action=edit&id=<?php echo $rs['id']; ?>">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            &nbsp;
                                            <a class="red" href="booking/action.php?action=change&id=<?php echo $rs['id']; ?>&status=<?php echo $rs['status']; ?>" OnClick="return chk();">
                                                <i class="fas fa-ban"></i>
                                            </a>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn-danger" id="btn-back-to-top">
                <i class="fas fa-arrow-up"></i>
            </button>
        </div>
    </div>
    </div>
<?php } ?>

<!-- แก้ไข -->
<?php if ($_GET['action'] == 'edit') {
    $meSQL = "SELECT * FROM tb_event WHERE id ='{$_GET['id']}' ";
    $meQuery = $conn->query($meSQL);
    if ($meQuery == TRUE) {
        $meResult2 = $meQuery->fetch_assoc();
    } else {
        echo $conn->error;
    }
?>
    <div class="container">
        <div class="wrap-container">
            <form method="post" action="booking\action.php?action=edit">
                <h3 class="edit">แก้ไข</h3>
                <div class="container-1-box">
                    <label class="number">หมายเลขห้อง</label>
                    <select name="idrooms" id="room">
                        <?php
                        $meSQL = "SELECT * FROM tb_rooms ORDER BY id_rooms asc";
                        $meQuery = $conn->query($meSQL);
                        while ($meResult = $meQuery->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $meResult['id_rooms']; ?>" <?php if ($meResult['id_rooms'] == $meResult2['rooms']) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                <?php echo $meResult['name_rooms']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="name">ชื่อผู้จอง</label>
                    <?php if ($_SESSION['status'] == 'admin') { ?>
                        <input type="text" name="membershow" placeholder="" class="long" value="<?php echo $rs['firstname'] . '  ' . $rs['surname']; ?>" disabled />
                        <input type="hidden" name="member" value="<?php echo $rs['firstname'] . '  ' . $rs['surname']; ?>" />
                        <input type="hidden" name="email" value="<?php echo $rs['email'];?>" />
                    <?php } else { ?>
                        <input type="text" name="membershow" placeholder="" class="long" value="<?php echo ($_SESSION['firstname_th'] . ' ' . $_SESSION['lastname_th']); ?>" disabled />
                        <input type="hidden" name="member" value="<?php echo ($_SESSION['firstname_th'] . ' ' . $_SESSION['lastname_th']); ?>" />
                        <input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>" />
                    <?php } ?>
                </div>
                <div class="container-1-box">
                    <label class="department">สาขา</label>
                    <input type="text" name="departmentshow" placeholder="" class="long" value="<?php echo ($_SESSION['dep']); ?>" disabled />
                    <input type="hidden" name="department" value="<?php echo ($_SESSION['dep']); ?>" />
                </div>
                <div class="container-1-box">
                    <label class="topic">วัตถุประสงค์</label>
                    <select name="title" id="title" required>
                        <option value="อ่าน/ติวหนังสือ" <?php if ($meResult2['title'] == 'อ่าน/ติวหนังสือ') {
                                                            echo 'selected';
                                                        } ?>>อ่าน/ติวหนังสือ</option>
                        <option value="ประชุมงาน/Presentงาน/ทำงานกลุ่ม" <?php if ($meResult2['title'] == 'ประชุมงาน/Presentงาน/ทำงานกลุ่ม') {
                                                                            echo 'selected';
                                                                        } ?>>ประชุมงาน/Presentงาน/ทำงานกลุ่ม</option>
                        <option value="ถ่ายVDO" <?php if ($meResult2['title'] == 'ถ่ายVDO') {
                                                    echo 'selected';
                                                } ?>>ถ่ายVDO</option>
                        <option value="สอนออนไลน์" <?php if ($meResult2['title'] == 'สอนออนไลน์') {
                                                        echo 'selected';
                                                    } ?>>สอนออนไลน์</option>
                        <option value="อื่นๆ" <?php if ($meResult2['title'] == 'อื่นๆ') {
                                                    echo 'selected';
                                                } ?>>อื่นๆ</option>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="amount">จำนวนผู้เข้าใช้</label>
                    <select name="people" id="people" required>
                        <option value="1" data-filter='{"room": ""}' <?php if ($meResult2['people'] == '1') {
                                                echo 'selected';
                                            } ?>>1</option>
                        <option value="2" data-filter='{"room": ""}' <?php if ($meResult2['people'] == '2') {
                                                echo 'selected';
                                            } ?>>2</option>
                        <option value="3" data-filter='{"room": ""}' <?php if ($meResult2['people'] == '3') {
                                                echo 'selected';
                                            } ?>>3</option>
                        <option value="4" data-filter='{"room": ""}' <?php if ($meResult2['people'] == '4') {
                                                echo 'selected';
                                            } ?>>4</option>
                        <option value="5" data-filter='{"room": ""}' <?php if ($meResult2['people'] == '5') {
                                                echo 'selected';
                                            } ?>>5</option>
                        <option value="6" data-filter='{"room": ""}' <?php if ($meResult2['people'] == '6') {
                                                echo 'selected';
                                            } ?>>6</option>
                        <option value="7" data-filter='{"room": "1"}' <?php if ($meResult2['people'] == '7') {
                                                echo 'selected';
                                            } ?>>7</option>
                        <option value="8" data-filter='{"room": "1"}' <?php if ($meResult2['people'] == '8') {
                                                echo 'selected';
                                            } ?>>8</option>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="date">วันที่ใช้งาน</label>
                    <input name="date" class="date" type="date" value="<?php $start = date('Y-m-d', strtotime($meResult2['start'])); echo $start; ?>" required>
                </div>
                <div class="container-1-box">
                    <label class="starttime">เวลาใช้งาน</label>
                    <!-- <input name="starttime" type="time" class="starttime" value="<?php $starttime = date('H:i', strtotime($meResult2['start']));
                                                                                        echo $starttime; ?>" required> -->
                    <select class="starttime" id="starttime" name='starttime' required>
                        <option value="08:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '08:01') {
                                                    echo 'selected';
                                                } ?>>8:00 น.</option>
                        <option value="08:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '08:31') {
                                                    echo 'selected';
                                                } ?>>8:30 น.</option>
                        <option value="09:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '09:01') {
                                                    echo 'selected';
                                                } ?>>9:00 น.</option>
                        <option value="09:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '09:31') {
                                                    echo 'selected';
                                                } ?>>9:30 น.</option>
                        <option value="10:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '10:01') {
                                                    echo 'selected';
                                                } ?>>10:00 น.</option>
                        <option value="10:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '10:31') {
                                                    echo 'selected';
                                                } ?>>10:30 น.</option>
                        <option value="11:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '11:01') {
                                                    echo 'selected';
                                                } ?>>11:00 น.</option>
                        <option value="11:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '11:31') {
                                                    echo 'selected';
                                                } ?>>11:30 น.</option>
                        <option value="12:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '12:01') {
                                                    echo 'selected';
                                                } ?>>12:00 น.</option>
                        <option value="12:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '12:31') {
                                                    echo 'selected';
                                                } ?>>12:30 น.</option>
                        <option value="13:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '13:01') {
                                                    echo 'selected';
                                                } ?>>13:00 น.</option>
                        <option value="13:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '13:31') {
                                                    echo 'selected';
                                                } ?>>13:30 น.</option>
                        <option value="14:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '14:01') {
                                                    echo 'selected';
                                                } ?>>14:00 น.</option>
                        <option value="14:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '14:31') {
                                                    echo 'selected';
                                                } ?>>14:30 น.</option>
                        <option value="15:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '15:01') {
                                                    echo 'selected';
                                                } ?>>15:00 น.</option>
                        <option value="15:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '15:31') {
                                                    echo 'selected';
                                                } ?>>15:30 น.</option>
                        <option value="16:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '16:01') {
                                                    echo 'selected';
                                                } ?>>16:00 น.</option>
                        <option value="16:31" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '16:31') {
                                                    echo 'selected';
                                                } ?>>16:30 น.</option>
                        <option value="17:01" <?php if ($starttime = date('H:i', strtotime($meResult2['start'])) == '17:01') {
                                                    echo 'selected';
                                                } ?>>17:00 น.</option>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="hour">จำนวนชั่วโมง</label>
                    <select name="hour" id="hour" required>
                        <?php if ($_SESSION['level_name'] == 'ปริญญาตรี' || $_SESSION['level_name'] == 'ปริญญาตรี - iMTM') { ?>
                            <option value="1" <?php if ($meResult2['hour'] == '1') {
                                                    echo 'selected';
                                                } ?>>1</option>
                            <option value="2" <?php if ($meResult2['hour'] == '2') {
                                                    echo 'selected';
                                                } ?>>2</option>
                        <?php } else if ($_SESSION['status'] == 'admin' || $_SESSION['type'] == 'STAFF' || $_SESSION['level_name'] == 'ปริญญาโท') { ?>
                            <option value="1" <?php if ($meResult2['hour'] == '1') {
                                                    echo 'selected';
                                                } ?>>1</option>
                            <option value="2" <?php if ($meResult2['hour'] == '2') {
                                                    echo 'selected';
                                                } ?>>2</option>
                            <option value="3" <?php if ($meResult2['hour'] == '3') {
                                                    echo 'selected';
                                                } ?>>3</option>
                            <option value="4" <?php if ($meResult2['hour'] == '4') {
                                                    echo 'selected';
                                                } ?>>4</option>
                        <?php } ?>
                    </select>
                </div>
                <div class="container-1-box">
                    <label class="other">อื่นๆ</label>
                    <textarea name="other"><?php echo $meResult2['other']; ?></textarea>
                </div>
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
                <div class="container-2-box">
                    <button class="btn-save" type="submit">บันทึก</button>
                    <button class="btn-cancel" type="button" onClick="javascript: window.history.back();">ยกเลิก</button>
                </div>
            </form>
        </div>
    </div>
<?php } ?>
<!-- End table -->
 
<!--   Datatables-->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>

<!-- extension responsive -->
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

<script src="JS/back2top.js"></script>
<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [5, 15, 30, 50, -1],
                [5, 15, 30, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Records"
            }
        });
    })
</script>
<script>
        localStorage.setItem('room', 'select');
            $('#room').on('change', function() {
                var val = $(this).val();
                localStorage.setItem('room', val);
                $('select#people>option').each(function () {
                    var filter = $(this).data();
                    var elem = $(this);
                    if((filter.filter.room != val) && filter.filter.room !="")  {
                    elem.hide();
                    $('#people').val("4");
                    } else if(filter.filter.room !="") {
                    elem.show();
                    $('#people').val("6");
                    } else {
                    elem.show();
                    }
                });
            });
    </script>

</body>

</html>

<?php
$conn->close();
?>