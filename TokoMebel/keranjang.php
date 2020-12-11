<?php

session_start();

//koneksi ke database
include 'koneksi.php';

//jika keranjang kosong
if(empty($_SESSION['keranjang']) OR !isset($_SESSION["keranjang"]))
{
	echo "<script>alert('Keranjang masih kosong');</script>";
	echo "<script>location='index.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Keranjang Belanja </title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>

<!-- navbar -->
<?php include 'menu.php'; ?>

<!-- tabel -->
<section class="konten">
	<div class="container">
		<h2> Keranjang Belanja </h2>
		<hr>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th> No </th>
					<th> Produk </th>
					<th> Harga </th>
					<th> Jumlah </th>
					<th> Total Harga </th>
					<th> Batalkan Pembelian </th>
				</tr>
			</thead>

			<tbody>
				<?php $nomor=1; ?>
				<!-- perulangan baris tabel sebanyak jumlah data produk -->
				<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?> 
				<!-- menampilkan produk berdasarkan id_produk -->
				<?php
				$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
				$pecah = $ambil->fetch_assoc();
				$total_harga = $pecah["harga_produk"]*$jumlah;
				?>
				<tr>
					<td> <?php echo $nomor; ?> </td>
					<td><?php echo $pecah["nama_produk"]; ?></td>
					<!-- number_format untuk penulisan koma2 di uang -->
					<td> Rp. <?php echo number_format($pecah["harga_produk"]); ?> </td>
					<td> <?php echo $jumlah; ?> </td>
					<td> Rp. <?php echo number_format($total_harga); ?> </td>
					<td>
						<a href="batalkan_pembelian.php?id=<?php echo $id_produk ?>" class="btn btn-danger btn-xs"> Hapus </a>
					</td>
				</tr>
				<?php $nomor++; ?>
				<?php endforeach?>

			</tbody>
		</table>

		<a href="index.php" class="btn btn-default"> Lanjut belanja </a><br><br>
		<a href="checkout.php" class="btn btn-primary"> Checkout </a>
	</div>
</section>
		

</body>
</html>