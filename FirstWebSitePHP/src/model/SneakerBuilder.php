<?php

require_once("model/Sneaker.php");

/* Classe représentant un builder pour manipuler les objets */

class SneakerBuilder {

	protected $data;
	protected $errors;

    const NAME_REF = "name";
    const IMAGE_REF = "image";
    const BRAND_REF = "brand";
    const PRICE_REF = "price";

	public function __construct($data = null) {
		if ($data === null) {
			$data = array(
				self::NAME_REF => "",
                self::IMAGE_REF => "",
                self::BRAND_REF => "",
                self::PRICE_REF => "",
			);
		}
		$this->data = $data;
		$this->errors = array();
	}

    /* Retourne une nouvelle instance de SneakerBuilder avec les données de la sneaker
    * passée en paramètre */
    public static function makeBuilderWithSneaker(Sneaker $sneaker) {
		$newBuilder = new SneakerBuilder(array(
			self::NAME_REF => $sneaker->getName(),
			self::IMAGE_REF => $sneaker->getImage(),
            self::BRAND_REF => $sneaker->getBrand(),
			self::PRICE_REF => $sneaker->getPrice(),
		));
        return $newBuilder;
	}

    /* Retourne la valeur associée a la référence passée en paramètre */
    public function getData($ref){
        if(key_exists($ref, $this->data)){
            return $this->data[$ref];
        }
        return null;
    }

    /* Retourne l'erreur associée à la référence passée en paramètre */
    public function getError($ref){
        if(key_exists($ref, $this->errors)){
            return $this->errors[$ref];
        }else{
            return null;
        } 
    }

    /* Upload une image stockée dans la variable $_FILE dans le dossier Upload
    * après avoir fait une verification avec isValid */
    public function uploadImage(){
        $image = $_FILES['image'];
        $nom = explode(".", $image['name']);
        $newId = uniqid() . "." . $nom[1];
        move_uploaded_file($image['tmp_name'], "/users/22001800/www-dev/dm-tw4b-2022/upload/{$newId}");
        $this->data[self::IMAGE_REF] = $newId;
    }

    /* Fonction retournant une nouvelle instance de Sneaker avec les données
    * stockées dans le tableau data. */
    public function createSneaker(){
        if(!key_exists(self::NAME_REF, $this->data)){
            $this->data[self::NAME_REF] = "";
        }
        $name = $this->data[self::NAME_REF];

        if(!key_exists(self::IMAGE_REF, $this->data)){
            $this->data[self::IMAGE_REF] = "";
        }
        $this->uploadImage();
        $image = $this->data[self::IMAGE_REF];
        
        if(!key_exists(self::BRAND_REF, $this->data)){
            $this->data[self::BRAND_REF] = "";
        }
        $brand = $this->data[self::BRAND_REF];

        if(!key_exists(self::PRICE_REF, $this->data)){
            $this->data[self::PRICE_REF] = "";
        }
        $price = $this->data[self::PRICE_REF];
        return new Sneaker($name, $image, $brand, $price);
    }

    /* Vérifie la validité des informations fournies par l'utilisateur et
    * retourne une array indiquant la ou les erreurs présentes dans le formulaire */
    public function isValid(){
        $this->errors = array();
        if (!key_exists(self::NAME_REF, $this->data) || $this->data[self::NAME_REF] === ""){
			$this->errors[self::NAME_REF] = "Aucun Nom";
        }
        if (!key_exists(self::BRAND_REF, $this->data) || $this->data[self::BRAND_REF] === ""){
            $this->errors[self::BRAND_REF] = "Aucune Marque";
        }
        if(!key_exists(self::PRICE_REF, $this->data) || intval($this->data[self::PRICE_REF]) < 0 || $this->data[self::PRICE_REF] === ""){
            $this->errors[self::PRICE_REF] = "Prix incorrect";
        }
        if($_FILES['image'] != null){
            $image = $_FILES['image'];
            if($image['name'] === "" || $image['size'] === 0){
                $this->errors[self::IMAGE_REF] = "Aucune image";
            }else{
                $fileExtension = pathinfo($image['name']);
                $fileExtension = $fileExtension['extension'];
                $extensions = ['jpg', 'jpeg', 'gif', 'png'];
                if($image['size'] > 500000){
                    $this->errors[self::IMAGE_REF] = "Fichier trop volumineux";
                }else if(!in_array($fileExtension, $extensions)){
                    $this->errors[self::IMAGE_REF] = "Type de fichier incompatible";
                }
            }
        }
        return count($this->errors) === 0;
    }

    /* Modifie les informations de la sneaker passée en paramètre par
    * celles contenues dans cette instance */
    public function updateSneaker(Sneaker $sneaker) {
		if(key_exists(self::NAME_REF, $this->data)){
			$sneaker->setName($this->data[self::NAME_REF]);
        }
        if(key_exists(self::BRAND_REF, $this->data)){
			$sneaker->setBrand($this->data[self::BRAND_REF]);
        }
        if(key_exists(self::PRICE_REF, $this->data)){
			$sneaker->setPrice($this->data[self::PRICE_REF]);
        }

        /* Supprimer ancienne image */
        $del = "/users/22001800/www-dev/dm-tw4b-2022/upload/" . $sneaker->getImage();
        unlink($del);
        /* Uploader la nouvelle image */
        $this->uploadImage();
        
        if(key_exists(self::IMAGE_REF, $this->data)){
			$sneaker->setImage($this->data[self::IMAGE_REF]);
        }
        return $sneaker;
	}
}

?>
