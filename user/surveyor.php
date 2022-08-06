<?php 
	require_once '../koneksi.php';
	$id_survey = '1';
	$judul = 
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
		  height: 80vh;
		  overflow-y: scroll;
		}

		


	</style>

</head>
<div class="container pt-3">
	<!-- Card Body -->
	  	<!-- Page content -->
		<div class="content" id="surveyor">
			<h1 class="font-Lato-Black">Result Survei</h1>
			<div class="table-responsive-sm vertical-scroll">          
			  <table class="table table-bordered">
			    <thead class="font-Lato-Black">
			      <tr>
			        <th rowspan="2" style="vertical-align: middle;">No</th>
			        <th rowspan="2" style="vertical-align: middle;">Soal</th>
			        <th rowspan="2" style="vertical-align: middle;">Jenis Soal</th>
<?php  
					$stmt = $db->prepare("SELECT user.nama FROM survey_responden INNER JOIN user ON survey_responden.id_responden = user.id WHERE survey_responden.id_survey = ? AND status_pengisian = 1");
					$stmt->bindParam(1, $id_survey);
					$stmt->execute();
					$colspan = $stmt->rowCount();
?>
			        <th colspan="<?php echo $colspan?>">Jawaban</th>
			      </tr>
			      <tr>
<?php 
					while($res = $stmt->fetch()){
?>
						<th><?php echo $res['nama'] ?></th>
<?php
					} 
?>
			      </tr>
			    </thead>
			    <tbody class="font-Lato-Light">
<?php 
					$stmt = $db->prepare("SELECT * FROM survey_pertanyaan WHERE id_survey = ?");
					$stmt->bindParam(1, $id_survey);
					$stmt->execute();
					while ($res = $stmt->fetch()) {
 ?>
			      <tr>
			        <td><?php echo $res['nomor'] ?></td>
			      	<td><?php echo $res['pertanyaan'] ?></td>
			      	<td><?php echo $res['jenis_pertanyaan'] ?></td>
<?php 
						$stmt2 = $db->prepare("SELECT survey_responden_jawaban.array_jawaban FROM survey_responden INNER JOIN survey_responden_jawaban ON survey_responden.token = survey_responden_jawaban.id_token WHERE survey_responden.id_survey = ? AND survey_responden_jawaban.nomor = ?");
						$stmt2->bindParam(1, $id_survey);
						$stmt2->bindParam(2, $res['nomor']);
						$stmt2->execute();
						while ($res2 = $stmt2->fetch()) {
?>
							<td><?php echo $res2['array_jawaban']; ?></td>
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





</body>
</html>