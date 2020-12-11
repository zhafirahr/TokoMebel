<?php

$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'"); //ambil data
$pecah = $ambil->fetch_assoc(); //pecah data

$koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan='$_GET[id]'"); //hapus datanya
echo "<script>alert('pelanggan terhapus');</script>"; //tampilkan tulisan 'produk terhapus'
echo "<script>location='index.php?halaman=pelanggan';</script>"; //redirect ke 'index.php?halaman=produk

?>

