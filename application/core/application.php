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
                    header('location: ' . URL . 'problem');
                }
            }
        } else {
            header('location: ' . URL . 'problem');
        }
    }

    /**
     * Get and split the URL
     */
    private function checkRoute()
    {
        if (isset($_SERVER['REQUEST_URI'])) {

            $url = trim($_SERVER[REQUEST_URI], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            $this->url_controller = isset($url[0]) ? $url[0] : null;
            $this->url_action = isset($url[1]) ? $url[1] : null;

            // Remove controller and action from the split URL
            unset($url[0], $url[1]);

            // Rebase array keys and store the URL params
            $this->url_params = array_values($url);
        }
    }
}
