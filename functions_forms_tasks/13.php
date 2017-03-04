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

function returnNumberOfOccurrences(array $arr){
	$resArr = [];
	$uniqueArr = (array_unique($arr));
	foreach ($uniqueArr as $uKey => $uValue) {
		$numberOfOccurrences = 0;
		foreach ($arr as $key => $value) {
			if($uValue == $value){
				$numberOfOccurrences++;
			}
			$resArr[$uValue] = $numberOfOccurrences;
		}
	}
	return $resArr;
}

//logic
$result = [];
$template = 'яблоко черешня вишня вишня черешня груша яблоко черешня вишня яблоко вишня вишня черешня груша яблоко черешня черешня вишня яблоко вишня вишня черешня вишня черешня груша яблоко черешня черешня вишня яблоко вишня вишня черешня черешня груша яблоко черешня вишня';

if (isRequestPost()) {
	if (isFormNotEmpty()) {
		$userText = textToArray($_POST['userText']);
		$result = returnNumberOfOccurrences($userText);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Count occurences</title>
</head>
<body>
	<h1>Count occurences</h1>
	<form method="post">
		<textarea name="userText" id="userText" cols="30" rows="10"><?=requestPost("userText", $template) ?></textarea>
		<br>
		<button>Count occurences</button>
	</form>
	<h2>Results:</h2>
	<?php foreach ($result as $key => $value): ?>
		<span><?="{$key} — {$value}" ?></span><br>
	<?php endforeach; ?>

</body>
</html>