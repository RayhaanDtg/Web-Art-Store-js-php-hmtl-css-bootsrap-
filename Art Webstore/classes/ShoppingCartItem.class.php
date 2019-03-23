<?php

// This class represents an item within a shopping cart. 

class ShoppingCartItem implements Serializable {
   
   private $quantity=1;
   private $id;
   // note, normally you wouldn't store the next values within the cart (instead you
   // would look up the price dynamically from server). However, for simplicity sake,
   // this exercise does store these items in the cart   
   private $title;
   private $image;
   private $price;   

   // constructor
   function __construct($id, $title, $image, $price) {
      $this->id = $id;
      $this->quantity = 1;
      
      $this->title = $title;
      $this->image = $image;
      $this->price = $price;
   }   
   
   // getters for the class properties
   public function getId() { return $this->id; }
   public function getQuantity() { return $this->quantity; }
   public function getTitle() { return $this->title; }
   public function getImage() { return $this->image; }
   public function getPrice() { return $this->price; }
   
   // calculated property
   public function getSubtotal() { return $this->quantity * $this->price; }
   
   // we are only going to implement one setter
   public function setQuantity($quantity) {
      if (is_numeric($quantity) && $quantity >= 0 && $quantity < 1000)
         $this->quantity = $quantity;
   }
   

   // in order to work with sessions this class needs to be serializable
   
   public function serialize() {
      return serialize( array('id' => $this->id, 
                              'quantity' => $this->quantity, 
                              'title' => $this->title, 
                              'image' => $this->image, 
                              'price' => $this->price));
   }
   public function unserialize($data) {
      $data = unserialize($data);
      $this->quantity = $data['quantity'];
      $this->title = $data['title'];
      $this->image = $data['image'];
      $this->price = $data['price'];
   }
}

?>