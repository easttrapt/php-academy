<?php
//Создать форму с двумя элементами textarea. При отправке формы скрипт должен выдавать только те слова, которые есть и в первом и во втором поле ввода.
//Реализацию это логики необходимо поместить в функцию getCommonWords($a, $b), которая будет возвращать массив с общими словами.

error_reporting(E_ALL);

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['text1']) && trim($_POST['text2']);
}

function requestPost($key){
	return isset($_POST[$key]) ? $_POST[$key] : '';
}

function textToArray($arr){
	$arr = mb_strtolower(trim($arr));
	$pattern = "/[\s-_!,.:+=?]+/";
	return preg_split($pattern, $arr);
}

function getCommonWords($arr1, $arr2){
	$commonArr = [];

	for ($i=0, $length1 = sizeof($arr1); $i < $length1; $i++) { 
		for ($j=0, $length2 = sizeof($arr2); $j < $length2; $j++) {
			if($arr1[$i] === $arr2[$j]) {
				$commonArr[] = $arr1[$i];
				continue;
			}
		}
	}
	return $commonArr;
}

function printArr(array $arr) {
	echo "Общие элементы:<br>";
	foreach ($arr as $value) {
		echo "{$value}<br>";
	}
}


//logic
$errorMessage = '';
$commonWords = [];

if(isRequestPost()) {
	if(isFormNotEmpty()) {
		$arr1 = textToArray($_POST['text1']);
		$arr2 = textToArray($_POST['text2']);

		$commonWords = getCommonWords($arr1, $arr2);

	} else {
		$errorMessage = "Form is invalid";
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>getCommonWords</title>
</head>
<body>
	<h1>getCommonWords($a, $b)</h1>

	<form method="post">
		<div>
			<label for="text1">First textarea</label>
			<br>
			<textarea name="text1" id="text1" cols="30" rows="10"><?=requestPost("text1"); ?></textarea>
		</div>

		<div>
			<label for="text2">Second textarea</label>
			<br>
			<textarea name="text2" id="text2" cols="30" rows="10"><?=requestPost("text2"); ?></textarea>
		</div>
		<button>Check</button>
	</form>
	<br>
	<button id="fillTemplate">Заполнить поля (js)</button>

	<h3><?=$errorMessage?></h3>
	<h3><?=printArr($commonWords); ?></h3>


	<script>
		//Можно не писать текст вручную каждый раз
		document.getElementById("fillTemplate").onclick = function(){
			document.getElementById("text1").value = "привет всем котам планеты земля! хорошей жизни";
			document.getElementById("text2").value = "ученые доказали Котам существование планеты, пригодной для жизни";
		};
	</script>


</body>
</html>