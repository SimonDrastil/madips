<section class="card">
    <h1>Join a Party</h1>
    <form method="post" action="/api/party/submit" class="stack" id="party-join-form">
        <label>Room Code
            <input name="code" value="<?= htmlspecialchars($_GET['code'] ?? ''); ?>" required>
        </label>
        <label>Your nickname
            <input name="nick" required>
        </label>
        <label>Placeholder key
            <input name="placeholder_key" placeholder="e.g., noun" required>
        </label>
        <label>Your word
            <input name="value" placeholder="e.g., comet" required>
        </label>
        <button type="submit" class="btn primary">Submit Word</button>
    </form>
</section>
