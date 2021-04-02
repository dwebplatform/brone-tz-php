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
checkProps($data, ['id']);
$brone->id = $data->id;
//Create Brone
try {
  $brone->cancel();
  echo json_encode(['status' => 'ok', 'msg' => ' бронь успешно удалена']);
} catch (Exception $e) {
  echo json_encode(['status' => 'error', 'msg' => $e->getMessage()]);
}