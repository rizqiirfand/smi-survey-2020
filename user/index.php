<?php 
	require_once '../koneksi.php';
	if (!session_id()) {
		session_start();
		$_SESSION["nik"] = '76349';
		$_SESSION["access"] = 'user';
	}
	require_once 'navbar.php';
	$conn = new koneksi();
	$db = $conn->get_koneksi();
 ?>

<head>
	<title>Halaman Surveyor</title>
	<style type="text/css">
		body{
			background-color: rgba(20, 29, 38, 1);
			}
		td{
			font-size: small;
			padding: 8px !important;
			text-align: left;
			}
		th{
			text-align: center;
			}


		@font-face {
			font-family: 'Lato-Black';
			src: url('../font/Lato-Black.ttf');
			}
		@font-face{
			  font-family:'Lato-Light';
			  src: url('../font/Lato-Light.ttf');
			}


		.font-Lato-Black{
			font-family: 'Lato-Black';
  	  		color: #FEF1AC;
		}
		.font-Lato-Light{
			font-family: 'Lato-Light';
  	  		color: #FEF1AC;
		}
		.card {
  			width: 80vw;
  			box-shadow: 0 4px 8px 0 rgba(255, 255, 255, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
		}

		.content {
			  margin-left: 0px; 
			  padding: 1px 16px;
			  height: auto;
		}
		.btn-lihat{
			border:1px solid white;
			background-color: #FEF1AC;
		}
		
		.gelap
		{
			color: #212529;
		}

		.vertical-scroll {
		  height: 65vh;
		  overflow-y: scroll;
		}

		


	</style>

</head>
<div class="container pt-3">
		<div class="content" id="surveyor">
			<h2 class="font-Lato-Black">List Survei</h2>
			<div class="d-flex justify-content-between mb-4 font-Lato-Black">
				<a href="buatform.php" class="btn btn-warning m-1" role="button" ><i class="fa fa-plus"></i> Buat Survei</a>
			</div>
			<div class="table-responsive-sm vertical-scroll">          
			  <table class="table table-bordered">
			    <thead class="font-Lato-Black">
			      <tr>
			        <th>Judul</th>
			        <th>Status</th>
			        <th>Responden</th>
			        <th>Lihat Detail</th>
			      </tr>
			    </thead>
			    <tbody class="font-Lato-Light">
			      <?php 
					$stmt = $db->prepare('SELECT * FROM survey WHERE id_author = ?');
					$stmt->bindParam(1, $_SESSION["nik"]);
					$stmt->execute();
					while ($res = $stmt->fetch()) {
?>
				      <tr>  
				        <td><?php echo $res["judul"]; ?></td>
				        <td>
<?php 
							$s = strtotime(date("Y-m-d"));
							$e = strtotime($res["batas_pengisian"]);
							$kdl = ($e-$s)/60/60/24;
							if ($res["status"]) {
								if ($kdl>0) {
								 	echo $kdl." Days Left";
								 } else {
								 	echo "Tidak Aktif";
								 }
							} else {
								echo "Survey Belum Disetujui";
							}
?>
						</td>
				        <td>
<?php 
							$stmt2 = $db->prepare('SELECT COUNT(*) AS total, COUNT(IF(status_pengisian=1 ,1,null)) AS finis FROM `survey_responden` WHERE id_survey = ?');
							$stmt2->bindParam(1, $res['id']);
							$stmt2->execute();
							$res2 = $stmt2->fetch();
							if ($res['status']) {
								echo "Total : ".$res2['total'].' / '.$res2['finis']." pengisi";
							} else {
								echo "-";
							}
							
 ?>
				        </td>
			        <td class="text-center">
			        	<button type="button" class="btn btn-secondary font-Lato-Light btn-lihat p-0 pr-4 pl-4 gelap" data-toggle="modal" data-target="<?php echo '#modal-'.$res['id'] ?>" <?php if (!$res['status']) echo "disabled"?>>Lihat</button>
<?php 
							if ($res['status']) {
?>
								<div class="modal fade" id="<?php echo 'modal-'.$res['id'] ?>">
								    <div class="modal-dialog modal-dialog-centered">
								      <div class="modal-content bg-dark">
								      
					<!-- Modal Header -->
					  					<div class="text-right">
								        	<button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fa fa-times"></i></button>
								        </div>
								        <div class="text-center">
								          <h4 class="modal-title font-Lato-Black "><?php echo $res['judul']; ?></h4>
								        </div>
								      
								        
					<!-- Modal body -->
								        <div class="modal-body">
											<div class="table-responsive-sm vertical-scroll">          
											  <table class="table table-bordered">
											    <thead class="font-Lato-Black">
											      <tr>
											        <th rowspan="2" style="vertical-align: middle;">No</th>
											        <th rowspan="2" style="vertical-align: middle;">Soal</th>
											        <th rowspan="2" style="vertical-align: middle;">Jenis Soal</th>
								<?php  
													$stmt2 = $db->prepare("SELECT user.nama FROM survey_responden INNER JOIN user ON survey_responden.id_responden = user.id WHERE survey_responden.id_survey = ? AND status_pengisian = 1");
													$stmt2->bindParam(1, $res['id']);
													$stmt2->execute();
													$colspan = $stmt2->rowCount();
								?>
											        <th colspan="<?php echo $colspan?>">Jawaban</th>
											      </tr>
											      <tr>
								<?php 
													while($res2 = $stmt2->fetch()){
								?>
														<th><?php echo $res2['nama'] ?></th>
								<?php
													} 
								?>
											      </tr>
											    </thead>
											    <tbody class="font-Lato-Light">
								<?php 
													$stmt2 = $db->prepare("SELECT * FROM survey_pertanyaan WHERE id_survey = ?");
													$stmt2->bindParam(1, $res['id']);
													$stmt2->execute();
													while ($res2 = $stmt2->fetch()) {
								 ?>
											      <tr>
											        <td><?php echo $res2['nomor'] ?></td>
											      	<td><?php echo $res2['pertanyaan'] ?></td>
											      	<td><?php echo $res2['jenis_pertanyaan'] ?></td>
								<?php 
														$stmt3 = $db->prepare("SELECT survey_responden_jawaban.array_jawaban FROM survey_responden INNER JOIN survey_responden_jawaban ON survey_responden.token = survey_responden_jawaban.id_token WHERE survey_responden.id_survey = ? AND survey_responden_jawaban.nomor = ?");
														$stmt3->bindParam(1, $res['id']);
														$stmt3->bindParam(2, $res2['nomor']);
														$stmt3->execute();
														while ($res3 = $stmt3->fetch()) {
								?>
															<td><?php echo $res3['array_jawaban']; ?></td>
								<?php
														}
								 ?>
											      </tr>
								<?php 
													}
								 ?>
											    </tbody>
											  </table>
											 </div>
								        </div>
								      </div>
								    </div>
								  </div>
<?php
							} else {
								echo "-";
							}
 ?>
			        </td>
			      </tr>
<?php  
											
					}
?> 
			    </tbody>
			  </table>
			 </div>
	</div>	
</div>





</body>
</html>