<section class="card">
    <h1>Create Account</h1>
    <form method="post" action="/register" class="stack">
        <?= MadMix\Util\Csrf::field(); ?>
        <label>Email
            <input name="email" type="email" required>
        </label>
        <label>Password
            <input name="password" type="password" required>
        </label>
        <button type="submit" class="btn primary">Register</button>
    </form>
</section>
