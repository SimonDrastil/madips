# MadMix

MadMix is a modern Mad Libs-inspired web app built with vanilla PHP and MySQL. It features curated templates, animated story reveals, party mode, and lightweight admin controls.

## Requirements
- PHP 8.2+
- MySQL 8+
- GD extension for PNG exports (optional but recommended)

## Setup
1. Clone the repository and move into the project directory.
2. Copy the environment file:
   ```bash
   cp .env.example .env
   ```
   Adjust database credentials as needed.
3. Create the database schema and seed data:
   ```bash
   mysql -u root -p madmix < config/schema.sql
   mysql -u root -p madmix < config/seeds.sql
   ```
4. Set your web root to `public/` and ensure PHP sessions are enabled.
5. Log in with the seeded admin account `admin@example.com` / `Admin123!`.

## Running Tests
```
php tests/TextEngineTest.php
php tests/ValidatorTest.php
```

## Features
- Dynamic placeholder engine with variables, modifiers, and weighted randomness
- Smart play forms with CSRF protection and rate limiting
- Party mode with QR join links and lobby polling
- PNG/PDF exports via server-side rendering
- Admin dashboard for key metrics

## Notes
- The project ships with an autoloader in `vendor/autoload.php` for simple PSR-4 loading.
- Configure web servers (Apache/Nginx) to route all requests through `public/index.php` for routing to function.
