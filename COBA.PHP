
<?php 
	require_once 'navbar.php';
 ?>

<head>
	<title>Survei Semen Indonesia</title>
	<link rel="stylesheet" type="text/css" href="css/style-buatform.css">
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
		input[name='judul']{
			font-weight: bold;
			font-size: 36pt;
			width: 100%
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
	</style>
	<script type="text/javascript">
		
	</script>
	<script type="text/javascript">
		var headerSoal = '<div class="card my-3 border-0 shadow">			<div class="card-header bg-secondary text-right py-2 px-4">				<font size="5px" class="btnHapus pointer text-light"><b >X</b></font>			</div>			<div class="card-body py-5 px-3">				<div class="d-flex ">					<div class="formSoal">						<div class="header d-flex px-3 ">							<input type="file" class="form-control-file " name="img[]" multiple="">							<font size="5" class="align-self-center nomor"></font>	      					<textarea class="form-control mx-4 underline" placeholder="Pertanyaan" name="perSurvey" required=""></textarea>							<select class="form-control col-sm-3 kategori" required="">	  								   						 	<option value="Essay" selected>Essay</option>	    						<option value="Pilihan">Pilihan Ganda</option>	    						<option value="Check">Check Box</option>	    						<option value="Range">Range</option>	  						</select>						</div>	    				'
		var footerSoal = '					</div>						<div class="col-sm-3 text-center align-self-center divImg">						<div class="kotak hideImg" > <i class="far fa-image"></i>						</div><font size="2" class="text-secondary">*ekstensi file upload .png .jpeg .jpg</font>					</div>				</div>			</div>		</div>'
		var bodyEssay = '<div class="body p-3">			</div>'
		var essay = headerSoal+bodyEssay+footerSoal
		var divMulti = '<div class="jawaban form-group col-sm-12 my-2"> 		    						<input type="radio" name="aradio" disabled="" class="form-control">		    						<input type="text" name="jawSurvey" class="form-control col-sm-10 underline" required="">		    					</div>'
		var bodyMulti ='<div class="body p-3 bodyMl">	    					<div class="contentJaw form-inline">		  '+divMulti+divMulti+'		    				</div>		    				<div class="footerJaw mt-3">		    					<button type="button" class="btn btn-success btnTM">+ Tambah Opsi</button>		    				</div>						</div>'
		var mulitpleChoice = headerSoal+bodyMulti+footerSoal
		var bodyRange = '<div class="body p-3">		<div class="form-inline ml-5">	<button type="button" name="-Range" class="btn btn-danger "><b>-</b></button>	<input type="text" placeholder="Maksimal Range" name="range" class="form-control m-3 underline">	  					<button type="button" name="+Range" class="btn btn-success "><b>+</b></button>				</div>		</div>'
		var range = headerSoal+bodyRange+footerSoal
		var btnDimg = '<button type="button" class="btn btn-danger btnDimg" ><i class="fas fa-trash-alt"></i> Delete</button>'
		var varHps = '<button type="button" class="btn btn-danger ml-4 btnHM">Hapus</button>'
		var arr = []
		var arrDesk = {judul : '', deskripsi : '', responden : []}
		$(document).ready(function(){

			var formData = new FormData();

			$(document).on('submit', '#uploadimage', function(e){
				e.preventDefault();
				formData.append('arrayARR', JSON.stringify(arr))
				formData.append('arrayARD', JSON.stringify(arrDesk))
		        $.ajax({
		            url : 'ajal.php',
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

			$(document).on('click', '.btnDimg', function(){
				var idx = $('.btnDimg').index(this)
				var inpIdx = 'input[type="file"]:eq('+idx+')'
				$(inpIdx).val('').change()
			})

			var arrName = []

			$(document).on('change', 'input[type="file"]', function(e){
				var idx = $('input[type="file"]').index(this)
				alert(idx+' => '+$('input[type="file"]:eq('+idx+')').val())
				if ($('input[type="file"]:eq('+idx+')').val()=='') {
					formData.delete('image['+idx+']')
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
					var id = fileobj.name;
					var arr_nama = id.split('\\');
					var nama = arr_nama[arr_nama.length-1];
					var ext = nama.split('.');
					var ext = ext[ext.length-1];
					var cekExt = ['jpg','jpeg','png','JPG','PNG','JPEG'] 
					if ($.inArray(ext,cekExt!=-1)) {
						if(fileobj.size < 1000000){
							if($.inArray(id, arrName)!=-1){
								var nomor = parseInt($.inArray(id, arrName))
								var nomornya = nomor + 1
								alert('nama file Pernah diupload pada Nomor '+ nomornya)
							} else {
								arrName[idx] = id
								formData.set('image['+idx+']', fileobj)
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
							$('.kotak').eq(idx).html('File ukuran terlalu besar')
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
			})

			$(document).on('dragover', '.kotak', function(){
				return false;
			})

			$(document).on('drop', '.kotak', function(event){
				var data = event.originalEvent.dataTransfer;
				if(data && data.files.length){
					event.preventDefault();
					var fileobj = data.files[0];
					var id = fileobj.name;
					var arr_nama = id.split('\\');
					var nama = arr_nama[arr_nama.length-1];
					var ext = nama.split('.');
					var reader = new FileReader();
					if (ext[ext.length-1] != "jpg"  && ext[ext.length-1] != "jpeg") {
						alert("Format gambar harus jpg");
						fileobj = undefined;
					} else {
					var reader = new FileReader();
					reader.readAsDataURL(fileobj);
					reader.onload = function(reader) {
				      var idx = $('.kotak').index(this)
						$('.kotak').eq(idx).html('')
						$('.kotak').eq(idx).css({
							'backgroundImage' : 'url("'+reader.target.result+'")',
							'backgroundSize' : '100% 100%',
							'border' : 'none'
						})
					}
					}
					event.stopPropagation();
				}
			})
			
			$(document).on('change', 'input[name=deskripsi]', function(){
				arrDesk['deskripsi'] = $('input[name=deskripsi]').val()
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
				createPanel($('.formSoal:eq('+idx+')>.header>.kategori').val(),idx)
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
			$(document).on('input','input[name=jawSurvey]', function(){
				updateJaw(
					$(this).parent().parent().parent().parent().parent().parent().parent().prevAll().length,
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
					$(this).parent().parent().parent().parent().parent().parent().parent().prevAll().length,
					$(this).closest('.formSoal').find('.btnHM').index(this)
					)
			})
			$(document).on('click','.btnTM', function(){
				createMulti($(this).parent().parent().parent().parent().parent().parent().prevAll().length)
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
			if ($(idx+'>.header>.kategori').val() == 'Check') {
				$(idx+'>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")	
			}
			if (no == 2) {
				$(idx+'>.body>.contentJaw>.jawaban').append(varHps)
			}
			if (no >= 3) {
				$(idx+'>.body>.contentJaw>.jawaban').eq(no).append(varHps)
			}
		}

		function deletePanel(val){
			$('.formSoal:eq('+val+')').parent().parent().parent().animate({
				opacity: '0',height:'0'},300, function(){
				$(this).remove()
				arr.splice(val,1)
				formData.delete('image['+idx+']')
				for(var i = val; i<arr.length ;i++){
					$('.nomor').eq(i).html(i+1)
					arr[i]['id'] = i+1
				}
			})
		}

		function updateJaw(idxForm,idxJaw,val){
			arr[idxForm]['jaw'][idxJaw] = val
		}

		function createPanel(val,add){
			var idx = add+1
			var no =arr.length+1
			if (val=='Essay') {
				var arrTemp = {id : no,per : '',kat : 'Essay',jaw : []}
				arr.push(arrTemp)
				$('#panelSoal').append(essay)
				$('.formSoal:eq('+idx+')>.header>.kategori').val('Essay')
				$('.nomor').eq(no-1).html(no)
			} else if (val=='Pilihan') {
				var arrTemp = {id : no,per : '',kat : 'Pilihan',jaw : ['','']}
				arr.push(arrTemp)
				$('#panelSoal').append(mulitpleChoice)
				$('.formSoal:eq('+idx+')>.header>.kategori').val('Pilihan')
				$('.nomor').eq(no-1).html(no)
			} else if (val=='Check') {
				var arrTemp = {id : no,per : '',kat : 'Check',jaw : ['','']}
				arr.push(arrTemp)
				$('#panelSoal').append(mulitpleChoice)
				$('.formSoal:eq('+idx+')>.header>.kategori').val('Check')
				$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				$('.nomor').eq(no-1).html(no)
			} else if (val=='Range') {
				var arrTemp = {id : no,per : '',kat : 'Range',jaw : []}
				arr.push(arrTemp)
				$('#panelSoal').append(range)
				$('.formSoal:eq('+idx+')>.header>.kategori').val('Range')
				$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				$('.nomor').eq(no-1).html(no)
			} else if(val == null){
				var arrTemp = {id : no,per : '',kat : 'Essay',jaw : []}
				arr.push(arrTemp)
				$('#panelSoal').append(essay)
				$('.nomor').eq(no-1).html(no)
			}
		}
		function updateKat(idx,add){
			if (add=='Essay') {
				arr[idx]['kat'] = 'Essay'
				arr[idx]['jaw'] = []
				$('.formSoal:eq('+idx+')>.body').replaceWith(bodyEssay)
			} else if (add=='Pilihan') {
				if (arr[idx]['kat'] != 'Check') {
					arr[idx]['kat'] = 'Pilihan'
					$('.formSoal:eq('+idx+')>.header>.kategori').val('Pilihan')
					arr[idx]['jaw'] = []
					$('.formSoal:eq('+idx+')>.body').replaceWith(bodyMulti)
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="checkbox"]').attr("type","radio")	
				} else {
					arr[idx]['kat'] = 'Pilihan'
					$('.formSoal:eq('+idx+')>.header>.kategori').val('Pilihan')
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="checkbox"]').attr("type","radio")
				} 
			} else if (add=='Check') {
				if (arr[idx]['kat'] != 'Pilihan') {
					arr[idx]['kat'] = 'Check'
					$('.formSoal:eq('+idx+')>.header>.kategori').val('Check')
					arr[idx]['jaw'] = []
					$('.formSoal:eq('+idx+')>.body').replaceWith(bodyMulti)
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				} else {
					arr[idx]['kat'] = 'Check'
					$('.formSoal:eq('+idx+')>.header>.kategori').val('Check')
					$('.formSoal:eq('+idx+')>.body>.contentJaw>.jawaban>input[type="radio"]').attr("type","checkbox")
				} 
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

<div class="container pb-5">
	<div class="bg-form bg-dark"></div>
	<form id="uploadimage" action="" method="post" enctype="multipart/form-data">
	<section id="AttrSurvei">
		<div class="card-deck ">
			<div class="card bg-card-buatform my-5 border-0 shadow pb-5">
				<div class="text-center card-header text-light bg-secondary p-3">
					<h1><b>Form Survei</b></h1>
				</div>
				<div class="card-body formAttr text-center">
  					<div class="form-group row justify-content-end text-right">
  						<label class="col-form-label col-sm-2 text-secondary px-0"><b>Responden :</b></label>
						<div class="col-sm-5 d-flex justify-content-end">
							<select class="mx-1 form-control underline" name="bidang" id="sel1">
								<option disabled="" selected="">Bidang </option>
							 	<option value="Ketupel">Ketupel</option>
								<option value="Sekertaris">Sekertaris</option>
								<option value="Bendahara">Bendahara</option>
								<option value="Anggota">Anggota</option>
							</select>
							<select class="mx-1 form-control underline" name="departemen" id="sel1">
								<option disabled="" selected="">Departemen </option>
							 	<option value="Ketupel">Ketupel</option>
								<option value="Sekertaris">Sekertaris</option>
								<option value="Bendahara">Bendahara</option>
								<option value="Anggota">Anggota</option>
							</select>
							<select class="mx-1 form-control underline" name="unit" id="sel1">
								<option disabled="" selected="">Unit </option>
							 	<option value="Ketupel">Ketupel</option>
								<option value="Sekertaris">Sekertaris</option>
								<option value="Bendahara">Bendahara</option>
								<option value="Anggota">Anggota</option>
							</select>
						</div>
					</div>
					<div class="form-group row justify-content-end text-right">
  						<label class="col-form-label col-sm-2 text-secondary px-0"><b>Batas Pengisian :</b></label>
						<input class="ml-3 pl-3 col-sm-4 form-control form-control-plaintext underline" type="date" name="batasWaktu">
					</div>
	  				<div class="form-group">
	  					<input type="text" class="form-control-plaintext pl-3 underline" placeholder="Judul" name="judul">
					</div>
					<div class="form-group">
	  					<input type="text" class="form-control-plaintext pl-3 underline" placeholder="Deskripsi" name="deskripsi">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section id="panelSoal">

	</section>
	<button type="button" class="btn btn-secondary p-3 my-5 btn-block btnNext">+ Tambah Soal</button>	
	<a href="#AttrSurvei" class="btn btn-primary">Up</a>
	<button type="button" class="btn btn-info" onclick="send()">Check Array</button>
	<button type="button" class="btn btn-danger" onclick="cek()">upload</button>
	<button class="btn btn-success">Submit</button>
	</form>
</div>
</body>
</html>


