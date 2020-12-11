<?php

session_start();

//koneksi ke database
include 'koneksi.php';

?>

<!DOCTYPE html>
<html>
<head>
	<title> Login Pelanggan </title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>

<body>

<!-- navbar -->
<?php include 'menu.php'; ?>

<!--interface-->
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<!--form-->
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"> Login Pelanggan </h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group">
							<label> Email </label>
							<input type="email" class="form-control" name="email">
						</div>
						<div class="form-group">
							<label> Password </label>
							<input type="password" class="form-control" name="password">
						</div>
						<button class="btn btn-primary" name="login"> Login </button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>	

<?php 
// jika tombol login ditekan
if (isset($_POST["login"]))
{
	// masukkan var $email dan $password dgn inputan user
	$email = $_POST["email"];
	$password = $_POST["password"];

	//lakukan query mengecek akun di database tabel pelanggan
	$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE email_pelanggan='$email' AND password_pelanggan='$password'");

	//menghitung akun yg cocok dgn masukan
	$cocok = $ambil->num_rows;

	//jika yg cocok ada 1 maka
	if ($cocok==1)
	{
		//suskes login dan mendapatkan akun dlm bentuk array
		$akun = $ambil->fetch_assoc();
		//simpan di session pelanggan
		$_SESSION["pelanggan"] = $akun;
		echo "<script>alert('Anda berhasil login');</script>";

		// jika sudah belanja
		if (isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"]))
		{
			echo "<script>location='checkout.php';</script>";
		}
		else
		{
			echo "<script>location='riwayat.php';</script>";
		}	
	}
	else
	{
		//gagal login
		echo "<script>alert('anda gagal login, periksa kembali akun anda');</script>";
		echo "<script>location='login.php';</script>";
	}
}
?>	

</body>
</html>