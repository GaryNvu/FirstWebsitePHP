<?php

/* Classe représentant une sneaker */

class Sneaker{
    protected $name;
    protected $image;
    protected $brand;
    protected $price;

    public function __construct($name, $image, $brand, $price){
      $this->name = $name;
      $this->image = $image;
      $this->brand = $brand;
      $this->price = $price;
    }

    /* Renvoie le nom de la sneaker */
    public function getName(){
      return $this->name;
    }

    /* Renvoie le nom de l'image de la sneaker */
    public function getImage(){
      return $this->image;
    }

    /* Renvoie la marque de la sneaker */
    public function getBrand(){
      return $this->brand;
    }

    /* Renvoie le prix de la sneaker */
    public function getPrice(){
      return $this->price;
    }

    /* Modifie le nom de la sneaker avec celui passé en paramètre */
    public function setName($newName){
      $this->name = $newName;
    }

    /* Modifie le nom de l'image de la sneaker avec celle passé en paramètre */
    public function setImage($newImage){
      $this->image = $newImage;
    }

    /* Modifie la marque de la sneaker avec celle passé en paramètre */
    public function setBrand($newBrand){
      $this->brand = $newBrand;
    }

    /* Modifie le prix de la sneaker avec celui passé en paramètre */
    public function setPrice($newPrice){
      $this->price = $newPrice;
    }
}
?>
