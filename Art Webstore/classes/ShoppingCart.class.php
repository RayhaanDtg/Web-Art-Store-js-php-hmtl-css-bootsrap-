<?php

// class that represents an entire shopping cart

// rather simple right now ... a better OO version would implement Iterator interface
// instead of returning items array .. again simplified for teaching expediancy

class ShoppingCart implements Countable  {

   private $items = array();   

   // is the shopping cart empty?
   public function isEmpty() {
    return (empty($this->items));
   }
   
   // add ShoppingCartItem to cart
   public function addItem($item, $key) {   
      if (isset($this->items[$key])) {
         $this->items[$key]->setQuantity($this->items[$key]->getQuantity() + 1);
      } else { 
         $this->items[$key] = $item;
      }
   }

   // remove an item from the cart
   public function removeItem($key) {
      if (isset($this->items[$key])) {
         unset($this->items[$key]);
      }
   }
   
   // update the quantity of an item in the cart
   public function updateItem($key, $quantity) {
      if (isset($this->items[$key])) {
         if ($quantity == 0) {
            $this->removeItem($key);
         }
         else {
            $item = $this->items[$key]; 
            $item->setQuantity($quantity);
            $this->items[$key] = $item; 
         }
      }
   }   
   
   // return the count of the items in the cart
   public function count() {
      return count($this->items);
   }
   
   // see above note ... ideally would implement Iterator interface rather than
   // what we are doing here: returning internal collection
   public function getItems() { return $this->items; }
   
   // return the subtotal of all items in the cart
   public function getSubtotal() {
      $subtotal = 0.0;
      foreach ($this->items as $item) {
         $subtotal += $item->getSubtotal();
      }
      return $subtotal;
   }
   
}

?>