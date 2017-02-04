<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Form to JSON</title>
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.98.0/js/materialize.min.js"></script>
	<script src="script.js"></script>
</head>
<body>
	<main>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<h1>Please fill the form</h1>
					<form action="index.php" method="POST">
						<div class="input-field">
							<input placeholder="e.g. Sam Baggins" id="user_name" type="text" name="user_name" class="validate">
							<label for="user_name">Your Name</label>
						</div>
						<div class="input-field">
							<input id="user_email" type="email" name="user_email" class="validate">
							<label for="user_email">Your Email</label>
						</div>

						<div class="input-field">
							<select multiple name="user_interests[]" class="filled-in-style">
								<option value="" disabled selected>Choose options</option>
								<option value="JavaScript">JavaScript</option>
								<option value="PHP">PHP</option>
								<option value="SQL">SQL</option>
							</select>
							<label>Select your interests</label>
						</div>

						<div class="switch">
							<label>
								Do not disturb
								<input type='hidden' value='off' name='notify_user'>
								<input checked type="checkbox" name="notify_user">
								<span class="lever"></span>
								Send me tonifications
							</label>
						</div>

						<button class="btn-large waves-effect waves-light userForm_submit" type="submit">
							<i class="material-icons right">send</i>GO
						</button>

					</form>
				</div>

				<?php
					if($_POST['user_name'] !== "" && $_POST['user_email'] !== "") {
						echo "Your name is <strong>{$_POST[user_name]}</strong>, your email is <strong>{$_POST[user_email]}</strong>.<br>";
						echo "JSON: " . json_encode( $_POST, JSON_UNESCAPED_UNICODE );
					} else {
						echo "Fill all inputs!";
					}
				?>

			</div>
		</div>
	</main>
</body>
</html>