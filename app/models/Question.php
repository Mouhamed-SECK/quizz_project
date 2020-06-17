<?php 

class Question {
    private $db;

    public function __construct(){
    $this->db = new Database;
    }


    
    // Regsiter user
    public function registerQuestion($data){
        $this->db->query('INSERT INTO questions (libelleQuestion, nbrePoint, typeReponses, responses, bonneReponses) VALUES(:libelleQuestion, :nbrePoint, :typeReponses,  :responses, :bonneReponses)');
        // Bind values
        $this->db->bind(':libelleQuestion', $data['libelleQuestion']);
        $this->db->bind(':typeReponses', $data['typeReponses']);
        $this->db->bind(':nbrePoint', $data['nbrePoint']);
        $this->db->bind(':responses', $data['responses']);
        $this->db->bind(':bonneReponses', $data['bonneReponses']);

  

  
        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }


      public function getnbreQuestion() {
        $this->db->query('SELECT nbrePoint from questions ');
        $this->db->resultSet();
        return   $this->db->rowCount() ;
      }
  
  
      public function getQuestion($depart ,$totalQuestion) {
        $this->db->query('SELECT * from questions limit :start, :end ');
        $this->db->bind(':start', $depart);
        $this->db->bind(':end', $totalQuestion);
  
        return $this->db->resultSet();
      }


      public function modifyNumberQuestion($nbreQuestion) {
        $this->db->query('UPDATE reglage set Nbrequestion = :nbrequestion Where 1');
        $this->db->bind(':nbrequestion', $nbreQuestion);

        // Execute
        if($this->db->execute()){
          return true;
        } else {
          return false;
        }
      }

      public function getNbreQuestionForGame () {
        $this->db->query('SELECT * FROM reglage WHERE 1');

        return $this->db->single();
      }

}