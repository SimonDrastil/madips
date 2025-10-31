<?php
/** @var array $data */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadMix</title>
    <link rel="stylesheet" href="/index.css">
    <link rel="icon" type="image/svg+xml" href="/assets/logo.svg">
</head>
<body>
<?php require __DIR__ . '/header.php'; ?>
<main class="container">
    <?php require __DIR__ . '/flash.php'; ?>
    <?php require $viewPath; ?>
</main>
<?php require __DIR__ . '/footer.php'; ?>
<script src="/app.js" defer></script>
</body>
</html>
