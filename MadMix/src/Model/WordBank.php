<?php
declare(strict_types=1);

namespace MadMix\Model;

use MadMix\Util\FallbackData;
use RuntimeException;

final class WordBank
{
    public static function randomByPos(string $pos): ?array
    {
        try {
            $stmt = DB::conn()->prepare('SELECT word, weight FROM word_banks WHERE pos = :pos');
            $stmt->execute(['pos' => $pos]);
            $words = $stmt->fetchAll();
            if (!$words) {
                return null;
            }

            $pool = [];
            foreach ($words as $word) {
                $pool = array_merge($pool, array_fill(0, (int)$word['weight'], $word['word']));
            }

            return ['word' => $pool[array_rand($pool)]];
        } catch (RuntimeException $e) {
            return FallbackData::randomWord($pos);
        }
    }
}
