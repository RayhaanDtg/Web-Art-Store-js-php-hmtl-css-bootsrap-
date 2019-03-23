<?php
// class definition must be before session_start
require_once("classes/ShoppingCartItem.class.php");
require_once("classes/ShoppingCart.class.php");

require_once('includes/art-config.inc.php');
require_once('lib/ArtistDB.class.php');
require_once('lib/ArtWorkDB.class.php');
require_once('lib/GenreDB.class.php');
require_once('lib/SubjectDB.class.php');
require_once('lib/DatabaseHelper.class.php');

session_start();

// retrieve query string
if ( isset($_GET['artworkID']) ) {
   $workId = $_GET['artworkID'];
}
else {
   $workId = 424;   
}   

$artworkData = new ArtWorkDB();
$requestedWork = $artworkData->findById($workId);

// retrieve or create shopping cart
if ( !isset($_SESSION["ShoppingCart"])) {
   $_SESSION["ShoppingCart"] = new ShoppingCart();
}
$cart = $_SESSION["ShoppingCart"];

$cartItem = new ShoppingCartItem($workId, $requestedWork["Title"], $requestedWork["ImageFileName"], $requestedWork["MSRP"]);
$cart->addItem($cartItem, $workId);

$_SESSION["ShoppingCart"] = $cart;

// redirect to previous page
header('Location: ' . $_SERVER['HTTP_REFERER']);
//header('Location: display-cart.php');

?>