<?php
//Дан массив $arr. С помощью цикла foreach запишите английские названия в массив $en, а
//русские — в массив $ru.
//$arr = ['green'=>'зеленый', 'red'=>'красный','blue'=>'голубой'];
//$en = ['green', 'red','blue'];
//$ru = ['зеленый', 'красный', 'голубой'];

	$arr = ['green'=>'зеленый', 'red'=>'красный','blue'=>'голубой'];

	$en =[];
	$ru = [];

	foreach ($arr as $key => $value) {
		$en[] = $key;
		$ru[] = $value;
	}

	echo "<pre>";

	print_r($en);

	echo "<hr>";

	print_r($ru);

	echo "<pre>";
?>