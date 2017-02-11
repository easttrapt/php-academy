<?php
	//сделать таблицу, в которой строки рандомного цвета с градиентом. Количество строк и столбцов указывается пользователем. 

	//Градиент буду делать через rgba от 1 до 0,1
	
	//константы мин и макс
	define("TABLEMIN", 1);
	define("TABLEMAX", 15);


	if($_POST) {
		$errorMessage = "Incorrect Form";
		//ВАЛИДАЦИЯ ФОРМЫ
		if( $_POST["userRows"] && $_POST["userCols"] ){
			//инпуты не пустые, двигаемся дальше
			$userRows = $_POST["userRows"];
			$userCols = $_POST["userCols"];
			//проверяю каждую переменную на число и соответствие от 1 до 15. Приведу к int на всякий случай
			if( is_numeric($userRows) && ($userRows >= TABLEMIN) && ($userRows <= TABLEMAX) ) {
				$userRowsValid = true;
				$userRows = (int) $userRows;
			} else {
				$errorMessage .= ". Invalid Rows";
			}
			if( is_numeric($userCols) && ($userCols >= TABLEMIN) && ($userCols <= TABLEMAX) ) {
				$userColsValid = true;
				$userCols = (int) $userCols;
			} else {
				$errorMessage .= ". Invalid Cols";
			}
		} else {
			//один интуп или оба пустые, меняю сообщение
			$errorMessage .= ". Empty inputs";
		}

		//ЕСЛИ ФОРМА ЗАПОЛНЕНА ВЕРНО
		if($userRowsValid && $userColsValid) {
			$errorMessage = "";
			//считаю шаг для альфа канала
			$stepAlpha = round( (1-0.1)/$userCols, 2); //нагуглил, что альфа-канал понимает 2 знака после запятой
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Table with gradient</title>
</head>
<body>
	<h1>Table with gradient</h1>
	<h2>min = 1, max = 15</h2>

	<form action="" method="POST">
		<div>
			<label for="userRows">Rows: </label>
			<input type="number" min="1" max="15" name="userRows" id="userRows" required>
		</div>
		<div>
			<label for="userCols">Cols: </label>
			<input type="number" min="1" max="15" name="userCols" id="userCols" required>
		</div>
		<button>Create table</button>
	</form>

	<hr>

	<table cellspacing="0" border="1" cellpadding="10">
		<?php for ( $i = 1; $i <= $userRows; $i++ ): 
			//генерирую 3 случайных числа от 0 до 255 для каждой строки
			$randRed = rand(0, 255);
			$randGreen = rand(0, 255);
			$randBlue = rand(0, 255);
		?>
			<tr>
				<?php for ( $j = 1; $j <= $userCols; $j++ ): 
					$rgbaC = "rgba({$randRed},{$randGreen},{$randBlue},".(1 - $stepAlpha * ($j-1) ).")";	//$j-1) - так как начали не с 0, но хочу чтобы первый цвет был с непрозрачностью 1
					?>
					<td style=<?="background-color:{$rgbaC}" ?> > <?=$rgbaC ?> </td>
				<?php endfor; ?>
			</tr>
		<?php endfor; ?>
	</table>

	<div class="alertMessage">
		<?=$errorMessage; ?>
	</div>

</body>
</html>