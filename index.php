<?php
error_reporting (E_ALL ^ E_NOTICE);
switch ($_GET["page"]) {
  case "home":
    include("home/index.php");
    break;
  case "member":
    include("member/index.php");
    break;
  case "room":
    include("room/index.php");
    break;
  case "login":
    include("member/login.php");
    break;
  case "user":	
    include("member/user.php");
    break;
  case "rooms":
	  include("rooms/index.php");
	  break;
  case "setrooms":
  	include("rooms/index.php");
	  break;
  case "booking":
	  include("booking/index.php");
  	break;
	case "mybooking":
	  include("booking/mybooking.php");
    break;
  case "report":
    include("report/index.php");
    break;
  case "style":
      include("style/index.php");
      break;
  case "equip":
      include("equip/index.php");
      break;
  case "division":
      include("division/index.php");
      break;
  default:
    include "home/index.php"; //ตั้งค่าหน้าแรก
}
?>