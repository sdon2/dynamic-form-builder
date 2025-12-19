<?php

require_once 'functions.php';

checkLogin() && checkUser();

require_once 'database.php';

$query = $conn->query('SELECT * FROM `forms` ORDER BY `created_at`');

$html = '';

if ($query->num_rows > 0) {
    while ($row = $query->fetch_assoc()) {
        $html .= '<tr>';
        $html .= sprintf('<td>%s</td>', $row['form_name']);
        $html .= sprintf('<td><a href="register-response.php?form=%d">Register Response</a></td>', $row['id']);
        $html .= '</tr>';
    }
} else {
    $html = '<tr><td colspan="2">No forms found.</td></tr>';
}

$content = <<<HTML
<div class="container">
    <div class="row mt-4">
        <div class="col-12">
            <h2>Dynamic Forms</h2>
            <table class="table table-bordered">
                <thead>
                    <th>Form Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    {$html}
                </tbody>
            </table>
        </div>
    </div>
</div>
HTML;

template('template.php', [
    'title' => 'Home',
    'content' => $content,
]);
