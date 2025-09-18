<?php
require_once __DIR__ . '/../config/Database.php';

class Post
{
  private $db;

  public function show()
  {
    $database = Database::getInstance();
    $this->db =  $database->getConnection();

    $stmt = $this->db->prepare("SELECT * FROM clients");
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $users;
  }


  public function getTotalCount()
  {
    $database = Database::getInstance();
    $this->db =  $database->getConnection();

    $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM clients");
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
  }

  public function getPaginated($offset, $records_per_page)
  {
    $database = Database::getInstance();
    $this->db =  $database->getConnection();

    $stmt = $this->db->prepare("SELECT * FROM clients LIMIT :offset, :limit");
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->bindValue(':limit', (int)$records_per_page, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create() {}

  public function edit() {}

  public function delete() {}
}
