<?php 
    class Questions extends Controller {

        public function __construct() {
            $this->questionModel = $this->model('Question');
        }


        private function getResponseInArray($array) {
            $responses = "";
            $bonneReponses = "";



            if (array_key_exists('response', $array)) {
                 return [$responses = trim( $array['response']), $bonneReponses = trim($responses = $array['response'])];
            }
            if (array_key_exists('isCorrect', $array)) {
                $bonneReponses .= $array['response-'.$array['isCorrect'] ] ;
            }

            foreach (array_keys($array) as $key){
                
                if (strpos($key, 'response-') !== false) {
                   
                    $responses .=  $array[$key] ."/";
                } elseif(strpos($key, 'isCorrect-')  !== false) {
                    
                    $id =( explode('-', $key))[1];
                    $bonneReponses .= $array['response-'.$id] .'/';
                }
            }


            return [ $responses , $bonneReponses];
           
        }

        public function createQuestion () {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
                // Process Form

                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // var_dump($this->getResponseInArray($_POST));

                // var_dump($_POST);
          
                // init data
                $data = [
                    'libelleQuestion' => $_POST['libelleQuestion'] ,
                    'nbrePoint' =>  trim($_POST['nbrePoint']),
                    'typeReponses' =>  trim($_POST['typeReponses']),
                    'responses' =>  $this->getResponseInArray($_POST)[0],
                    'bonneReponses' =>  $this->getResponseInArray($_POST)[1],
                ];

                if($this->questionModel->registerQuestion($data)) {
                    redirect('questions/createQuestion/');
                }
           
            } else {
                $this->view('questions/createQuestion', 'layout_admin');
            }
        }


        
        public function listQuestion($currentPage =1) {
            $totalQuestion = 4 ;
           
            if (isset($currentPage) )  {
             
             $currentPage = intval($currentPage);
               
            } 
            $depart  = ($currentPage-1) * $totalQuestion;

            $Questions = $this->questionModel->getQuestion($depart, $totalQuestion);
            $nbreQuestion = $this->questionModel->getnbreQuestion();
            $nbreQuestionForGame = $this->questionModel->getNbreQuestionForGame();
         

           
           foreach ($Questions as $question){
                $responses = explode("/",  $question->responses);
                $bonneReponses = explode("/",  $question->bonneReponses);

                if  ($question->typeReponses !== 'choixText') {
                array_pop($responses);

                }
                if ($question->typeReponses ===  'choixMultiple') {
                array_pop($bonneReponses);

                }

                $question->responses = $responses ;
                $question->bonneReponses = $bonneReponses  ;
               
           }


           $numberOfPages = ceil($nbreQuestion/ $totalQuestion) ;
        
  
            $data = [
                'listQuestion' => $Questions,
                'nbreOfPages' => $numberOfPages,
                'currentPage' => $currentPage,
                'nbreQuestionForGame' =>$nbreQuestionForGame
            ];
            $this->view('questions/listQuestion', 'layout_admin', $data);
        }


        public function fixQuestions () {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $nbreQuestion = $_POST['nbreQuestion'];

               

                if ($this->questionModel->modifyNumberQuestion($nbreQuestion)) {
                    flash('modify_success', 'NbreQuestion du jeu changer' );
                    redirect('questions/listQuestion/1');
                   

                }
            } else {
                redirect('questions/listQuestion/1');

            }

        }

        public function jouer($currentPage =1, $action=2) {
            

            if ($_SERVER['REQUEST_METHOD'] == 'POST' and !empty($_POST)) {
                
                if (array_key_exists('response', $_POST )) {
                    $res = explode("/", trim($_POST['response']));
                    $_SESSION['repondus'][$res[1]] = $res[0] ;
                } elseif (strpos(array_keys($_POST)[0], 'response-') !== false) {
                    $id = explode("/", array_values($_POST)[0])[1] ;
                    $res = [];
                    foreach($_POST as $values) {
                        $res[] = explode("/", $values)[0];
                    }
                    $_SESSION['repondus'][$id] = $res ;
                } else {
                    $id = explode("/", array_keys($_POST)[0])[1];
                    $_SESSION['repondus'][$id] =$_POST[array_keys($_POST)[0]] ;
                }

                // Game over
                if ($action == 'fin') {
                    $score = 0;
                    foreach($_SESSION['allQuestion'] as $res ) {
                     
                        $userResponse =$_SESSION['repondus'][$res->id];
                        $goodRes = $res->bonneReponses;

            
                        if ($res->typeReponses !== "choixMultiple") {
                            if (in_array($userResponse,  $goodRes)) {
                                  $score = $score +  intval($res->nbrePoint);
                                  $_SESSION['isCorrect'][$res->id] = true;
                            } else {
                                // get false response
                                $_SESSION['isCorrect'][$res->id] = false;
                            }

                        } else {
                            $evaluate = true;
                            if (count($userResponse) != count($goodRes)) {
                                $evaluate = false;
                            } else {
                                foreach($userResponse as $value) {
                                    if (!in_array($value, $goodRes)) {
                                        $evaluate = false;
                                        $_SESSION['isCorrect'][$res->id] = false;
                                         break;
                                    }
                                }
                            }
                           
                            if ($evaluate) {
                                $score = $score +  intval($res->nbrePoint);
                                $_SESSION['isCorrect'][$res->id] = true;
                            } 
                        }
                       
                    }

                    $data = [
                        'score' => $score,
                    ];

                    $this->view('jeu/finJeu', 'layout_joueur', $data);
                   
                 
                    
                }
            }   
           
            if (isset($currentPage) )  {
             $currentPage = intval($currentPage);
            } 

            $depart  = ($currentPage-1)* 1;

           $question = $this->questionModel->getQuestion($depart, 1)[0];
           $responses = explode("/",  $question->responses);
           $bonneReponses = explode("/",  $question->bonneReponses);

           if  ($question->typeReponses !== 'choixText') {
                array_pop($responses);
           }
           if ($question->typeReponses ===  'choixMultiple') {
                array_pop($bonneReponses);
           }
           $question->responses = $responses ;
           $question->bonneReponses = $bonneReponses;
           if (!array_key_exists($question->id , $_SESSION['allQuestion']  )  ) {
            $_SESSION['allQuestion'][$question->id] = $question;
           }
           
           
           $numberOfPages = $this->questionModel->getNbreQuestionForGame()->NbreQuestion; 
        

           $data = [
            'question' => $question,
            'nbreOfPages' => $numberOfPages,
            'currentPage' => $currentPage,
         
        ];

         
           $this->view('jeu/interfaceJeu', 'layout_joueur', $data);
        }


    }