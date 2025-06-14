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
    
    public function saveUser(User $user): int
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare(
            'INSERT INTO public.users (email, password_hash)
            VALUES (:email, :password_hash)
            RETURNING id'
        );
        $stmt->execute([
            ':email'         => $user->getEmail(),
            ':password_hash' => $user->getPasswordHash()
        ]);
        return (int) $stmt->fetchColumn();
    }

    public function saveUserProfile(int $userId, string $fullName): void
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare(
            'INSERT INTO public.user_profiles (user_id, full_name)
            VALUES (:uid, :fullname)'
        );
        $stmt->execute([
            ':uid'      => $userId,
            ':fullname' => $fullName
        ]);
    }

}
