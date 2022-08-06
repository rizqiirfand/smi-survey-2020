<?php 
	require_once 'koneksi.php';
	require_once 'navbar.php';
 ?>

<head>
	<title>Survei Semen Indonesia</title>
	<link rel="stylesheet" type="text/css" href="css/style-buatform.css">

	<script type="text/javascript" src="js/role-responden.js"></script>
	<script type="text/javascript">
		var bodyEssay = '<div class="body"></div>'
		var essay = '<div class="formSoal"><div class="header"><input type="text" name="perSurvey" placeholder="Pertanyaan" required="">				<button id="btnUpImgc">img</button><select class="kategori" ><option value="essay">essay</option>					<option value="mulitpleChoice">mulitpleChoice</option></select></div>'+bodyEssay+' <div class="footer"><button type="button" class="btnHapus">Hapus</button></div>	</div>'
		var divMulti = '<div class="jawaban"> <input type="text" name="jawSurvey" required="">	</div>'
		var bodyMulti = '<div class="body"><div class="contentJaw">'+divMulti+divMulti+'</div> <div class="button CRUD">	<button type="button" class="btnTM">Tambah</button> 	</div></div>'
		var mulitpleChoice = '<div class="formSoal">			<div class="header">				<input type="text" name="perSurvey" placeholder="Pertanyaan" required="">				<button class="btnUpImg">img</button>				<select class="kategori">					<option value="essay">essay</option>					<option value="mulitpleChoice" selected>mulitpleChoice</option>		</select>			</div>	'+bodyMulti+'<div class="footer"><button type="button" class="btnHapus">Hapus</button></div></div>'
		var arr = []
		var arrDesk = []
		$(document).ready(function(){

			$(document).on('submit', '#formSurvey', function(){
				$.ajax
			})

			$(document).on('change', 'input[name=judul]', function(){
				arrDesk['judul'] = $('input[name=judul]').val()
			})
			
			$(document).on('change', 'input[name=deskripsi]', function(){
				arrDesk['deskripsi'] = $('input[name=deskripsi]').val()
			})
			
			$(document).on('change', 'select[name=responden]', function(){
				arrDesk['responden'] = $('select[name=responden]').val()
			})

			$(document).on('change', 'input[name=batasWaktu]', function(){
				arrDesk['batasWaktu'] = $('input[name=batasWaktu]').val()
			})

			$(document).on('click', '.btnNext', function(){
				createPanel($('.formSoal').eq(($('.formSoal').length)-1).find('.kategori').val())
			})
			$(document).on('change','.kategori', function(){
				updateKat(
					$('.kategori').index(this),
					$(this).val()
					)
			})
			$(document).on('input','input[name=perSurvey]', function(){
				updatePer(
					$('input[name=perSurvey]').index(this),
					$(this).val()
					)
			})
			$(document).on('input','input[name=jawSurvey]', function(){
				updateJaw(
					$(this).parent().parent().parent().parent().prevAll().length,
					$(this).closest('.formSoal').find('input[name=jawSurvey]').index(this),
					$(this).closest('.formSoal').find('input[name=jawSurvey]').eq(
						$(this).closest('.formSoal').find('input[name=jawSurvey]').index(this)).val()
					)
				})
			$(document).on('click','.btnHapus', function(){
				deletePanel($('.btnHapus').index(this))
			})
			$(document).on('click','.btnHM', function(){
				deleteMulti(
					$(this).parent().parent().parent().parent().prevAll().length,
					$(this).closest('.formSoal').find('.btnHM').index(this)
					)
			})
			$(document).on('click','.btnTM', function(){
				createMulti($(this).parent().parent().parent().prevAll().length)
			})
		})
		
		function showPanel(){
			$('#panelHome').children().remove()
			$('#panelSoal').children().remove()
			$('#panelSoal').append(essay)
		}

		function deleteMulti(add,val){
			var idx = '.formSoal:eq('+add+')'
			$(idx+'>.body>.contentJaw>.jawaban').closest('.formSoal').find('.jawaban').eq(val).remove()
			if ($(idx+'>.body>.contentJaw>.jawaban').length == 2) { 
				$(idx+'>.body>.contentJaw>.jawaban>.btnHM').remove()
			}
			arr[add]['jaw'].splice(val,1)
		}
		function createMulti(val){
			var idx = '.formSoal:eq('+val+')'
			var no = $(idx+'>.body>.contentJaw>.jawaban').length
			$(idx+'>.body>.contentJaw').append(divMulti)
			if (no == 2) {
				$(idx+'>.body>.contentJaw>.jawaban').append('<button type="button" class="btnHM">Hapus</button>')
			}
			if (no >= 3) {
				$(idx+'>.body>.contentJaw>.jawaban').eq(no).append('<button type="button" class="btnHM">Hapus</button>')
			}
		}

		function deletePanel(val){
			$('.formSoal').eq(val).animate({opacity: '0',height:'0'},300,function(){$(this).remove()})
			arr.splice(val,1)
		}

		function updateJaw(idxForm,idxJaw,val){
			arr[idxForm]['jaw'][idxJaw] = val
		}

		function createPanel(val){
			var no =arr.length+1
			if (val=='essay') {
				var arrTemp = {id : no,per : '',kat : 'essay',jaw : []}
				arr.push(arrTemp)
				$('#panelSoal').append(essay)
			} else if (val=='mulitpleChoice') {
				var arrTemp = {id : no,per : '',kat : 'mulitpleChoice',jaw : ['','']}
				arr.push(arrTemp)
				$('#panelSoal').append(mulitpleChoice)
			} else if(val == null){
				var arrTemp = {id : no,per : '',kat : 'essay',jaw : []}
				arr.push(arrTemp)
				$('#panelSoal').append(essay)
			}
		}
		function updateKat(idx,add){
			if (add=='essay') {
				arr[idx]['kat'] = 'essay'
				arr[idx]['jaw'] = []
				$('.formSoal:eq('+idx+')>.body').replaceWith(bodyEssay)
			} else if (add=='mulitpleChoice') {
				arr[idx]['kat'] = 'mulitpleChoice'
				arr[idx]['jaw'] = []
				$('.formSoal:eq('+idx+')>.body').replaceWith(bodyMulti)
			}
		}
		function updatePer(idx,add){
			arr[idx]['per'] = add
		}
		function send(){
			console.table(arrDesk)
		}
	</script>

