<?php
//1. Создать контактную форму. Сделать так, чтобы один посетитель не мог отправить форму больше 3 раз за одну минуту.
error_reporting(E_ALL);

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['name']) && trim($_POST['email']) && trim($_POST['message']);
}

function requestPost($key, $template = ''){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}

function getPostArr($arr){
	$result = [];
	foreach ($arr as $key => $value) {
		$result[$key] = $value;
	}
	return $result;
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

//cookies
//хочу чтобы кука жила 1 минуту. Когда буду отправлять сообщение, буду проверять массив кук. если там уже есть 3, то выводить сообщение об ошибке.
function setFormCookies($time = 60){
	$count = isset($_COOKIE['count']) ? (int)$_COOKIE['count'] : 0;
	$count++;
	setcookie('count', $count, time() + $time);
	setcookie("formSent[".$count."]", uniqid(), time() + $time);
}

function getFormSentTimes($arrName = 'formSent'){
	if(isset($_COOKIE['formSent'])){
		return count($_COOKIE['formSent']);
	}
	return;
}



//logic
$userData = [];
$flashMessage = array("class" => "hide", "text" => "");


if(isRequestPost()) {
	if(isFormNotEmpty()) {
		if (getFormSentTimes() < 3) {
			$userData = getPostArr($_POST);
			setFormCookies();
			$flashMessage = array("class" => "alert", "text" => "Your message was sent");
		} else {
			$flashMessage = array("class" => "alert", "text" => "Stop spam us!");
		}
	} else {
		$flashMessage = array("class" => "alert", "text" => "Form is invalid");
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Stop spam us!</title>
</head>
<body>
	<h1>You can send form 3 times per minute</h1>

	<form method="POST">
		<div>
			<label for="name">Yor name</label><br>
			<input type="text" id="name" value="" name="name">
		</div>
		<div>
			<label for="email">Yor email</label><br>
			<input type="email" id="email" value="" name="email">
		</div>
		<div>
			<label for="email">Yor message</label><br>
			<textarea name="message" id="message" cols="30" rows="10"></textarea>
		</div>
		
		<button>Send</button>
	</form>

	<h3 class=<?="'".$flashMessage["class"]."'" ?>><?=$flashMessage["text"] ?></h3>
	
</body>
</html>