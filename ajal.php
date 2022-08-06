<?php
if (isset($_FILES['image'])) {
	$a = $_FILES['image'];
	$cek = [];
	end($a['size']);
	$last = key($a['size']);
	reset($a['size']);
	$first = key($a['size']);
	for ($i=$first; $i <=$last ; $i++) { 
		if (isset($a['name'][$i])) {
			$allowExt = array("jpeg", "jpg", "png","JPG","PNG","JPEG");
			$fileType = array("image/png","image/jpg","image/jpeg");
			$expExt = explode(".", $a["name"][$i]); 
			$ext = end($expExt);
			if(in_array($a["type"][$i],$fileType) && $a["size"][$i]<1000000 && in_array($ext,$allowExt)){
				if ($a["error"][$i] > 0){
					$cek[$i]['pesan'] = "Return Code: ".$a["error"][$i] . "<br/><br/>";
					$cek[$i]['index'] = $i;
				} else {
					if (file_exists("upload/" . $a["name"][$i])) {
						$cek[$i]['pesan'] = $a["name"][$i]." <span id='invalid'><b>already exists.</b></span> ";
						$cek[$i]['index'] = $i;
					} else {
						$sourcePath = $a['tmp_name'][$i];
						$targetPath = "upload/".$a['name'][$i]; 
						move_uploaded_file($sourcePath,$targetPath) ; 
					};
				}
			} else {
				$cek[$i]['pesan'] = "<span id='invalid'>***Invalid file Size or Type***<span>";
				$cek[$i]['index'] = $i;
			} 
		}
	};
}
print_r($cek)
?>