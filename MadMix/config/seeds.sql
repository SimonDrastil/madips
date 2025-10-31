INSERT INTO users (email, password_hash, role) VALUES
('admin@example.com', '$2y$10$h0Y.gxTqYtDrfCkEFdDD9ONiW8yF8dSBI0Z7XEtJDLrFvhQ9A9bA6', 'admin');

INSERT INTO categories (name, slug) VALUES
('Comedy', 'comedy'),
('Sci-Fi', 'sci-fi'),
('Horror', 'horror'),
('School', 'school'),
('Sports', 'sports');

INSERT INTO templates (user_id, category_id, title, slug, body, difficulty, is_public) VALUES
(1, 1, 'Galactic Giggles', 'galactic-giggles', 'In a {adjective} galaxy, Captain {name|title} piloted the {adjective} {thing}.', 'easy', 1),
(1, 1, 'Prank Day', 'prank-day', 'Every {weekday} the class would {verb} the {teacher|title}.', 'easy', 1),
(1, 2, 'Cosmic Heist', 'cosmic-heist', '{set:hero={name}} planned a heist on {place}. Their {adjective} crew needed {number} gadgets.', 'norm', 1),
(1, 2, 'Alien Interview', 'alien-interview', 'Today we interviewed a {adjective} alien who only spoke in {emotion} squeaks.', 'easy', 1),
(1, 3, 'Haunted Hallway', 'haunted-hallway', 'The {adjective} hallway echoed with {noun:plural} and {choice|whispers|cackles|footsteps}.', 'norm', 1),
(1, 3, 'Midnight Snack', 'midnight-snack', 'At midnight, the {choice|ghost|zombie|vampire} demanded {food} with a side of {adjective} sauce.', 'easy', 1),
(1, 4, 'Substitute Surprise', 'substitute-surprise', 'Our substitute teacher was a {animal} named {name} who taught {choice|math|art|history}.', 'easy', 1),
(1, 4, 'Detention Diaries', 'detention-diaries', 'Detention was {adjective} until someone smuggled in a {thing} and started {verb:ing}.', 'norm', 1),
(1, 5, 'Stadium Shake-Up', 'stadium-shake-up', 'The crowd went {emotion} when the {choice|Lions|Sharks|Owls} {verb:past} the mascot.', 'norm', 1),
(1, 5, 'Coach''s Pep Talk', 'coach-pep-talk', 'Coach {name} shouted, "Give me {number}!" and we responded with {adjective} energy.', 'easy', 1),
(1, 1, 'Comedy Roast', 'comedy-roast', 'I roasted my friend with a {adjective} joke about their {thing} collection.', 'norm', 1),
(1, 2, 'Robot Reboot', 'robot-reboot', 'The robot''s {noun} malfunctioned, causing it to randomly {verb} every {number} seconds.', 'hard', 1);

INSERT INTO word_banks (pos, word, weight) VALUES
('noun', 'spaceship', 2),
('noun', 'pencil', 1),
('verb', 'dance', 1),
('verb', 'sprint', 1),
('adjective', 'wobbly', 2),
('adjective', 'radiant', 1),
('animal', 'llama', 1),
('food', 'pizza', 2),
('emotion', 'ecstatic', 1),
('color', 'turquoise', 1),
('thing', 'gizmo', 1),
('name', 'Nova', 1),
('weekday', 'Friday', 1),
('weekday', 'Monday', 1),
('place', 'Mars Colony', 1),
('number', '42', 1);
