<?php 
	require_once 'navbar.php';
 ?>

<head>
	<title>Survei Semen Indonesia</title>
	<style type="text/css">
		body{
			background-color: #141D26;

		}
		.card-header-jawaban3{
			background-color: transparent;
			padding: 20px;
		}
		.font-judul-survei{
			font-family: 'Montserrat-Regular';
			color: #FFFFFF;
			text-align: center;
			font-size: 20pt;
		}

		.font-deskripsi-survei{
			font-family: 'Montserrat-Regular';
			text-align: center;
			font-size: small;
			font-color: #304352;
		}
		.slidecontainer {
		  width: 100%;
		}

		.slider {
		  -webkit-appearance: none;
		  width: 100%;
		  height: 25px;
		  background: #d3d3d3;
		  outline: none;
		  opacity: 0.7;
		  -webkit-transition: .2s;
		  transition: opacity .2s;
		}

		.slider:hover {
		  opacity: 1;
		}

		.slider::-webkit-slider-thumb {
		  -webkit-appearance: none;
		  appearance: none;
		  width: 25px;
		  height: 25px;
		  background-image:linear-gradient(to right, #232526, #414345);
		  cursor: pointer;
		}

		.slider::-moz-range-thumb {
		  width: 25px;
		  height: 25px;
		  background: #4CAF50;
		  cursor: pointer;
		}

		.btn-submit{
			background-image:linear-gradient(240deg, #00b4db, #0083b0);
			border-radius: 20px;
			padding: auto;
		}

		.font-montserrat-putih{
			font-family: 'Montserrat-Regular';
		  	color: #FFFFFF;
		}

		.card-warna{
			background-image:linear-gradient(315deg,#0f0c29,#302b63, #24243e);
		}

		.card-body{	
			border: 1px dashed #FFF;
			margin:5px 0px;
			margin-left: 6px;
			color: white;

		}

		.card-text{
			background-color: rgba(255, 255, 255, 0.1);
		}

		.btn-jawaban{
		  width: 140px;
		  height: 45px;
		  font-family: 'Roboto-Light', sans-serif;
		  font-size: 11px;
		  text-transform: uppercase;
		  letter-spacing: 2.5px;
		  font-weight: 500;
		  color: #000;
		  background-color: #fff;
		  border: none;
		  border-radius: 45px;
		  box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
		  transition: all 0.3s ease 0s;
		  cursor: pointer;
		  outline: none;
		}

		.btn-jawaban:hover {
		  background-color: #2EE59D;
		  box-shadow: 0px 5px 10px rgba(46, 229, 157, 0.4);
		  color: #fff;
		  transform: translateY(-2px);
		}
		.wrap {
		  height: 100%;
		  display: flex;
		  align-items: center;
		  justify-content: center;
		}

		@font-face{
		  font-family:'Montserrat-Regular';
		  src: url('font/Montserrat-Regular.otf');
		}
		@font-face{
		  font-family:'Roboto-Light';
		  src: url('font/Roboto-Light.tff');
		}


	</style>
</head>


<div class="container pt-3">


	<section id="isi">
		<div class="card bg-card-buatform border-0 card-warna">
			<div class="card-header card-header-jawaban3 border-0">
				<h5 class="font-judul-survei">JUDUL SURVEI</h5>
				<h5 class="font-deskripsi-survei text-light">Deskripsi survei berupa hal-hal yang perlu dicantumkan dalam survei</h5>
			</div>


			<div class="row">
				<div class="col-sm-8">
					<div class="card-body p-0">
						<form action="">
							<div id="1" class=" card-text m-3 p-2 ">
								
								<div id="pertanyaan">
									<font>1.</font>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</div>
								<div class="jawaban">
									<textarea placeholder="Blablabla" rows="1" cols="30" name="jawaban" style="resize: both  !important; "></textarea>
								</div>
									
							</div>

						</form>
					</div>

				</div>

				<div class="col-sm-4 text-center ini-kelas-foto pt-4">
					<div style="width: 180px; height: 180px;background-image: linear-gradient( to right, #12c2e9, #c471ed, #f64f59); padding-top: 5vh;">
						<div style="color: #FFFFFF">
							Ini Foto
						</div>
					</div>
				</div>
				
			</div>


			<div class="row">
				<div class="col-sm-8">
					<div class="card-body p-0">
						<form action="">
							<div id="2" class="card-text m-3 p-2">

								<div id="pertanyaan">
									<font>2.</font>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</div>

								<div id="jawaban">
									<div class="radio">
									  <label><input type="radio" name="optradio">Option 1</label>
									</div>
									<div class="radio">
									  <label><input type="radio" name="optradio">Option 2</label>
									</div>
									<div class="radio">
									  <label><input type="radio" name="optradio">Option 3</label>
									</div>
									<div class="radio">
									  <label><input type="radio" name="optradio">Option 4</label>
									</div>						
								</div>
														
							</div>

						</form>
					</div>

				</div>
				<div class="col-sm-4 text-center ini-kelas-foto pt-4">
					<div style="width: 180px; height: 180px; background-image: linear-gradient(to right, #093028, #237a57); padding-top: 5vh;">
						<div style="color: #FFFFFF;">
							Ini Foto
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8">
					<div class="card-body p-0">
						<form action="">
							<div id="3" class="card-text m-3 p-2">

								<div id="pertanyaan">
									<font>2.</font>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</div>

								<div id="jawaban">
									<div class="checkbox">
									  <label><input type="checkbox" name="optradio">Option 1</label>
									</div>
									<div class="checkbox">
									  <label><input type="checkbox" name="optradio">Option 2</label>
									</div>
									<div class="checkbox">
									  <label><input type="checkbox" name="optradio">Option 3</label>
									</div>
									<div class="checkbox">
									  <label><input type="checkbox" name="optradio">Option 4</label>
									</div>						
								</div>
														
							</div>

						</form>
					</div>

				</div>
				<div class="col-sm-3 text-center pt-4">
					<div style="width: 180px; height: 180px; background-color: black;">
						<div style="color: #FFFFFF;">
							Ini Foto
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-8">
					<div class="card-body p-0">
						<form action="">
							<div id="4" class="card-text m-3 p-2">

								<div id="pertanyaan">
									<font>2.</font>
									Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
									tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
									quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
									consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
									cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
									proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
								</div>

								<div id="jawaban">
									<div class="slidecontainer">
										<p id="value2">Ini Valuenya</p>
										  <input type="range" oninput="value2.innerHTML=this.value" min="1" max="5" value="50" class="slider" id="myRange">
									</div>	    							
								</div>
														
							</div>

						</form>
					</div>

				
				</div>
				<div class="col-sm-4 text-center ini-kelas-foto pt-4">
					<div style="width: 180px; height: 180px; background-color: black; padding-top: 5vh;">
						<div style="color: #FFFFFF;">
							Ini Foto
						</div>
					</div>
				</div>
			</div>

			<div class="text-center p-3 wrap">
				<button class="btn btn-jawaban">Submit</button>
			</div>
		</div>
	
	</section>
</div>




</body>
</html>