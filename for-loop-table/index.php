<?php
	$car1 = [
		'brand' => 'Toyota',
		'model' => 'Prius',
		'fuel' => 'Hybrid',
		'gear' => 'Auto',
		'price' => 25000
	];

	$car2 = [
		'brand' => 'Opel',
		'model' => 'Astra',
		'fuel' => 'Gasoline',
		'gear' => 'Mechanics',
		'price' => 15000
	];

	$car3 = [
		'brand' => 'Volkswagen',
		'model' => 'Passat',
		'fuel' => 'Diesel',
		'gear' => 'Mechanics',
		'price' => 28000
	];

	$car4 = [
		'brand' => 'Volkswagen',
		'model' => 'Golf',
		'fuel' => 'Gasoline',
		'gear' => 'Auto',
		'price' => 22000
	];

	$car5 = [
		'brand' => 'Subaru',
		'model' => 'Legacy',
		'fuel' => 'Gasoline',
		'gear' => 'Auto',
		'price' => 24000
	];


	$cars = [$car1, $car2, $car3, $car4, $car5];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>for-endfor</title>
</head>
<body>
	<table cellspacing="0" border="1" cellpadding="10">

		<tr>
			<?php foreach ($cars[1] as $key => $value): ?> 
				<th><?=$key ?></th>
			<?php endforeach; ?>
		</tr>

		<?php for ( $i = 0, $length = count($cars); $i < $length; $i++ ): 
			$bgclr = $i%2 ? 'ffffff' : 'ffeebb';
		?>
			<tr bgcolor=<?=$bgclr ?> >
				<td><?=$cars[$i]['brand'] ?></td>
				<td><?=$cars[$i]['model'] ?></td>
				<td><?=$cars[$i]['fuel'] ?></td>
				<td><?=$cars[$i]['gear'] ?></td>
				<td><?=$cars[$i]['price'] ?></td>
			</tr>
		<?php endfor; ?>
		
	</table>
</body>
</html>
