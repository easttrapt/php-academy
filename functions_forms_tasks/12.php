<?php
//12. Написать функцию, которая в качестве аргумента принимает строку, и форматирует ее таким образом, что предложения идут в обратном порядке.<br>
//Пример:<br><br>
//Входная строка:  'А Васька слушает да ест. А воз и ныне там. А вы друзья как ни садитесь, все в музыканты не годитесь. А король-то — голый. А ларчик просто открывался. А там хоть трава не расти.';<br><br>
//Строка, возвращенная функцией :  'А там хоть трава не расти. А ларчик просто открывался. А король-то — голый. А вы друзья как ни садитесь, все в музыканты не годитесь. А воз и ныне там.А Васька слушает да ест.'

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

function strToArraySentense($text, &$endsWithDot){
	$text = trim($text);
	//if ends with '.', cut '.'
	if(mb_substr($text, -1) == '.') {
		$text = mb_substr($text, 0, mb_strlen($text) - 1);
		$endsWithDot = true;
	}
	//glue = delimeter = '. '
	return explode('. ', $text);
}

function arraySentenseToStr($arr, $endsWithDot){
	echo "here";
	debug($endsWithDot);
	$str = implode('. ', $arr); 
	echo "{$str[mb_strlen($str) - 1]}";
	return $endsWithDot ? $str : mb_substr($str, 0, mb_strlen($str) - 1);
}





function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}


//logic
$endsWithDot = false;
$resultStr = '';
$template = 'А Васька слушает да ест. А воз и ныне там. А вы друзья как ни садитесь, все в музыканты не годитесь. А король-то — голый. А ларчик просто открывался. А там хоть трава не расти.';
if (isRequestPost()) {
	if (isFormNotEmpty()) {
		$arrSentense = strToArraySentense($_POST['userText'], $endsWithDot);
		$arrSentense = array_reverse($arrSentense);
		$resultStr = arraySentenseToStr($arrSentense, $endsWithDot);
		$resultStr .= ".";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Reverse Sentense</title>
</head>
<body>
	<h1>Reverse Sentense</h1>
	<form method="post">
		<textarea name="userText" id="userText" cols="30" rows="10"><?=requestPost("userText", $template) ?></textarea>
		<br>
		<button>start</button>
	</form>
	<h2>Result:</h2>
	<p><?=$resultStr; ?></p>
	<p><?php debug($endsWithDot); ?></p>

</body>
</html>