<?php 
    /*
    *App Core Class
    * Creates URL & loads core controller
    * URL FORMAT - /controller/method/params
    */

    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct() {
            $url = $this->getUrl();

            // Look in controllers for first value
            if(file_exists('../app/controllers/' . ucwords(isset($url[0])) . '.php')){
                // If exists set it as the current controller 
                $this->currentController = ucwords($url[0]);

                // Unset the  0 Index
                unset($url[0]);
            }

            // Require the controller 
            require_once '../app/controllers/'. $this->currentController . '.php';


            // Once we get that controller instantiate that controllers class
            $this->currentController = new $this->currentController;


            // Check for second part of the url 
            if(isset($url[1])){
                // Check to see if the method exists in the controller
                if(method_exists($this->currentController, $url[1])){
                    $this->currentMethod = $url[1];

                    // Unset index 1 of url
                    unset($url[1]);
                }
                
            }

            // Get params
            $this->params = $url ? array_values($url) : [];


            // Call a callback with array of params
            // Basically this function lets us use the params passed into it
            // in the callback function

            call_user_func_array([$this->currentController, $this->currentMethod],
            $this->params);


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
