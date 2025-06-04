<?php
require "session.php";
require "../koneksi.php";

$querykategoris = mysqli_query($con, "SELECT * FROM kategoris");
$jumlahkategoris = mysqli_num_rows($querykategoris);

$querymovies = mysqli_query($con, "SELECT * FROM movies");
$jumlahmovies = mysqli_num_rows($querymovies);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/fontawesome.min.css">
</head>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .card-summary {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-summary:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-kategori {
        background: linear-gradient(135deg, #20c997, #198754);
        color: white;
    }

    .card-movies {
        background: linear-gradient(135deg, #0d6efd, #1e40af);
        color: white;
    }

    .card-summary .icon {
        font-size: 4rem;
        opacity: 0.6;
    }

    .card-summary a {
        text-decoration: none;
        color: #fff;
        font-weight: 500;
    }

    .card-summary a:hover {
        text-decoration: underline;
    }

    .breadcrumb {
        background-color: transparent;
        padding-left: 0;
    }

    .breadcrumb .breadcrumb-item {
        font-size: 1.1rem;
    }
</style>


<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>
        <h2 class="text-light">hallo <?php $_SESSION['username']; ?></h2>

 <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .card-summary {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-summary:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-kategori {
        background: linear-gradient(135deg, #20c997, #198754);
        color: white;
    }

    .card-movies {
        background: linear-gradient(135deg, #0d6efd, #1e40af);
        color: white;
    }

    .card-summary .icon {
        font-size: 4rem;
        opacity: 0.6;
    }

    .card-summary a {
        text-decoration: none;
        color: #fff;
        font-weight: 500;
    }

    .card-summary a:hover {
        text-decoration: underline;
    }

    .breadcrumb {
        background-color: transparent;
        padding-left: 0;
    }

    .breadcrumb .breadcrumb-item {
        font-size: 1.1rem;
    }
</style>
<style>
    body {
        background-image: url(../image/bgfilmku.jpg);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h2 {
        font-weight: 600;
        color: #333;
    }

    .card-summary {
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card-summary:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .card-kategori {
        background: linear-gradient(135deg, #20c997, #198754);
        color: white;
    }

    .card-movies {
        background: linear-gradient(135deg, #0d6efd, #1e40af);
        color: white;
    }

    .card-summary .icon {
        font-size: 4rem;
        opacity: 0.6;
    }

    .card-summary a {
        text-decoration: none;
        color: #fff;
        font-weight: 500;
    }

    .card-summary a:hover {
        text-decoration: underline;
    }

    .breadcrumb {
        background-color: transparent;
        padding-left: 0;
    }

    .breadcrumb .breadcrumb-item {
        font-size: 1.1rem;
    }
</style>
<div class="col-lg-4 col-md-6 col-12 mb-3">
    <div class="card-summary card-kategori p-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="icon"><i class="fas fa-align-justify"></i></div>
            <div class="text-end">
                <h4>Kategori</h4>
                <p class="fs-5 mb-1"><?php echo $jumlahkategoris; ?> Kategori</p>
                <a href="kategoris.php">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-4 col-md-6 col-12 mb-3">
    <div class="card-summary card-movies p-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="icon"><i class="fas fa-film"></i></div>
            <div class="text-end">
                <h4>Movies</h4>
                <p class="fs-5 mb-1"><?php echo $jumlahmovies; ?> Movies</p>
                <a href="movies.php">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>


    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>


</html>