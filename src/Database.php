<?php
namespace App;

use PDO;
use App\Exceptions\DatabaseException;

class Database {
  private static ?PDO $instance = null;

  public static function get(): PDO {
    if (self::$instance === null) {
      $cfg = [
        'db_host' => getenv('DB_HOST') ?: null,
        'db_name' => getenv('DB_NAME') ?: null,
        'db_user' => getenv('DB_USER') ?: null,
        'db_pass' => getenv('DB_PASS') ?: null,
      ];

      if (in_array(null, $cfg, true)) {
        $file = getenv('DB_CONFIG_FILE');
        if ($file && file_exists($file)) {
          /** @noinspection PhpIncludeInspection */
          $fileCfg = include $file;
          if (is_array($fileCfg)) {
            $cfg = array_merge($cfg, $fileCfg);
          }
        }
      }

      foreach (['db_host', 'db_name', 'db_user', 'db_pass'] as $key) {
        if (empty($cfg[$key])) {
          throw new \RuntimeException("Database configuration '{$key}' missing");
        }
      }

      $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
                      $cfg['db_host'], $cfg['db_name']);

      try {
        self::$instance = new PDO($dsn, $cfg['db_user'], $cfg['db_pass'], [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
      } catch (\Throwable $e) {
        error_log('DB connection failed: ' . $e->getMessage());
        throw new DatabaseException('Errore di connessione al database.');
      }
    }
    return self::$instance;
  }
}