<?php
declare(strict_types=1);

namespace MadMix\Model;

use MadMix\Util\Slug;
use RuntimeException;

final class Story
{
    public static function create(int $templateId, ?int $userId, string $content): string
    {
        $shareSlug = Slug::make(bin2hex(random_bytes(5)));

        try {
            $stmt = DB::conn()->prepare('INSERT INTO stories (template_id, user_id, content, share_slug, created_at) VALUES (:template_id, :user_id, :content, :share_slug, NOW())');
            $stmt->execute([
                'template_id' => $templateId,
                'user_id' => $userId,
                'content' => $content,
                'share_slug' => $shareSlug,
            ]);
        } catch (RuntimeException $e) {
            if (session_status() === PHP_SESSION_ACTIVE) {
                $_SESSION['stories'][$shareSlug] = [
                    'template_id' => $templateId,
                    'user_id' => $userId,
                    'content' => $content,
                    'share_slug' => $shareSlug,
                ];
            }
        }

        return $shareSlug;
    }

    public static function findByShareSlug(string $slug): ?array
    {
        try {
            $stmt = DB::conn()->prepare('SELECT * FROM stories WHERE share_slug = :slug');
            $stmt->execute(['slug' => $slug]);
            $story = $stmt->fetch();
            if ($story) {
                return $story;
            }
        } catch (RuntimeException $e) {
            // fall through to session storage
        }

        return $_SESSION['stories'][$slug] ?? null;
    }
}
