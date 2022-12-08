<?php

require_once("lib/ObjectFileDB.php");
require_once("model/Sneaker.php");
require_once("model/SneakerStorage.php");

/* Classe gérant le stockage des sneakers dans la base de donnée SQL */

class SneakerStorageMySQL implements SneakerStorage{
  protected $db;
  protected $pdo;

  public function __construct($pdo){
    $this->pdo = $pdo;
  }

  /* Renvoie la sneaker d'identifiant $id, ou null
	 * si l'identifiant ne correspond à aucune couleur. */
  public function read($id){
    $requete = "SELECT * FROM sneakers WHERE id=:id;";
    $stmt = $this->pdo->prepare($requete);
    $data = array(
      ':id' => $id,
    );
    $stmt->execute($data);
    $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

    if($ligne == null){
      return null;
    }else{
      $sneaker = new Sneaker($ligne['name'],$ligne['image'],$ligne['brand'],$ligne['price']);
    }
    return($sneaker);
  }

  /* Renvoie un tableau associatif id => Sneaker
	 * contenant toutes les sneakers de la base. */
  public function readAll(){
    $requete = "SELECT * FROM sneakers;";
    $stmt = $this->pdo->query($requete);
    $tableau = $stmt->fetchAll();
    $array = array();
    foreach ($tableau as $ligne) {
    /* les champs correspondant à des indices */
      $array[$ligne['id']] = new Sneaker($ligne['name'],$ligne['image'],$ligne['brand'],$ligne['price']);
    }
    return $array;
  }

  /* Insère une nouvelle sneaker dans la base. Renvoie l'identifiant
	 * de la nouvelle sneaker. */
  public function create(Sneaker $s){
    $requete = "INSERT INTO sneakers(name,image,brand,price) VALUES (:name,:image,:brand,:price);";
    $stmt = $this->pdo->prepare($requete);
    $data = array(
      ':name' => $s->getName(),
      ':image' => $s->getImage(),
      ':brand' => $s->getBrand(),
      ':price' => $s->getPrice(),
    );
    $stmt->execute($data);

    $name = $s->getName();
    $requete = "SELECT * FROM sneakers WHERE name='$name';";
    $stmt = $this->pdo->query($requete);

    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    return $res['id'];
  }

  /* Supprime une sneaker. Renvoie
	 * true si la suppression a été effectuée, false
	 * si l'identifiant ne correspond à aucune couleur. */
  public function delete($id){
    if($this->read($id)){
      $requete = "DELETE FROM sneakers WHERE id=:id;";
      $stmt = $this->pdo->prepare($requete);
      $data = array(
        ':id' => $id,
      );
      $stmt->execute($data);
      return True;
    }else{
      return False;
    }
  }

  /* Met à jour une sneaker dans la base. Renvoie
	 * true si la modification a été effectuée, false
	 * si l'identifiant ne correspond à aucune couleur. */
  public function update($id, $sneaker){
    $name = $sneaker->getName();
    $image = $sneaker->getImage();
    $brand = $sneaker->getBrand();
    $price = $sneaker->getPrice();
    $requete = "UPDATE sneakers
                SET name='$name',
                image='$image',
                brand='$brand',
                price='$price'
                WHERE id='$id';";
    $stmt = $this->pdo->query($requete);
  }
}
?>
