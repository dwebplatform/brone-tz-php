<?php
function checkProps($data, $props)
{
  foreach ($props as $prop) {
    if (!property_exists($data, $prop)) {
      echo json_encode(['status' => 'error', 'msg' => 'Не было передано свойство ' . $prop]);
      die();
    }
  }
}