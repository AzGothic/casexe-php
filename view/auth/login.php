<?php

/* define title */
$this->title = $this->title . ' | Login';

?>

<form method="POST" action="<?= App::i()->request->route['uri'] ?>">
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="<?= $form['email'] ?>">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
        </div>
    </div>
    <div class="form-group row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary">Sign in</button>
        </div>
    </div>
</form>

