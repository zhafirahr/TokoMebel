<?php

$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'"); //ambil data
$pecah = $ambil->fetch_assoc(); //pecah data
$fotoproduk = $pecah['foto_produk']; //ambil foto

if (file_exists("../foto_produk/$fotoproduk")) //jika file ada di folder foto produk
{
	unlink("../foto_produk/$fotoproduk"); //hapus filenya
}

$koneksi->query("DELETE FROM produk WHERE id_produk='$_GET[id]'"); //hapus datanya
echo "<script>alert('produk terhapus');</script>"; //tampilkan tulisan 'produk terhapus'
echo "<script>location='index.php?halaman=produk';</script>"; //redirect ke 'index.php?halaman=produk

?>