<section class="card">
    <h1><?= htmlspecialchars($template['title'] ?? 'Story'); ?></h1>
    <article id="story" class="story" data-content="<?= htmlspecialchars($content); ?>">
        <pre><?= htmlspecialchars($content); ?></pre>
    </article>
    <div class="button-row">
        <?php if ($shareSlug): ?>
            <button class="btn" data-copy="<?= htmlspecialchars('https://example.com/s/' . $shareSlug); ?>">Copy Link</button>
        <?php endif; ?>
        <?php if (!empty($template['slug'])): ?>
        <form method="post" action="/play/<?= htmlspecialchars($template['slug']); ?>/remix">
            <?= MadMix\Util\Csrf::field(); ?>
            <button type="submit" class="btn ghost">Remix</button>
        </form>
        <?php endif; ?>
        <button class="btn" data-export="png">Download PNG</button>
        <button class="btn" data-export="pdf">Download PDF</button>
    </div>
</section>
