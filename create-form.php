<?php

require_once('functions.php');

checkLogin() && checkAdmin();

if ($_POST) {
    $data = $_POST['name'];

    require_once('database.php');

    $statement = $conn->prepare("INSERT INTO `forms` (`form_name`) VALUES (?)");
    $statement->bind_param('s', $data);

    if ($statement->execute()) {
        session_set('success', 'Form created successfully');
        redirect('forms.php');
        exit();
    }
}

$content = <<<HTML
<form method="POST" action="" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6 form-group">
            <label class="form-label">Form Name</label>
            <input type="text" class="form-control" name="name" placeholder="Form Name">
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-12">
            <button type="submit" class="btn btn-success">Save</button>
            <a href="forms.php" class="btn btn-primary">Back</a>
        </div>
    </div>
</form>
HTML;

template('template.php', [
    'title' => 'Create new form',
    'content' => $content,
]);