<?php
//Дан массив $arr. С помощью первого цикла foreach выведите на экран столбец ключей, с
//помощью второго — столбец элементов.

	$arr = ['green'=>'зеленый','red'=>'красный','blue'=>'голубой'];

	foreach ($arr as $key => $value) {
		echo "{$key}<br>";
	}

	echo "<hr>";

	foreach ($arr as $key => $value) {
		echo "{$value}<br>";
	}

?>