<section class="card" id="party-lobby" data-code="<?= htmlspecialchars($state['room']['code'] ?? ''); ?>">
    <h1>Party Lobby</h1>
    <?php if (!$state['room']): ?>
        <p>Room inactive.</p>
    <?php else: ?>
        <ul id="submission-list">
            <?php foreach ($state['submissions'] as $submission): ?>
                <li><strong><?= htmlspecialchars($submission['placeholder_key']); ?></strong> by <?= htmlspecialchars($submission['user_nick']); ?> — <?= htmlspecialchars($submission['value']); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>