</head>



<div class="container">
		<div class="card-deck pt-3">
  			<div class="card bg-card-buatform">
    			<div class="card-body text-center">
      			<form action="">
      				<div class="form-group">
      					<input type="text" class="form-control-plaintext underline" placeholder="Masukkan Judul Survei" name="judul">
    				</div>
    				<div class="form-group">
      					<input type="text" class="form-control-plaintext underline" placeholder="Masukkan Deskripsi" name="deskripsi">
    				</div>
    				<div class="form-group">
  						<input class="form-control-plaintext underline" type="date" name="bday">
					</div>
    				<div class="form-group">
<div style="position: absolute; z-index: 1; margin-top: -200px; margin-left: -100px; background-color: green; color: white; font-size: 12px; width: 100vw; height: 100vh;">
<?php
	$conn = new koneksi();
	$db = $conn->get_koneksi();
	$stmt = $db->query('SELECT * FROM level');
	$res = $stmt->fetchAll();;
	// while ($res = $stmt->fetch()) {
	echo '<br>----<br>';
	print_r($res);

	for ($i=0; $i<count($res)-1; $i++) { 
		// for ($j=0; $j<count($res[$i]); $j++) { 
		echo "<br>//////";
		echo $res[$i][1];	
		$stmt2 = $db->prepare('SELECT * FROM '.$res[$i][1]);
		$stmt2->execute();
		while ($res2 = $stmt2->fetch()) {
			echo "<br>%%%%%";
			print_r($res2);
			$stmt3 = $db->prepare('SELECT * FROM '.$res[$i+1][1].' WHERE id_'.$res[$i][1].' = ?');
			$stmt3->bindParam(1, $res2["id"]);
			$stmt3->execute();
			while ($res3 = $stmt3->fetch()) {
				echo "<br>@@@@@@@@@@";
				print_r($res3);
			}
		}

		// }
	}

	// }
