<!-- 
File name register.php 
    
Author: Kevin Callaghan
-->

<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
<?php 
    session_start();
?>

<h1>Register</h1>

<div class="formContainer">

	<form action="controller.php" method="post" id="registration">
		<input type="text" name="usernameIn" placeholder="Username">
		<br>
		<br>
		<input type="text" name="passwordIn" placeholder="Password">
		<br>
		<br>
		<input type='submit'>
		<br>
		<br>
	</form>

</div>

</body>
</html>