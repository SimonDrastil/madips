<section class="card">
    <h1><?= htmlspecialchars($template['title']); ?></h1>
    <p>Category: <?= htmlspecialchars($template['category_name']); ?> · Difficulty: <?= htmlspecialchars($template['difficulty']); ?></p>
    <form method="post" action="/play/<?= htmlspecialchars($template['slug']); ?>/generate" class="stack" data-template="<?= htmlspecialchars($template['body']); ?>">
        <?= MadMix\Util\Csrf::field(); ?>
        <?php foreach ($placeholders as $key => $pos): ?>
            <label class="input-group">
                <span><?= htmlspecialchars(ucfirst($key)); ?> (<?= htmlspecialchars($pos); ?>)</span>
                <div class="input-with-button">
                    <input name="<?= htmlspecialchars($key); ?>" value="<?= htmlspecialchars($_SESSION['old'][$key] ?? ''); ?>" required placeholder="e.g., fun, swift" />
                    <button type="button" class="btn ghost" data-random="<?= htmlspecialchars($key); ?>" data-pos="<?= htmlspecialchars($pos); ?>">🎲</button>
                </div>
            </label>
        <?php endforeach; ?>
        <button type="submit" class="btn primary">Reveal Story</button>
    </form>
</section>
