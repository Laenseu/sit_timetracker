    <?= $this->extend("layouts/default") ?>

<?= $this->section("title") ?> Users <?= $this->endSection() ?>

<?= $this->section("content") ?>


<h1>Users</h1>



<table class="table table-striped"
           id="time-log-table"
           data-pagination="true"
           data-page-list="[5, 10, 20, 50]"
           data-search="true">
    <thead>
        <tr>
            <th>Email</th>
            <th>Username</th>
            <th>Active</th>
            <th>Banned</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($users as $user): ?>
            <tr>
                <td><a href="<?= url_to("\Admin\Controllers\Users::show", $user->id) ?>"><?= esc($user->email) ?></a></td>
                <td><?= esc($user->username) ?></td>
                <td><?= yesno($user->active)?></td>
                <td><?= yesno($user->isBanned()) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $pager->links() ?>

<?= $this->endSection() ?>