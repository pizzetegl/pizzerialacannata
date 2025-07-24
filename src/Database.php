<?php
namespace App;

use PDO;

class Database {
  private static ?PDO $instance = null;

  public static function get(): PDO {
    if (self::$instance === null) {
      $cfg = include __DIR__ . '/config.php';
      $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
                      $cfg['db_host'], $cfg['db_name']);
      self::$instance = new PDO($dsn, $cfg['db_user'], $cfg['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    }
    return self::$instance;
  }
}