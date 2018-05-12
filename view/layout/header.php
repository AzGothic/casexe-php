<?php

use app\model\User;

$user = User::get();

?>

<?php if ($user) : ?>
<h5 class="float-md-right">
    <?= $user->name ?> (<span class="user_points_box"><span class="user_points"><?= $user->points ?></span> Points</span>)
    <a href="/auth/logout" class="btn btn-warning">Logout</a>
</h5>
<div class="clearfix"></div>
<?php endif; ?>
