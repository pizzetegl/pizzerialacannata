<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <title>Il Tuo Menu</title>
  <link rel="stylesheet" href="/css/app.css">
</head>
<body>
  <h1>Menu</h1>
  <?php foreach ($menu as $category => $items): ?>
    <section>
      <h2><?= htmlspecialchars($category) ?></h2>
      <ul>
        <?php foreach ($items as $item): ?>
          <li>
            <strong><?= htmlspecialchars($item['name']) ?></strong>
            — €<?= number_format($item['price'],2,',','.') ?>
            <?php if ($item['stock'] !== 'available'): ?>
              <em>(Non disponibile)</em>
            <?php endif ?>
            <p><?= htmlspecialchars($item['desc']) ?></p>
            <?php if ($item['stock'] === 'available'): ?>
              <form method="post" action="cart/add">
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
                <button type="submit">Aggiungi al carrello</button>
              </form>
            <?php endif ?>
          </li>
        <?php endforeach ?>
      </ul>
    </section>
  <?php endforeach ?>
</body>
</html>