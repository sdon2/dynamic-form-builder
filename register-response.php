<?php

require_once('functions.php');

checkLogin() && checkUser();

require_once('database.php');

$form_id = $_GET['form'];

if ($_POST) {
    //die(var_dump($_POST));
    $user_id = user();
    $sql = sprintf("INSERT INTO form_responses (form_id, user_id) VALUES (?, ?)");
    $statement = $conn->prepare($sql);
    $statement->bind_param('ii', $form_id, $user_id);
    if ($statement->execute()) {
        $response_id = $conn->insert_id;
        foreach($_POST as $field_id => $value) {
            $sql = "INSERT INTO `form_response_values` (`response_id`, `field_id`, `value`) VALUES (?, ?, ?)";
            $statement = $conn->prepare($sql);
            $value = is_array($value) ? implode(',', $value) : $value;
            $statement->bind_param('iis', $response_id, $field_id, $value);
            $statement->execute();
        }
    }

    if ($statement->execute()) {
        session_set('success', 'Response registered successfully');
        redirect("register-response.php?form={$form_id}");
        exit();
    }
}

$sql = sprintf('SELECT * FROM forms WHERE id = %s', $form_id);
$query = $conn->query($sql);
$form = $query->fetch_assoc();

$sql = sprintf('SELECT * FROM form_fields WHERE form_id = %s ORDER BY sort_order', $form_id);

$query = $conn->query($sql);

$fields_html = '<div class="row">';

while ($row = $query->fetch_assoc()) {
    $fields_html .= '<div class="col-md-6">';
    $fields_html .= sprintf('<label class="form-label">%s</label>', $row['label']);
    switch ($row['type']) {
        case "text":
            $fields_html .= sprintf('<input name="%s" type="text" class="form-control" placeholder="%s" %s>', $row["id"], $row['placeholder'] , $row['required'] ? 'required' : '');
            break;
        case "number":
            $fields_html .= sprintf('<input name="%s" type="number" class="form-control" placeholder="%s" %s>', $row["id"], $row['placeholder'] , $row['required'] ? 'required' : '');
            break;
        case "date":
            $fields_html .= sprintf('<input name="%s" type="date" class="form-control" placeholder="%s" %s>', $row["id"], $row['placeholder'] , $row['required'] ? 'required' : '');
            break;
        case "textarea":
            $fields_html .= sprintf('<textarea name="%s" placeholder="%s" class="form-control" %s>', $row['id'],  $row['placeholder'] , $row['required'] ? 'required' : '');
            $fields_html .= '</textarea>';
            break;
        case "dropdown":
            $fields_html .= sprintf('<select class="form-control" name="%s" placeholder="%s" %s>', $row['id'],  $row['placeholder'] , $row['required'] ? 'required' : '');
            $sql = sprintf('SELECT * FROM `field_options` WHERE `field_id`=%s', $row['id']);
            $query = $conn->query($sql);
            $options = '<option value="">--SELECT--</option>';
            while ($option = $query->fetch_assoc()) {
                $options .= sprintf('<option>%s</option>', $option['option_text']);
            }
            $fields_html .= $options . '</select>';
            break;
        case "checkbox":
            $fields_html .= '<fieldset>';
            $sql = sprintf('SELECT * FROM `field_options` WHERE `field_id`=%s', $row['id']);
            $query = $conn->query($sql);
            $options = '';
            while ($option = $query->fetch_assoc()) {
                $options .= sprintf('<label class="mx-2"><input type="checkbox" name="%s[]" value="%s"><span class="px-1">%s</span></label>',$row['id'], $option['option_text'], $option['option_text']);
            }
            $fields_html .= $options . '</fieldset>';
            break;
        case "radio":
            $fields_html .= '<fieldset>';
            $sql = sprintf('SELECT * FROM `field_options` WHERE `field_id`=%s', $row['id']);
            $query = $conn->query($sql);
            $options = '';
            while ($option = $query->fetch_assoc()) {
                $options .= sprintf('<label class="mx-2"><input type="radio" name="%s[]" value="%s"><span class="px-1">%s</span></label>',$row['label'], $option['option_text'], $option['option_text']);
            }
            $fields_html .= $options . '</fieldset>';
            break;
        default:
            break;
    }

    $fields_html .= '</div>';
}

$fields_html .= '</div>';

$content = <<<HTML
<div class="row">
    <div class="col-md-12 my-2">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{$form['form_name']}</h4>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <form action="" method="POST" enctype="multipart/form-data">
                            {$fields_html}
                            <div class="col-md-12 my-2">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <a href="forms.php" class="btn btn-primary">Back</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;

template('template.php', [
    'title' => 'Register Response',
    'content' => $content,
]);