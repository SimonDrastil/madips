<section>
    <h1>Pick a template</h1>
    <div class="grid cards">
        <?php foreach ($templates as $template): ?>
            <article class="card">
                <h2><?= htmlspecialchars($template['title']); ?></h2>
                <p><?= htmlspecialchars($template['category_name']); ?> · <?= htmlspecialchars($template['difficulty']); ?></p>
                <a class="btn" href="/play/<?= htmlspecialchars($template['slug']); ?>">Details</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>
