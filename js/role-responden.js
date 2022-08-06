$(document).ready(function(){

	$(document).on('change', "#role-responden-bidang", function(){
		if ($(this).val() == 0) {
			$("#role-responden-departemen").html('<option value=0 selected="">Semua departemen</option>');
			$("#role-responden-unit").html('<option value=0 selected="">Semua unit</option>');
			$("#role-responden-departemen").val("0").change();
		} else {
			$.ajax({
				type:'post',
				data : {
					role : 'departemen', id_bidang : $(this).val()
				},
				url : '../ajax/role-responden.php',
				success : function(data){
					$("#role-responden-departemen").html(data);
					$("#role-responden-departemen").val("0").change();
				}
			});
		}
	});

	$("#role-responden-bidang").val("0").change();

	$(document).on('change', "#role-responden-departemen", function(){
		if ($(this).val() == 0) {
			$("#role-responden-unit").html('<option value=0 selected="">Semua unit</option>');
			$("#role-responden-unit").val("0").change();
		} else {
			$.ajax({
				type:'post',
				data : {
					role : 'unit', id_departemen : $(this).val()
				},
				url : '../ajax/role-responden.php',
				success : function(data){
					$("#role-responden-unit").html(data);
					$("#role-responden-unit").val("0").change();
				}
			});
		}
	});
});
