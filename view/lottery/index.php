<?php

/* define title */
$this->title = $this->title . ' | Lottery';

?>

<div id="lottery_box">
    Loading...
</div>

<div>
    <h3>
        Prize Pool
        <button class="btn btn-primary prizes_update float-md-right">refresh</button>
    </h3>
    <ul class="list-group" id="prizes">
        <li class="list-group-item">Loading...</li>
    </ul>
</div>

<?php if (APP_ENV !== 'prod') : ?>
<div>
    <h2>ONLY FOR DEVELOPMENT</h2>
    <a class="btn btn-dark" href="/lottery/clear">Delete current user from Winners</a>
</div>
<?php endif; ?>
