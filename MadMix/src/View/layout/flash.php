<?php if (!empty($_SESSION['flash'])): ?>
    <div class="flash success"><?= htmlspecialchars($_SESSION['flash']); ?></div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
<?php if (!empty($_SESSION['errors'])): ?>
    <div class="flash error">
        <?php foreach ($_SESSION['errors'] as $field => $message): ?>
            <p><strong><?= htmlspecialchars($field); ?>:</strong> <?= htmlspecialchars($message); ?></p>
        <?php endforeach; ?>
    </div>
    <?php unset($_SESSION['errors'], $_SESSION['old']); ?>
<?php endif; ?>
