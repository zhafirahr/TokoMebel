<?php

session_start();

//koneksi ke database
include 'koneksi.php';

$id_pembelian = $_GET["id"];

$ambil = $koneksi->query("SELECT * FROM pembayaran 
	LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian
	WHERE pembelian.id_pembelian='$id_pembelian'");
$det_bay = $ambil->fetch_assoc();

// jika blm ada data pembayaran
if (empty($det_bay))
{
	echo "<script>alert('Belum ada data pembayaran');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}

// jika data pelanggan yg membayar !== yg login
if ($_SESSION["pelanggan"]['id_pelanggan']!==$det_bay["id_pelanggan"])
{
	echo "<script>alert('Anda tidak dapat mengakses halaman');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<title> Lihat Pembayaran </title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

	<?php include 'menu.php'; ?>

	<div class="container">
		<h3> Lihat Pembayaran </h3>
		<div class="row">
			<div class="col-md-6">
				<table class="table">
					<tr>
						<th> Nama </th>
						<td> <?php echo $det_bay["nama"] ?> </td>
					</tr>
					<tr>
						<th> Bank </th>
						<td> <?php echo $det_bay["bank"] ?> </td>
					</tr>
					<tr>
						<th> Tanggal </th>
						<td> <?php echo $det_bay["tanggal"] ?> </td>
					</tr>
					<tr>
						<th> Jumlah </th>
						<td> Rp. <?php echo number_format($det_bay["jumlah"]) ?> </td>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				<img src="bukti_pembayaran/<?php echo $det_bay["bukti"] ?>" alt="" class="img-responsive">
			</div>
		</div>
	</div>


<!-- navbar -->
<?php include 'menu.php'; ?>

</body>
</html>