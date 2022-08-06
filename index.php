<?php
	if (!session_id()) {
		session_start();
	}
	require_once 'koneksi.php';
	if (isset($_POST["login"]) && $_POST["login"] == 'login') {
		$conn = new koneksi();
		$db = $conn->get_koneksi();
		$stmt = $db->prepare('SELECT * FROM user WHERE id = ? AND password = sha1(?)');
		$stmt->bindParam(1, $_POST["nik"]);
		$stmt->bindParam(2, $_POST["password"]);
		$stmt->execute();
		if ($stmt->rowCount() == 1) {
			$_SESSION["nik"] = $_POST["nik"];
			$_SESSION["access"] = 'user';
			header('Location: user/');
		} else {
			$stmt = $db->prepare('SELECT * FROM admin WHERE username = ? AND password = sha1(?)');
			$stmt->bindParam(1, $_POST["nik"]);
			$stmt->bindParam(2, $_POST["password"]);
			$stmt->execute();
			if ($stmt->rowCount() == 1) {
				$_SESSION["nik"] = $_POST["nik"];
				$_SESSION["access"] = 'admin';
				header('Location: admin/');
			} else {
				echo '<script>alert("Username atau password salah!")</script>';
				// header('Location: index.php');
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Judul -->
	<title>Survei Semen Indonesia</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style-index.css">
</head>
<!-- Body -->
<body>
<!-- Navbar -->
	<nav class="navbar navbar-expand-sm bg-dark-nav justify-content-between pr-5 p-0 sticky-top">
<!-- LOGO -->
		<a class="navbar-brand" href="#">
			<img src="img/logo.gif" alt="Logo" class="logo brightness">
		</a>
<!-- Login Button -->
		<div>
			<div class="pr-4">
				<button type="button" class="btn font-Lato-Black btn-login" data-toggle="modal" data-target="#myModal">Login</button>	
			</div>
			
<!-- The Modal -->
			  <div class="modal fade" id="myModal">
			    <div class="modal-dialog modal-dialog-centered">
			      <div class="modal-content bg-modal">
			      
<!-- Modal Header -->
  					<div class="kanan pr-2">
			        	<button type="button" class="text-light tutup" data-dismiss="modal">&times;</button>
			        </div>
			        <div class="text-center">
			          <h4 class="modal-title font-Lato-Black ">LOG-IN</h4>
			        </div>
			      
			        
<!-- Modal body -->
			        <div class="modal-body">
			          <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
			          	<div class="form-group">
			          		<label for="nik" class="font-montserrat"> NIK </label>
			          		<input type="text" name="nik" class="form-control font-Lato-Light-abu" id="nik" placeholder="Masukkan NIK" required="" autofocus="">
			          	</div>
			          	<div class="form-group">
			          		<label for="password" class="font-montserrat">Password</label>
			          		<input type="password" name="password" class="form-control font-Lato-Light-abu" id="password" placeholder="Masukkan Password" required="">
			          	</div>
			          	<div class="form-group form-check font-Lato-Light-abu ">      					
      							<input class="form-check-input " type="checkbox" name="remember"> 
      							<label class="form-check-label">Remember me</label>
        						<a href="">Lupa Password?</a>
    					</div>
    					<div class="text-center">
    						<button type="submit" name="login" value="login" class="btn btn-modal">Login</button>
    					</div>

    					<!-- <div class="input-group input-group-prepend  ">
			          		<i class="fa fa-user"></i>
			          		<input type="text" class="form-control ml-2" placeholder="Username" id="usr" name="username">
			          		<div class="input-group-append">
        						<span href="#" class="fa fa-eye ml-2"></span>
      						</div>

      					</div> -->
    						
			          </form>
			        </div>
			        

			        
			      </div>
			    </div>
			  </div>
		</div>
		
	</nav>
	<section>
<!-- Jumbotron + Gambar-->
		<div class="bg-cover bg-overlay"></div>
<!-- Profile aplikasi -->		
		<div class="bg-shadows">
			<div>
				<h1 class="font-Lato-Black ">Software Survei Lokal Semen Indonesia</h1>
				<h5 class="font-Lato-Light text-center">Sebuah aplikasi yang memungkinan anda membuat form </br> survei dengan cepat dan mudah</h5>
<!-- Tombol Get Started -->
				<div class="text-center">
					<a href="#" class="btn btn-dark start">Get Started</a>	
				</div>
			</div>
		</div>
		<!-- <div class="sosmed">
			<span href="#" class="fa fa-facebook"></span>
			<span href="#" class="fa fa-google"></span>
			<span href="#" class="fa fa-twitter"></span>
		</div> -->

		
	</section>

</body>
</html>