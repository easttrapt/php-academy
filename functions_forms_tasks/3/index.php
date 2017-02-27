<?php
//Есть текстовый файл. Необходимо удалить из него все слова, длина которых превыщает N символов. Значение N задавать через форму. Проверить работу на кириллических строках - найти ошибку, найти решение

error_reporting(E_ALL);

define("MYFILE", "file.txt");

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return (int) ($_POST['maxLength']);
}

function requestPost($key, $template = ''){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}

function textToArray($arr){
	$arr = mb_strtolower(trim($arr));
	$pattern = "/[\s-_!,.:+=?]+/";
	return preg_split($pattern, $arr);
}

function sliceLongWordArr($arr, $maxLength){
	foreach ($arr as $key => $value) {
		if(mb_strlen($value) > $maxLength){
			unset($arr[$key]);
		}
	}
	return $arr;
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function returnFileContent(){
	$h = fopen(MYFILE, 'r+');
	$text = fread($h, filesize(MYFILE));
	fclose($h);

	return $text;
}



function deleteLongWords($fileName, $maxLength){
	$h = fopen(MYFILE, 'r+');
	$text = fread($h, filesize(MYFILE));

	$textArr = textToArray($text);
	$textArr = sliceLongWordArr($textArr, $maxLength);

	$text = implode(" ", $textArr);

	ftruncate($h, 0);
	rewind($h);

	fwrite($h, $text);
	fclose($h);
}


//logic

if (isRequestPost()) {
	if (isFormNotEmpty()) {
		deleteLongWords(MYFILE, $_POST["maxLength"]);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Delete long words from file</title>
</head>
<body>
	<h1>Delete long words from file</h1>
	<form method="post">
		<input type="number" name="maxLength" value=<?=requestPost("maxLength", 10); ?>>
		<br>
		<button>Delete long words</button>
	</form>
	<h2>File content</h2>
	<span><?=returnFileContent(); ?></span>

</body>
</html>