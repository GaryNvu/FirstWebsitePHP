<?php

class View{
    protected $title;
    protected $menu;
    protected $h1;
    protected $content;
    protected $price;

    protected $feedback;

    protected $router;

    public function __construct(Router $router, $feedback){
      $this->router = $router;
      $this->menu = array(
        "Accueil" => $this->router->getHomePageURL(),
        "Liste" => $this->router->getListURL(),
        "Nouvelle Sneaker" => $this->router->getSneakerCreationURL(),
        "A propos" => $this->router->getAboutPage(),
      );

      $this->feedback = $feedback;
    }

    /* Rendu de la page */
    public function render(){
      require_once('squelette.php');
    }

    // Page d'une sneaker
    public function makeSneakerPage($id, $sneaker){
      $this->title = $sneaker->getName();
      $this->h1 = "{$sneaker->getName()} - {$sneaker->getBrand()}";
      $this->price = $sneaker->getPrice();
      $brand = $sneaker->getBrand();
      $image = "../upload/{$sneaker->getImage()}";

      $this->content .= "<figure class='figPresentation'>\n<img class='imgPresentation' src=\"$image\" alt=\"$brand\">\n";
      $this->content .= "<p class='price'>{$this->price}€</p>\n";
      $this->content .= "<a class='actions' href={$this->router->getSneakerAskDeletionURL($id)}>Supprimer</a>\n";
      $this->content .= "<a class='actions' href={$this->router->getSneakerModificationURL($id)}>Modififier</a></figure>";
    }

    // Page d'accueil
    public function makeHomePage(){
      $this->title = "Accueil";
      $this->h1 = "Page d'accueil";
      $this->content = "<p id='textAccueil'>Bienvenue sur SNEAKY, un site sur les sneakers. Vous pouvez grâce au menu ci-dessus accéder à différentes pages. Vous pourrez notamment consulter une liste de sneakers que vous pourrez modifier en ajoutant vos propres modèles ou bien en modifiant ceux existant.</p>";
    }

    // Page de la liste des sneakers
    public function makeListPage($tab){
      $this->title = "Liste";
      $this->h1 = "Liste des Sneakers";
      $this->content = $this->content . "<ul class='listeSneakers'>";
      foreach ($tab as $key => $value) {
        $this->content = $this->content . "<li><a href='{$this->router->getSneakerURL($key)}'>{$tab[$key]->getName()}</a></li>";
      }
      $this->content = $this->content . "</ul>";
    }

    // Page d'erreur spécifiant l'erreur
    public function makeUnexpectedErrorPage($e){
      $this->title = "Erreur";
      $this->h1 = "Erreur lors du chargement de la page";
      $this->content = "<p class='err'>$e</p>";
    }

