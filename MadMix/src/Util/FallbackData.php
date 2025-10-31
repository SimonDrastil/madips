<?php
declare(strict_types=1);

namespace MadMix\Util;

final class FallbackData
{
    /** @return array<int,array{id:int,name:string,slug:string}> */
    public static function categories(): array
    {
        return [
            ['id' => 1, 'name' => 'Comedy', 'slug' => 'comedy'],
            ['id' => 2, 'name' => 'Sci-Fi', 'slug' => 'sci-fi'],
            ['id' => 3, 'name' => 'Horror', 'slug' => 'horror'],
            ['id' => 4, 'name' => 'School', 'slug' => 'school'],
            ['id' => 5, 'name' => 'Sports', 'slug' => 'sports'],
        ];
    }

    /** @return array<int,array<string,mixed>> */
    public static function templates(): array
    {
        $categories = self::categories();
        $index = [];
        foreach ($categories as $category) {
            $index[$category['id']] = $category['name'];
        }

        $templates = [
            ['id' => 1, 'user_id' => 1, 'category_id' => 1, 'title' => 'Galactic Giggles', 'slug' => 'galactic-giggles', 'body' => 'In a {adjective} galaxy, Captain {name|title} piloted the {adjective} {thing}.', 'difficulty' => 'easy', 'is_public' => 1],
            ['id' => 2, 'user_id' => 1, 'category_id' => 1, 'title' => 'Prank Day', 'slug' => 'prank-day', 'body' => 'Every {weekday} the class would {verb} the {teacher|title}.', 'difficulty' => 'easy', 'is_public' => 1],
            ['id' => 3, 'user_id' => 1, 'category_id' => 2, 'title' => 'Cosmic Heist', 'slug' => 'cosmic-heist', 'body' => '{set:hero={name}} planned a heist on {place}. Their {adjective} crew needed {number} gadgets.', 'difficulty' => 'norm', 'is_public' => 1],
            ['id' => 4, 'user_id' => 1, 'category_id' => 2, 'title' => 'Alien Interview', 'slug' => 'alien-interview', 'body' => 'Today we interviewed a {adjective} alien who only spoke in {emotion} squeaks.', 'difficulty' => 'easy', 'is_public' => 1],
            ['id' => 5, 'user_id' => 1, 'category_id' => 3, 'title' => 'Haunted Hallway', 'slug' => 'haunted-hallway', 'body' => 'The {adjective} hallway echoed with {noun:plural} and {choice|whispers|cackles|footsteps}.', 'difficulty' => 'norm', 'is_public' => 1],
            ['id' => 6, 'user_id' => 1, 'category_id' => 3, 'title' => 'Midnight Snack', 'slug' => 'midnight-snack', 'body' => 'At midnight, the {choice|ghost|zombie|vampire} demanded {food} with a side of {adjective} sauce.', 'difficulty' => 'easy', 'is_public' => 1],
            ['id' => 7, 'user_id' => 1, 'category_id' => 4, 'title' => 'Substitute Surprise', 'slug' => 'substitute-surprise', 'body' => 'Our substitute teacher was a {animal} named {name} who taught {choice|math|art|history}.', 'difficulty' => 'easy', 'is_public' => 1],
            ['id' => 8, 'user_id' => 1, 'category_id' => 4, 'title' => 'Detention Diaries', 'slug' => 'detention-diaries', 'body' => 'Detention was {adjective} until someone smuggled in a {thing} and started {verb:ing}.', 'difficulty' => 'norm', 'is_public' => 1],
            ['id' => 9, 'user_id' => 1, 'category_id' => 5, 'title' => 'Stadium Shake-Up', 'slug' => 'stadium-shake-up', 'body' => 'The crowd went {emotion} when the {choice|Lions|Sharks|Owls} {verb:past} the mascot.', 'difficulty' => 'norm', 'is_public' => 1],
            ['id' => 10, 'user_id' => 1, 'category_id' => 5, 'title' => "Coach's Pep Talk", 'slug' => 'coach-pep-talk', 'body' => 'Coach {name} shouted, "Give me {number}!" and we responded with {adjective} energy.', 'difficulty' => 'easy', 'is_public' => 1],
            ['id' => 11, 'user_id' => 1, 'category_id' => 1, 'title' => 'Comedy Roast', 'slug' => 'comedy-roast', 'body' => 'I roasted my friend with a {adjective} joke about their {thing} collection.', 'difficulty' => 'norm', 'is_public' => 1],
            ['id' => 12, 'user_id' => 1, 'category_id' => 2, 'title' => 'Robot Reboot', 'slug' => 'robot-reboot', 'body' => "The robot's {noun} malfunctioned, causing it to randomly {verb} every {number} seconds.", 'difficulty' => 'hard', 'is_public' => 1],
        ];

        foreach ($templates as &$template) {
            $template['category_name'] = $index[$template['category_id']] ?? '';
        }
        unset($template);

        return $templates;
    }

