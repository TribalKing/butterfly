<?php

/**
 *
 * Class Home
 *
 */
class Home extends Controller
{
    /**
     * Index Page
     */
    public function index()
    {
        $users = $this->model->getAllUsers();

        // load views
        require APP . 'view/includes/header.php';
        require APP . 'view/home/index.php';
        require APP . 'view/includes/footer.php';
    }

    /**
     * Create a new user
     */
    public function create()
    {
        if (isset($_POST["add_user"])) {
            $this->validation($_POST["name"], $_POST["age"]);
            $this->model->addUser($_POST["name"], $_POST["age"]);
        }

        header('location: ' . URL . 'public/home/index');
    }

    /**
     * Delete a user
     */
    public function delete($user_id)
    {
        $url = explode('/', $_SERVER[REQUEST_URI]);

        $user_id = end($url);
        if ($part != 'home' || $part != 'create') {
            if (isset($user_id)) {
                $this->model->deleteUser($user_id);
            }
        }
        header('location: ' . URL . 'public/home/index');
    }

    private function validation($name, $age)
    {
        // Checking spaces in name
        if (strpos($name, ' ') !== false || strpos($age, ' ') !== false) {
            $_SESSION['flash'] = 'Space is not allowed.';
            header('location: ' . URL . 'public/home/index');
            die();
        }

        // Age restriction
        if ($age > 120) {
            $_SESSION['flash'] = 'You cannot be older then 120 years.';
            header('location: ' . URL . 'public/home/index');
            die();
        }

        // Name length
        if (strlen($name) > 30) {
            $_SESSION['flash'] = 'Your name cannot be that long.';
            header('location: ' . URL . 'public/home/index');
            die();
        }
    }
}
