<?php
  class Pages extends Controller {
    public function __construct(){
     
    }
    
    // public function adminIndex(){
    
    //   $this->view('users/listJoueur', 'layout_admin');
    // }

    public function jouer(){
    
      $this->view('jeu/interfaceJeu', 'layout_joueur');
    }

   

  }