<?php
//9. Написать функцию, которая переворачивает строку. Было "abcde", должна выдать "edcba". Ввод текста реализовать с помощью формы.

error_reporting(E_ALL);

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return ($_POST['userString']);
}

function requestPost($key, $template = ''){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}


function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}




//logic
$invertedString = '';
if (isRequestPost()) {
	if (isFormNotEmpty()) {
		$invertedString = strrev($_POST["userString"]);
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Invert String</title>
</head>
<body>
	<h1>Invert String</h1>
	<form method="post">
		<input type="text" name="userString" value=<?=requestPost("userString", 'abcde'); ?>>
		<br>
		<button>Inver</button>
	</form>
	<h2>Inverted String</h2>
	<span><?=$invertedString; ?></span>
</body>
</html>