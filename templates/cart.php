<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Carrello</title>
</head>
<body>
  <?php
  use App\Database;
  use App\Exceptions\DatabaseException;
  $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
  ?>
  <h1>Il tuo carrello</h1>
  <?php if (empty($cart)): ?>
    <p>Il carrello è vuoto. <a href="<?= $basePath ?>/">Torna al menu</a></p>
  <?php else: ?>
    <table>
      <tr><th>Piatti</th><th>Quantità</th><th>Prezzo unitario</th><th>Subtotale</th></tr>
      <?php
      // recupera i dettagli da DB
      try {
        $db = Database::get();
      } catch (DatabaseException $e) {
        echo $e->getMessage();
        return;
      }
      $total = 0;
      foreach ($cart as $itemId => $qty):
        $stmt = $db->prepare("SELECT name, price FROM menu_items WHERE id = ?");
        $stmt->execute([$itemId]);
        $item = $stmt->fetch();
        $sub = $item['price'] * $qty;
        $total += $sub;
      ?>
        <tr>
          <td><?= htmlspecialchars($item['name']) ?></td>
          <td><?= $qty ?></td>
          <td>€<?= number_format($item['price'],2,',','.') ?></td>
          <td>€<?= number_format($sub,2,',','.') ?></td>
        </tr>
      <?php endforeach; ?>
      <tr>
        <th colspan="3">Totale</th>
        <th>€<?= number_format($total,2,',','.') ?></th>
      </tr>
    </table>
    <p><a href="<?= $basePath ?>/">< Torna al menu</a> | <a href="<?= $basePath ?>/checkout">Procedi al checkout &gt;</a></p>
  <?php endif; ?>
</body>
</html>
