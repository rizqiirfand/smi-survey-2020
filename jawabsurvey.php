<?php 
	require_once 'navbar.php';
	require_once 'koneksi.php';
	$conn = new koneksi();
	$db = $conn->get_koneksi();
	$db->beginTransaction();
	if (isset($_POST['submite'])) {
		print_r($_POST);
		$stmt = $db->prepare('UPDATE `survey_responden` SET `status_pengisian`=1 WHERE token = ?');
		$stmt->bindParam(1, $_GET['id']);
		$stmt->execute();
		$i=0;
		foreach ($_POST as $key => $value) {
			if ($key != 'submite') {
				$i++;
				if ($key == "Checkbox") {
					$jawaban = implode(",", $value);
				} else {
					$jawaban = $value;
				};
				$stmt = $db->prepare('INSERT INTO survey_responden_jawaban(`id_token`, `nomor`, `array_jawaban`) VALUES (?,?,?)');
				$stmt->bindParam(1, $_GET['id']);
				$stmt->bindParam(2, $i);
				$stmt->bindParam(3, $jawaban);
				$stmt->execute();
			}
		}
	}
	if ($db->commit()) {
	} else {
		$db->rollback();
	}
 ?>

<head>
	<title>Survei Semen Indonesia</title>
	<script type="text/javascript">
$(document).ready(function () {
    $('input[type=checkbox]').change(function () {

    	var idx = $(this).parents().parents().parents('.pilCheck').prevAll().length;
    	var idx = idx-1;
    	var inp = $('.pilCheck:eq('+idx+')>.checkbox>label>input[type="checkbox"]');
		if ($(this).prop('checked') == false) {
			if (inp.filter(':checked').length == 0) {
			inp.prop('required',true)
			}
		} else {
			
			if (inp.filter(':checked').length <= 1) { 
				inp.prop('required',false)
			}
		}
    })
});

</script>
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
		  background-color: #141D26;
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
			/*background-image:linear-gradient(315deg,#0f0c29,#302b63, #24243e);*/
			background-color: rgb(36,52,71);
		}

		.card-body{	
			border: 1px dashed #FFF;
			margin:5px 0px;
			margin-left: 6px;
			margin-right: 6px;
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

		.foto{
		  height: 100%;
		  display: flex;
		  align-items: center;
		  justify-content: center;
		  margin: 16px 0px;
		  text-align: center;
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


<div class="container pt-3 pb-3">


	<section id="isi">
		<form method="post">
		<div class="card bg-card-buatform border-0 card-warna">
<?php
			$stmt = $db->prepare('SELECT * FROM survey_responden WHERE token = ?');
			$stmt->bindParam(1, $_GET['id']);
			$stmt->execute();
			$res = $stmt->fetch();
			
			$id_survey = $res['id_survey'];

			$stmt = $db->prepare('SELECT judul,deskripsi FROM survey WHERE id = ?');
			$stmt->bindParam(1, $id_survey);
			$stmt->execute();
			$res = $stmt->fetch();

			$judul = $res['judul'];
			$deskripsi = $res['deskripsi'];

			$stmt2 = $db->prepare('SELECT * FROM survey_pertanyaan WHERE id_survey = ? ');
			$stmt2->bindParam(1, $id_survey);
			$stmt2->execute();
?>
			<div class="card-header card-header-jawaban3 border-0">
				<h5 class="font-judul-survei"><?php echo $judul; ?></h5>
				<h5 class="font-deskripsi-survei text-light"><?php echo $deskripsi; ?></h5>
			</div>


			
<?php 
				$i = 0;
				while($res2 = $stmt2->fetch()) { 
?>
			<div class="row pt-3">
				<div class="col-sm-8">
					<div class="card-body p-0">	
						<div id="1" class=" card-text m-3 p-2 ">
							<div id="pertanyaan">
								<font><?php echo $res2['nomor']?></font>
								<?php echo $res2['pertanyaan']; ?>
							</div>
<?php  
							$pilihan = unserialize($res2['array_option']);
							if ($res2['jenis_pertanyaan'] == 'Pilihan') {
?>
								<div id="jawaban wrap">
<?php  
								foreach ($pilihan as $val) {
?>
									<div class="radio">
									  <label><input type="radio" name="pilihan" required="" value="<?php echo $val ?>"><?php echo $val ?></label>
									</div>
<?php
								}
?>					
								</div>
<?php
							} elseif ($res2['jenis_pertanyaan'] == 'Checkbox') {
?>
								<div class="pilCheck">
<?php  
								foreach ($pilihan as $val) {
?>
									<div class="checkbox">
									  <label><input type="checkbox" name="Checkbox[]" required="" value="<?php echo $val ?>"><?php echo $val ?></label>
									</div>
<?php
								}
?>					
								</div>

								

<?php								# code...
							} elseif ($res2['jenis_pertanyaan'] == 'Range') {
?>
								<div id="jawaban">
									<div class="slidecontainer">		
										<div style="width: 30px; height: 30px;border-top-right-radius: 20px; border-top-left-radius: 20px; background: #d3d3d3; margin:0px auto;">
											<p style="color: black; text-align: center; vertical-align: middle;" id="value2"><?php echo $pilihan[0]/2+1; ?></p>
										</div>
										  <input  type="range" oninput="value2.innerHTML=this.value" min="1" max="<?php echo $pilihan[0]; ?>" class="slider" name="myRange" required="">
									</div>	    							
								</div>
<?php
							} elseif ($res2['jenis_pertanyaan'] == 'Essay'){
?>
								<div class="jawaban wrap justify-content-start ">
									<textarea placeholder="Blablabla" rows="1" cols="30" name="jawaban" style="res2ize: both; width: 100%; !important; " required=""></textarea>
								</div>
<?php
							}
?>
								
						</div>
					</div>

				</div>

				<div class="col-sm-4 foto">
					<div style="width: 180px; height: 180px;  padding-top: 10vh;background-image: url(<?php echo "img/img_survey/".$id_survey.'/'.$i.'.'.$res2['gambar']; ?>);background-size : 100% 100%;"> 
					</div>
				</div>
			</div>		
<?php
				$i++;
				}
?>
				
			

			<div class="text-center p-3 wrap">
				<button name="submite" class="btn btn-jawaban">Submit</button>
			</div>
		</div>
		</form>
	</section>
</div>




</body>
</html>