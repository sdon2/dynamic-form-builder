<?php

require_once('config.php');

function template($template, $data = [])
{
    extract($data);

    ob_start();

    include $template;

    $output = ob_get_contents();

    ob_end_clean();

    echo $output;
}

function user()
{
    return $_SESSION['user'] ?? false;
}

function checkLogin()
{
    session_start();

    if (!user()) {
        redirect('login.php');
    }
}

function checkAdmin()
{
    if (user()['role'] ?? null !== 'admin') {
        logout();
    }
}

function checkUser()
{
    if (user()['role'] !== 'user') {
        logout();
    }
}

function logout()
{
    session_start();
    session_destroy();
    redirect('login.php');
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function getUserById($id)
{
    global $users;

    foreach ($users as $user) {
        if ($user['id'] == $id) return $user;
    }

    return null;
}

function redirectIfAuthenticated()
{
    session_start();

    if (isset($_SESSION['user'])) {
        redirect('index.php');
    }
}
function authenticate($email, $password)
{
    global $users;
    
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            return $user;
        }
    }
    
    return false;
}

function session_set($session_variable, $message)
{
    $_SESSION[$session_variable] = $message;
}

function session_get($session_variable)
{
    return $_SESSION[$session_variable] ?? false;
}

function session_pull($session_variable)
{
    $result = session_get($session_variable);
    unset($_SESSION[$session_variable]);
    return $result;
}
