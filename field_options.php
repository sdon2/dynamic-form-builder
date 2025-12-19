<?php

require_once('functions.php');
require_once('database.php');

checkLogin() && checkAdmin();

$field_id = $_GET['field'];
$form_id = $_GET['form'];

$query = $conn->query("SELECT * FROM `field_options` WHERE `field_id`={$field_id}");

$options_html = '';
while($row = $query->fetch_assoc()) {
    $options_html .= sprintf('<div class="col-md-6"><label class="form-label">Option 1</label><input type="text" class="form-control" name="options[]" value="%s" required><button type="button" class="remove-option btn btn-danger" title="Remove">X</button></div>', $row['option_text']);
}

if ($_POST) {
    $options = $_POST['options'];

    require_once('database.php');

    // Delete existing options
    $sql = "DELETE FROM `field_options` WHERE `field_id`={$field_id}";
    $conn->execute_query($sql);

    foreach($options as $option) {
        // Insert new options
        $sql = "INSERT INTO `field_options` (`field_id`, `option_text`) VALUES ({$field_id}, ?)";
        $statement = $conn->prepare($sql);
        $statement->bind_param('s', $option);
        $statement->execute();
    }

    session_set('success', 'Options created successfully');
    redirect("fields.php?form={$form_id}");
    exit();
}

$content = <<<HTML
<form method="POST" action="" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12 mt-2 mt-4 field-options">
            <div class="row">
                <div class="col-12 d-flex">
                    <div>
                        <h4>Field Options</h4>
                    </div>
                    <div class="px-2">
                        <button type="button" class="add-option btn btn-info">Add Option</button>
                    </div>
                </div>
                {$options_html}
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="fields.php?form={$form_id}" class="btn btn-primary">Back</a>
        </div>
    </div>
</form>
<style>
    .remove-option {
        position: relative;
        bottom: 72px;
        left: 72px;
        padding: 5px 10px;
        font-size: 12px;
    }
</style>
<script src="//code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    var option_number = 2;

    $('.add-option').on('click', function () {
        var option = $('<div class="col-md-6"><label class="form-label">Option ' + option_number + '</label><input type="text" class="form-control" name="options[]" required><button type="button" class="remove-option btn btn-danger" title="Remove">X</button></div>');
        $('.field-options .row').append(option);
        option_number++;
    });

    $(document).on('click', '.remove-option', function () {
        var option = $(this).parent();
        $(option).remove();
    });
</script>
HTML;

template('template.php', [
    'title' => 'Field Options',
    'content' => $content,
]);