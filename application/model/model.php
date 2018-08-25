<?php

class User
{
    /**
     * @param object $db for a database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            $_SESSION['flash'] = 'Database connection could not be established.';
            die();
        }
    }

    /**
     * Create a new user
     */
    public function addUser($name, $age)
    {
        $check = $this->getUser($name, $age);

        if (!$check) {
            $sql = "INSERT INTO users (name, age) VALUES ('{$name}', {$age})";

            $query = $this->db->prepare($sql);
            $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link);

            $query->execute($parameters);

            $_SESSION['flash'] = 'Added new user.';
        } else {
            $_SESSION['flash'] = 'That user already exist.';
        }

    }

    /**
     * Delete a user
     */
    public function deleteUser($user_id)
    {
        $sql = "DELETE FROM users WHERE id = {$user_id}";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);

        $query->execute($parameters);
    }

    /**
     * Get a user
     */
    public function getUser($name, $age)
    {
        $sql = "SELECT id, name, age FROM users WHERE name = '{$name}' AND age = {$age} LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':user_id' => $user_id);

        $query->execute($parameters);

        return $query->fetch();
    }

    /**
     * Get all users from database
     */
    public function getAllUsers()
    {
        $sql = "SELECT id, name, age FROM users LIMIT 20";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * Total users
     */
    public function getCountOfUsers()
    {
        $sql = "SELECT COUNT(id) AS count_of_users FROM users";
        $query = $this->db->prepare($sql);
        $query->execute();

        return $query->fetch()->count_of_users;
    }

}
