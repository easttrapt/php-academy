<?php
//1. Дан массив с элементами 'html', 'css', 'php', 'js', 'jq'. С помощью цикла foreach выведите эти слова в столбик.

	$arr = ['html', 'css', 'php', 'js', 'jq'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>1</title>
</head>
<body>
	<ul>
		<?php foreach ($arr as $value): ?>
			<li><?=$value ?></li>
		<?php endforeach; ?>
	</ul>
</body>
</html>