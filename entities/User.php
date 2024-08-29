<?php

namespace entities;

use core\Entity;

class User extends Entity
{
    protected $id;
    protected $firstname;
    protected $lastname;
    protected $username;
    protected string $password = '';
    protected $roleId;
    protected $createdAt;
    protected $updatedAt;
    protected $serviceId;

    protected $firstconnection;
    protected $firstconnectionAt;

    public function __construct($userData)
    {
        parent::__construct($userData);
        if (isset($userData['plain_password'])) {
            $this->setPlainPassword($userData['plain_password']);
        }
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

    public function setPlainPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