echo '<br>';
	$conn = new koneksi();
	$db = $conn->get_koneksi();
	$stmt = $db->query('SELECT * FROM level');
	while ($res = $stmt->fetch()) {
		echo '<select id="role-responden-'.$res['nama'].'">
				<option disabled selected>Pilih '.$res["nama"].'</option>';
		$stmt2 = $db->prepare('SELECT * FROM '.$res["nama"]);
		$stmt2->execute();
		while ($res2 = $stmt2->fetch()) {
			echo '<option value='.$res2["id"].'>'.$res2["nama"].'</option>';
		}
		echo "</select>";
	}


	for ($i=0; $i<count($res)-1; $i++) { 
		// for ($j=0; $j<count($res[$i]); $j++) { 
		echo "<br>//////";
		echo $res[$i][1];	
		$stmt2 = $db->prepare('SELECT * FROM '.$res[$i][1]);
		$stmt2->execute();
		while ($res2 = $stmt2->fetch()) {
			echo "<br>%%%%%";
			print_r($res2);
			$stmt3 = $db->prepare('SELECT * FROM '.$res[$i+1][1].' WHERE id_'.$res[$i][1].' = ?');
			$stmt3->bindParam(1, $res2["id"]);
			$stmt3->execute();
			while ($res3 = $stmt3->fetch()) {
				echo "<br>@@@@@@@@@@";
				print_r($res3);
			}
		}

		// }
	}

?>
</div>
  						<select class="form-control underline" id="sel1" name="responden">
  							<option disabled="" selected="">Pilih Role </option>
   						 	<option value=>Ketupel</option>
    						<option>Sekertaris</option>
    						<option>Bendahara</option>
    						<option>Anggota</option>
  						</select>
					</div>


    			</div>
    			
					<div class="form-group text-center pb-1">
    					<button class="btn btn-buat font-montserrat-putih" style="">Buat</button>
    				</div>
      			</form>
			</div>
    	</div>
</div>



<section id="pertanyaan-essay">
	<div class="container">
		<div class="card-deck pt-5">
			<div class="card bg-card-buatform">
				<div class="card-body">
					<h4 class="text-center font-montserrat-hitam">JUDUL SURVEI</h4>
					<h6 class="text-center font-montserrat-hitam">Ini adalah deskripsi survei</h6>

					
						<div class="header row">
							<input id="gambar" type="file" class="form-control-file " name="file">
							<span class="rounded-gambar text-center col-sm-2 icon" >
								<a class="fa fa-file-photo-o pointer ukuran" onclick="gambar.click()"></a>
							</span>

							<div class="form-group col-sm-6">
								<label>No.1</label>
	      						<input type="text" class="form-control-plaintext underline" placeholder="Tulis Pertanyaan" name="tanya-essay">
	    					</div>

							<select class="form-control kotak col-sm-3" id="kategori">
	  							<option disabled="" selected="">Jenis Pertanyaan </option>
	   						 	<option>Essay</option>
	    						<option>Pilihan Ganda</option>
	    						<option>Check Box</option>
	    						<option>Range</option>
	  						</select>
						</div>

					
	    				<div class="body">
						
						</div>
						<div class="footer kanan hapus p-2 pointer">
							<span class="fa fa-trash"></span>
							Hapus
						</div>
					
					
					</div>
					
					</div>
				
				
			</div>
		
		</div>
	
</section>






</body>
</html>


