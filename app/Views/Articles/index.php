<?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?> Articles <?= $this->endSection() ?>

<?= $this->section("content") ?>

    <h1>Articles</h1>

    <?php foreach ($articles as $article): ?>
        <article>
            <h2> <?= $article["title"] ?></h2>
            <p> <?= $article["content"]?> </p>
        </article>
    <?php endforeach; ?>

<?= $this->endSection() ?>