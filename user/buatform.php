<?php 
	require_once '../koneksi.php';
	if (!session_id()) {
		session_start();
		$_SESSION["nik"] = '57342';
		$_SESSION["access"] = 'user';
	}
	require_once 'navbar.php';
 ?>

<head>
	<title>Halaman User <?php echo $_SESSION["nik"]; ?> - Buat Form</title>
	<link rel="stylesheet" type="text/css" href="../css/style-user-buatform.css">
	<script type="text/javascript" src="../js/autosize.js"></script>
	<style type="text/css">
		.bg-form{
			position: fixed;
			height: 50vh;
			width: 100vw;
			background-color: #FFBB00;
			z-index: -1;
			top: 0;
			left: 0
		}
		select.underline, input[type="date"]{
			border: none;
			outline: solid 0.3px;
			margin: 10px 10px;
		}
		.hideImg{
			margin:10px auto;
			width: 200px;
			height: 200px;
			border-radius: 10px;
			border:2px dashed lightgrey;
			color: grey;
			font-size: 36pt;
			font-weight: bold;
			cursor: pointer;
			display: flex;
			justify-content: center;
			align-items: center; 
		}
		.bg-head-nav{
			background-color: rgb(195,167,89);
		}
		.btnNext{
			font-size: 14pt;
			font-weight: bold;
		}
		textarea[name='judul']{
			font-weight: bold;
			font-size: 36pt;
			width: 100%;
		}
		.formSoal{
			flex:1;
		}
		.viewImg{
			margin:10px auto;
			background-image: none;
			cursor: pointer;
			width: 200px;
			height: 200px;
			display: flex;
			background-size : 100% 100%;
			border : none;
			border-radius : 0;
			justify-content: flex-end;
			align-items : flex-start;
			color : white;
		}
		.card{
			animation :animate linear 0.5s;
			animation-iteration-count: 1;
		}
		.wrap{
			height: 100%;
			display: flex;
			align-items: center;
			flex-direction: column;
			justify-content: center;
		}
		.upDiv{
			position: fixed;
			bottom: 30px;
			right: 30px;
			border-radius: 100px;
			text-align: center;
			font-size: 24px;
			z-index: 1
		}
		.btnSimpan{
			font-size: 12pt
		}
		.head-close{
			font-size: 36pt;
			text-decoration: none;
			font-weight: bold;
		}
		textarea.underline{
			height: 50px;
		}
		input[type='radio'],input[type='checkbox']{
			width: 20px !important;
		}
		@keyframes animate{
			0%{
				opacity: 0;
				transform: translate(0px,50px);
			}
			100%{
				opacity: 1;
				transform: translate(0px,0px);
			}
		}
		@media only screen and (max-width: 768px){
			.head-close{
				font-size: 24pt
			}
			.row{
				flex-direction: column;
			}
			.formAttr>.form-group>.col-sm-5.row{
				width: 100%	
			}
			.btn {
				font-size: 10pt
			}
			.pengisian{
				margin: 0.5rem
			}
			.btnTM{
				width: 100%
			}
			.col-sm-5.row{
				margin:0px;
			}
			.formSoal>.header{
				flex-direction: column-reverse;
			}
		}
	</style>

	<script type="text/javascript" src="../js/role-responden.js"></script>
	<script type="text/javascript">

		var headerSoal = '<div class="card my-3 border-0 shadow">			<div class="card-header bg-dark-nav text-right py-3 px-4">				<font size="5px" class="btnHapus pointer text-light"><b >X</b></font>			</div>			<div class="card-body py-5 px-3">				<div class="row">					<div class="formSoal">						<div class="header row px-3 ">							<input type="file" class="form-control-file " name="img[]" multiple="">							<div class="col-sm-9 d-flex justify-content-between"><font size="5" class="align-self-start px-2 nomor"></font>	      					<textarea class="form-control underline flex-grow-1" placeholder="Pertanyaan" name="perSurvey" required="" rows="1" data-min-rows="1"></textarea></div>						<div class="col-sm-3">	<select class="form-control kategori mb-4 underline" required="">	  								   						 	<option value="Essay" selected>Essay</option>	    						<option value="Pilihan">Pilihan Ganda</option>	    						<option value="Check">Check Box</option>	    						<option value="Range">Range</option>	  						</select></div>						</div>	    				'
		var footerSoal = '					</div>						<div class="col-sm-3 wrap text-center wrap divImg">						<div class="kotak hideImg" > <i class="far fa-image"></i>						</div><font size="2" class="text-secondary">*ekstensi file upload .png .jpeg .jpg</font>					</div>				</div>			</div>		</div>'
		var bodyEssay = '<div class="body p-3">			</div>'
		var essay = headerSoal+bodyEssay+footerSoal
		var divMulti = '<div class="jawaban form-group col-sm-12 my-2 d-flex"> 		    						<input type="radio" name="aradio" disabled="" class="form-control">		    						<textarea name="jawSurvey" class="form-control col-sm-10 underline" required=""></textarea>		    					</div>'
		var bodyMulti ='<div class="body p-3 bodyMl">	    					<div class="contentJaw form-inline">		  '+divMulti+divMulti+'		    				</div>		    				<div class="footerJaw mt-3">		    					<button type="button" class="btn btn-success btnTM">+ Tambah Opsi</button>		    				</div>						</div>'
		var mulitpleChoice = headerSoal+bodyMulti+footerSoal
		var bodyRange = '<div class="body p-3">		<div class="form-group row p-3">	<input type="text" placeholder="Maksimal Range" name="range" class="col-sm-5 m-2 form-control underline">  					<button type="button" name="+Range" class="btn btn-secondary m-2 "><b><i class="fas fa-chevron-up"></i></b></button>		<button type="button" name="-Range" class="btn btn-secondary m-2"><b><i class="fas fa-chevron-down"></i></b></button>			</div>		</div>'
		var range = headerSoal+bodyRange+footerSoal
		var btnDimg = '<button type="button" class="btn btn-danger btnDimg" ><i class="fas fa-trash-alt"></i> Delete</button>'
		var varHps = '<button type="button" class="btn btn-danger ml-4 btnHM"><i class="fas fa-trash-alt"></i></button>'
		var arr = []
		var respondenTmp = {bidang : '',departemen:'',unit:''}
		var arrDesk = {judul : '', deskripsi : '',responden:respondenTmp, awal : '', akhir : ''}
		var formData = new FormData();
		var arrName = []

		$(document).ready(function(){

			$('#formSurvey')[0].reset();
			autosize($('textarea'));

			$(document).on('submit', '#formSurvey', function(e){
				e.preventDefault();
				formData.append('survey_pertanyaan', JSON.stringify(arr))
				formData.append('survey', JSON.stringify(arrDesk))
		        $.ajax({
		            url : '../ajax/simpan-survey.php',
		            data : formData,
		            type : 'POST',
		            processData: false,
		            contentType: false,
		            success : function(data){
		            	alert(data); 
		            },
		        });
			})

			$(document).on('click', '.kotak', function(){
				var idx = $('.kotak').index(this)
				var inpIdx = 'input[type="file"]:eq('+idx+')'
				$(inpIdx).click()
			})

			$(document).on('dragover', '.kotak', function(){
				return false;
			})

			$(document).on('drop', '.kotak', function(e){
				e.preventDefault();
				var idx = $('.kotak').index(this)
				var fileobj = e.originalEvent.dataTransfer.files[0]
				upImage(fileobj,idx)
			})

			$(document).on('change', 'input[name="calStart"]', function(){
		      var dateVal = new Date($(this).val()).setHours(0,0,0,0)
		      var now = new Date().setHours(0,0,0,0)
		      if ( now > dateVal ) {
		        alert('Input tanggal tidak boleh kurang dari tanggal sekarang !')
		        $(this).val('')
		        $('input[name="calEnd"]').attr('disabled',true)
		      } else {
		        $('input[name="calEnd"]').attr('disabled',false)
		        arrDesk['awal'] = $(this).val()
		      }
		    })
		    $(document).on('change', 'input[name="calEnd"]', function(){
		      var start = new Date($('input[name="calStart"]').val()).setHours(0,0,0,0)
		      var end = new Date($(this).val()).setHours(0,0,0,0)
		      var now = new Date().setHours(0,0,0,0)
		      if ( end <= start ) {
		        alert('Input tanggal tidak boleh kurang dari tanggal awal !')
		        $(this).val('')
		      } else {
		      	arrDesk['akhir'] = $(this).val()
		      }
		    })

			$(document).on('click', '.btnDimg', function(){
				var idx = $(this).parent().parent().parent().parent().prevAll().length
				var inpIdx = 'input[type="file"]:eq('+idx+')'
				$(inpIdx).val('').change()
			})

			$(document).on('change', 'input[type="file"]', function(e){
				var idx = $('input[type="file"]').index(this)
				var inpIdx = 'input[type="file"]:eq('+idx+')'
				if ($('input[type="file"]:eq('+idx+')').val()=='') {
					formData.delete('image['+idx+']')
					arrName.splice(idx,1)
					arr[idx]['img'] = ""
					if ($('.kotak').eq(idx).hasClass("viewImg")) {
						$('.kotak').eq(idx).addClass('hideImg').removeClass('viewImg')
						$('.kotak').eq(idx).removeAttr('style')
						$('.kotak').eq(idx).html('<i class="far fa-image"></i>')
					}
					if($('.divImg:eq('+idx+')').has('button').length){
						$('.divImg:eq('+idx+')>.btnDimg').remove()
					}
				} else {
					var fileobj = e.target.files[0]
					upImage(fileobj,idx)
				}
			})
			
			$(document).on('change', 'textarea[name=judul]', function(){
				arrDesk['judul'] = $('textarea[name=judul]').val()
			})

			$(document).on('change', 'textarea[name=deskripsi]', function(){
				arrDesk['deskripsi'] = $('textarea[name=deskripsi]').val()
			})

			$(document).on('input', 'input[name="range"]', function(){
				cekRange($('input[name="range"]').index(this),$(this).parent().parent().parent().parent().parent().parent().prevAll().length)
			})

			$(document).on('click', 'button[name="+Range"]', function(){
				tambahRange($('button[name="+Range"]').index(this),$(this).parent().parent().parent().parent().parent().parent().prevAll().length)
			})

			$(document).on('click', 'button[name="-Range"]', function(){
				kurangRange($('button[name="-Range"]').index(this), $(this).parent().parent().parent().parent().parent().parent().prevAll().length)
			})

			$(document).on('change', 'input[name=batasWaktu]', function(){
				arrDesk['batasWaktu'] = $('input[name=batasWaktu]').val()
			})
			
			$(document).on('change', 'select[name=bidang]', function(){
				arrDesk['responden']['bidang'] = $('select[name=bidang]').val()
			})

			$(document).on('change', 'select[name=departemen]', function(){
				arrDesk['responden']['departemen'] = $('select[name=departemen]').val()
			})

			$(document).on('change', 'select[name=unit]', function(){
				arrDesk['responden']['unit'] = $('select[name=unit]').val()
			})

			$(document).on('click', '.btnNext', function(){
				var idx = ($('.formSoal').length)-1
				createPanel($('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val(),idx)
			})
			$(document).on('change','.kategori', function(){
				updateKat(
					$('.kategori').index(this),
					$(this).val()
					)
			})
			$(document).on('input','textarea[name=perSurvey]', function(){
				updatePer(
					$('textarea[name=perSurvey]').index(this),
					$(this).val()
					)
			})
			$(document).on('input','textarea[name=jawSurvey]', function(){
				updateJaw(
					$(this).parent().parent().parent().parent().parent().parent().parent().prevAll().length,
					$(this).closest('.formSoal').find('textarea[name=jawSurvey]').index(this),
					$(this).closest('.formSoal').find('textarea[name=jawSurvey]').eq(
						$(this).closest('.formSoal').find('textarea[name=jawSurvey]').index(this)).val()
					)
				})
			$(document).on('click','.btnHapus', function(){
				var idx = $('.btnHapus').index(this)
				deletePanel(idx)
			})
			$(document).on('click','.btnHM', function(){
				deleteMulti(
					$(this).parent().parent().parent().parent().parent().parent().parent().prevAll().length,
					$(this).closest('.formSoal').find('.btnHM').index(this)
					)
			})
			$(document).on('click','.btnTM', function(){
				createMulti($(this).parent().parent().parent().parent().parent().parent().prevAll().length)
			})
		})
		
		function upImage(fileobj,idx){
			var inpIdx = 'input[type="file"]:eq('+idx+')'
			var id = fileobj.name;
			var arr_nama = id.split('\\');
			var nama = arr_nama[arr_nama.length-1];
			var ext = nama.split('.');
			var ext = ext[ext.length-1];
			var cekExt = ['jpg','jpeg','png','JPG','PNG','JPEG']
			if ($.inArray(ext,cekExt)!=-1) {
				if(fileobj.size < 1000000){
					if($.inArray(id, arrName)!=-1){
						var nomor = parseInt($.inArray(id, arrName))
						var nomornya = nomor + 1
						alert('nama file Pernah diupload pada Nomor '+ nomornya)
					} else {
						arrName[idx] = id
						formData.set('image['+idx+']', fileobj)
						arr[idx]['img'] = id
						var reader = new FileReader()
						reader.readAsDataURL(fileobj)
						reader.onload = function(reader) {
							$('.kotak').eq(idx).html('')
							$('.kotak').eq(idx).css({
								'backgroundImage' : 'url("'+reader.target.result+'")',
							})
							if ($('.kotak').eq(idx).hasClass("hideImg")) {
								$('.kotak').eq(idx).addClass('viewImg').removeClass('hideImg')
							}
						}
						if(!($('.divImg:eq('+idx+')').has('button').length)){
							$('.divImg:eq('+idx+')').append(btnDimg)
						}
					}
				} else {
					formData.delete('image['+idx+']')
					$('.kotak').eq(idx).html('Ukuran File Maksimum 1MB')
					$('.kotak').eq(idx).css({ 'fontSize' : '12pt', 'color':'red'})
					if ($('.kotak').eq(idx).hasClass("viewImg")) {
						$('.kotak').eq(idx).addClass('hideImg').removeClass('viewImg')
						$('.kotak').eq(idx).removeAttr('style')
						$('.kotak').eq(idx).css({ 'fontSize' : '12pt', 'color':'red'})
					}
					$(inpIdx).val('').change()
				}		
			} else {
				$('.kotak').eq(idx).html('Format Tidak Sesuai')
				$('.kotak').eq(idx).css({ 'fontSize' : '12pt', 'color':'red'})
				if ($('.kotak').eq(idx).hasClass("viewImg")) {
					$('.kotak').eq(idx).addClass('hideImg').removeClass('viewImg')
					$('.kotak').eq(idx).removeAttr('style')
					$('.kotak').eq(idx).css({ 'fontSize' : '12pt', 'color':'red'})
				}
				$(inpIdx).val('').change()
			}
		}

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
			if ($(idx+'>.header>.col-sm-3>.kategori').val() == 'Check') {
				$(idx+'>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")	
			}
			if (no == 2) {
				$(idx+'>.body>.contentJaw>.jawaban').append(varHps)
			}
			if (no >= 3) {
				$(idx+'>.body>.contentJaw>.jawaban').eq(no).append(varHps)
			}
			autosize($('textarea.underline'))
		}

		function deletePanel(idx){
			$('.formSoal:eq('+idx+')').parent().parent().parent().animate({
				opacity: '0',height:'0'},300, function(){
				$(this).remove()
				arr.splice(idx,1)
				for(var i = idx; i<arr.length ;i++){
					$('.nomor').eq(i).html(i+1)
					arr[i]['id'] = i+1
				}
				formData.delete('image['+idx+']')
				arrName.splice(idx,1)
			})
		}

		function updateJaw(idxForm,idxJaw,val){
			arr[idxForm]['jaw'][idxJaw] = val
		}

		function createPanel(val,add){
			var idx = add+1
			var no =arr.length+1
			if (val=='Essay') {
				var arrTemp = {id : no,per : '',kat : 'Essay',jaw : [],img : ''}
				arr.push(arrTemp)
				$('#panelSoal').append(essay)
				$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Essay')
				$('.nomor').eq(no-1).html(no)
			} else if (val=='Pilihan') {
				var arrTemp = {id : no,per : '',kat : 'Pilihan',jaw : ['',''],img : ''}
				arr.push(arrTemp)
				$('#panelSoal').append(mulitpleChoice)
				$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Pilihan')
				$('.nomor').eq(no-1).html(no)
			} else if (val=='Check') {
				var arrTemp = {id : no,per : '',kat : 'Check',jaw : ['',''],img : ''}
				arr.push(arrTemp)
				$('#panelSoal').append(mulitpleChoice)
				$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Check')
				$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				$('.nomor').eq(no-1).html(no)
			} else if (val=='Range') {
				var arrTemp = {id : no,per : '',kat : 'Range',jaw : [],img : ''}
				arr.push(arrTemp)
				$('#panelSoal').append(range)
				$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Range')
				$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				$('.nomor').eq(no-1).html(no)
			} else if(val == null){
				var arrTemp = {id : no,per : '',kat : 'Essay',jaw : [],img : ''}
				arr.push(arrTemp)
				$('#panelSoal').append(essay)
				$('.nomor').eq(no-1).html(no)
			}
			autosize($('textarea.underline'))
		}
		function updateKat(idx,add){
			if (add=='Essay') {
				arr[idx]['kat'] = 'Essay'
				arr[idx]['jaw'] = []
				$('.formSoal:eq('+idx+')>.body').replaceWith(bodyEssay)
			} else if (add=='Pilihan') {
				if (arr[idx]['kat'] != 'Check') {
					arr[idx]['kat'] = 'Pilihan'
					$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Pilihan')
					arr[idx]['jaw'] = []
					$('.formSoal:eq('+idx+')>.body').replaceWith(bodyMulti)
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="checkbox"]').attr("type","radio")	
				} else {
					arr[idx]['kat'] = 'Pilihan'
					$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Pilihan')
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="checkbox"]').attr("type","radio")
				} 
				autosize($('textarea.underline'))
			} else if (add=='Check') {
				if (arr[idx]['kat'] != 'Pilihan') {
					arr[idx]['kat'] = 'Check'
					$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Check')
					arr[idx]['jaw'] = []
					$('.formSoal:eq('+idx+')>.body').replaceWith(bodyMulti)
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				} else {
					arr[idx]['kat'] = 'Check'
					$('.formSoal:eq('+idx+')>.header>.col-sm-3>.kategori').val('Check')
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				} 
				autosize($('textarea.underline'))
			} else if (add=='Range') {
				arr[idx]['kat'] = 'Range'
				arr[idx]['jaw'] = []
				$('.formSoal:eq('+idx+')>.body').replaceWith(bodyRange)
			}
		}
		function updatePer(idx,add){
			arr[idx]['per'] = add
		}
		function cekRange(val,idxPar){
			var idx = 'input[name="range"]:eq('+val+')'
			$(idx).val($(idx).val().replace(/[^0-9.]/g, ''))
			$(idx).val($(idx).val().replace(/(\..*)\./g, '$1'))
			if ($(idx).val() == 0) {
				$(idx).val('')
			}
			arr[idxPar]['jaw'] = [$(idx).val()]
		}
		function kurangRange(val,idxPar){
			var idx = 'input[name="range"]:eq('+val+')'
			var ranges = $(idx).val()
			if (ranges > 1 && ranges != '') {
				$(idx).val(ranges-1)
				arr[idxPar]['jaw'] = [ranges-1]
			}
		}
		function cek(){
			alert($('input[type="file"]').eq(0).val())
		}
		function tambahRange(val,idxPar){
			var idx = 'input[name="range"]:eq('+val+')'
			var ranges = $(idx).val()
			if (ranges!='') {ranges = parseInt(ranges)}
			$(idx).val(ranges+1)
			arr[idxPar]['jaw'] = [ranges+1]
		}
		function send(){
			console.table(arrDesk)
			console.table(arr)
		}
	</script>
