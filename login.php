<?php

require_once 'config.php';
require_once 'functions.php';

redirectIfAuthenticated();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $user = authenticate($email, $password);
    if ($user) {
        $_SESSION['user'] = $user;
        redirect('index.php');
    } else {
        $message = 'Invalid credentials';
    }
}

$content = <<<HTML
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="card shadow p-0" style="width: 400px;">
        <div class="card-header" style="background-color: #6610f2; color: white;">
            <h2 class="card-title mb-0">Login</h2>
        </div>
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #6610f2; color: white;">Login</button>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <div class="row col-md-8">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <strong>Admin User Login:</strong>
                        <strong>Email:</strong> admin@example.com<br/>
                        <strong>Password:</strong> 123456
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4 mt-md-0">
                <div class="card">
                    <div class="card-body">
                        <strong>Demo User Login:</strong>
                        <strong>Email:</strong> user@example.com<br/>
                        <strong>Password:</strong> 123456
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;

if ($message) {
    $content = str_replace('<div class="card-body">', '<div class="card-body"><p class="text-danger">' . $message . '</p>', $content);
}

template('template.php', [
    'title' => 'Login',
    'content' => $content,
    'showSidebar' => false,
]);
