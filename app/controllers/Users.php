<?php 
    class Users extends Controller {

        public function __construct() {
            $this->userModel = $this->model('User');
        }

        public function register () {
            // Check for POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process Form

                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // init data
                $data = [
                    'prenom' => trim($_POST['prenom']) ,
                    'nom' =>  trim($_POST['nom']),
                    'login' =>  trim($_POST['login']),
                    'password1' => trim($_POST['password1']),
                    'password2' =>  trim($_POST['password2']),
                    'avatar' =>$_FILES['avatar'],
                    'avatar_err' => '',
                    'nom_err' => '',
                    'prenom_err' => '',
                    'login_err' => '',
                    'password1_err' => '',
                    'password2_err' => '',
                ];

                // validate data

                // Validate File and upload
                $avatarName  = $data['avatar']['name'];
                $avatarTmpName  = $data['avatar']['tmp_name'];
                $avatarSize  = $data['avatar']['size'];
                $avatarError  =$data['avatar']['error'];
                $avatarType  = $data['avatar']['type'];

                $avatarExt = explode('.', $avatarName);
                $avatarActualExt = strtolower((end($avatarExt)));

                $allowed = array('jpg', 'jpeg', 'png');
                // verify extention
                if (in_array($avatarActualExt, $allowed)) {
                    if ($avatarError === 0) {
                        if ($avatarSize < 1000000) {
                            $avatarNewName = uniqid('', true).".".$avatarActualExt;
                            $data['avatar'] = $avatarNewName;
                            $avatarDestination =  'uploads/' .$avatarNewName;
                            move_uploaded_file($avatarTmpName, $avatarDestination);
                        } else {
                            $data['avatar_err'] = 'Fichier trop grand ';
                        }
                    } else {
                        $data['avatar_err'] = 'Erreur upload ';
                    }

                } else {
                    $data['avatar_err'] = 'Extension non autorisé ';
                }

                // Validate Login
                if(empty($data['login'])){
                    $data['login_err'] = 'Veuillez saisir un login';
                }  else {
                    // Check email
                    if($this->userModel->findUserByLogin($data['login'])){
                      $data['login_err'] = 'Cet login est déja utilisé';
                    }
                  }

                // Validate nom
                if(empty($data['nom'])){
                    $data['nom_err'] = 'Veuillez saisir un nom';
                } 
                // Validate nom
                if(empty($data['prenom'])){
                    $data['prenom_err'] = 'Veuillez saisir un nom';
                } 
            
                // Validate password
                if(empty($data['password1'])){
                    $data['password1_err'] = 'Veuillez saisir un password';
                }  elseif(strlen($data['password1']) < 6) {
                    $data['password1_err'] = 'Saisir plus de 6 charactéres';
                }
               
                // Validate confirm password
                if(empty($data['password2'])){
                    $data['password2_err'] = 'Veuillez confirmer le password';
                
                } else {
                    if($data['password1'] != $data['password2']){
                        $data['password2_err'] = 'Les mots de pass  doit correspondre';
                    }
                }

                if  (empty($data['nom_err']) && empty($data['prenom_err']) && empty($data['login_err']) && empty($data['password1_err']) && empty($data['password2_err']) && empty($data['avatar_err']) ) {
                    // Validated on enregistre

                    // Hash Password
                    $data['password1'] = password_hash($data['password1'], PASSWORD_DEFAULT);

                    // atributet statu
                    if (isset($_SESSION['user_profil'])) {
                        $data['profil'] = 'admin';
                        $data['score'] = null;
                    } else {
                        $data['profil'] = 'joueur';
                        $data['score'] = 0;
                    }
                    
                    // Register User
                    if($this->userModel->register($data)){
                   
                        // load view 
                        if (isset($_SESSION['user_profil'])) {
                            flash('register_success', 'Votre compte est creer' );
                            $this->view('users/register', 'layout_admin', $data);
                        } else {
                            flash('register_success', 'Votre compte été bien creer' );
                           redirect('users/login');
                        }
                    } else {
                        die('Something went wrong');
                    }

                  
                } else {
                    // Load view with error 
                            // load view 
                    if (isset($_SESSION['user_profil'])) {
                        $this->view('users/register', 'layout_admin', $data);
                    } else {
                        $this->view('users/register', 'layout_connexion', $data);
                    }
               
                }


        
            } else {
               
                // init data for form view 
                $data = [
                    'prenom' => '',
                    'nom' => '',
                    'login' => '',
                    'password1' => '',
                    'password2' => '',
                    'avatar' => '',
                    'nom_err' => '',
                    'prenom_err' => '',
                    'login_err' => '',
                    'password1_err' => '',
                    'password2_err' => '',
                    'avatar_err' => '',
                    
                ];
                // load view 
                if (isset($_SESSION['user_profil']) && $_SESSION['user_profil'] == "admin") {
                    $this->view('users/register', 'layout_admin', $data);
                } else {
                    $this->view('users/register', 'layout_connexion', $data);
                }
               


            }
        }


        public function login () {
            // Check for POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Process Form
                
                // Sanitize Post Data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // init data
                $data = [
                    
                    'login' =>  trim($_POST['login']),
                    'password' => trim($_POST['password']),
                    'login_err' => '',
                    'password_err' => '',
                ];

                 // Validate login
                 if(empty($data['login'])){
                    $data['login_err'] = 'Veuillez saisir un login';
                } 

                // Validate password
                if(empty($data['password'])){
                    $data['password_err'] = 'Veuillez saisir un password';
                } 

                // Check for user/email
                if($this->userModel->findUserByLogin($data['login'])){
                    // User found
                } else {
                    // User not found
                    $data['login_err'] = 'No user found';
                }

                // make sure error are empty
                if  (  empty($data['login_err']) && empty($data['password_err'])) {
                    // Validated
                    $loggedInUser = $this->userModel->login($data['login'], $data['password']);

                    if($loggedInUser){
                        // Create Session
                        $this->createUserSession($loggedInUser);
                       
                      } else {
                        $data['password_err'] = 'Password incorrect';
            
                        $this->view('users/login','layout_connexion', $data);
                      }
                } else {
                    // Load view with error 
                             $this->view('users/login', 'layout_connexion', $data);
                }

            } else {
               
                // init data for form view
                $data = [
                 
                    'login' => '',
                    'password' => '',
                    'login_err' => '',
                    'password_err' => '',
                ];
                
                $this->view('users/login', 'layout_connexion', $data);



            }
        }


        
        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_login'] = $user->login;
            $_SESSION['user_nom'] = $user->nom;
            $_SESSION['user_prenom'] = $user->prenom;
            $_SESSION['user_profil'] = $user->profil;
            $_SESSION['user_avatar'] = $user->avatar;
           
            if ($user->profil === 'admin') {
                redirect('users/listJoueur/1');
            } else {
                 $_SESSION['repondus'] = [];
                $_SESSION['allQuestion'] = [];
                $_SESSION['isCorrect'] = [];
                redirect('questions/jouer');

            }
        }
    
        public function logout(){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_prenom']);
            unset($_SESSION['user_nom']);
            unset($_SESSION['user_profil']);
            unset($_SESSION['user_avatar']);
            unset($_SESSION['user_login']);
            unset($_SESSION['allQuestion']);
            unset($_SESSION['repondus']);
            unset($_SESSION['isCorrect']);
            
            session_destroy();
            redirect('users/login');
        }
    
        public function isLoggedIn(){
            if(isset($_SESSION['user_id'])){
            return true;
            } else {
            return false;
            }
        }


        public function listJoueur($currentPage =1) {
            $totalJoueur = 5;
           
            if (isset($currentPage) )  {
             
             $currentPage = intval($currentPage);
               
            } 
            $depart  = ($currentPage-1) * $totalJoueur;

           $listJoueur = $this->userModel->getJoueur($depart, $totalJoueur);
           $nbreJoueur = $this->userModel->getNumberJoueur();

           $numberOfPages = ceil($nbreJoueur/ $totalJoueur) ;
       
            
            $data = [
                'listJoueur' => $listJoueur,
                'nbreOfPages' => $numberOfPages,
                'currentPage' => $currentPage
            ];
            $this->view('users/listJoueur', 'layout_admin', $data);
        }
    }