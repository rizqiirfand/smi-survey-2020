<?php
	date_default_timezone_set("Asia/Jakarta");
	require_once '../koneksi.php';
	$conn = new koneksi();
	$db = $conn->get_koneksi();

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	if (isset($_POST['konfirmasi_terima'])) {

		require '../library/PHPMailer-master/Exception.php';
		require '../library/PHPMailer-master/PHPMailer.php';
		require '../library/PHPMailer-master/SMTP.php';

		$stmt = $db->prepare('SELECT id_level_responden, id_penempatan_responden, judul FROM survey WHERE survey.id = ?');
		$stmt->bindParam(1, $_POST['konfirmasi_terima']);
		$stmt->execute();
		$res = $stmt->fetch();

		if ($res["id_level_responden"] != 0 && $res["id_penempatan_responden"] != 0) {

			$stmt2 = $db->prepare('SELECT * FROM level WHERE level.id >= ?');
			$stmt2->bindParam(1, $res['id_level_responden']);
			$stmt2->execute();
			$res2 = $stmt2->fetchAll(PDO::FETCH_NUM);
			?>
		<div class="print_r">
			<?php print_r($res2);?>
			<br>---------------<br>
			<?php
			$i = 1;
			$sql = 'SELECT * FROM ';
			$sql .= $res2[$i][1];
			while (true) { 
				if ($i == count($res2)-1) {
					break;
				}
				$sql .= ' INNER JOIN ';
				$sql .= $res2[$i+1][1];
				$sql .= ' ON ';
				$sql .= $res2[$i][1]. '.id = ';
				$sql .= $res2[$i+1][1].'.id_'.$res2[$i][1];
				$i++;
			}
			$sql .= ' WHERE id_'.$res2[0][1].' = '.$res["id_penempatan_responden"];
			
			$sql .= ' AND id_';
			$sql_temp = $sql;

			$mail = new PHPMailer(true);

			try {
			    $mail->isSMTP();
			    $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
			    $mail->SMTPAuth = true;
			    $mail->Username = 'aniksetyowati1215@gmail.com';   //username
			    $mail->Password = 'anik1215';   //password
			    $mail->SMTPSecure = 'ssl';
			    $mail->Port = 465;   

			    $mail->setFrom('aplikasisurvei@semenindonesia.com', 'Survei Semen Indonesia');

			    // $mail->addReplyTo('mokhamad.iqbal6@gmail.com', 'Mokhamad Iqbal');
			    // $mail->addCC('cc@example.com');
			    // $mail->addBCC('bcc@example.com');

			    // $mail->addAttachment('FLOW DIAGRAM SURVEY.png', 'flow.png');
			     
			    $mail->isHTML(true);
			     
			    $mail->Subject = 'Pengisian survei '.$res["judul"];

			    $db->beginTransaction();

				$stmt3 = $db->query('SELECT id, nama, email, id_level, id_penempatan FROM user');
				$stmt4 = $db->prepare('SELECT * FROM level WHERE id = ?');
				$stmt6 = $db->prepare('INSERT INTO survey_responden VALUES(?, ?, ?, ?, ?)');
				
				while ($res3 = $stmt3->fetch()) {
					if ($res3["id_level"] >= $res["id_level_responden"]) {
						$stmt4->bindParam(1, $res3["id_level"]);
						$stmt4->execute();
						$res4 = $stmt4->fetch();
						$sql = $sql_temp;
						$sql .= $res4["nama"];
						$stmt5 = $db->prepare($sql.' = ?');
						$stmt5->bindParam(1, $res3['id_penempatan']);
						$stmt5->execute();
						if ($stmt5->rowCount() > 1) {
							$token = '';
							$token .= sha1($_POST["konfirmasi_terima"].$res3['id']);
							$mail->ClearAllRecipients();
			    			$mail->addAddress($res3["email"], $res3["nama"]);
						    $mail->Body    = 'Halo, '.$res3["nama"].'. Silahkan mengisi survei <b>'.$res["judul"].'</b> pada link berikut. <a href="http://localhost/PI/smig_survey/SI-WebSurvei/jawabsurvey.php?id='.$token.'">Isi survei.</a>';
						    if ($mail->send()) {
						    	$stmt6->bindParam(1, $token);
						    	$stmt6->bindParam(2, $_POST["konfirmasi_terima"]);
						    	$stmt6->bindParam(3, $res3["id"]);
						    	$stmt6->bindValue(4, 0);
						    	$stmt6->bindValue(5, 1);
						    	$stmt6->execute();
						    	echo 'Berhasil mengirim ke '.$res3["id"].'<br>';
						    }
						} 
					}
				}

				$stmt7 = $db->prepare('UPDATE survey SET status = 1 WHERE id = ?');
				$stmt7->bindParam(1, $_POST["konfirmasi_terima"]);
				if ($stmt7->execute()) {
					$db->commit();
				} else {
					$db->rollback();
				}
				$mail = null;
			} catch (Exception $e) {
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}

		} else {
			$mail = new PHPMailer(true);

			try {
			    $mail->isSMTP();
			    $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
			    $mail->SMTPAuth = true;
			    $mail->Username = 'aniksetyowati1215@gmail.com';   //username
			    $mail->Password = 'anik1215';   //password
			    $mail->SMTPSecure = 'ssl';
			    $mail->Port = 465;   

			    $mail->setFrom('aplikasisurvei@semenindonesia.com', 'Survei Semen Indonesia');

			    // $mail->addReplyTo('mokhamad.iqbal6@gmail.com', 'Mokhamad Iqbal');
			    // $mail->addCC('cc@example.com');
			    // $mail->addBCC('bcc@example.com');

			    // $mail->addAttachment('FLOW DIAGRAM SURVEY.png', 'flow.png');
			     
			    $mail->isHTML(true);
			     
			    $mail->Subject = 'Pengisian survei '.$res["judul"];

			    $db->beginTransaction();

				$stmt3 = $db->query('SELECT id, nama, email, id_level, id_penempatan FROM user');
				$stmt6 = $db->prepare('INSERT INTO survey_responden VALUES(?, ?, ?, ?, ?)');
				
				while ($res3 = $stmt3->fetch()) {
					$token = '';
					$token .= sha1($_POST["konfirmasi_terima"].$res3['id']);
					$mail->ClearAllRecipients();
	    			$mail->addAddress($res3["email"], $res3["nama"]);
				    $mail->Body    = 'Halo, '.$res3["nama"].'. Silahkan mengisi survei <b>'.$res["judul"].'</b> pada link berikut. <a href="http://localhost/PI/smig_survey/SI-WebSurvei/jawabsurvey.php?id='.$token.'">Isi survei.</a>';
				    if ($mail->send()) {
				    	$stmt6->bindParam(1, $token);
				    	$stmt6->bindParam(2, $_POST["konfirmasi_terima"]);
				    	$stmt6->bindParam(3, $res3["id"]);
				    	$stmt6->bindValue(4, 0);
				    	$stmt6->bindValue(5, 1);
				    	$stmt6->execute();
				    	echo 'Berhasil mengirim ke '.$res3["id"].'<br>';
				    }
				}

				$stmt7 = $db->prepare('UPDATE survey SET status = 1 WHERE id = ?');
				$stmt7->bindParam(1, $_POST["konfirmasi_terima"]);
				if ($stmt7->execute()) {
					$db->commit();
				} else {
					$db->rollback();
				}
				$mail = null;
			} catch (Exception $e) {
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}
		}



?>
<?php
			echo "<br>++++<br>";
?>
	</div>
<?php





	} else if (isset($_POST['konfirmasi_tolak'])) {

		$stmt = $db->prepare("UPDATE survey SET survey.status = 2 WHERE survey.id = ?");
		$stmt->bindParam(1, $_POST['konfirmasi_tolak']);
		if ($stmt->execute()) {
			echo "<script>alert('Survey dengan id ".$_POST['konfirmasi_tolak']." berhasil ditolak')</script>";
		}
		// echo $_POST['konfirmasi_tolak'];
	}
	require_once 'navbar.php';
 ?>

