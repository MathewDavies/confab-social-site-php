<?php
  /*
   * App Core Class
   * Creates URL & loads core controller
   * URL FORMAT - /controller/method/params
   */

   // Report all errors except E_NOTICE

error_reporting(E_ALL & ~E_NOTICE);

  class Core {
    protected $currentController = 'Pages';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct(){
      //print_r($this->getUrl());

      $url = $this->getUrl();

      // Look in controllers for first value
      if(file_exists('../app/controllers/' . ucwords($url[0]). '.php')){
        // If exists, set as controller
        $this->currentController = ucwords($url[0]);
        // Unset 0 Index
        unset($url[0]);
      }

      // Require the controller
      require_once '../app/controllers/'. $this->currentController . '.php';

      // Instantiate controller class
      $this->currentController = new $this->currentController;

      //check for second part of the url
      if(isset($url[1])){
          if(method_exists($this->currentController, $url[1])){
              $this->currentMethod = $url[1];
              unset($url[1]);
          }
      }
        $this->params = $url ? array_values($url) : [];
        call_user_func_array([$this->currentController, 
        $this->currentMethod], $this->params);
        }

    public function getUrl(){
      if(isset($_GET['url'])){
        $url = rtrim($_GET['url'], '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        return $url;
      }
    }
  } 
  
  