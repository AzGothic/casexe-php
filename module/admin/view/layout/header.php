<?php

use app\module\admin\model\Admin;

$admin = Admin::get();

?>

<?php if ($admin) : ?>
<h5 class="float-md-right">
    <?= $admin->name ?>
    <a href="/admin/auth/logout" class="btn btn-warning">Logout</a>
</h5>
<div class="clearfix"></div>
<?php endif; ?>
