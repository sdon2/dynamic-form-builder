<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Home' ?> | Dynamic Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="<?= $showSidebar ?? true ? 'd-flex' : 'container' ?>">
        <?php if ($showSidebar ?? true): ?>
        <!-- Sidebar for desktop -->
        <nav id="sidebar" class="bg-dark text-white p-3 d-none d-md-block" style="width: 250px; min-height: 100vh;">
            <h4>Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <?php if(user()['role'] === 'admin'): ?>
                        <a class="nav-link text-white" href="forms.php">Forms</a>
                    <?php elseif(user()['role'] === 'user'): ?>
                        <a class="nav-link text-white" href="user-forms.php">Forms</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Main content -->
        <div class="flex-grow-1 p-3">

            <!-- Mobile toggle button -->
            <button class="btn btn-dark d-md-none mb-3" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">
                ☰ Menu
            </button>

            <h1><?= $title ?? 'Home' ?></h1>

            <?php if (session_get('success')): ?>
            <div class="alert alert-success">
                <?= session_pull('success') ?>
            </div>
            <?php elseif (session_get('error')): ?>
            <div class="alert alert-danger">
                <?= session_pull('error') ?>
            </div>
            <?php endif; ?>
            <?php endif; ?>


            <?php
            // Include or echo content here
            echo $content;
            ?>

        </div>
    </div>

    <!-- Offcanvas sidebar for mobile -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="mobileSidebar"
        aria-labelledby="mobileSidebarLabel" style="width:250px;">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <?php if(user()['role'] === 'admin'): ?>
                        <a class="nav-link text-white" href="forms.php">Forms</a>
                    <?php elseif(user()['role'] === 'user'): ?>
                        <a class="nav-link text-white" href="user-forms.php">Forms</a>
                    <?php endif; ?>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
