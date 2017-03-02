<?php
//5. Написать функцию, которая выводит список файлов в заданной директории, которые содержат искомое слово.  Директория и искомое слово задаются как параметры функции.

error_reporting(E_ALL);


//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['userDir']) && trim($_POST['userQuery']) && isset($_POST['userLocation']);
}

function requestPost($key, $template = null){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
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

function getFileType($arr){
	$result = [];
	foreach ($arr as $key => $value) {
		$result[pathinfo($value, PATHINFO_BASENAME)] = pathinfo($value, PATHINFO_EXTENSION) == "" ? "dir" : pathinfo($value, PATHINFO_EXTENSION);
	}
	return $result;
}

function returnFilesByName($arr, $q) {
	return array_filter($arr, function($val) use ($q){
		return strpos($val, $q) !== false;
	});
}

function returnFilesByContent($arr, $q) {
	$result = [];
	foreach ($arr as $file) {
		$fileText = file_get_contents($file);
		if (strpos($fileText, $q) !== false) {
			$result[] = $file;
		}
	}
	return $result;
}

//logic
$resultArr = [];
$errorMessage = '';

if(isRequestPost()) {
	if(isFormNotEmpty()) {
		$dir = trim($_POST['userDir']);
		$query = trim($_POST['userQuery']);
		$location = trim($_POST['userLocation']);
		$allFiles = getFilesFromDir($dir);

		if ($_POST["userLocation"] == "fileName") {
			$resultArr = returnFilesByName($allFiles, $query);
		} else {
			$resultArr = returnFilesByContent($allFiles, $query);
		}

		//форматирование для "красивого вывода"
		$resultArr = getFileType($resultArr);

	} else {
		$errorMessage = "Form is invalid";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandir + query</title>
</head>
<body>
	<h1>Scandir + query</h1>
	
	<form method="post">
		Directory: <input type="text" name="userDir" value=<?="'".requestPost("userText", ".")."'" ?>>
		<br>
		Search query: <input type="text" name="userQuery" value=<?="'".requestPost("userQuery", "hello")."'" ?>>
		<br>

		Search in:
		<input type="radio" name="userLocation" <?=(requestPost("userLocation")&&$_POST["userLocation"] == "fileName" ? "checked" : "")?> value="fileName">File name
		<input type="radio" name="userLocation" <?=(requestPost("userLocation")&&$_POST["userLocation"] == "fileContent" ? "checked" : "")?> value="fileContent">File content
		<br>
		<button>Scan</button>
		<br>
		<?=$errorMessage ?>
	</form>
	<hr>
	<table cellspacing="0" border="1" cellpadding="10">
		<tr>
			<th>File name</th>
			<th>File type</th>
		</tr>
		<?php foreach ($resultArr as $key => $value): ?>
			<tr>
				<td>
					<?=$key; ?>
				</td>
				<td>
					<?=$value; ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	
</body>
</html>