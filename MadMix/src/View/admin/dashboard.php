<section class="grid stats">
    <article class="card">
        <h2>Templates</h2>
        <p><?= (int)$stats['templates']; ?></p>
    </article>
    <article class="card">
        <h2>Stories</h2>
        <p><?= (int)$stats['stories']; ?></p>
    </article>
    <article class="card">
        <h2>Flags</h2>
        <p><?= (int)$stats['flags']; ?></p>
    </article>
</section>
<section class="card">
    <h2>Latest Stories</h2>
    <ul>
        <?php foreach ($recent as $story): ?>
            <li><?= htmlspecialchars(mb_strimwidth($story['content'], 0, 120, '...')); ?></li>
        <?php endforeach; ?>
    </ul>
</section>
