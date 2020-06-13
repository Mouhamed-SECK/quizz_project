<?php
  /*
   * Base Controller
   * Loads the models and views
   */
  class Controller {
    // Load model
    public function model($model){
      // Require model file
      require_once '../app/models/' . $model . '.php';

      // Instatiate model
      return new $model();
    }

    // Load view
    public function view($view, $layout =null,  $data = []){
      // Check for view file
      if(file_exists('../app/views/' . $view . '.php')){

        ob_start();
        require_once '../app/views/' . $view . '.php';
        $content_for_layout = ob_get_clean();
        require_once '../app/views/layout/' . $layout . '.php';

      } else {
        // View does not exist
        die('View does not exist');
      }
    }
  }