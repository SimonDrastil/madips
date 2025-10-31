<section class="card">
    <h1>Party Room</h1>
    <p>Share this code with friends: <strong><?= htmlspecialchars($room['code']); ?></strong></p>
    <img src="<?= htmlspecialchars($qr); ?>" alt="QR code to join party">
    <p>Guests can join at <code>/party/join?code=<?= htmlspecialchars($room['code']); ?></code></p>
</section>
