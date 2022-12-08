<?php

class SneakerStorageStub implements SneakerStorage{
  protected $db;

  public function __construct(){
    $this->db = array(
      'airForce' => new Sneaker('Air Force One', 'AirForce1.jpg', 'Nike', '120€'),
      'TN' => new Sneaker('TN', 'TN.jpg', 'Nike', '150€'),
      'airmax' => new Sneaker('Air Max 270', 'airmax270.jpg', 'Nike', '160€'),

      '550' => new Sneaker('550', '550.jpg', 'New Balance', '130€'),
      '574' => new Sneaker('574', '574.jpg', 'New Balance', '110€'),
      '2002R' => new Sneaker('2002R', '2002R.jpg', 'New Balance', '140€'),

      'ozweego' => new Sneaker('Ozweego', 'ozweego.jpg', 'Adidas', '130€'),
      'stansmith' => new Sneaker('Stansmith', 'stansmith.jpg', 'Adidas', '110€'),
      'superstar' => new Sneaker('Superstar', 'superstar.jpg', 'Adidas', '110€'),

      'xray' => new Sneaker('X-ray²', 'xray.jpg', 'Puma', '85€')
    );
  }

  public function read($id){
    if(key_exists($id, $this->db)){
      return($this->db[$id]);
    }
    return null;
  }

  public function readAll(){
    return $this->db;
  }

  public function create(Sneaker $s){
    print("oui");
  }
}

?>
