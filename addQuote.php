<!-- 
This is the addQuote page for Final Project, Quotation Service. 
It is a PHP file because later on you will add PHP code to this file.

File name addQuote.php 
    
Author: Kevin Callaghan
-->

<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<h1>Add a Quote</h1>


<div class="container">


	<form action="controller.php" method="post" id="quoteForm">
		<textarea class="quoteInput" name="quoteIn" form="quoteForm" placeholder="Enter quote here..." rows="4" cols="50"></textarea>
		<br>
		&nbsp;&nbsp;Author:
		<br>
		<input type="text" class="authorInput" name="authorIn">
		<br>
		<br>
		<input type='submit' value="Add Quote">
	</form>


</div>


</body>
</html>