</head>

<div class="container pb-5 ">
	<form id="formSurvey" enctype="multipart/form-data" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<section id="AttrSurvei">
			<div class="pt-2 pb-5">
				<div class="text-right mb-3 ">
					<a href="index.php" class="text-warning head-close" ><i class="fas fa-times"></i></a>
				</div>
				<div class="card bg-card-buatform  shadow" style="border:0px">
					<div class="text-center card-header text-light bg-dark-nav p-3" style="border:0px">
						<h1><b>Form Survei</b></h1>
					</div>
					<div class="card-body formAttr text-center">
	  					<div class="form-group row justify-content-end">
	  						<label class="col-form-label col-sm-2 text-secondary px-0"><b>Responden :</b></label>
							<div class="col-sm-5 row">
<?php
						$conn = new koneksi();
						$db = $conn->get_koneksi();
						$stmt = $db->query('SELECT * FROM level WHERE id != 0');
						while ($res = $stmt->fetch()) {
?>
								<select class="col-sm-3 form-control underline" name="<?php echo $res['nama']; ?>" id="role-responden-<?php echo $res['nama']; ?>" required="">
									<option value=0 selected="">Semua <?php echo $res["nama"]; ?></option>
<?php
							$stmt2 = $db->prepare('SELECT * FROM '.$res["nama"]);
							$stmt2->execute();
							while ($res2 = $stmt2->fetch()) {
?>
									<option value=<?php echo $res2["id"]; ?>><?php echo $res2["nama"]; ?></option>
<?php
							}
?>
								</select>
<?php
						}