    /** @return array<string,mixed>|null */
    public static function templateBySlug(string $slug): ?array
    {
        foreach (self::templates() as $template) {
            if ($template['slug'] === $slug) {
                return $template;
            }
        }

        return null;
    }

    /** @return array<string,mixed>|null */
    public static function randomWord(string $pos): ?array
    {
        $words = [
            'noun' => [
                ['word' => 'spaceship', 'weight' => 2],
                ['word' => 'pencil', 'weight' => 1],
                ['word' => 'gadget', 'weight' => 1],
            ],
            'verb' => [
                ['word' => 'dance', 'weight' => 1],
                ['word' => 'sprint', 'weight' => 1],
                ['word' => 'zap', 'weight' => 1],
            ],
            'adjective' => [
                ['word' => 'wobbly', 'weight' => 2],
                ['word' => 'radiant', 'weight' => 1],
                ['word' => 'zany', 'weight' => 1],
            ],
            'animal' => [
                ['word' => 'llama', 'weight' => 1],
                ['word' => 'otter', 'weight' => 1],
            ],
            'food' => [
                ['word' => 'pizza', 'weight' => 2],
                ['word' => 'taco', 'weight' => 1],
            ],
            'emotion' => [
                ['word' => 'ecstatic', 'weight' => 1],
                ['word' => 'bewildered', 'weight' => 1],
            ],
            'color' => [
                ['word' => 'turquoise', 'weight' => 1],
                ['word' => 'crimson', 'weight' => 1],
            ],
            'thing' => [
                ['word' => 'gizmo', 'weight' => 1],
                ['word' => 'contraption', 'weight' => 1],
            ],
            'plural' => [
                ['word' => 'bananas', 'weight' => 1],
                ['word' => 'lasers', 'weight' => 1],
            ],
            'name' => [
                ['word' => 'Nova', 'weight' => 1],
                ['word' => 'Jax', 'weight' => 1],
            ],
            'teacher' => [
                ['word' => 'Professor Pixel', 'weight' => 1],
                ['word' => 'Coach Lumen', 'weight' => 1],
            ],
            'weekday' => [
                ['word' => 'Friday', 'weight' => 1],
                ['word' => 'Monday', 'weight' => 1],
            ],
            'place' => [
                ['word' => 'Mars Colony', 'weight' => 1],
                ['word' => 'Neon City', 'weight' => 1],
            ],
            'number' => [
                ['word' => '42', 'weight' => 1],
                ['word' => '9000', 'weight' => 1],
            ],
            'verb:past' => [
                ['word' => 'blasted', 'weight' => 1],
                ['word' => 'juggled', 'weight' => 1],
            ],
            'verb:ing' => [
                ['word' => 'dancing', 'weight' => 1],
                ['word' => 'plotting', 'weight' => 1],
            ],
        ];

        $options = $words[$pos] ?? null;
        if ($options === null) {
            return null;
        }

        $pool = [];
        foreach ($options as $option) {
            $pool = array_merge($pool, array_fill(0, (int)$option['weight'], $option['word']));
        }

        if ($pool === []) {
            return null;
        }

        return ['word' => $pool[array_rand($pool)]];
    }
}
