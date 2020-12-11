﻿<?php
session_start(); //karen menyimpan akunnya di session
//skrip koneksi
$koneksi = new mysqli("localhost","root","","toko_mebel");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Binary Admin</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <h2> Toko Mebel : Login </h2>
               
                <h5>( Login yourself to get access )</h5>
                 <br />
            </div>
        </div>
         <div class="row ">
               
                  <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                        <strong>   Enter Details To Login </strong>  
                            </div>
                            <div class="panel-body">
                                <form role="form" method="post">
                                       <br />
                                     <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-tag"  ></i></span>
                                            <input type="text" class="form-control" name="user" />
                                        </div>
                                        <div class="form-group input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"  ></i></span>
                                            <input type="password" class="form-control"  name="pass" />
                                        </div>
                                    <div class="form-group">
                                            <label class="checkbox-inline">
                                                <input type="checkbox" /> Remember me
                                            </label>
                                            <span class="pull-right">
                                                   <a href="#" >Forget password ? </a> 
                                            </span>
                                        </div>
                                     
                                     <button class="btn btn-primary" name="login"> Login </button>
                                    <hr />
                                    Not register ? <a href="registeration.html" >click here </a> 
                                    </form>

                                    <?php
                                    if (isset($_POST['login'])) //jika tombol login dipencet
                                    {   
                                        // ambil data 
                                        $ambil = $koneksi->query("SELECT * FROM admin WHERE username='$_POST[user]' AND password='$_POST[pass]'");
                                        //melakukan pencarian user dan password yg cocok
                                        $cocok = $ambil->num_rows;

                                        //jika pasangan user dan password yg cocok ada 1
                                        if($cocok==1)
                                        {   
                                            //pecah data, simpan di $_SESSION(dia seorang admin)
                                            $_SESSION['admin']=$ambil->fetch_assoc();
                                            //tampilkan alert login berhasil
                                            echo "<div class='alert alert-info'> Login berhasil </div>";
                                            //redirect ke index.php
                                            echo "<meta http-equiv='refresh' content='1;url=index.php'>";
                                        }
                                        else
                                        {
                                            //tampilkan alert login gagal
                                            echo "<div class='alert alert-danger'> Login gagal </div>";
                                            //redirect ke login.php
                                            echo "<meta http-equiv='refresh' content='1;url=login.php'>";
                                        }
                                    }
                                    ?>
                            </div>
                           
                        </div>
                    </div>
                
                
        </div>
    </div>


     <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
