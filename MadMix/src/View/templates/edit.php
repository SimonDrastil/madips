<section class="card">
    <h1>Edit Template</h1>
    <form method="post" action="/templates/<?= htmlspecialchars($template['slug']); ?>" class="stack">
        <?= MadMix\Util\Csrf::field(); ?>
        <label>Title
            <input name="title" required value="<?= htmlspecialchars($template['title']); ?>">
        </label>
        <label>Category
            <select name="category_id">
                <?php foreach ($categories as $category): ?>
                    <option value="<?= (int)$category['id']; ?>" <?= $category['id'] == $template['category_id'] ? 'selected' : ''; ?>><?= htmlspecialchars($category['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label>Difficulty
            <select name="difficulty">
                <option value="easy" <?= $template['difficulty'] === 'easy' ? 'selected' : ''; ?>>Easy</option>
                <option value="norm" <?= $template['difficulty'] === 'norm' ? 'selected' : ''; ?>>Normal</option>
                <option value="hard" <?= $template['difficulty'] === 'hard' ? 'selected' : ''; ?>>Hard</option>
            </select>
        </label>
        <label>Body
            <textarea name="body" rows="8" required><?= htmlspecialchars($template['body']); ?></textarea>
        </label>
        <label><input type="checkbox" name="is_public" <?= $template['is_public'] ? 'checked' : ''; ?>> Public</label>
        <button type="submit" class="btn primary">Update</button>
    </form>
</section>
