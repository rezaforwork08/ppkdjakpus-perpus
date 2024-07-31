<?php
session_start();

// echo "<h1>Selamat Datang " . (isset($_SESSION['NAMA_LENGKAP']) ? $_SESSION['NAMA_LENGKAP'] : '') . "</h1>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang, </title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        nav.menu {
            background-color: white !important;
            box-shadow: 0 0 3px #000;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <nav class="menu navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Perpustakaan</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="user.php">User</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li>
                    </ul>
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>

        <div class="content">
            Ini User
        </div>

        <!-- content here -->
        <?php
        if (isset($_GET['pg'])) {
            if (file_exists('content/' . $_GET['pg'] . '.php')) {
                include 'content/' . $_GET['pg'] . '.php';
            }
        } else {
            include 'content/home.php';
        }
        ?>
        <!-- end content -->
    </div>
</body>

</html>