<?php
// class definition must be before session_start
require_once("classes/ShoppingCartItem.class.php");
require_once("classes/ShoppingCart.class.php");

session_start();

// in a real application, these constants would likely be defined
// within an external file
define("TAX_PERCENT",0.10);
define("SHIPPING_THRESHOLD",2000);
define("SHIPPING_FLAT_AMOUNT",100);   

// retrieve or create shopping cart
if ( !isset($_SESSION["ShoppingCart"])) {
   $_SESSION["ShoppingCart"] = new ShoppingCart();
}
$cart = $_SESSION["ShoppingCart"];  

// outputs a single cart item
function outputCartRow($file, $title, $quantity, $price) {
   echo '<tr>';
   echo '<td><img class="img-thumbnail" src="images/art/works/tiny/' . $file . '.jpg" alt="..."></td>';
   echo '<td>' . $title . '</td>';
   echo '<td>' . $quantity . '</td>';
   echo '<td>$' . number_format($price,2) . '</td>';
   echo '<td>$' . number_format($quantity * $price,2) . '</td>';
   echo '</tr>';
}

// display all the items in the shopping cart
function outputShoppingCart($cart) {
   foreach ($cart->getItems() as $item) {         
      // retrieve cart from session
      outputCartRow( $item->getImage(), $item->getTitle(), $item->getQuantity(), $item->getPrice() );
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Assignment 3</title>

 <!-- Bootstrap core CSS  -->    
 <link href="bootstrap3_defaultTheme/dist/css/bootstrap.css" rel="stylesheet"> 
 <!-- Custom styles for this template -->
 <link href="bootstrap3_defaultTheme/theme.css" rel="stylesheet">

 </head>

<body>



<?php include 'includes/art-header.inc.php' ?>

<div class="container">

   <div class="page-header">
      <h2>View Cart</h2>
         
      <table class="table table-condensed">
         <tr>
            <th>Image</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Amount</th>
         </tr>
         <?php
            // display all the items in the shopping cart
            outputShoppingCart($cart);
            
            // now calculate subtotal, tax, shipping, and grand total
            $subtotal = $cart->getSubtotal();
            $tax = $subtotal * TAX_PERCENT;
            $shipping = 0;
            if ($subtotal <= SHIPPING_THRESHOLD)
               $shipping = SHIPPING_FLAT_AMOUNT;
            $grandTotal = $subtotal + $tax + $shipping;

         ?>
 
         <tr class="success strong">
            <td colspan="4" class="moveRight">Subtotal</td>
            <td>$<?php echo number_format($subtotal,2) ?></td>
         </tr>
         <tr class="active strong">
            <td colspan="4" class="moveRight">Tax</td>
            <td>$<?php echo number_format($tax,2) ?></td>
         </tr>  
         <tr class="strong">
            <td colspan="4" class="moveRight">Shipping</td>
            <td>$<?php echo number_format($shipping,2) ?></td>
         </tr> 
         <tr class="warning strong text-danger">
            <td colspan="4" class="moveRight">Grand Total</td>
            <td>$<?php echo number_format($grandTotal,2) ?></td>
         </tr>    
         <tr >
            <td colspan="4" class="moveRight"><button type="button" class="btn btn-primary" >Continue Shopping</button></td>
            <td><a href="emptyCart.php" class="btn btn-success" >Checkout</a></td>
         </tr>
      </table>         
         
         

   </div>  <!-- end main row --> 
</div>  <!-- end container -->

<?php include 'includes/art-footer.inc.php' ?>

 <!-- Bootstrap core JavaScript
 ================================================== -->
 <!-- Placed at the end of the document so the pages load faster -->
 <script src="bootstrap3_defaultTheme/assets/js/jquery.js"></script>
 <script src="bootstrap3_defaultTheme/dist/js/bootstrap.min.js"></script>    
</body>
</html>
