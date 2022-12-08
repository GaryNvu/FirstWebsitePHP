<?php

require_once("lib/ObjectFileDB.php");
require_once("model/Sneaker.php");
require_once("model/SneakerStorage.php");

class SneakerStorageFile implements SneakerStorage{
  protected $db;

  public function __construct($file){
    $this->db = new ObjectFileDB($file);
  }

  public function reinit(){
    $this->db->deleteAll();
    $objects = array(
      'airForce' => new Sneaker('Air Force One', 'AirForce1.jpg', 'Nike', '120'),
      'TN' => new Sneaker('TN', 'TN.jpg', 'Nike', '150€'),
      'airmax' => new Sneaker('Air Max 270', 'airmax270.jpg', 'Nike', '160'),

      '550' => new Sneaker('550', '550.jpg', 'New Balance', '130'),
      '574' => new Sneaker('574', '574.jpg', 'New Balance', '110'),
      '2002R' => new Sneaker('2002R', '2002R.jpg', 'New Balance', '140'),

      'ozweego' => new Sneaker('Ozweego', 'ozweego.jpg', 'Adidas', '130'),
      'stansmith' => new Sneaker('Stansmith', 'stansmith.jpg', 'Adidas', '110'),
      'superstar' => new Sneaker('Superstar', 'superstar.jpg', 'Adidas', '110'),

      'xray' => new Sneaker('X-ray²', 'xray.jpg', 'Puma', '85')
    );
    foreach($objects as $key => $value){
      $this->db->insert($value);
    }
  }

  public function read($id){
    return $this->db->fetch($id);
  }

  public function readAll(){
    return $this->db->fetchAll();
  }

  public function create(Sneaker $s){
    return $this->db->insert($s);
  }
  
  public function delete($id){
    $this->db->delete($id);
  }

  public function update($id, $sneaker){
    $this->db->update($id, $sneaker);
  }
}
?>
