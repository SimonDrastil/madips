<?php
declare(strict_types=1);

namespace MadMix\Model;

use MadMix\Util\Slug;
use PDO;

final class Template
{
    public static function allPublic(): array
    {
        $stmt = DB::conn()->query('SELECT t.*, c.name AS category_name FROM templates t JOIN categories c ON c.id = t.category_id WHERE is_public = 1 ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public static function findBySlug(string $slug): ?array
    {
        $stmt = DB::conn()->prepare('SELECT t.*, c.name AS category_name FROM templates t JOIN categories c ON c.id = t.category_id WHERE slug = :slug');
        $stmt->execute(['slug' => $slug]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public static function create(array $data): int
    {
        $slug = Slug::make($data['title']);
        $stmt = DB::conn()->prepare('INSERT INTO templates (user_id, category_id, title, slug, body, difficulty, is_public, created_at, updated_at) VALUES (:user_id, :category_id, :title, :slug, :body, :difficulty, :is_public, NOW(), NOW())');
        $stmt->execute([
            'user_id' => $data['user_id'],
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'body' => $data['body'],
            'difficulty' => $data['difficulty'],
            'is_public' => $data['is_public'] ?? 1,
        ]);

        return (int)DB::conn()->lastInsertId();
    }

    public static function updateBySlug(string $slug, array $data): void
    {
        $stmt = DB::conn()->prepare('UPDATE templates SET title=:title, body=:body, difficulty=:difficulty, category_id=:category_id, is_public=:is_public, updated_at=NOW() WHERE slug=:slug');
        $stmt->execute([
            'title' => $data['title'],
            'body' => $data['body'],
            'difficulty' => $data['difficulty'],
            'category_id' => $data['category_id'],
            'is_public' => $data['is_public'] ?? 0,
            'slug' => $slug,
        ]);
    }
}
