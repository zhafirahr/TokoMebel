<?php

session_start();

//koneksi ke database
include 'koneksi.php';

//jika $_SESSION["pelanggan"] blm terisi, maka redirect ke login.php
if (!isset($_SESSION["pelanggan"]))
{
	echo "<script>alert('Silahkan login terlebih dahulu');</script>";
	echo "<script>location='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title> Checkout </title>
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
				</tr>
			</thead>

			<tbody>
				<?php $nomor=1; ?>
				<?php $total_belanja=0; ?>
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
				</tr>
				<?php $nomor++; ?>
				<?php $total_belanja+=$total_harga; ?>
				<?php endforeach?>

			</tbody>
			<tfoot>
				<tr>
					<th colspan="4"> Total Belanja </th>
					<th> Rp. <?php echo number_format($total_belanja) ?> </th>
				</tr>
			</tfoot>
		</table>

		<form method="post">

			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan'] ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telp_pelanggan'] ?>" class="form-control">
					</div>
				</div>
				<div class="col-md-4">
					<select class="form-control" name="id_ongkir">
						<option value=""> Pilih Ongkos Kirim </option>
						<?php
						$ambil = $koneksi->query("SELECT * FROM ongkos_kirim");
						while($satu_ongkir = $ambil->fetch_assoc()){
						?>
						<option value="<?php echo $satu_ongkir["id_ongkir"] ?>">
							<?php echo $satu_ongkir['nama_kota'] ?> -
							Rp. <?php echo number_format($satu_ongkir['tarif']) ?>
						</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label> Alamat Lengkap Pengiriman </label>
				<textarea class="form-control" name="alamat_pengiriman" placeholder="Masukkan alamat lengkap pengiriman dan kode pos"></textarea>
			</div>
			<button class="btn btn-primary" name="checkout"> Checkout </button>
		</form>

		<?php
		if (isset($_POST["checkout"]))
		{
			$id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
			$id_ongkir = $_POST["id_ongkir"];
			$tanggal_pembelian = date("Y-m-d");
			$alamat_pengiriman = $_POST['alamat_pengiriman'];

			$ambil = $koneksi->query("SELECT * FROM ongkos_kirim WHERE id_ongkir='$id_ongkir'");
			$data_ongkir = $ambil->fetch_assoc();
			$nama_kota = $data_ongkir['nama_kota'];
			$tarif = $data_ongkir['tarif'];

			$total_pembelian = $total_belanja + $tarif;

			// menyimpan data ke tabel pembelian
			$koneksi->query("INSERT INTO pembelian (id_pelanggan,id_ongkir,tanggal_pembelian,total_pembelian,nama_kota,tarif,alamat_pengiriman) VALUES ('$id_pelanggan','$id_ongkir','$tanggal_pembelian','$total_pembelian','$nama_kota','$tarif','$alamat_pengiriman')");

			// mendapatkan id pembelian yg barusan terjadi
			$id_pembelian_terakhir = $koneksi->insert_id;

			foreach ($_SESSION["keranjang"] as $id_produk => $jumlah_produk) 
			{

				// mendapatkan data produk berdasarkan id produk
				$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
				$tiap_produk = $ambil->fetch_assoc();

				$nama = $tiap_produk['nama_produk'];
				$harga = $tiap_produk['harga_produk'];
				$berat = $tiap_produk['berat_produk'];

				$sub_berat = $tiap_produk['berat_produk']*$jumlah;
				$sub_harga = $tiap_produk['harga_produk']*$jumlah;

				$koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,nama,harga,berat,sub_berat,sub_harga,jumlah_produk) VALUES ('$id_pembelian_terakhir','$id_produk','$nama','$harga','$berat','$sub_berat','$sub_harga','$jumlah_produk') ");

				// skrip update stok
				$koneksi->query("UPDATE produk SET stok_produk=stok_produk - $jumlah WHERE id_produk='$id_produk'");
			}

			// mengkosongkan keranjang belanja
			unset($_SESSION["keranjang"]);

			// tampilan dialihkan ke halaman nota, nota dari pembelian terakhir
			echo "<script>alert('Pembelian Berhasil Dilakukan');</script>";
			echo "<script>location='nota.php?id=$id_pembelian_terakhir';</script>";
		}

		?>

	</div>
</section>


</body>
</html>