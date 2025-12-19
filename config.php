<?php

$users = [
    ['id' => 1, 'email' => 'admin@example.com', 'password' => '123456', 'role' => 'admin'],
    ['id' => 2, 'email' => 'user@example.com', 'password' => '123456', 'role' => 'user'],
];

$db_config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'database' => 'dynamic-forms',
];

$field_types = ['text', 'textarea', 'number', 'date', 'dropdown', 'checkbox', 'radio'];