    // Page de debug
    public function makeDebugPage($variable) {
    	$this->title = 'Debug';
    	$this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    // Page de formulaire de creation d'une sneaker
    public function makeSneakerCreationPage($sneakerBuild){
      $this->title = "Création";
      $this->h1 = "Créer une Sneaker";
      $this->content = "<form enctype='multipart/form-data' method='POST' action={$this->router->getSneakerSaveURL()} id='forms'>";

      $error = $sneakerBuild->getError($sneakerBuild::NAME_REF);
      if($error !== null){
        $this->content .= "<span class='err'>{$error}</span>";
      }
      $this->content .= "<label>Nom</label><input type='text' name='name' value='{$sneakerBuild->getData($sneakerBuild::NAME_REF)}'>";

      $error = $sneakerBuild->getError($sneakerBuild::BRAND_REF);
      if($error !== null){
        $this->content .= "<span class='err'>{$error}</span>";
      }
      $this->content .= "<label>Marque</label><input type='text' name='brand' value='{$sneakerBuild->getData($sneakerBuild::BRAND_REF)}'>";

      $error = $sneakerBuild->getError($sneakerBuild::PRICE_REF);
      if($error !== null){
        $this->content .= "<span class='err'>{$error}</span>";
      }
      $this->content .= "<label>Prix</label><input type='text' name='price' value='{$sneakerBuild->getData($sneakerBuild::PRICE_REF)}'>";

      $error = $sneakerBuild->getError($sneakerBuild::IMAGE_REF);
      if($error !== null){
        $this->content .= "<span class='err'>{$error}</span>";
      }
      $this->content .= "<label>Image</label><input type='file' name='image'>";
      $this->content .= "<input type='submit' value='Confirmer'>";
      $this->content .= "</form>";
    }

    /* Page d'erreur de creation d'une sneaker */
    public function makeSneakerCreationError(){
      $this->title = "Erreur";
      $this->content = "<p>Erreur lors de la création de la Sneaker</p>";
    }

    /* Page de demande de confirmation de suppression */
    public function makeAskSneakerDeletionPage($id){
      $this->title = "Supression";
      $this->h1 = "Supprimer une Sneaker";
      $this->content .= "<div class='supp'>";
      $this->content .= "<p>Voulez-vous vraiment supprimer la sneaker {$id} ?</p>";
      $this->content .= "<form method='POST' action={$this->router->getSneakerDeletionURL($id)}>";
      $this->content .= "<button type='submit'>Confirmer</button>";
      $this->content .= "</form>";
      $this->content .= "</div>";
    }

    /* Page de suppression d'une sneaker */
    public function makeSneakerDeletionPage($id){
      $this->title = "Supression";
      $this->content .= "<div class='supp'>";
      $this->content .= "<p>La suppression de la sneaker {$id} à bien été effectué</p>";
      $this->content .= "</div>";
    }

    /* Page de formulaire de modification d'une sneaker */
    public function makeSneakerModificationPage($id, $sneakerBuild){
      $this->title = "Modification";
      $this->h1 = "Mofifier une Sneaker";
      $this->content = "<form enctype='multipart/form-data' method='POST' action={$this->router->getSneakerSaveModificationURL($id)} id='forms'>";
      $this->content .= "<label>Nom</label><input type='text' name='name' value='{$sneakerBuild->getData($sneakerBuild::NAME_REF)}'>";
      $this->content .= "<label>Marque</label><input type='text' name='brand' value='{$sneakerBuild->getData($sneakerBuild::BRAND_REF)}'>";
      $this->content .= "<label>Prix</label><input type='text' name='price' value='{$sneakerBuild->getData($sneakerBuild::PRICE_REF)}'>";
      $this->content .= "<label>Image</label><input type='file' name='image'>";
      $this->content .= "<input type='submit' value='Confirmer'>";
      $this->content .= "</form>";
    }

    /* Page A propos */
    public function makeAboutPage(){
      $this->title = "A propos";
      $this->h1 = "A propos";
      $this->content .= "<p>Numéro étudiant : 22001800</p>";
      $this->content .= "<p class='underline'> Réalisation de base :";
      $this->content .= "<ul class='listeInfos'>";
      $this->content .= "<li>Liste d'objets, affichables indépendamment (TP07)</li>";
      $this->content .= "<li>Création basique d'objets (TP08)</li>";
      $this->content .= "<li>Modification basique d'objets (TP08)</li>";
      $this->content .= "<li>Builders pour la manipulation d'objets (TP08)</li>";
      $this->content .= "<li>Suppression d'objets (TP08)</li>";
      $this->content .= "<li>Redirection en GET après création/modif/suppression réussie (TP09)</li>";
      $this->content .= "<li>Gestion du feedback (TP09)</li>";
      $this->content .= "<li>Redirection en GET après POST même lors des erreurs (TP09)</li>";
      $this->content .= "<li>Utilisation d'une base de données MySQL (TP10)</li>";
      $this->content .= "</ul>";
      $this->content .= "<p class='underline'>Compléments réalisés :</p>";
      $this->content .= "<ul class='listeInfos'>";
      $this->content .= "<li>Routage via le chemin virtuel (PATH_INFO)</li>";
      $this->content .= "<li>Possibilité d'illustrer un objet en uploadant une image</li>";
      $this->content .= "</ul>";
      $this->content .= "<p>Concernant les images contenues dans le dossier 'upload', certaines sont liées aux objets présents dans la base de données, d'autres sont à votre disposition pour l'ajout ou la modification d'objets</p>";
    }

    /* Fonction de redirection lorsque la création d'une sneaker réussie */
    public function displaySneakerCreationSuccess($id){
      $this->router->POSTredirect($this->router->getSneakerURL($id), "La paire a bien été créée");
    }

    /* Fonction de redirection lorsque la création d'une sneaker échoue */
    public function displaySneakerCreationFailure(){
      $this->router->POSTredirect($this->router->getSneakerCreationURL(), "Erreurs dans le formulaire");
    }

    /* Fonction de redirection lorsque la suppression d'une sneaker réussie */
    public function displaySneakerDeletion($id){
      $this->router->POSTredirect($this->router->getSneakerDeletionURL($id), "Suppression effectuée");
    }

    /* Fonction de redirection lorsque la modification d'une sneaker réussie */
    public function displaySneakerModificationSuccess($id) {
      $this->router->POSTredirect($this->router->getSneakerURL($id), "La sneaker a bien été modifiée !");
    }

    /* Fonction de redirection lorsque la modification d'une sneaker échoue */
    public function displaySneakerModificationFailure($id) {
      $this->router->POSTredirect($this->router->getSneakerModificationURL($id), "Erreurs dans le formulaire.");
    }
}

?>
