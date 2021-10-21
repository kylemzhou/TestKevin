<!-- 
This is the home page for Final Project, Quotation Service. 
It is a PHP file because later on you will add PHP code to this file.

File name quotes.php 
    
Authors: Rick Mercer and Kevin Callaghan
-->

<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body onload="showQuotes()">
<?php 
    session_start();
?>

<h1>Quotation Service</h1>

<?php 
if(!isset($_SESSION['user'])){
    echo   '<a href="./register.php" ><button>Register</button></a>
            <a href="./login.php" ><button>Login</button></a>';
}
else{
    echo   '<a href="./addQuote.php" ><button>Add Quote</button></a>
            <form action="controller.php" method="post">
                <input type="submit" name="logout" value="logout">
            </form>
            <h3>Hello '. $_SESSION['user']. '</h3>';
}
?>

<div id="quotes"></div>

<script>
var element = document.getElementById("quotes");
function showQuotes() {
	//alert('view.php under construction');
	
    // TODO 5: 
    // Complete this function using an AJAX call to controller.php
  	// You will need query parameter ?todo=getQuotes.
  	// Echo back one big string to here that has all styled quotations.
  	// Write all of the complex code to layout the array of quotes 
  	// inside function getQuotesAsHTML inside controller.php

	//element.innerHTML = "test passed";

	var ajax = new XMLHttpRequest();

	ajax.open("GET", "controller.php?todo=getQuotes", true);

	ajax.send();
	ajax.onreadystatechange = function() {
		if (ajax.readyState == 4 && ajax.status == 200) {
			var responseS = ajax.responseText;
			document.getElementById("quotes").innerHTML = responseS;
		}
	};
	
} // End function showQuotes

</script>

</body>
</html>