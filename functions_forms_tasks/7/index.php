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

//for delete
function isRequestGet(){
	return (bool) $_GET;
}

function isActionDelete(){
	return $_GET['action'] == 'delete' && $_GET['id'];
}

function deleteComment($file, $id){
	$comments = getCommentsArr($file);
	foreach ($comments as $key => $comment) {
		if ($comments[$key]["id"] == $id) {
			unset($comments[$key]);
		}
	}
	//сохраняю в json
	foreach ($comments as $key => $comment) {
		$comments[$key] = json_encode($comment);
	}
	$comments = implode(PHP_EOL, $comments);
	file_put_contents($file, $comments);
}


function debug($a){
	echo "<pre>";
	var_dump($a);
	echo "</pre>";
}

function saveComment($file, array $comment){
	$comments = file_get_contents($file) . json_encode($comment) . PHP_EOL;
	file_put_contents($file, $comments);
}

function getCommentsArr($file){
	$comments = file_get_contents($file);
	$result = [];
	if ($comments) {
		$comments = array_filter(explode(PHP_EOL, $comments));
		foreach ($comments as $key => $commentString) {
			$result[$key] = json_decode($commentString, true);
		}
	}
	return $result;
}



//logic
$fileComments = './comments.txt';
$errorMessage = '';

//get saved comments from file
$allComments = getCommentsArr($fileComments);

//add new comment
if(isRequestPost()) {
	if(isFormNotEmpty()) {
		$newComment = array(
			'id' => uniqid(),
			'userName' => trim($_POST['userName']),
			'userComment' => trim($_POST['userComment'])
			);

		saveComment($fileComments, $newComment);
		//get comments again
		$allComments = getCommentsArr($fileComments);
	} else {
		$errorMessage = "Form is invalid";
	}
}

//delete comment
if(isRequestGet()){
	if(isActionDelete()){
		deleteComment($fileComments, $_GET['id']);
		//get comments again
		$allComments = getCommentsArr($fileComments);
	} else {
		$errorMessage = "Cant delete";
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
			<h4><?=$userData["userName"]; ?></h4>
			<span><?=$userData["userComment"]; ?></span><br>
			<a href=<?="./?action=delete&id=".$userData["id"]; ?>>delete</a>
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

</body>
</html>