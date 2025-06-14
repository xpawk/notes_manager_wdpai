<?php

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';

class UserRepository extends Repository
{
    public function getUserByEmail(string $email): ?User
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM public.users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return User::fromDatabase($user['id'], $user['email'], $user['password_hash']);
        }

        return null;
    }

    public function saveUser(User $user): void
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('INSERT INTO public.users (email, password_hash) VALUES (:email, :password_hash)');
        $email = $user->getEmail();
        $passwordHash = $user->getPasswordHash();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password_hash', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();
    }
}
