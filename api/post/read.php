<?php
// Headers 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once './models/Post.php';

// Instanstiate DB & connect
$database = new DataBase();
$db = $database->connect();

// Instansiate blog post object
$post = new Post($db);

// Blog post result 
$result = $post->read();
// Get row count
$count = $result->rowCount();


// check if any post

if ($count) {
  $posts_array = array();
  $post_arr['data'] = array();
  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $post_item = [
      'id' => $id,
      'title' => html_entity_decode($body),
      'author' => $author,
      'category_name' => 12
    ];
  }
} else {
}