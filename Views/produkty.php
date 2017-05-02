<?php
require_once '../Controllers/SessionController.php';
require_once '../Controllers/DatabaseManager.php';
require_once '../Controllers/ViewController.php';

////////////////////////////////// Session timer //////////////////////////////////
session_start();
if(isset($_SESSION['login'])){
	$sessionController = new SessionController();
	$sessionController->checkSessionTime($_SESSION['sessionStart']);
}
// No redirect. Available for every user
////////////////////////////////// Navigation Bar //////////////////////////////////
$viewController = new ViewController();
echo $viewController->getNavBar();
echo $viewController->getPageHead("Produkty");

echo '<h2>Wszystkie produkty</h2><br>';
////////////////////////////////////////////// Product searcher ////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$databaseManager = new DatabaseManager();

//// Searcher form ////
echo 	'<div class="searcher">
			<form method="post">
				<b text-align="center">Wyszukaj</b>
				<br><br><input type="search" name="search"/>
				<br><br><input type="submit" name="submit" value="Szukaj" />
			<form>
		</div>';

if (isset($_POST['search'])) {
	$search = mysql_real_escape_string(htmlentities($_POST['search'], ENT_QUOTES, "UTF-8"));

	$query = "SELECT p_ID, name, price, author, artist FROM products WHERE MATCH (name, author, artist)
	AGAINST ('*".$search."*' IN BOOLEAN MODE) GROUP BY name";
	
	if ($result = $databaseManager->getFromDatabase($query)){
		if ($result->num_rows < 1) 
			echo "Niestety, nie znaleziono wyszukiwanego przez ciebie przedmiotu";
		else{
			while($row = $result->fetch_assoc()){
				echo '<a href=productView.php?p_ID='.$row['p_ID'].' class="mainLink">
						<div class="product">
							<span class=prodLink>'.$row['name'].'</span>
							<br>Cena: '.str_replace(".", ",", number_format($row['price'],2))." PLN<br>";
							if ($row['author']) echo $row['author'];
							if ($row['artist']) echo $row['artist'];
				echo "</div></a><br>";
			}
		}
	}
	$result->free_result();
	unset($_POST['search']); // Unset search phrase //
}
///////////////////////////// Request for all SPECIFIED by a type products in database /////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
elseif (isset($_GET['type'])) {

	$query = "SELECT p_ID, name, price, author, artist FROM products WHERE type LIKE '".$_GET['type']."'";

	if ($result = $databaseManager->getFromDatabase($query)){
		while ($row = $result->fetch_assoc()) {
			echo '<a href=productView.php?p_ID='.$row['p_ID'].' class="mainLink">
					<div class="product">
						<span class=prodLink>'.$row['name'].'</span>
						<br>Cena: '.str_replace(".", ",", number_format($row['price'],2))." PLN<br>";
						if ($row['author']) echo $row['author'];
						if ($row['artist']) echo $row['artist'];
			echo 	"</div></a><br>";
		}
	}
	$result->free_result();
}	
else{
///////////////////////////////////// Request for ALL products in database /////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$query = 'SELECT p_ID, name, price, author, artist FROM `products`';

	if($result = $databaseManager->getFromDatabase($query)){
		while($row = $result->fetch_assoc()){
			echo '<a href=productView.php?p_ID='.$row['p_ID'].' class="mainLink">
					<div class="product">
						<span class=prodLink>'.$row['name'].'</span>
						<br>Cena: '.str_replace(".", ",", number_format($row['price'],2))." PLN<br>";
						if ($row['author']) echo $row['author'];
						if ($row['artist']) echo $row['artist'];
			echo 	"</div></a><br>";
		}
	}
	$result->free_result();
}

echo '<div style="clear:both"></div>';
?>
</body>
</html>