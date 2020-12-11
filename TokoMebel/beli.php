<?php

session_start();

//mendapatkan id_produk dari url
$id_produk = $_GET['id'];

//jika produk sudah ada di keranjang, maka jumlahnya di + 1
if(isset($_SESSION['keranjang'][$id_produk]))
{
	$_SESSION['keranjang'][$id_produk]+=1;
}
//jika produk belum ada di keranjang, maka jumlahnya 1
else
{
	$_SESSION['keranjang'][$id_produk] = 1;
}

//menuju halaman keranjang
echo "<script>alert('produk telah masuk ke keranjang belanja');</script>";
echo "<script>location='keranjang.php';</script>";

?>