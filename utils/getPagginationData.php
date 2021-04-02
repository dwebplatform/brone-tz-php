<?php
function getPagginationData()
{
  $items_per_page = 4;
  if (isset($_GET['limit'])) {
    $items_per_page = filter_input(INPUT_GET, 'limit', FILTER_VALIDATE_INT);
    if (false === $items_per_page) {
      $items_per_page = 4;
    }
  }
  $page = 1;
  if (isset($_GET['page'])) {
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
    if (false === $page) {
      $page = 1;
    }
  }
  $offset = ($page - 1) * $items_per_page;
  return ['offset' => $offset, 'items_per_page' => $items_per_page];
}