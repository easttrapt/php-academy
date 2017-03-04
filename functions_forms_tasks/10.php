<?php
//10. Написать функцию, которая считает количество уникальных слов в тексте. Слова разделяются пробелами. Текст должен вводиться с формы.

error_reporting(E_ALL);


//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['userText']);
}

function requestPost($key, $template = null){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}

function textToArray($arr){
	$arr = mb_strtolower(trim($arr));
	$pattern = "/[\s-_!,.:+=?]+/";
	return array_filter(preg_split($pattern, $arr));
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function returnNumberOfUnique(array $arr){
	return count(array_unique($arr));
}

//logic
$result = 0;
$template = 'Синоптики обещают теплую погоду. Погоду теплую . Синоптики обещают, но не влияют на погоду.';

if (isRequestPost()) {
	if (isFormNotEmpty()) {
		$userText = textToArray($_POST['userText']);
		$result = returnNumberOfUnique($userText);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Count unique words</title>
</head>
<body>
	<h1>Count unique words</h1>
	<form method="post">
		<textarea name="userText" id="userText" cols="30" rows="10"><?=requestPost("userText", $template) ?></textarea>
		<br>
		<button>Count unique words</button>
	</form>
	<h2><?="Уникальных слов в тексте: ".$result; ?></h2>

</body>
</html>