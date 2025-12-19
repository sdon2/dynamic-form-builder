<?php

require_once('functions.php');

checkLogin();

$content = <<<HTML
<div class="row">
    <div class="col-12">
        <p>This is the main content area.</p>
    </div>
</div>
HTML;

template('template.php', [
    'title' => 'Home',
    'content' => $content,
]);