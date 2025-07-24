<?php
namespace App\Controllers;

class CartController
{
    public function index()
    {
        session_start();
        $cart = $_SESSION['cart'] ?? [];
        // includi la view /templates/cart.php
        include __DIR__ . '/../../templates/cart.php';
    }

    public function add()
    {
        session_start();
        $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
        // prendi item e qty dal form
        $itemId = intval($_POST['item_id'] ?? 0);
        if ($itemId <= 0) {
            header('Location: ' . $basePath . '/');
            exit;
        }
        // inizializza carrello se manca
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        // aggiungi o incrementa
        if (isset($_SESSION['cart'][$itemId])) {
            $_SESSION['cart'][$itemId]++;
        } else {
            $_SESSION['cart'][$itemId] = 1;
        }
        // torna al carrello
        header('Location: ' . $basePath . '/cart');
        exit;
    }
}