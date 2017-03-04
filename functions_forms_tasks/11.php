<?php
//11. Написать функцию, которая в качестве аргумента принимает строку, и форматирует ее таким образом, что каждое новое предложение начиняется с большой буквы.<br>
//Пример:<br><br>
//Входная строка: 'а васька слушает да ест. а воз и ныне там. а вы друзья как ни садитесь, все в музыканты не годитесь. а король-то — голый. а ларчик просто открывался.а там хоть трава не расти.';<br><br>
//Строка, возвращенная функцией :  'А Васька слушает да ест. А воз и ныне там. А вы друзья как ни садитесь, все в музыканты не годитесь. А король-то — голый. А ларчик просто открывался.А там хоть трава не расти.';</p>

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

function strToArraySentense($text){
	$text = mb_strtolower(trim($text));
	//glue = delimeter = '. '
	return explode('. ', $text);
}

function arraySentenseToStr($arr){
	return implode('. ', $arr);
}

function ucFirstX($str){
	$first = mb_strtoupper(mb_substr($str, 0, 1));
	return $first.mb_substr($str, 1);
}

function ucArrSentense($arr){
	$arr = array_map("ucFirstX", $arr);
	return $arr;
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}


//logic
$resultStr = '';
$template = 'а васька слушает да ест. а воз и ныне там. а вы друзья как ни садитесь, все в музыканты не годитесь. а король-то — голый. а ларчик просто открывался.а там хоть трава не расти.';
if (isRequestPost()) {
	if (isFormNotEmpty()) {
		$arrSentense = strToArraySentense($_POST['userText']);
		$arrSentenseUC = ucArrSentense($arrSentense);
		$resultStr = arraySentenseToStr($arrSentenseUC);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>ucFirst Sentense</title>
</head>
<body>
	<h1>ucFirst Sentense</h1>
	<form method="post">
		<textarea name="userText" id="userText" cols="30" rows="10"><?=requestPost("userText", $template) ?></textarea>
		<br>
		<button>start</button>
	</form>
	<h2>Result:</h2>
	<p><?=$resultStr; ?></p>

</body>
</html>