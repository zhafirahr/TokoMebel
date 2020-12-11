<?php 
session_start();
include 'koneksi.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title> Nota Pembelian </title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<!-- navbar -->
<?php include 'menu.php'; ?>

<section class="konten">
	<div class="container">

	<!-- nota dicopas dari detail.php di admin-->
	<h2> Detail Pembelian </h2>

<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan ON pembelian.id_pelanggan=pelanggan.id_pelanggan WHERE pembelian.id_pembelian='$_GET[id]'");
$detail = $ambil->fetch_assoc();
?>

<!-- jika pelanggan yg beli != pelanggan yg login, maka dilarikan ke halaman riwayat.php-->
<!-- pelanggan yg beli == pelanggan yg login -->

<?php
// mendapatkan id pelanggan yang beli
$id_pelanggan_ygbeli = $detail["id_pelanggan"];

// mendapatkan id pelanggan yang login
$id_pelanggan_yglogin = $_SESSION["pelanggan"]["id_pelanggan"];

if ($id_pelanggan_ygbeli !== $id_pelanggan_yglogin)
{
	echo "<script>alert('Anda tidak dapat mengakses halaman');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}
?>

<div class="row">
	<div class="col-md-4">
		<h3> Pembelian </h3>
		<strong> No. Pembelian: <?php echo $detail['id_pembelian']; ?></strong> <br>
		Tanggal : <?php echo $detail['tanggal_pembelian']; ?> <br>
		Total   : Rp. <?php echo number_format($detail['total_pembelian']); ?> 
	</div>
	<div class="col-md-4">
		<h3> Pelanggan </h3>
		<strong><?php echo $detail['nama_pelanggan']; ?></strong> <br>
		<p>
			<?php echo $detail['telp_pelanggan']; ?> <br>
			<?php echo $detail['email_pelanggan']; ?> 
		</p>
	</div>
	<div class="col-md-4">
		<h3> Pengiriman </h3>
		<strong><?php echo $detail['nama_kota']; ?></strong> <br>
		Ongkos Kirim: Rp. <?php echo number_format($detail['tarif']); ?> <br>
		Alamat: <?php echo $detail['alamat_pengiriman'] ?>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Berat</th>
			<th>Jumlah</th>
			<th>Sub Berat</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
		<?php while($pecah = $ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td> Rp. <?php echo number_format($pecah['harga']); ?></td>
			<td><?php echo $pecah['berat']; ?> gr. </td>
			<td><?php echo $pecah['jumlah_produk']; ?></td>
			<td><?php echo $pecah['sub_berat']; ?> gr. </td>
			<td> Rp. <?php echo number_format($pecah['sub_harga']); ?></td>
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>

<div class="row">
	<div class="col-md-7">
		<div class="alert alert-info">
			<p>
				Silahkan melakukan pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?> ke <br>
				<strong> BANK BCA 123-456789-1234 AN. Toko Mebel </strong>
			</p>
		</div>
	</div>
</div>

	</div>
</section>


</body>
</html>