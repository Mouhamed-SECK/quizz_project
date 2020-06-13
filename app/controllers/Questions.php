<?php 
    class Questions extends Controller {

        public function __construct() {
            $this->questionModel = $this->model('Question');
        }


        private function getResponseInArray($array) {
            $response;

            if (array_key_exists('response', $array)) {
                 return $response['response'] = $array['response'];
            }

            foreach (array_keys($array) as $key){
                
                if (strpos($key, 'response-') !== false) {
                    $id =( explode('-', $key))[1];
                    $response['response']['response-'.$id] = $array[$key];
                } elseif(strpos($key, 'isCorrect-')  !== false) {
                    $id =( explode('-', $key))[1];
                    $response['correct']['isCorrect-'.$id] = $array[$key];
                }
            }


            return serialize($response);
           
        }

        public function createQuestion () {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
                // Process Form

                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
          
                // init data
                $data = [
                    'libelleQuestion' => $_POST['libelleQuestion'] ,
                    'nbrePoint' =>  trim($_POST['nbrePoint']),
                    'typeReponses' =>  trim($_POST['typeReponses']),
                    'responses' =>  $this->getResponseInArray($_POST)
                ];

                if($this->questionModel->registerQuestion($data)) {
                    redirect('users/listQuestion/1');
                }
           
            } else {
                $this->view('questions/createQuestion', 'layout_admin');
            }
        }


        
        public function listQuestion($currentPage =1) {
            $totalQuestion = 4;
           
            if (isset($currentPage) )  {
             
             $currentPage = intval($currentPage);
               
            } 
            $depart  = ($currentPage-1) * $totalQuestion;

            $Questions = $this->questionModel->getQuestion($depart, $totalQuestion);
            $nbreQuestion = $this->questionModel->getnbreQuestion();
            $nbreQuestionForGame = $this->questionModel->getNbreQuestionForGame();
            $listQuestion = [];

           
           foreach ($Questions as $question){
                if (strlen($question->responses) > 70) {
                    $question->responses = unserialize($question->responses);
                    $listQuestion[] = $question;
                  

              
                } else{
                    $listQuestion[] = $question;
                }
           }


           $numberOfPages = ceil($nbreQuestion/ $totalQuestion) ;
       
            
            $data = [
                'listQuestion' => $listQuestion,
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

        public function addAssocitive($array1, $array2) {
            $finalArray = [];

            foreach($array1 as $key => $value) {
                $finalArray[$key] = $value;
            }
            foreach($array2 as $key2 => $value2) {
                $finalArray[$key2] = $value2;
            }

            return $finalArray;

        }           
        public function jouer($currentPage =1, $action=2) {
            

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                if (isset($_POST["responseTexte-" .($currentPage-1)])) {
                    $_SESSION['remplis'][$currentPage-1] = $_POST;
                } else if( isset($_POST["response-" .($currentPage-1)])) {
                    $_SESSION['cocher'][$currentPage-1] = $_POST;
                }

                if ($action == 'fin') {
                   extract($_SESSION);
                   extract($_SESSION);
                    // var_dump(   $_SESSION);
               
                   $playerResponses  = $this->addAssocitive($cocher, $remplis);
                  $playerResponses[count($playerResponses) + 1] = $_POST;
                 

                   // calcule score
                   foreach ($playerResponses as $key => $value) {
                    
                    foreach ($value as $res) {
                        // var_dump($value);

                        // var_dump($_SESSION['questions'][$key]->responses);

                        if (is_array($_SESSION['questions'][$key]->responses)) {
                            
                            // var_dump($res);
                            // var_dump($_SESSION['questions'][$key]->responses['correct']);
                             if (array_key_exists($res, $_SESSION['questions'][$key]->responses['correct'])) {
                                 var_dump($key);
                                var_dump($res);
                                var_dump("correct");

                            }
                        }
                 
                        // if (isset($_SESSION['questions'][$key]->responses['correct']) ) {

                        // }
                        // if (in_array($res, $_SESSION['questions'][$key]->responses['correct'])) {
                        //     die('correct');
                        // }
                    }
                   }
                 

                 
                }
            }   
           
       
            $totalQuestion = 1;
           
            if (isset($currentPage) )  {
             
             $currentPage = intval($currentPage);
               
            } 
            $depart  = ($currentPage-1) * $totalQuestion;

           $Questions = $this->questionModel->getQuestion($depart, 1);


           
           foreach ($Questions as $question){
                if (strlen($question->responses) > 70) {
                    $question->responses = unserialize($question->responses);
                    $listQuestion[] = $question;
                    $_SESSION['questions'][$currentPage] = $question;

                  
                } else{
                    $listQuestion[] = $question;
                    $_SESSION['questions'][$currentPage] = $question;
                }
           }

  

           
           $numberOfPages = $this->questionModel->getNbreQuestionForGame()->NbreQuestion; 
        

           $data = [
            'listQuestion' => $listQuestion,
            'nbreOfPages' => $numberOfPages,
            'currentPage' => $currentPage,
         
        ];

         
           $this->view('jeu/interfaceJeu', 'layout_joueur', $data);
        }


    }