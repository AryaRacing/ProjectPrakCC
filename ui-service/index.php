<?php

require 'vendor/autoload.php';

$crudServiceUrl = 'https://<your-project-id>.appspot.com/gudang';

function getItems() {
    global $crudServiceUrl;
    $response = file_get_contents($crudServiceUrl);
    return json_decode($response, true);
}

$items = getItems();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Warung Madura</title>
</head>
<body>
    <h1>Daftar Barang di Gudang</h1>
    <ul>
        <?php foreach ($items as $item): ?>
            <li><?php echo htmlspecialchars($item['nama_barang']); ?> - Stok: <?php echo htmlspecialchars($item['stok']); ?> - Harga: <?php echo htmlspecialchars($item['harga_jual']); ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
