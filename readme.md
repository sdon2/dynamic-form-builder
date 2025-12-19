# Dynamic Form Builder

A PHP-based dynamic form builder system that allows administrators to create custom forms and collect responses from users.

## Features

- **User Authentication**: Role-based access control with admin and user roles
- **Form Management**: Create, view, and manage dynamic forms
- **Dynamic Fields**: Support for multiple field types (text, textarea, number, date, dropdown, checkbox, radio)
- **Response Collection**: Collect and manage form responses
- **Admin Panel**: Dedicated admin interface for form creation and management
- **User Interface**: Clean, responsive design with Bootstrap

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx)
- PHP MySQLi extension

## Installation & Setup

### 1. Database Setup

1. Create a MySQL database named `dynamic-forms`:
```sql
CREATE DATABASE dynamic-forms;
```

2. Import the database schema:
```bash
mysql -u root -p dynamic-forms < database.sql
```

### 2. Configuration

Update the database credentials in `config.php`:
```php
$db_config = [
    'host' => 'localhost',      // Your database host
    'username' => 'root',       // Your database username
    'password' => 'root',       // Your database password
    'database' => 'dynamic-forms',
];
```

### 3. Web Server Setup

1. Copy all project files to your web server's document root
2. Ensure proper file permissions (755 for directories, 644 for files)
3. Start your web server and navigate to the project URL

## Demo Credentials

### Admin User
- **Email**: admin@example.com
- **Password**: 123456
- **Role**: Administrator (can create and manage forms)

### Regular User
- **Email**: user@example.com
- **Password**: 123456
- **Role**: User (can view and submit forms)

## How to Run Demo

### Step 1: Login
1. Open your web browser and navigate to the project URL
2. Use the admin credentials to log in: `admin@example.com` / `123456`

### Step 2: Create a Form (Admin Only)
1. After logging in as admin, go to "Forms" section
2. Click "Create Form" button
3. Enter a form name (e.g., "Customer Survey")
4. Save the form

### Step 3: Add Fields to Form
1. Click "Fields" button next to your created form
2. Click "Create Field" button
3. Configure field properties:
   - **Label**: Field display name (e.g., "Full Name")
   - **Type**: Select field type (text, textarea, number, date, dropdown, checkbox, radio)
   - **Required**: Mark as mandatory field
   - **Placeholder**: Optional placeholder text
4. For dropdown/checkbox/radio fields, add options after creating the field
5. Repeat to add more fields

### Step 4: Test Form as User
1. Log out from admin account
2. Log in as regular user: `user@example.com` / `123456`
3. Navigate to "User Forms" section
4. Select and fill out the form you created
5. Submit the form

### Step 5: View Responses (Admin Only)
1. Log back in as admin
2. Go to "Forms" section
3. Click "Responses" button next to your form
4. View all submitted responses

## Project Structure

```
├── config.php          # Configuration file (database, users, field types)
├── database.php        # Database connection
├── database.sql        # Database schema
├── functions.php       # Helper functions
├── index.php           # Home page
├── login.php           # Login page
├── logout.php          # Logout functionality
├── template.php        # Main template layout
├── forms.php           # Form management (admin)
├── create-form.php     # Create new form
├── fields.php          # Field management
├── create-field.php    # Create form fields
├── field_options.php   # Field options management
├── responses.php       # Response viewing
├── register-response.php # Submit form responses
└── user-forms.php      # User form interface
```

## Key Features Explained

### Form Creation
- Admins can create unlimited forms
- Each form can have multiple fields of different types
- Forms are stored in the database with proper relationships

### Field Types Supported
- **Text**: Single line text input
- **Textarea**: Multi-line text input
- **Number**: Numeric input
- **Date**: Date picker
- **Dropdown**: Select from predefined options
- **Checkbox**: Multiple selection options
- **Radio**: Single selection options

### Response Management
- All form submissions are stored with timestamps
- Responses are linked to users and forms
- Admin can view all responses for any form
