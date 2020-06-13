<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function register($data){
      $this->db->query('INSERT INTO user (nom, prenom, login, pwd, profil, avatar , score) VALUES(:nom, :prenom, :login,  :pwd, :profil, :avatar , :score)');
      // Bind values
      $this->db->bind(':nom', $data['nom']);
      $this->db->bind(':prenom', $data['prenom']);
      $this->db->bind(':login', $data['login']);
      $this->db->bind(':pwd', $data['password1']);
      $this->db->bind(':profil', $data['profil']);
      $this->db->bind(':avatar', $data['avatar']);
      $this->db->bind(':score', $data['score']);

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

 
    // Login User
    public function login($login, $password){
        $this->db->query('SELECT * FROM user WHERE login = :login');
        $this->db->bind(':login', $login);
  
        $row = $this->db->single();
  
        $hashed_password = $row->pwd;
        if(password_verify($password, $hashed_password)){
          return $row;
        } else {
          return false;
        }
      }


    // Find user by Login
    public function findUserByLogin($login){
      $this->db->query('SELECT * FROM user WHERE login = :login');
      // Bind value
      $this->db->bind(':login', $login);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }


    public function getNumberJoueur() {
      $this->db->query('SELECT nom, prenom, score from user where profil = "abdou" ');
      $this->db->resultSet();
      return   $this->db->rowCount() ;
    }


    public function getJoueur($depart ,$joueurParPage) {
      $this->db->query('SELECT nom, prenom, score from user where profil = "abdou" order by score desc limit :start, :end ');
      $this->db->bind(':start', $depart);
      $this->db->bind(':end', $joueurParPage);

      return $this->db->resultSet();
    }
   }