<?php
declare(strict_types=1);

namespace MadMix\Model;

final class User
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = DB::conn()->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function create(array $data): int
    {
        $stmt = DB::conn()->prepare('INSERT INTO users (email, password_hash, role, created_at) VALUES (:email, :password_hash, :role, NOW())');
        $stmt->execute([
            'email' => $data['email'],
            'password_hash' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role' => $data['role'] ?? 'user',
        ]);

        return (int)DB::conn()->lastInsertId();
    }
}
