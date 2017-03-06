<?php
//3. Сделать выпадающий список со списком цветов (красный, синий, желтый и т.д.).
    /*После выбора цвета и отправки формы надо:
        1) запоминать цвет в cookies и выводить на странице текст Lorem Ipsum в выбранном цвете;
        2) если был выбран цвет, например, желтый, то при следующей загрузке страницы должен быть тоже выбран желтый в выпадающем списке.
           То есть, необходимо проставлять selected="seleted" для выбранного пункта в выпадающем списке. То есть, сохранять выбранное значение при перезагрузке страницы.*/
error_reporting(E_ALL);

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return $_POST['color'];
}

function requestPost($key, $template = ''){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}

function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function createMessage($color){
	//делаю цвет обязательным аргументом, так как буду в него передавать резутьтат getColorCookies()
	return array(
		"class" => $color,
		"text" => "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam obcaecati natus deserunt, a iure sapiente! Suscipit maxime doloribus obcaecati assumenda autem architecto excepturi pariatur enim, commodi iste voluptates voluptas laudantium."
		);
}

function setOptions($optionsColors, $colorFromCookies, $disabledText = "Select color"){
	//это что-то вроде конструктора для селекта. 
	//мне показалось, что удобно передавать только цвета и заглушку с цветом "disabled" и значением в необязательном параметре 
	$options = [];
	foreach ($optionsColors as $key => $value) {
		if($value === "disabled" && $colorFromCookies == "gray"){
			$options[] = array(
				"value" => "",
				"disabled" => "disabled",
				"text" => $disabledText,
				"selected" => "selected"
			);
		} 
		elseif ($value === "disabled" && $colorFromCookies != "gray"){
			$options[] = array(
				"value" => "",
				"disabled" => "disabled",
				"text" => $disabledText,
				"selected" => false
			);
		} elseif ($value !== "disabled"){
			//для остальных
			$options[] = array(
				"value" => $value,
				"disabled" => false,
				"text" => $value,
				"selected" => $value == $colorFromCookies ? "selected" : false
			);
		}
	}
	return $options;
}

//cookies
function setColorCookies($color, $time = 86400){
	//$color = isset($_COOKIE['color']);
	setcookie('color', $color, time() + $time);
	header('Location: '.$_SERVER['PHP_SELF']);
}

function getColorCookies(){
	return isset($_COOKIE['color']) ? $_COOKIE['color'] : "gray";
}






//logic
$userMessage = array("class" => "", "text" => "");;
$flashMessage = array("class" => "hide", "text" => "");
//цвета
$optionsColors = [ "disabled", "green", "red", "blue", "yellow", "black", "pink"];


$userColor = getColorCookies();
$userMessage = createMessage($userColor);

$options = setOptions($optionsColors, $userColor);


if(isRequestPost()) {
	if(isFormNotEmpty()) {
		setColorCookies($_POST["color"]);
	} else {
		$flashMessage = array("class" => "alert", "text" => "Form is invalid");
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cookie Color</title>
</head>
<body>
	<h1>Cookie Color</h1>

	<form method="POST">
		<div>
			<select name="color" id="color">
				<?php foreach ($options as $key => $value): ?>
					<option <?=$value["disabled"] ? "disabled" : "" ?> 
						<?=$value["selected"] ? "selected='selected'" : "" ?>
						value=<?="'".$value["value"]."'" ?> 
					><?=$value["text"] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		
		<button>Send</button>
	</form>

	<h3 style=<?="color:".$userMessage["class"]?>><?=$userMessage["text"]?></h3>

	<h3 class=<?="'".$flashMessage["class"]."'" ?>><?=$flashMessage["text"] ?></h3>

	<?php debug($options) ?>
	
</body>
</html>