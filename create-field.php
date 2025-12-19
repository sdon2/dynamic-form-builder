<?php

require_once('functions.php');
require_once('config.php');

checkLogin() && checkAdmin();

$form_id = $_GET['form'];

if ($_POST) {
    $label = $_POST['label'];
    $type = $_POST['type'];
    $required = $_POST['required'];
    $placeholder = $_POST['placeholder'];
    $sort_order = $_POST['sort_order'];

    require_once('database.php');

    $sql = "INSERT INTO `form_fields` (`form_id`, `label`, `type`, `required`, `placeholder`, `sort_order`) VALUES ({$form_id}, ?, ?, ?, ?, ?)";
    $statement = $conn->prepare($sql);
    $statement->bind_param('ssisi', $label, $type, $required, $placeholder, $sort_order);

    if ($statement->execute()) {
        session_set('success', 'Field created successfully');
        redirect("fields.php?form={$form_id}");
        exit();
    }
}

$type_options = '';
foreach ($field_types as $type) {
    $type_options .= sprintf('<option value="%s">%s</option>', $type, ucfirst($type));
}

$content = <<<HTML
<form method="POST" action="" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 mt-2 form-group">
            <label class="form-label">Label</label>
            <input type="text" class="form-control" name="label" placeholder="Label" required>
        </div>
        <div class="col-md-6 mt-2 form-group">
            <label class="form-label">Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="">--SELECT--</option>
                {$type_options}
            </select>
        </div>
        <div class="col-md-4 mt-2 form-group">
            <label class="form-label">Required</label>
            <select name="required" id="required" class="form-control" required>
                <option value="">--SELECT--</option>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="col-md-4 mt-2 form-group">
            <label class="form-label">Placeholder</label>
            <input type="text" class="form-control" name="placeholder" placeholder="Place Holder">
        </div>
        <div class="col-md-4 mt-2 form-group">
            <label class="form-label">Sort Order</label>
            <input type="number" class="form-control" name="sort_order" placeholder="Sort Order">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="fields.php?form={$form_id}" class="btn btn-primary">Back</a>
        </div>
    </div>
</form>
HTML;

template('template.php', [
    'title' => 'Create new field',
    'content' => $content,
]);