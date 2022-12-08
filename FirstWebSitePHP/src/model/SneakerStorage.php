<?php

require_once("Sneaker.php");

interface SneakerStorage{
    
    /* Renvoie la sneaker d'identifiant $id, ou null
	 * si l'identifiant ne correspond à aucune couleur. */
    public function read($id);

    /* Renvoie un tableau associatif id => Sneaker
	 * contenant toutes les sneakers de la base. */
    public function readAll();

    /* Insère une nouvelle sneaker dans la base. Renvoie l'identifiant
	 * de la nouvelle sneaker. */
    public function create(Sneaker $s);

    /* Supprime une sneaker. Renvoie
	 * true si la suppression a été effectuée, false
	 * si l'identifiant ne correspond à aucune couleur. */
    public function delete($id);

    /* Met à jour une sneaker dans la base. Renvoie
	 * true si la modification a été effectuée, false
	 * si l'identifiant ne correspond à aucune couleur. */
    public function update($id, $sneaker);
}

?>