<head>
	<title>Admin Page ! ! !</title>
	<link rel="stylesheet" type="text/css" href="../css/style-admin-kelolasurvey.css">
	<style type="text/css">
		td{
			font-size: small;
			padding: 8px !important;
			text-align: left;
		}
		th{
			text-align: center;
		}
		.print_r{
			/*width: 100vw;*/
			/*height: 50vh;*/
			padding-top:130px;
			background-color: red;
			color: white;
			bottom:0;
			position: absolute;
			z-index: 1; 
		}
	</style>
</head>


<!-- The sidebar -->
<div class="sidebar">
  <a href="#news">Kelola Survei</a>
  <a href="#about">Kelola Surveyor</a>

</div>

<!-- Page content -->
<div class="content">
	<div class="table-responsive-sm vertical-scroll">          
	  <table class="table table-bordered">
	    <thead class="font-Lato-Black">
	      <tr>
	        <th>ID</th>
	        <th>Surveyor</th>
	        <th>Judul</th>
	        <th>Target Responden</th>
	        <th>Waktu Pembuatan</th>
	        <th>Lihat Detail</th>
	      </tr>
	    </thead>
	    <tbody class="font-Lato-Light">
<?php
	$stmt = $db->query('SELECT survey.*, user.nama FROM survey INNER JOIN user ON survey.id_author = user.id ORDER BY survey.status, survey.waktu_pembuatan');
	while ($res = $stmt->fetch()) {
?>
	      <tr>
	        <td><?php echo $res["id"]; ?></td>
	        <td><?php echo $res["nama"]; ?></td>
	        <td><?php echo $res["judul"]; ?></td>
	        <td>
<?php
				$stmt2 = $db->prepare('SELECT * FROM level WHERE id = ?');
				$stmt2->bindParam(1, $res["id_level_responden"]);
				$stmt2->execute();
				$res2 = $stmt2->fetch();
				if ($res2["id"] != 0) {
					$stmt3 = $db->prepare('SELECT * FROM '.$res2["nama"].' WHERE id = ?');
					$stmt3->bindParam(1, $res["id_penempatan_responden"]);
					$stmt3->execute();
					$res3 = $stmt3->fetch();
					$target_responden = strtoupper($res2["nama"]." ".$res3["nama"]);
				} else {
					$target_responden = strtoupper($res2["nama"]);
				}
					echo $target_responden;
?>
	        </td>
	        <td><?php echo $res["waktu_pembuatan"]; ?></td>
	        <td class="text-center">
	        	<button type="button" class="btn font-Lato-Light btn-lihat p-0 pr-4 pl-4 " data-toggle="modal" data-target="#modal-lihat-<?php echo $res['id']; ?>">Lihat</button>
	        	<!-- The Modal -->
			  <div class="modal fade" id="modal-lihat-<?php echo $res['id']; ?>">
			    <div class="modal-dialog modal-dialog-centered modal-lg">
			      <div class="modal-content bg-modal box-shadow" style="background-color: #141D26;">
			      
<!-- Modal Header -->
  					<div class="text-right pr-2">
			        	<button type="button" class="text-light tutup" style="background-color: transparent;" data-dismiss="modal">&times;</button>
			        </div>
			        <div class="text-center">
			          <h4 class="modal-title font-Lato-Black ">Detail Survei</h4>
			        </div>
			      
			        
<!-- Modal body -->
			        <div class="modal-body vertical-scroll-modal">
						<div class="table-responsive-sm">          
						  <table class="table table-bordered">
						    <tbody class="font-Lato-Black">
						      <tr>
						        <th>ID</th>
						        <td class="font-Lato-Light"><?php echo $res["id"]; ?></td>
						      </tr>
						      <tr>
						        <th>Surveyor</th>
						        <td class="font-Lato-Light"><?php echo $res["nama"]; ?></td>
						      </tr>
						      <tr>
						        <th>Judul</th>
						        <td class="font-Lato-Light"><?php echo $res["judul"]; ?></td>
						      </tr>
						      <tr>
						        <th>Deskripsi</th>
						        <td class="font-Lato-Light"><?php echo $res["deskripsi"]; ?></td>
						      </tr>
						      <tr>
						        <th style="width: 170px;">Jumlah Pertanyaan</th>
						        <td class="font-Lato-Light" ><?php echo $res["jumlah_pertanyaan"]; ?></td>
						      </tr>
						      <tr>
						        <th>Batas Pengisian</th>
						        <td class="font-Lato-Light"><?php echo $res["batas_pengisian"]; ?></td>
						      </tr>
						      <tr>
						        <th >Target Responden</th>
						        <td class="font-Lato-Light">
<?php
						if ($res["id_level_responden"] != 0) {
							echo $target_responden;
						} else {
							echo $target_responden;
						}
?>
						        </td>
						      </tr>
						      <tr>
						        <th>Waktu Pembuatan</th>
						        <td class="font-Lato-Light"><?php echo date("l, d-F-Y H:i:s", strtotime($res["waktu_pembuatan"])); ?></td>
						      </tr>
						  </tbody>
						</table>
					</div>
				</div>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
			<div class="modal-footer justify-content-center">
			  <div class="table table-responsive-sm table-borderless">
				<table class="table">
					<thead>
				      <tr>
<?php
			switch ($res["status"]) {
				case 0:
?>
				        <th class="font-Lato-Black status-menunggu">Status</th>
				        <td class="font-Lato-Black status-menunggu">Menunggu konfirmasi admin</td>
				      </tr>
				    </thead>
				  </table>
				 			<button type="submit" class="btn btn-success btn-capsule-left" name="konfirmasi_terima" value="<?php echo $res['id']; ?>">Setuju</button>
				 			<button type="submit" class="btn btn-danger btn-capsule-right" name="konfirmasi_tolak-right" value="<?php echo $res['id']; ?>">Tolak</button>
<?php
					break;
				case 1:
?>
				        <th class=" font-Lato-Black status-disetujui">Status</th>
						<td class="font-Lato-Black status-disetujui">Survei disetujui</td>
				      </tr>
				    </thead>
				  </table>
<?php
					break;
				case 2:
?>
				        <th class="font-Lato-Black status-ditolak">Status</th>
						<td class="font-Lato-Black status-ditolak">Survei ditolak</td>
				      </tr>
				    </thead>
				  </table>
<?php
						break;
			}
?>
	
				      	</td>
				      </tr>
				</div>
			</div>
		</form>
				</div>

			</div>
		</div>
	</td>
</tr>

			        


<?php
	}
?>
					</tbody>
				</table>

			  </div>
			</div>


<!-- <div class="footer">
	<p>Copyright</p>
</div> -->



</body>
</html>