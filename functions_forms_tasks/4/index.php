<?php
//Написать функцию, которая выводит список файлов в заданной директории. Директория задается как параметр функции.

error_reporting(E_ALL);


//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['userDir']);
}

function requestPost($key, $template = null){
	$template = '.';
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}


function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function scanDirView($dir){
	$result = scandir($dir);
	//так как отстортированный массив всегда начинается с . .. , то можно их удалять без проверки
	array_splice($result, 0, 2);
	return $result;
}

function getFileType($dir){
	$arr = scanDirView($dir);
	$result = [];
	foreach ($arr as $key => $value) {
		$result[pathinfo($value, PATHINFO_BASENAME)] = pathinfo($value, PATHINFO_EXTENSION) == "" ? "dir" : pathinfo($value, PATHINFO_EXTENSION);
	}
	return $result;
}

//logic
$resultArr = [];

if(isRequestPost()) {
	if(isFormNotEmpty()) {
		$dir = trim($_POST['userDir']);
		$resultArr = getFileType($dir);
	} else {
		$errorMessage = "Form is invalid";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Scandir+</title>
</head>
<body>
	<h1>Scandir+</h1>
	
	<form method="post">
		<input type="text" name="userDir" value=<?="'".requestPost("userText")."'" ?>>
		<button>Scan</button>
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