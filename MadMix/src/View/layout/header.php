<header class="site-header">
    <div class="container flex between align-center">
        <a class="brand" href="/">
            <img src="/assets/logo.svg" alt="MadMix logo" width="36" height="36">
            <span>MadMix</span>
        </a>
        <nav>
            <a href="/play">Play</a>
            <a href="/templates">Templates</a>
            <a href="/party/host">Party</a>
            <?php if (isset($_SESSION['user'])): ?>
                <form class="inline" method="post" action="/logout">
                    <?= MadMix\Util\Csrf::field(); ?>
                    <button type="submit" class="btn">Logout</button>
                </form>
            <?php else: ?>
                <a href="/login" class="btn">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
