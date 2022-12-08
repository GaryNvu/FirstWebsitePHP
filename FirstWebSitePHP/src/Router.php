<?php

require_once("view/View.php");
require_once("control/Controller.php");
require_once("model/SneakerBuilder.php");

class Router{
  
  public $server;

  public function __construct($sneakerdb){
    $this->sneakerdb = $sneakerdb;
  }

  public function main(){
    session_start();
    if(key_exists('feedback', $_SESSION)){
      $feedback = $_SESSION['feedback'];
    }else{
      $feedback = '';
    }
    $_SESSION['feedback'] = '';

    $view = new View($this, $feedback);
    $controller = new Controller($view, $this->sneakerdb);

    try{
      // Si pas de chemin alors diriger vers l'accueil
      if(!key_exists('PATH_INFO', $_SERVER)){
        $view->makeHomePage();
      // Si un chemin alors verifier lequel
      }else{
        // Décomposition pour recuperer le page et l'identifiant
        $this->server = explode("/", $_SERVER['PATH_INFO']);

        if(key_exists(2, $this->server)){
          switch($this->server[2]){
            case "askDeletion":
              $controller->askSneakerDeletion($this->server[1]);
              break;
            case "deletion":
              $controller->sneakerDeletion($this->server[1]);
              break;
            case "modification":
              $controller->sneakerModification($this->server[1]);
              break;
            case "saveModification":
              $controller->saveSneakerModification($this->server[1], $_POST);
              break;
          }          
        }else{
          switch($_SERVER['PATH_INFO']){
            case "/list":
              $controller->sneakerList();
              break;
            case "/about":
              $controller->AboutPage();
              break;
            case "/new":
              $controller->newSneaker();
              break;
            case "/saveNew":
              $controller->saveNewSneaker($_POST);
              break;
            default:
              $_SERVER['PATH_INFO'] = str_replace("/", "", $_SERVER['PATH_INFO']);
              $controller->sneakerInformation($_SERVER['PATH_INFO']);
          }
        }
        
      }
    }catch(Exception $e){
      $view->makeUnexpectedErrorPage($e);
    }

    $view->render();
  }

  /* URL de la page d'accueil */
  public function getHomePageURL(){
    return "/dm-tw4b-2022/sneaker.php";
  }

  /* URL d'une page de sneaker */
  public function getSneakerURL($id) {
  	return ($this->getHomePageURL() . "/" . $id);
  }

  /* URL de la liste des sneaker */
  public function getListURL(){
    return ($this->getHomePageURL() . "/list");
  }

  /* URL de la page A propos */
  public function getAboutPage(){
    return ($this->getHomePageURL() . "/about");
  }

  /* URL du formulaire de creation */
  public function getSneakerCreationURL(){
    return ($this->getHomePageURL() . "/new");
  }

  /* URL de création de la nouvelle sneaker */
  public function getSneakerSaveURL(){
    return ($this->getHomePageURL() . "/saveNew");
  }

  /* URL de confirmation de suppression de la sneaker */
  public function getSneakerAskDeletionURL($id){
    return ($this->getHomePageURL() . "/$id/askDeletion");
  }

  /* URL de suppresion de la sneaker */
  public function getSneakerDeletionURL($id){
    return ($this->getHomePageURL() . "/$id/deletion");
  }

  /* URL du formulaire de modification d'une sneaker */
  public function getSneakerModificationURL($id){
    return ($this->getHomePageURL() . "/$id/modification");
  }

  /* URL de modification de la sneaker */
  public function getSneakerSaveModificationURL($id){
    return ($this->getHomePageURL() . "/$id/saveModification");
  }

  /* Fonction de redirection */
  public function POSTredirect($url, $feedback){
    $_SESSION['feedback'] = $feedback;
    header("Location: $url", true, 303);
    die;
  }
}

?>
