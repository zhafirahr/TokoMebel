<?php include 'koneksi.php'; ?>
<?php 
$keyword = $_GET["keyword"];

$semua_data = array();
$ambil = $koneksi->query("SELECT * FROM produk WHERE nama_produk LIKE '%$keyword%' OR deskripsi_produk LIKE '%$keyword%'");

while ($pecah = $ambil->fetch_assoc())
{
	$semua_data[] = $pecah;
}

?>

<!DOCTYPE html>

<html>
<head>
	<title> Pencarian </title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<!-- navbar -->
<?php include 'menu.php'; ?>
	<div class="container">
		<h3> Hasil Pencarian = <?php echo $keyword ?> </h3>

		<?php if (empty($semua_data)): ?>
			<div class="alert alert-danger"> Produk <strong> <?php echo $keyword ?> </strong> tidak ditemukan </div>
		<?php endif ?>

		<div class="row">

			<?php foreach ($semua_data as $key => $value): ?>

			<div class="col-md-3">
				<div class="thumbnail">
					<img src="foto_produk/<?php echo $value["foto_produk"] ?>" alt="" class="img-responsive">
					<div class="caption">
						<h4> <?php echo $value["nama_produk"] ?> </h4>
						<h5> Rp. <?php echo number_format($value['harga_produk']) ?> </h5>
						<a href="beli.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-primary"> Beli </a>
						<a href="detail.php?id=<?php echo $value["id_produk"]; ?>" class="btn btn-default"> Detail </a>
					</div>
				</div>
			</div>

		<?php endforeach ?>

		</div>
	</div>

</body>
</html>