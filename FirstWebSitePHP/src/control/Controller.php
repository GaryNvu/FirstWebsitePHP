<?php

require_once("model/Sneaker.php");
require_once("model/SneakerStorage.php");
require_once("model/SneakerBuilder.php");
require_once("view/View.php");

/* Controleur du site */

class Controller{

    protected $view;
    protected $sneakerdb;

    public function __construct(View $view, SneakerStorageMySQL $sneakerdb){
      $this->view = $view;
      $this->sneakerdb = $sneakerdb;
    }

    /* Appelle la vue de la sneaker corespondant à l'id passé en paramètre */
    public function sneakerInformation($id) {
      $sneaker = $this->sneakerdb->read($id);
      if($sneaker !== null){
        // La sneaker existe on affichage la page
        $this->view->makeSneakerPage($id, $sneaker);
      }else{
        // Elle n'existe pas on affiche une page d'erreur
        $this->view->makeUnexpectedErrorPage("Sneaker inexistante");
      }
    }

    /* Apelle la vue de la liste des sneakers */
    public function sneakerlist(){
      $this->view->makeListPage($this->sneakerdb->readAll());
    }

    /* Appelle la vue des informations complémentaires */
    public function AboutPage(){
      $this->view->makeAboutPage();
    }

    /* Appelle la vue de création d'une sneaker */
    public function newSneaker(){
      if(key_exists('currentSneaker', $_SESSION)){
        if($_SESSION['currentSneaker'] !== null){
          $this->view->makeSneakerCreationPage($_SESSION['currentSneaker']);
        }else{
          $this->view->makeSneakerCreationPage(new SneakerBuilder());
        }
      }else{
        $this->view->makeSneakerCreationPage(new SneakerBuilder());
      }
    }

    /* Crée si possible une nouvelle sneaker avec la grille donnée en paramètre 
    et redirige vers la page de la sneaker */
    public function saveNewSneaker(array $data){
      $sneakerBuild = new SneakerBuilder($data);
      if($sneakerBuild->isValid()){
        // On crée la nouvelle sneaker
        $newSneaker = $sneakerBuild->createSneaker();
        // On l'ajoute dans la BDD
        $id = $this->sneakerdb->create($newSneaker);
        // On reinitialise la varaible de session
        $_SESSION['currentSneaker'] = null;
        // On redirige vers les etapes suivante de creation
        $this->view->displaySneakerCreationSuccess($id);
      }else{
        $_SESSION['currentSneaker'] = $sneakerBuild;
        // On redirige vers le formulaire de creation
        $this->view->displaySneakerCreationFailure();
      }
    }

    /* Vérifie si la sneaker existe et redirige selon le résultat */ 
    public function askSneakerDeletion($id){
      // On recupere la sneaker
      $sneaker = $this->sneakerdb->read($id);
      if($sneaker !== null){
        // Si elle existe on redirige vers les etapes suivante de suppression
        $this->view->makeAskSneakerDeletionPage($id);
      }else{
        // Si elle n'existe pas on affiche une page d'erreur
        $this->view->makeUnexpectedErrorPage("Sneaker inexistante");
      }
    }

    /* Supprime une sneaker et appelle la vue de la page de confirmation de suppression */
    public function sneakerDeletion($id){
      // On supprime l'image du dossier upload */
      $sneaker = $this->sneakerdb->read($id);
      $del = "/users/22001800/www-dev/dm-tw4b-2022/upload/" . $sneaker->getImage();
      unlink($del);
      // On supprime la sneaker
      $this->sneakerdb->delete($id);
      // On affiche la page de suppression
      $this->view->makeSneakerDeletionPage($id);
    }

    /* Prépare la page de formulaire de modification grâce a l'identifiant donné en paramètre */
    public function sneakerModification($id){
      // On recupere la sneaker dans la BDD
      $sneaker = $this->sneakerdb->read($id);
      // On construit un builder avec la sneaker recuperee
      $sneakerBuild = SneakerBuilder::makeBuilderWithSneaker($sneaker);
      // On construit la page de formulaire
      $this->view->makeSneakerModificationPage($id, $sneakerBuild);
    }

    /* Met à jour la sneaker correspondant à l'id en paramètre avec
    les informations de la grille données en paramètre */
    public function saveSneakerModification($id, array $data){
      // On construit un builder a partir des données recupérees
      $sneakerBuild = new SneakerBuilder($data);
      // On recupere une sneaker a partir de la BDD
      $sneaker = $this->sneakerdb->read($id);

      if($sneakerBuild->isValid()){
        // On met a jour la sneaker
        $sneaker = $sneakerBuild->updateSneaker($sneaker);
        // On met a jour la sneaker dans la BDD
        $this->sneakerdb->update($id, $sneaker);
        // On redirige vers la page de la sneaker
        $this->view->displaySneakerModificationSuccess($id);
      }else{
        $this->view->displaySneakerModificationFailure($id);
      }

    }
}
?>
