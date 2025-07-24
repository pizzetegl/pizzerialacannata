<?php
namespace App\Controllers;

use App\Database;
use App\Exceptions\DatabaseException;

class MenuController {
  public function index() {
    try {
      $db = Database::get();
    } catch (DatabaseException $e) {
      echo $e->getMessage();
      return;
    }
    // Prendi categorie e piatti
    $stmt = $db->query("
      SELECT c.id AS cat_id, c.name AS cat_name,
             i.id AS item_id, i.name AS item_name,
             i.description, i.price, i.stock_status
      FROM menu_categories c
      JOIN menu_items i ON i.category_id = c.id
      ORDER BY c.name, i.name
    ");
    $rows = $stmt->fetchAll();

    // Organizza in un array nidificato
    $menu = [];
    foreach ($rows as $r) {
      $menu[$r['cat_name']][] = [
        'id'     => $r['item_id'],
        'name'   => $r['item_name'],
        'desc'   => $r['description'],
        'price'  => $r['price'],
        'stock'  => $r['stock_status'],
      ];
    }

    // Includi template
    include __DIR__ . '/../../templates/menu.php';
  }
}