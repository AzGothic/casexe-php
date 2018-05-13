<?php

/* define title */
$this->title = $this->title . ' | Index';

use app\model\Winners;

?>

<h2>
    Winners
</h2>

<?php if (!$winners) : ?>
    <div class="alert alert-warning" role="alert">
        Nothing found
    </div>
<?php else: ?>
    <table class="table table-bordered">
        <thead class="thead-light">
        <tr>
            <th scope="col">User</th>
            <th scope="col">Prize</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($winners as $winner) : ?>
            <tr>
                <td>
                    <?= $winner->user->name ?>
                </td>
                <td>
                    <?= $winner->typeText ?>
                    <strong>
                        <?php if ($winner->type == Winners::TYPE_ITEM) : ?>
                            <?= $winner->item->name ?>
                        <?php else : ?>
                            <?= $winner->value ?>
                        <?php endif; ?>
                    </strong>
                </td>
                <td>
                    <?= $winner->statusText ?>
                </td>
                <td>
                    <?php if ($winner->status == Winners::STATUS_ACCEPTED) : ?>
                        <?php if ($winner->type == Winners::TYPE_ITEM) : ?>
                            <button class="btn btn-success item_sent" data-winner="<?= $winner->id ?>">Sent</button>
                        <?php else : ?>
                            <button class="btn btn-success user_transfer" data-user="<?= $winner->user->id ?>">Transfer</button>
                        <?php endif; ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>