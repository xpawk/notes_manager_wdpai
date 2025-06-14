<?php

class User
{
    private $id;
    private $email;
    private $passwordHash;

    public function __construct($id, $email, $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->setPassword($password);
    }

    public static function fromDatabase($id, $email, $passwordHash)
    {
        $instance = new self($id, $email, '');
        $instance->passwordHash = $passwordHash;
        return $instance;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->passwordHash);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}
