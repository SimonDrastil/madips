<section class="hero">
    <h1>MadMix: Stories remixed with your words.</h1>
    <p>Choose a curated template, add hilarious words, and reveal animated tales. Perfect for parties, classrooms, and everything in-between.</p>
    <a class="btn primary" href="/play">Start Playing</a>
</section>
<section class="grid cards">
    <?php foreach ($featured as $template): ?>
        <article class="card">
            <h2><?= htmlspecialchars($template['title']); ?></h2>
            <p>Category: <?= htmlspecialchars($template['category_name']); ?></p>
            <a class="btn" href="/play/<?= htmlspecialchars($template['slug']); ?>">Play</a>
        </article>
    <?php endforeach; ?>
</section>
<section>
    <h2>Categories</h2>
    <ul class="chip-list">
        <?php foreach ($categories as $category): ?>
            <li class="badge"><?= htmlspecialchars($category['name']); ?></li>
        <?php endforeach; ?>
    </ul>
</section>
