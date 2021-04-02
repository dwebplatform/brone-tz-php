<?php
// Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Access-Control-Allow-Methods,Content-Type,Access-Control-Allow-Origin, Authorization,X-Requested-With');
include_once '../../config/db.php';
include_once '../../models/Brone.php';
include_once '../../utils/checkProps.php';
// Instanstiate DB & connect
$database = new DataBase();
$db = $database->connect();
// Instansiate blog post object
$brone = new Brone($db);
$data = json_decode(file_get_contents("php://input"));
checkProps($data, ['userId', 'roomId', 'from', 'to']);
//Create Brone
try {
  $brone->userId = $data->userId;
  $brone->roomId = $data->roomId;
  $brone->from = $data->from;
  $brone->to = $data->to;
  $brone->create();

  echo json_encode(['status' => 'ok', 'msg' => 'Новая бронь создана успешно']);
  die();
} catch (Exception $e) {
  echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
}