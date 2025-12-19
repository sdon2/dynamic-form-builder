<?php

require_once('functions.php');

checkLogin() && checkAdmin();

require_once('database.php');

$query = $conn->query('SELECT * FROM forms');

if ($query->num_rows > 0) {
    $table_html = '<tr>';
    
    while ($row = $query->fetch_assoc()) {
        $table_html .= sprintf("<td>%s</td><td>%s</td>", $row['id'], $row['form_name']);
        $table_html .= sprintf("<td><a href=\"fields.php?form=%d\" class=\"mx-1 btn btn-primary\">Fields</a>", $row['id']);
        $table_html .= sprintf("<a href=\"responses.php?form=%d\" class=\"mx-1 btn btn-success\">Responses</a></td>", $row['id']);
    }

    $table_html .= '</tr>';
} else {
    $table_html = '<tr><td colspan="3">No entries found.</td></tr>';
}

$content = <<<HTML
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary" href="create-form.php">Create Form</a>
    </div>
    <div class="col-md-12 my-2">
        <div class="card">
            <div class="card-header">Forms</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Form Name</th>
                            <th width="20%">Actions</th>
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
        <a href="index.php" class="btn btn-primary">Back</a>
    </div>
</div>
HTML;

template('template.php', [
    'title' => 'Forms',
    'content' => $content,
]);