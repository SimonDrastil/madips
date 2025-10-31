<section class="card">
    <h1>Create Template</h1>
    <form method="post" action="/templates" class="stack">
        <?= MadMix\Util\Csrf::field(); ?>
        <label>Title
            <input name="title" required>
        </label>
        <label>Category
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int)$category['id']; ?>"><?= htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Difficulty
            <select name="difficulty">
                <option value="easy">Easy</option>
                <option value="norm" selected>Normal</option>
                <option value="hard">Hard</option>
            </select>
        </label>
        <label>Body
            <textarea name="body" rows="8" placeholder="Use {placeholder:type} syntax" required></textarea>
        </label>
        <label><input type="checkbox" name="is_public" checked> Public</label>
        <button type="submit" class="btn primary">Save</button>
    </form>
</section>
