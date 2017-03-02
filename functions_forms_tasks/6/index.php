<?php

//6. Создать страницу, на которой можно загрузить несколько фотографий в галерею. Все загруженные фото должны помещаться в папку gallery и выводиться на странице в виде таблицы.

//constants
define("UPLOADDIR", './uploads/');

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return !empty($_FILES["images"]);
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function getFilesFromDir($dir){
	$result = scandir($dir);
	//так как отстортированный массив всегда начинается с . .. , то можно их удалять без проверки
	array_splice($result, 0, 2);
	return $result;
}


//logic

//показываю картинки из директории даже если форма не отправлена
//считаю, что в директории существуют только картинки, не проверяю тип файлов. Просто получаю фалы с помощью getFilesFromDir()

$uploadedImages = getFilesFromDir(UPLOADDIR);

//обрабатываю пост
if(isRequestPost()) {
	if(isFormNotEmpty()) {
		foreach ($_FILES["images"]["error"] as $key => $error) {
			if ($error == UPLOAD_ERR_OK) {
				$tmp_name = $_FILES["images"]["tmp_name"][$key];
				$name = basename($_FILES["images"]["name"][$key]);
				//заменяю пробелы на минусы
				$name = str_replace(' ', '-',$name);
				//у меня винда. Сперва сохраняю в 1251, потом при выводе снова перевожу в ютф 8. Работает.
				$name = iconv("utf-8","cp1251",  $name);
				move_uploaded_file($tmp_name, UPLOADDIR."/$name");
			}
		}
		//запрашиваю картинки еще раз
		$uploadedImages = getFilesFromDir(UPLOADDIR);

	} else {
		$errorMessage = "Nothing to upload";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Images upload</title>
	<style>
		.gallery {
			margin: 20px auto;
		}
		.gallery:after {
			display: block;
			content: "";
			visibility: hidden;
			clear: both;
		}
		.gallery_image {
			float: left;
			max-width: 30%
		}
		.gallery_image img {
			width: 100%;
		}
	</style>
</head>
<body>
	<h1>Images upload</h1>

	<div class="userForm">
		<form enctype="multipart/form-data" method="POST">
			<input type="hidden" name="MAX_FILE_SIZE" value="300000" />
			<input name="images[]" type="file" multiple="multiple">
			<button>Upload</button>
		</form>
	</div>
	<div class="gallery">
		<?php foreach ($uploadedImages as $key => $value): ?>
			<div class="gallery_image">
				<img src=<?="'".UPLOADDIR."/".iconv("cp1251","utf-8", $value)."'"?> alt=<?="'".UPLOADDIR."/".$value."'"?>>
			</div>
		<?php endforeach; ?>
	</div>
	
</body>
</html>