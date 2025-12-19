<?php

require_once('functions.php');

checkLogin() && checkAdmin();

require_once('database.php');

$form_id = $_GET['form'];

$sql = <<<SQL
SELECT fr.user_id, f.form_name, ff.label, frv.*
FROM form_responses fr
JOIN form_response_values frv ON frv.response_id = fr.id
JOIN form_fields ff ON frv.field_id = ff.id
JOIN forms f ON ff.form_id = f.id
WHERE fr.form_id = {$form_id}
ORDER BY fr.user_id, ff.label
SQL;

$query = $conn->query($sql);

$table_html = '';
if ($query->num_rows > 0) {    
    while ($row = $query->fetch_assoc()) {
        $table_html .= '<tr>';
        $table_html = sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td>", getUserById($row['user_id'])['email'], $row['form_name'], $row['label'], $row['value']);
        $table_html .= "</tr>";
    }
} else {
    $table_html = '<tr><td colspan="4">No entries found.</td></tr>';
}

$content = <<<HTML
<div class="row">
    <div class="col-md-12 my-2">
        <div class="card">
            <div class="card-header">Responses</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Form</th>
                            <th>Label</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        $table_html
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-12 my-2">
        <a href="forms.php" class="btn btn-primary">Back</a>
    </div>
</div>
HTML;

template('template.php', [
    'title' => 'Responses',
    'content' => $content,
]);