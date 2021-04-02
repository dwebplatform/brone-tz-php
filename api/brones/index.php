<?php
// Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../models/Brone.php';
include_once '../../utils/getPagginationData.php';
include_once '../../utils/convertRowsToArray.php';
// Instanstiate DB & connect
$database = new DataBase();
$db = $database->connect();
// Instansiate blog post object
$brone = new Brone($db);
$pagginationData = getPagginationData();
$offset = $pagginationData['offset'];
$items_per_page = $pagginationData['items_per_page'];
$result = $brone->read($offset, $items_per_page);
// Get row count
$count = $result->rowCount();

if ($count) {
  $brones_array = convertRowToArray($result);
  echo json_encode($brones_array);
} else {
  echo json_encode(['status' => 'error', 'msg' => 'Не удалось получить ни одной брони']);
}