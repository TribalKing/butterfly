<?php

class Application
{
    /** @var null The controller */
    private $url_controller = null;

    /** @var null  */
    private $url_action = null;

    /** @var array URL parameters */
    private $url_params = array();

    /**
     * Calling controller method
     */
    public function __construct()
    {
        $this->checkRoute();

        if (!$this->url_controller) {

            require APP . 'controller/home.php';

            $page = new Home();

            $page->index();

        } elseif (file_exists(APP . 'controller/' . $this->url_controller . '.php')) {
            require APP . 'controller/' . $this->url_controller . '.php';
            $this->url_controller = new $this->url_controller();

            if (method_exists($this->url_controller, $this->url_action)) {
                if (!empty($this->url_params)) {
                    call_user_func_array(array($this->url_controller, $this->url_action), $this->url_params);
                } else {
                    $this->url_controller->{$this->url_action}();
                }
            } else {
                if (strlen($this->url_action) == 0) {
                    $this->url_controller->index();
                }
                else {
                    header('location: ' . URL . 'public/home');
                }
            }
        } else {
            header('location: ' . URL . 'public/home');
        }
    }

    /**
     * Get and split the URL
     */
    private function checkRoute()
    {
        if (isset($_SERVER['REQUEST_URI'])) {

            $url = explode('/', $_SERVER[REQUEST_URI]);
            $this->url_controller = 'home';

            $part = end($url);

            if($part != 'home'){
                $this->url_action = end($url);
            }

            if($part != 'create' && $part != '' && $part != 'index' && $part != 'problem' && $part != 'home'){
                $this->url_action = 'delete';
            }

            // Rebase array keys and store the URL params
            $this->url_params = array_values($url);


        }
    }
}