?>
							</div>
						</div>
						<div class="form-group pengisian row justify-content-end mb-5">
	  						<label class="col-form-label  text-secondary px-0"><b>Tgl Pengisian Awal:</b></label>
							<input type="date" name="calStart" class="col-sm-3 form-control form-control-plaintext underline" required="">
							<label class="col-form-label col-sm-2 text-secondary px-0"><b>Tgl Pengisian Akhir:</b></label>
    						<input type="date" name="calEnd" class="col-sm-3 form-control form-control-plaintext underline" disabled="" required="">
						</div>
		  				<div class="form-group">
		  					<textarea class="form-control-plaintext pl-3 underline" placeholder="Judul" name="judul" required=""></textarea>
						</div>
						<div class="form-group">
		  					<textarea class="form-control-plaintext pl-3 underline" placeholder="Deskripsi" name="deskripsi" required=""></textarea>
						</div>
					</div>
				</div>
			</div>
		</section>
		<section id="panelSoal">

		</section>
		<button type="button" class="btn btn-secondary p-3 my-5 btn-block btnNext bg-dark-nav" style="border:0px">+ Tambah Soal</button>	
		<a href="#AttrSurvei" class="btn btn-secondary bg-dark-nav upDiv"><i class="fas fa-angle-up"></i></a>
		<!-- <button type="button" onclick="send()" class="btn btn-info">Check Array</button> -->
		<div class="text-right">
		<button class="btn btn-success p-3 btnSimpan btn-block"><b><i class="check circle icon"></i>Simpan</b></button>
		</div>
	</form>
</div>
</body>
</html>
