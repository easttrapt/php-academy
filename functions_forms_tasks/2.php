<?php
//Создать форму с элементом textarea. При отправке формы скрипт должен выдавать ТОП3 длинных слов в тексте. Реализовать с помощью функции.

error_reporting(E_ALL);

//constant
define("THRESHOLD", 3);

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['userText']);
}

function requestPost($key){
	$template = 'Заводы крестьянам, фабрики крестьянам, власть крестьянам, ура, ура, ура';
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}

function textToArray($arr){
	$arr = mb_strtolower(trim($arr));
	$pattern = "/[\s-_!,.:+=?]+/";
	return preg_split($pattern, $arr);
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function returnArrayWordLength(array $arr){
	//[0] => 'hello' ---> [5] => 'hello' - works if words are unique
	$arr = array_unique($arr);
	$resultArr = [];
	foreach ($arr as $key => $value) {
		$resultArr[mb_strlen($value)] = $value;
	}
	return $resultArr;
}

//logic
$result = [];

if (isRequestPost()) {
	if (isFormNotEmpty()) {
		$userText = textToArray($_POST['userText']);
		$result = returnArrayWordLength($userText);
		krsort($result);
		$result = array_slice($result, 0, THRESHOLD);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>TOP 3 words by length</title>
</head>
<body>
	<h1>TOP 3 words by length</h1>
	<form method="post">
		<textarea name="userText" id="userText" cols="30" rows="10"><?=requestPost("userText") ?></textarea>
		<br>
		<button>Find long words</button>
	</form>
	<h2><?=debug($result); ?></h2>

</body>
</html>