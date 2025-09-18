<?php

class Database
{
  private static $instance = null;
  private $connection;

  private $host;
  private $dbname;
  private $username;
  private $password;
  private $charset;

  private function __construct()
  {
    $this->loadConfig();
    $this->connect();
  }

  private function loadConfig(): void
  {
    $this->host = $_ENV['DB_HOST'] ?? 'MySQL-8.0';
    $this->dbname = $_ENV['DB_NAME'] ?? 'usersList';
    $this->username = $_ENV['DB_USER'] ?? 'root';
    $this->password = $_ENV['DB_PASSWORD'] ?? '';
    $this->charset = $_ENV['DB_CHARSET'] ?? 'utf8mb4';
  }

  private function connect(): void
  {
    try {
      $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

      $this->connection = new PDO($dsn, $this->username, $this->password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_STRINGIFY_FETCHES => false
      ]);
    } catch (PDOException $e) {
      throw new PDOException("Connection failed: " . $e->getMessage());
    }
  }

  public static function getInstance(): self
  {
    if (self::$instance === null) {
      self::$instance = new self();
    }

    return self::$instance;
  }

  public function getConnection(): PDO
  {
    return $this->connection;
  }
}
