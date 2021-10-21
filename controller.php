<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Kevin Callaghan
//  
session_start (); // Not needed until a future iteration

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo getQuotesAsHTML ( $arr );
}

if (isset( $_POST ['quoteIn'] ) && isset( $_POST ['authorIn']) ) {
    if (!empty($_POST ['quoteIn']) && !empty($_POST ['authorIn'])){
        $arr = $theDBA->addQuote($_POST ['quoteIn'], $_POST ['authorIn']);
        unset($_POST ['quoteIn']);
        unset($_POST ['authorIn']);
        header ( "Location: view.php" ); 
    }
    else {
        header ( "Location: view.php" ); 
    }
}

if (isset( $_POST ['update'] ) && isset( $_POST ['ID'] )) {
    $whichUpdate = $_POST ['update'];
    $quoteId = $_POST ['ID'];
    unset($_POST ['update']);
    unset($_POST ['ID']);
    if($whichUpdate == "delete"){
      $theDBA->delete($quoteId);
    }
    if($whichUpdate == "increase"){
        $theDBA->raiseRating($quoteId);
    }
    if($whichUpdate == "decrease"){
        $theDBA->lowerRating($quoteId);
    }
    header ( "Location: view.php" ); 
}

if (isset( $_POST ['logout'] )) {
    unset($_POST ['logout']);
    unset($_SESSION ['user']);
    header ( "Location: view.php" );
}

function getQuotesAsHTML($arr) {
    // TODO 6: Many things. You should have at least two quotes in 
    // table quotes. layout each quote using a combo of PHP and HTML 
    // strings that includes HTML for buttons along with the actual 
    // quote and the author, ~15 PHP statements. This function will 
    // be the most time consuming in Quotes 1. You will
    // need to add css rules to styles.css. 
    $result = '';
    $deleteButton = "";
    if(isset($_SESSION['user'])) {
        $deleteButton = '<button name="update" value="delete">Delete</button>';
    }
    
    foreach ($arr as $quote) {
        $result .= '<div class="container">' . PHP_EOL;
        $result .= '"' . $quote ['quote'] . '"' . PHP_EOL;
        $result .= "<br>" . PHP_EOL;
        $result .= "<p class='author'>" . PHP_EOL;
        $result .= "&nbsp;&nbsp;--" . $quote['author'] . "<br></p>" . PHP_EOL;
        $result .= '<form action="controller.php" method="post">' . PHP_EOL;
        $result .= '  <input type="hidden" name="ID" value="' . $quote['id'] . '">&nbsp;&nbsp;&nbsp;' . PHP_EOL;
        $result .= '<button name="update" value="increase">+</button>' . PHP_EOL;
        $result .= '&nbsp;<span id="rating">'. $quote['rating'] .'</span>&nbsp;&nbsp;' . PHP_EOL;
        $result .= '<button name="update" value="decrease">-' . PHP_EOL;
        $result .= '</button>&nbsp;&nbsp;' . PHP_EOL;
        $result .= $deleteButton . PHP_EOL;
        $result .= '</form>' . PHP_EOL;
        $result .= '</div>' . PHP_EOL;
    }
    
    return $result;
}

if (isset( $_POST ['usernameIn'] ) && isset( $_POST ['passwordIn'] )) {
    $arr = $theDBA->getAllUsers();
    $flag = false;
    for($i = 0; $i < count($arr); $i++){
        if($arr[$i]['username'] === $_POST ['usernameIn']){
            $flag = true;
        }
    }
    if($flag == true){
        echo '<!DOCTYPE html>
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
		           <input type="password" name="passwordIn" placeholder="Password">
		           <br>
		           <br>
		           <input type="submit">
                   <h3>Account name taken</h3>
	          </form>
            
              </div>
            
              </body>
              </html>';
    }
    else {
        $theDBA->addUser($_POST ['usernameIn'], $_POST ['passwordIn']);
        header ( "Location: view.php" );
    }
    unset($_POST ['usernameIn']);
    unset($_POST ['passwordIn']);
}

if (isset( $_POST ['usernameLogin'] ) && isset( $_POST ['passwordLogin'] )) {
    $b = $theDBA->verifyCredentials($_POST ['usernameLogin'], $_POST ['passwordLogin']);
    if($b == false){
        echo '<!DOCTYPE html>
                <html>
                <head>
                    <title>Quotation Service</title>
                    <link rel="stylesheet" type="text/css" href="styles.css">
                </head>
            
                <body>
                <?php
                    session_start();
                ?>
            
                <h1>Login</h1>
            
                <div class="formContainer">
            
	               <form action="controller.php" method="post" id="login">
		              <input type="text" name="usernameLogin" placeholder="Username">
		              <br>
		              <br>
		              <input type="text" name="passwordLogin" placeholder="Password">
	                  <br>
		              <br>
		              <input type="submit">
		              <h3>Invalid Account/Password</h3>
                   </form>
            
                </div>
            
                </body>
                </html>';
    }
    else{
        $_SESSION['user'] = $_POST ['usernameLogin'];
        header ( "Location: view.php" );
    }
    unset($_POST ['usernameLogin']);
    unset($_POST ['passwordLogin']);
}

?>

