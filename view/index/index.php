<?php

/* define title */
$this->title = $this->title . ' | Index';

?>

<div class="alert alert-primary" role="alert">Logged as '<?= $user->email ?>'</div>
<a href="/auth/logout" class="btn btn-warning">Logout</a>