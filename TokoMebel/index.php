<?php
session_start();
//koneksi ke database
include 'koneksi.php';
?>

<!DOCTYPE html>

<html>

<head>
	<title> Toko Mebel </title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<!-- navbar -->
<?php include 'menu.php'; ?>

<!-- konten -->
<section class="konten">
	<div class="container">
		<h2> Produk Terbaru </h2>

		<div class="row">

			<?php $ambil = $koneksi->query("SELECT * FROM produk "); ?>
			<?php while($tiap_produk = $ambil->fetch_assoc()){ ?>
			<div class="col-md-3">
				<div class="thumbnail">
					<img src="foto_produk/<?php echo $tiap_produk['foto_produk']; ?>" alt="">
					<div class="caption">
						<h5><?php echo $tiap_produk['nama_produk']; ?></h5>
						<h6> Rp. <?php echo number_format($tiap_produk['harga_produk']); ?></h6>
						<a href="beli.php?id=<?php echo $tiap_produk['id_produk']; ?>" class="btn btn-primary"> Beli </a>
						<a href="detail.php?id= <?php echo $tiap_produk["id_produk"]; ?>" class="btn btn-default"> Detail </a>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>
</section>

</body>
</html>
