<?php
class Post
{
  // DB stuff;
  private $conn;
  private $table = 'posts';
  // Properties

  public $id;
  public $category_id;
  public $category_name;
  public $title;
  public $author;
  public $body;
  public $created_at;

  public function __construct($db)
  {
    $this->conn = $db;
  }
  // get posts
  public function read()
  {
    $query = 'SELECT 
    c.name as category_name,
    p.id,
    p.category_id,
    p.title,
    p.body,
    p.author,
    p.created_at 
    FROM
    ' . $this->table . ' p
    LEFT JOIN 
    categories c ON p.id = c.id 
    ORDER BY p.created_at DESC';
    // prepare statement
    $stmt = $this->conn->prepare($query);
    // Execute statement
    $stmt->execute();
    return $stmt;
  }
}