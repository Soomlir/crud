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

  public function create($data)
  {
    try {
      $database = Database::getInstance();
      $this->db = $database->getConnection();

      $requiredFields = ['name', 'lastname', 'phone', 'email'];
      foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
          return "Field '$field' is required";
        }
      }

      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
      }

      $sql = "INSERT INTO clients (name, lastname, phone, email, address)
            VALUES (:name, :lastname, :phone, :email, :address)";

      $stmt = $this->db->prepare($sql);

      $name = $data['name'];
      $lastname = $data['lastname'];
      $phone = $data['phone'];
      $email = $data['email'];
      $address = $data['address'] ?? null;

      $stmt->bindParam(':name', $name);
      $stmt->bindParam(':lastname', $lastname);
      $stmt->bindParam(':phone', $phone);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':address', $address);

      $result = $stmt->execute();

      if ($result) {
        return true;
      } else {
        return "Failed to create client";
      }
    } catch (PDOException $e) {
      if ($e->getCode() == 23000) {
        return "Email address already exists";
      }
      return "Database error: " . $e->getMessage();
    }
  }

  public function getById($id)
  {
    try {
      $database = Database::getInstance();
      $this->db = $database->getConnection();

      $stmt = $this->db->prepare("SELECT * FROM clients WHERE id = :id");
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      return false;
    }
  }

  public function edit($id, $data)
  {
    try {
      $database = Database::getInstance();
      $this->db = $database->getConnection();

      $requiredFields = ['name', 'lastname', 'phone', 'email'];
      foreach ($requiredFields as $field) {
        if (empty($data[$field])) {
          return "Field '$field' is required";
        }
      }

      if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format";
      }

      $checkStmt = $this->db->prepare("SELECT id FROM clients WHERE email = :email AND id != :id");
      $checkStmt->bindParam(':email', $data['email']);
      $checkStmt->bindParam(':id', $id, PDO::PARAM_INT);
      $checkStmt->execute();

      if ($checkStmt->fetch()) {
        return "Email address already exists for another client";
      }

      $sql = "UPDATE clients
            SET name = :name, lastname = :lastname, phone = :phone,
                email = :email, address = :address
            WHERE id = :id";

      $stmt = $this->db->prepare($sql);

      $params = [
        ':id' => $id,
        ':name' => $data['name'],
        ':lastname' => $data['lastname'],
        ':phone' => $data['phone'],
        ':email' => $data['email'],
        ':address' => $data['address'] ?? null
      ];

      $result = $stmt->execute($params);

      if ($result && $stmt->rowCount() > 0) {
        return true;
      } else {
        return "Failed to update client or no changes made";
      }
    } catch (PDOException $e) {
      return "Database error: " . $e->getMessage();
    }
  }

  public function delete($id)
  {
    try {
      $database = Database::getInstance();
      $this->db = $database->getConnection();

      if (!is_numeric($id) || $id <= 0) {
        return "Invalid client ID";
      }

      $sql = "DELETE FROM clients WHERE id = :id";

      $stmt = $this->db->prepare($sql);

      $stmt->bindParam(':id', $id, PDO::PARAM_INT);

      $result = $stmt->execute();

      if ($result && $stmt->rowCount() > 0) {
        return true;
      } else {
        return "Client not found or already deleted";
      }
    } catch (PDOException $e) {
      return "Database error: " . $e->getMessage();
    }
  }
}
