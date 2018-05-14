<?php

use app\model\{
    User,
    Winners,
    Options
};

?>

<?php if (!$winner) : ?>
    <h2>LOTTERY</h2>
    <button class="btn btn-success btn-lg btn-block" id="lottery_play">PLAY</button>
<?php else : ?>
    <h2>YOUR PRIZE</h2>
    <div class="alert alert-success" role="alert">
        <?php if ($winner->type == Winners::TYPE_ITEM) : ?>
            <strong><?= $winner->item->name ?></strong>
            <?php if ($winner->status == Winners::STATUS_WAITING) : ?>
                <div>Choose Action</div>
                <button class="btn btn-success btn-block" id="prize_accept">Accept</button>
                <button class="btn btn-warning btn-block" id="prize_change">Change for <?= $winner->item->points ?> Points</button>
                <button class="btn btn-danger btn-block" id="prize_reject">Reject</button>
            <?php elseif ($winner->status == Winners::STATUS_ACCEPTED) : ?>
                <div><i>Accepted, waiting for delivery</i></div>
            <?php elseif ($winner->status == Winners::STATUS_REJECTED) : ?>
                <div><i>Rejected</i></div>
            <?php elseif ($winner->status == Winners::STATUS_DONE) : ?>
                <div><i>Done</i></div>
            <?php endif; ?>
        <?php elseif ($winner->type == Winners::TYPE_EURO) : ?>
            <strong><?= $winner->value ?> EURO</strong>
            <?php if ($winner->status == Winners::STATUS_WAITING) : ?>
                <div>Choose Action</div>
                <button class="btn btn-success btn-block" id="prize_accept">Accept</button>
                <button class="btn btn-warning btn-block" id="prize_change">Change for <?= ceil($winner->value * Options::get('convertation_ratio')) ?> Points</button>
                <button class="btn btn-danger btn-block" id="prize_reject">Reject</button>
            <?php elseif ($winner->status == Winners::STATUS_ACCEPTED) : ?>
                <div><i>Accepted</i></div>
                <button class="btn btn-success btn-block" id="prize_to_card">Withdraw to <?= User::get()->card ?></button>
            <?php elseif ($winner->status == Winners::STATUS_REJECTED) : ?>
                <div><i>Rejected</i></div>
            <?php elseif ($winner->status == Winners::STATUS_DONE) : ?>
                <div><i>Done</i></div>
            <?php endif; ?>
        <?php else : ?>
            <strong><?= $winner->value ?> Points</strong>
            <?php if ($winner->status == Winners::STATUS_WAITING) : ?>
                <div>Choose Action</div>
                <button class="btn btn-success btn-block" id="prize_accept">Accept</button>
                <button class="btn btn-danger btn-block" id="prize_reject">Reject</button>
            <?php elseif ($winner->status == Winners::STATUS_REJECTED) : ?>
                <div><i>Rejected</i></div>
            <?php elseif ($winner->status == Winners::STATUS_DONE) : ?>
                <div><i>Added to Loyality points</i></div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>