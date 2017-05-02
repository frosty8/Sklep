<?php
/**
* 
*/
class ViewController
{
////////////////////////////////// Main navigation bar //////////////////////////////////

	public function getpageHead($title)
	{
		return '<!DOCTYPE="html">
				<html>
				<head>
					<title>'.$title.'</title>
					<link rel="stylesheet" type="text/css" href="../styles.css">
					<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
				</head>';
	}
////////////////////////////////// Main navigation bar //////////////////////////////////

	public function getNavBar()
	{
		return '<div class="navBar">
					<ol>
						<li><a href="index.php" class="mainLink">Strona Główna</a></li>
						<li><a href="produkty.php" class="mainLink">Produkty</a>
							<ul>
								<li><a href="produkty.php?type=book" class="mainLink">Książki</a></li>
								<li><a href="produkty.php?type=album" class="mainLink">Muzyka</a></li>
							</ul>
						</li>
						<li><a href="register.php" class="linkDistinct">Zarejestruj się</a></li>
					</ol>
				</div>
				<div style="clear: both;"></div>';
	}
//////////////////////////////////////// Side bar ////////////////////////////////////////

	public function getSideBar($loggedStatus){
		if ($loggedStatus) {
			return '<div class="sideBar">
						<div style="text-align:center;border-bottom: 3px solid #787878">
							<b>'.$_SESSION['login'].'</b>
						</div>
						<div class="sideTile"><a href="../logout.php" class="link">Wyloguj się</a></div>
						<div class="sideTile"><a href="myProfile.php" class="link">Konto</a></div>
						<div class="sideTile"><a href="basket.php" class="link">Koszyk</a></div>
					</div>
					<div style="clear: both;"></div>';
		}
		else{
		return '<div class="sideBar">
				 	<div class="sideTile"><a href="register.php" class="link">Zarejestruj się</a></div>
				 	<div class="sideTile"><a href="login.php" class="link">Zaloguj się</a></div>
				</div>
				<div style="clear: both;"></div>';
		}		 
	}
//////////////////////////////////////// (ADMIN) ProductForm /////////////////////////////////////

	public function getAdminForm(){

		return '<form method="post">
					<fieldset>
					<legend>Wstaw nowy produkt</legend>
					<br>Tytuł<br>
						<input type="text" name="productName" size="60">
					<br>Cena<br>
						<input type="text" name="productPrice" size="60">
					<br>Autor/wykonawca<br>
						<input type="text" name="productAuthor" size="60">
					<br>Opis<br>
						<textarea name="productDescription" rows="8" cols="60"></textarea>
					<br>Typ<br>
						<input type="radio" name="productType" value="Book" checked> Książka
						<input type="radio" name="productType" value="Album"> Album
					<br><br>
						<input type="submit" value="Wstaw dane">
					</fieldset>
				</form>';
		
	}
//////////////////////////////////////// Register form ////////////////////////////////////////

	public function getRegisterForm()
	{
		return	
				'<h2>Zarejestruj się</h2><br>
				<form method="post">
					<h2>Login</h2>
					<input type="text" name="newLogin">
					<br>
					<h2>Hasło</h2>
					<input type="password" name="newPassword">
					<h3>Adres</h3>
					<input type="text" name="newAdress">
					<br><br>
					<input type="checkbox" name="newRules"> Akceptuję zasady korzystania z serwisu
					<br><br>
					<input class="button1" type="submit" name="submit" value="Zarejestruj nowe konto">
				</form>';
	}
//////////////////////////////////////// Logging form ////////////////////////////////////////

	public function getLoggingForm()
	{
		return	
				'<h2>Zaloguj się</h2><br>
				<form method="post">
					<h2>Login</h2>
					<input type="text" name="login">
					<br>
					<h2>Hasło</h2>
					<input type="password" name="password">
					<br><br>
					<input class="button1" type="submit" name="submit" value="Zaloguj się">
				</form>';
	}
//////////////////////////////////////// Footer links ////////////////////////////////////////

	public function getFooterLinks(){

		return '<h3><a class="linkBack" href="./produkty.php">Wszystkie produkty</a></h3>
			    <h4><a class="linkBack" href="./index.php">Strona główna</a></h4>';

	}

}				
?>