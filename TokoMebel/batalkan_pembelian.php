<?php

session_start();

//ambil id produk yg akan dihapus
$id_produk = $_GET["id"];
unset($_SESSION["keranjang"][$id_produk]);

echo "<script>alert('Produk dihapus dari keranjang');</script>";
echo "<script>location='keranjang.php';</script>";

?>