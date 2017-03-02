<?php
//Создать гостевую книгу, где любой человек может оставить комментарий в текстовом поле и добавить его. Все добавленные комментарии выводятся над текстовым полем.

error_reporting(E_ALL);

//functions
function isRequestPost(){
	return (bool) $_POST;
}

function isFormNotEmpty(){
	return trim($_POST['userName']) && trim($_POST['userComment']);
}

function requestPost($key, $template = ''){
	return isset($_POST[$key]) ? $_POST[$key] : $template;
}

function addComment($arr){
	$arr[] = array(trim($_POST['userName']) => trim($_POST['userComment']));
}


function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}




//logic
$errorMessage = '';

$allComments = [];


if(isRequestPost()) {
	if(isFormNotEmpty()) {
		//addComment($allComments);
		//debug($allComments);
		$allComments[] = array(trim($_POST['userName']) => trim($_POST['userComment']));
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
	<style>
		.comment:empty {
			display: none;
		}
		.comment {
			max-width: 50%;
			background-color: #dddddd;
			margin: 5px;
			padding: 5px;
		}
	</style>
</head>
<body>
	<h1>Comments here</h1>
	
	<div class="comments">
		
		<?php foreach($allComments as $index=>$userData): ?>
		<div class="comment">

			<?php foreach($userData as $key=>$value): ?>
				<h4><?php echo $key; ?></h4>
				<span><?php echo $value; ?></span>
			<?php endforeach; ?>

		</div>
		<?php endforeach; ?>

	</div>

	<form method="post">
		<div>
			<label for="userName">Your name</label>
			<br>
			<input type="text" name="userName" id="userName" value=<?="'".requestPost("userName")."'"; //"'" - не нашел более элегантного решения?>>
		</div>

		<div>
			<label for="userComment">Your comment</label>
			<br>
			<textarea name="userComment" id="userComment" cols="30" rows="10"><?=requestPost("userComment"); ?></textarea>
		</div>
		<button>Send comment</button>
	</form>
	<br>

	<h3><?=$errorMessage?></h3>
	<h3></h3>
	
	<?php debug($allComments); ?>




</body>
</html>