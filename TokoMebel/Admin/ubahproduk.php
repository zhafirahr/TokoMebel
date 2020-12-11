<h2> Ubah Produk </h2>

<?php
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'"); //ambil data dari database
$pecah = $ambil->fetch_assoc(); //pecahin data

echo "<pre>";
print_r($pecah); //print data
echo "</pre>"; 
?>


<form method="post" enctype="multipart/form-data"> 
	<div class="form-group">
		<label> Nama Produk </label>
		<input type="text" name="nama" class="form-control" value="<?php echo $pecah['nama_produk']; ?>">
	</div>
	<div class="form-group">
		<label> Harga (Rp) </label>
		<input type="number" name="harga" class="form-control" value="<?php echo $pecah['harga_produk']; ?>">
	</div>
	<div class="form-group">
		<label> Berat (Gr) </label>
		<input type="number" name="berat" class="form-control" value="<?php echo $pecah['berat_produk']; ?>">
	</div>
	<div class="form-group">
		<label> Foto Produk </label> <br>
		<img src="../foto_produk/<?php echo $pecah['foto_produk'] ?>" width="200">
	</div>
	<div class="form-group">
		<label> Ganti Foto </label>
		<input type="file" name="foto" class="form-control">
	</div>
	<div class="form-group">
		<label> Deskripsi </label>
		<textarea name="deskripsi" class="form-control" rows="10">
			<?php echo $pecah['deskripsi_produk']; ?>
		</textarea>
	</div>
	<button class="btn btn-primary" name="ubah"> Ubah </button>
</form>


<?php
if (isset($_POST['ubah'])) //jika ada tombol ubah
{
	$namafoto = $_FILES['foto']['name']; //ambil foto
	$lokasifoto = $_FILES['foto']['tmp_name']; //letakkan foto di lokasi sementara

	if (!empty($lokasifoto)) //jika foto diubah ("$lokasifoto" tdk kosong)
	{
		move_uploaded_file($lokasifoto, "../foto_produk/$namafoto"); //upload foto dari $lokasifoto ke $namafoto
		//akses query untuk ubah data, ubah data yg sesuai id aja
		$koneksi->query("UPDATE produk SET nama_produk='$_POST[nama]', harga_produk='$_POST[harga]', berat_produk='$_POST[berat]', foto_produk='$namafoto', deskripsi_produk='$_POST[deskripsi]' WHERE id_produk='$_GET[id]'");
	}
	else
	{
		//akses query untuk ubah data, ubah data yg sesuai id aja
		$koneksi->query("UPDATE produk SET nama_produk='$_POST[nama]', harga_produk='$_POST[harga]', berat_produk='$_POST[berat]', foto_produk='$namafoto', deskripsi_produk='$_POST[deskripsi]' WHERE id_produk='$_GET[id]'");
	}

	// tampilkan tulisan 'data produk telah diubah' dilayar
	echo "<script>alert('data produk telah diubah');</script>";
	//redirect ke halaman produk.php
	echo "<script>location='index.php?halaman=produk';</script>";

}
?>