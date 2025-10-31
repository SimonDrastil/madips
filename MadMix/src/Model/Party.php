<?php
declare(strict_types=1);

namespace MadMix\Model;

final class Party
{
    public static function createRoom(int $hostUserId): array
    {
        $code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
        $stmt = DB::conn()->prepare('INSERT INTO party_rooms (host_user_id, code, active, created_at) VALUES (:host_user_id, :code, 1, NOW())');
        $stmt->execute([
            'host_user_id' => $hostUserId,
            'code' => $code,
        ]);

        return ['code' => $code, 'id' => (int)DB::conn()->lastInsertId()];
    }

    public static function findByCode(string $code): ?array
    {
        $stmt = DB::conn()->prepare('SELECT * FROM party_rooms WHERE code = :code AND active = 1');
        $stmt->execute(['code' => $code]);
        $room = $stmt->fetch();
        return $room ?: null;
    }

    public static function stateByCode(string $code): array
    {
        $room = self::findByCode($code);
        if (!$room) {
            return ['room' => null, 'submissions' => []];
        }

        $subStmt = DB::conn()->prepare('SELECT placeholder_key, value, user_nick FROM party_submissions WHERE room_id = :room_id ORDER BY created_at');
        $subStmt->execute(['room_id' => $room['id']]);

        return ['room' => $room, 'submissions' => $subStmt->fetchAll()];
    }

    public static function submit(int $roomId, string $placeholder, string $value, string $nick): void
    {
        $stmt = DB::conn()->prepare('INSERT INTO party_submissions (room_id, placeholder_key, value, user_nick, created_at) VALUES (:room_id, :placeholder_key, :value, :user_nick, NOW())');
        $stmt->execute([
            'room_id' => $roomId,
            'placeholder_key' => $placeholder,
            'value' => $value,
            'user_nick' => $nick,
        ]);
    }
}
