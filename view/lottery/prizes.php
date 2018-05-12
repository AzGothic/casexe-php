<?php if ($options['prize_pool_left'] >= $options['min_prize']) : ?>
    <?php $max = ($options['max_prize'] <= $options['prize_pool_left'])
                ? $options['max_prize']
                : $options['prize_pool_left'] ?>
    <li class="list-group-item">
        <strong><?= $options['min_prize'] ?>-<?= $max ?> EURO</strong> (left <?= $options['prize_pool_left'] ?> EURO)
    </li>
<?php endif; ?>
<li class="list-group-item">
    <strong><?= $options['min_points'] ?>-<?= $options['max_points'] ?> Points</strong>
</li>
<?php if ($items) : ?>
    <?php foreach ($items as $item) : ?>
        <li class="list-group-item"><strong><?= $item->name ?></strong></li>
    <?php endforeach; ?>
<?php endif; ?>