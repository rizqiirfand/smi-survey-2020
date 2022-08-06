<?php
	require_once '../koneksi.php';
	$conn = new koneksi();
	$db = $conn->get_koneksi();
	switch ($_POST["role"]) {
		case 'departemen':
			$stmt = $db->prepare('SELECT * FROM '.$_POST["role"].' WHERE id_bidang = ?');
			$stmt->bindParam(1, $_POST["id_bidang"]);
			break;
		case 'unit':
			$stmt = $db->prepare('SELECT * FROM '.$_POST["role"].' WHERE id_departemen = ?');
			$stmt->bindParam(1, $_POST["id_departemen"]);
			break;
	}
	$stmt->execute();
	echo '<option value=0 selected="">Semua '.$_POST["role"].'</option>';
	while ($res = $stmt->fetch()) {
		echo '<option value='.$res["id"].'>'.$res["nama"].'</option>';
	}
?>