<?php

function convertRowToArray($rows)
{
  $brones_array = array();
  $brones_array['data'] = array();
  while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $brone_item = [
      'id' => $id,
      'userId' => $userId,
      'roomId' => $roomId,
      'from' => $from,
      'to' => $to
    ];
    $brones_array['data'][] = $brone_item;
  }
  return  $brones_array;
}