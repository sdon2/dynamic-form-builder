<?php

require_once('functions.php');

checkLogin() && checkAdmin();

require_once('database.php');

$form_id = $_GET['form'];

$sql = sprintf('SELECT * FROM form_fields WHERE form_id = %s', $form_id);

$query = $conn->query($sql);

$table_html = '';
if ($query->num_rows > 0) {
    
    while ($row = $query->fetch_assoc()) {
        $table_html .= '<tr>';
        $options_required = in_array($row['type'], ['dropdown', 'checkbox', 'radio']);
        $options = $options_required ? sprintf("<td><a href=\"field_options.php?field=%d&form={$form_id}\" class=\"btn btn-primary\">Options</a></td>", $row['id']) : '<td></td>';
        $table_html .= sprintf("<td>%s</td><td>%s</td><td>%s</td><td>%s</td>", $row['id'], $row['label'], ucfirst($row['type']), $row['required'] ? 'Yes' : 'No');
        $table_html .= sprintf('<td>%s</td><td>%s</td>', $row['placeholder'], $row['sort_order']);
        $table_html .= $options;
        $table_html .= "</tr>";
    }

    $table_html .= '</tr>';
} else {
    $table_html = '<tr><td colspan="5">No entries found.</td></tr>';
}

$content = <<<HTML
<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary" href="create-field.php?form={$_GET['form']}">Create Field</a>
    </div>
    <div class="col-md-12 my-2">
        <div class="card">
            <div class="card-header">Fields</div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Label</th>
                            <th>Type</th>
                            <th>Required?</th>
                            <th>Placeholder</th>
                            <th>Sort Order</th>
                            <th width="10%">Actions</th>
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
    'title' => 'Forms',
    'content' => $content,
]);