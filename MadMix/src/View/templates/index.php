<section>
    <h1>Community Templates</h1>
    <div class="grid cards">
        <?php foreach ($templates as $template): ?>
            <article class="card">
                <h2><?= htmlspecialchars($template['title']); ?></h2>
                <p><?= htmlspecialchars($template['category_name']); ?> · <?= htmlspecialchars($template['difficulty']); ?></p>
                <a href="/play/<?= htmlspecialchars($template['slug']); ?>" class="btn">Play</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
