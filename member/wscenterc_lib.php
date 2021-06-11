<meta charset="utf-8">
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$strName = $_REQUEST['username']; // USERNAME
$strPass = $_REQUEST['password']; // PASSWORD

require_once("nusoap/nusoap_helper.php");

$client = new nusoap_client("https://ws.pim.ac.th/webservice/wscenters.php?wsdl", 'wsdl');
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = FALSE;

$params = array();
$params = array(
	'strName' => $strName,
	'strPass' => $strPass
);

$data = $client->call("AuthenLDAPCenterForILS", $params);
$obj  = @$data;

// echo '<pre>';
// print_r($obj);
// echo '</pre>';

// echo '<pre>';
// print_r($client);
// echo '</pre>';

// echo '<pre>';
// print_r($data[0]['FIRSTNAME_TH']);
// echo '</pre>';

// echo 'Return Array : ';
// echo '<pre>';
// print_r($obj);
// echo '</pre>';

// echo 'Return Json : ';
// $j = json_encode($obj);
// echo '<pre>';
// print_r($j);
// echo '</pre>';
?>
