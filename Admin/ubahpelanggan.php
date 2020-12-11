<h2> Ubah Pelanggan </h2>

<?php
$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'"); //ambil data dari database
$pecah = $ambil->fetch_assoc(); //pecahin data

echo "<pre>";
print_r($pecah); //print data
echo "</pre>"; 
?>


<form method="post"> 
	<div class="form-group">
		<label> Nama Pelanggan </label>
		<input type="text" name="nama" class="form-control" value="<?php echo $pecah['nama_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label> Nomor Telpon </label>
		<input type="text" name="telp" class="form-control" value="<?php echo $pecah['telp_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label> Email </label>
		<input type="text" name="email" class="form-control" value="<?php echo $pecah['email_pelanggan']; ?>">
	</div>
	<div class="form-group">
		<label> Password </label>
		<input type="password" name="passw" class="form-control" value="<?php echo $pecah['password_pelanggan']; ?>">
	</div>
	<button class="btn btn-primary" name="ubah"> Ubah </button>
</form>


<?php
if (isset($_POST['ubah'])) //jika ada tombol ubah
{
	//akses query untuk ubah data, ubah data yg sesuai id aja
	$koneksi->query("UPDATE pelanggan SET nama_pelanggan='$_POST[nama]', telp_pelanggan='$_POST[telp]', email_pelanggan='$_POST[email]', password_pelanggan='$_POST[passw]' WHERE id_pelanggan='$_GET[id]'");

	// tampilkan tulisan 'data produk telah diubah' dilayar
	echo "<script>alert('data pelanggan telah diubah');</script>";
	//redirect ke halaman produk.php
	echo "<script>location='index.php?halaman=pelanggan';</script>";

}
?>