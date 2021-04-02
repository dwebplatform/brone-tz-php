<?php
class Brone
{
  // DB stuff;
  private $conn;
  private $table = 'brones';
  // Properties
  public $id;
  public $userId;
  public $roomId;
  public $from;
  public $to;

  public function __construct($db)
  {
    $this->conn = $db;
  }
  public function roomExist()
  {
    $query = 'SELECT COUNT(*) FROM rooms u WHERE u.id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam('1', $this->roomId);
    $stmt->execute();
    $res = $stmt->fetchColumn();
    return $res;
  }
  public function userExist()
  {
    $query = 'SELECT COUNT(*) FROM users u WHERE u.id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam('1', $this->userId);
    $stmt->execute();
    $res = $stmt->fetchColumn();
    return $res;
  }
  public function hasIntesect()
  {
    $query = 'SELECT COUNT(*) FROM `brones` b WHERE b.from <=:to AND b.to>=:from';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':from', $this->from);
    $stmt->bindParam(':to', $this->to);
    $stmt->execute();
    $res = $stmt->fetchColumn();
    return $res;
  }
  //удаляем бронь
  public function cancel()
  {
    if (!is_numeric($this->id)) {
      throw new Exception('Не был передан id');
    }
    $query = 'DELETE FROM `' . $this->table . '` WHERE id = ?';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam('1', $this->id);
    if ($stmt->execute()) {
      return true;
    } else {
      throw new Exception($stmt->error);
    }
  }
  // создаем бронь
  public function create()
  {
    // if user not exist 
    if (!$this->userExist()) {
      throw new Exception('Пользователя с таким id не существует');
    }
    if (!$this->roomExist()) {
      throw new Exception('Комнаты с таким id не существует');
    }
    //check intersactions
    if ($this->hasIntesect()) {
      throw new Exception('Выберите другой интервал');
      die();
    }
    $query = 'INSERT INTO `' . $this->table . '` (`userId`, `roomId`, `from`,`to`) VALUES (:userId, :roomId, :from,:to);';
    //Prepare statement
    $stmt = $this->conn->prepare($query);
    // TODO: check userId on exist in data base and so on
    $this->validateFields();
    try {
      $stmt->bindParam(':userId', $this->userId);
      $stmt->bindParam(':roomId', $this->roomId);
      $stmt->bindParam(':from', $this->from);
      $stmt->bindParam(':to', $this->to);
    } catch (\Exception $e) {
    }
    if ($stmt->execute()) {
      return true;
    } else {
      throw new Exception($stmt->error);
      // printf("Error: %s.\n", $stmt->error);
    }
  }

  private function validateFields()
  {
    if (!is_numeric($this->userId) || !is_numeric($this->roomId) || !is_numeric($this->from) || !is_numeric($this->to)) {
      throw new Exception('Не правильно были переданы поля для брони');
    }
  }
  public function read($offset, $items_per_page)
  {
    $query = 'SELECT 
    b.id, b.userId, b.roomId, b.from, b.to
    FROM ' . $this->table . ' b ';
    if (is_numeric($offset) && is_numeric($items_per_page)) {
      $query .= ' LIMIT ' . $offset . ',' . $items_per_page;
    }
    // prepare statement
    $stmt = $this->conn->prepare($query);
    // Execute statement
    $stmt->execute();
    return $stmt;
  }
}