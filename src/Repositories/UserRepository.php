<?php

require_once 'Repository.php';
require_once __DIR__ . '/../Models/User.php';

class UserRepository extends Repository
{
    public function getUserByEmail(string $email): ?array
    {
        $sql = 'SELECT * FROM view_user_profile WHERE email = :email';
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getUserById(int $userId): array
    {
        $sql = 'SELECT * FROM view_user_profile WHERE id = :id';
        $stmt = $this->db->connect()->prepare($sql);
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function updateProfile(int $id, string $name, string $email): void
    {
        $c = $this->db->connect();
        $c->beginTransaction();
        $c->prepare('UPDATE users SET email = :e WHERE id = :id')
        ->execute([':e' => $email, ':id' => $id]);

        $c->prepare(
        'INSERT INTO user_profiles (user_id, full_name)
        VALUES (:id, :n)
        ON CONFLICT (user_id) DO UPDATE SET full_name = EXCLUDED.full_name')
        ->execute([':id' => $id, ':n' => $name]);
        $c->commit();
    }

    public function updatePassword(int $id, string $plain): void
    {
        $hash = password_hash($plain, PASSWORD_DEFAULT);
        $this->db->connect()
            ->prepare('UPDATE users SET password_hash = :h WHERE id = :id')
            ->execute([':h' => $hash, ':id' => $id]);
    }

    public function updateAvatar(int $id, string $path): void
    {
        $this->db->connect()
            ->prepare(
            'INSERT INTO user_profiles (user_id, avatar_path)
                VALUES (:id,:p)
                ON CONFLICT (user_id) DO UPDATE SET avatar_path = EXCLUDED.avatar_path')
            ->execute([':id'=>$id, ':p'=>$path]);
    }
    public function getPasswordHash(int $id): ?string
    {
        $stmt = $this->db->connect()
                ->prepare('SELECT password_hash FROM users WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn() ?: null;
    }
}
