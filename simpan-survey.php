<?php
	if (!session_id()) {
		session_start();
	}
	date_default_timezone_set("Asia/Jakarta");
	require_once '../koneksi.php';
	
	$survey = json_decode($_POST["survey"], true);
	$survey_pertanyaan = json_decode($_POST["survey_pertanyaan"], true);

	$id_level_responden = count($survey["responden"]);
	if (isset($_FILES['image'])) {
		$img = $_FILES['image'];
		$cek = [];
		end($img['size']);
		$last = key($img['size']);
		reset($img['size']);
		$first = key($img['size']);
		for ($i=$first; $i <=$last ; $i++) { 
			if (isset($img['name'][$i])) {
				$allowExt = array("jpeg", "jpg", "png","JPG","PNG","JPEG");
				$fileType = array("image/png","image/jpg","image/jpeg");
				$expExt = explode(".", $img["name"][$i]); 
				$ext = end($expExt);
				if(in_array($img["type"][$i],$fileType) && $img["size"][$i]<1000000 && in_array($ext,$allowExt)){
					if ($img["error"][$i] > 0){
						$cek[$i]['pesan'] = "Error : ".$img["error"][$i];
						$cek[$i]['index'] = $i;
					} else {
						if (file_exists("upload/" . $img["name"][$i])) {
							$cek[$i]['pesan'] = $img["name"][$i]."File Pernah Diupload";
							$cek[$i]['index'] = $i;
						} else {
							$sourcePath = $img['tmp_name'][$i];
							$targetPath = "img/".$img['name'][$i]; 
							move_uploaded_file($sourcePath,$targetPath) ; 
						};
					}
				} else {
					$cek[$i]['pesan'] = "Format atau Ukuran tidak sesuai";
					$cek[$i]['index'] = $i;
				} 
			}
		}
		if (isset($cek)) {
			print_r($cek);
		}
	}
	for ($i=count($survey["responden"])-1; $i>=0 ; $i--) { 
		if ($survey["responden"][array_keys($survey["responden"])[$i]] == 0) {
			$id_level_responden--;
		} else {
			break;
		}
	}

	if ($id_level_responden != 0) {
		$id_penempatan_responden = $survey["responden"][array_keys($survey["responden"])[$id_level_responden-1]];
	} else {
		$id_penempatan_responden = 0;
	}

	$dateTime = new DateTime();
	$waktu_pembuatan = $dateTime->format("Y-m-d H:i:s");

	$conn = new koneksi();
	$db = $conn->get_koneksi();
	$db->beginTransaction();
	$stmt = $db->prepare('INSERT INTO survey(id_author, judul, deskripsi, jumlah_pertanyaan, batas_pengisian, id_level_responden, id_penempatan_responden, waktu_pembuatan) VALUES(?, ?, ?, ?, ?, ?, ?, ?)');
	$stmt->bindParam(1, $_SESSION["nik"]);
	$stmt->bindParam(2, $survey["judul"]);
	$stmt->bindParam(3, $survey["deskripsi"]);
	$stmt->bindValue(4, count($survey_pertanyaan));
	$stmt->bindParam(5, $survey["batasWaktu"]);
	$stmt->bindParam(6, $id_level_responden);
	$stmt->bindParam(7, $id_penempatan_responden);
	$stmt->bindParam(8, $waktu_pembuatan);
	$stmt->execute();

	$id_survey = $db->lastInsertId();
	$stmt2 = $db->prepare('INSERT INTO survey_pertanyaan VALUES(?, ?, ?, ?, ?, ?)');
	for ($i=0; $i<count($survey_pertanyaan); $i++) { 
		$stmt2->bindParam(1, $id_survey);
		$stmt2->bindParam(2, $survey_pertanyaan[$i]["id"]);
		$stmt2->bindParam(3, $survey_pertanyaan[$i]["per"]);
		$stmt2->bindParam(4, $survey_pertanyaan[$i]["kat"]);
		$stmt2->bindValue(5, 0);
		$stmt2->bindValue(6, serialize($survey_pertanyaan[$i]["jaw"]));
		$stmt2->execute();
	}

	if ($db->commit()) {
		echo "berhasil";
	} else {
		$db->rollback();
		echo "gagal";
	}
?>