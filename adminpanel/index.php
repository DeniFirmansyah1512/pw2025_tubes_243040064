<?php
require "session.php";
require "../koneksi.php";

$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query data kategoris
$querykategoris = mysqli_query($con, "SELECT * FROM kategoris");
$jumlahkategoris = mysqli_num_rows($querykategoris);

// Query data movies (dengan join dan pencarian)
if ($search != '') {
    $querymovies = mysqli_query($con, "
        SELECT movies.*, kategoris.nama AS genre 
        FROM movies 
        JOIN kategoris ON movies.kategori_id = kategoris.id 
        WHERE movies.judulfilm LIKE '%$search%' 
        OR kategoris.nama LIKE '%$search%'
    ");
} else {
    $querymovies = mysqli_query($con, "
        SELECT movies.*, kategoris.nama AS genre 
        FROM movies 
        JOIN kategoris ON movies.kategori_id = kategoris.id
    ");
}
$jumlahmovies = mysqli_num_rows($querymovies);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <style>
        body {
            background-image: url(../image/bgfilmku.jpg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card-summary {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-kategori {
            background: linear-gradient(135deg, #20c997, #198754);
            color: white;
        }

        .card-movies {
            background: linear-gradient(135deg, #0d6efd, #1e40af);
            color: white;
        }

        .movie-list {
            background-color: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-top: 20px;
        }

        .movie-title {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .movie-genre {
            font-style: italic;
            color: gray;
        }

        .movie-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background-color: #FBDB93;
            border-radius: 10px;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        a {
            text-decoration: none !important;
        }

        .card-title {
            color: #0d6efd;
            font-weight: bold;
        }

        .card-subtitle {
            font-style: italic;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-4">
        <h2 class="text-white">Halo, <?php echo $_SESSION['username']; ?>!</h2>

        <!-- Search box -->
        <form method="GET" class="my-4">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Cari judul film atau genre..." name="search" value="<?= htmlspecialchars($search); ?>">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <!-- Ringkasan -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card card-summary card-kategori p-3">
                    <h4>Kategori</h4>
                    <p><?= $jumlahkategoris ?> total kategori</p>
                    <a href="kategoris.php" class="text-white">Lihat detail</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-summary card-movies p-3">
                    <h4>Movies</h4>
                    <p><?= $jumlahmovies ?> total film ditemukan</p>
                    <a href="movies.php" class="text-white">Lihat semua film</a>
                </div>
            </div>
        </div>

        <!-- Hasil pencarian -->
        <?php if ($search != ''): ?>
            <h4 class="text-white">Hasil pencarian untuk "<strong><?= htmlspecialchars($search); ?></strong>":</h4>
        <?php endif; ?>

        <div class="row mt-4">
            <?php if ($jumlahmovies == 0): ?>
                <div class="col">
                    <div class="alert alert-warning">Tidak ada film yang cocok dengan pencarian Anda.</div>
                </div>
            <?php else: ?>
                <?php while ($data = mysqli_fetch_assoc($querymovies)) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm border-0 movie-card">
                            <div class="card-body">
                                <h5 class="card-title mb-1"><?= htmlspecialchars($data['judulfilm']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($data['genre']); ?></h6>
                                <p class="mb-1"><strong>Actor:</strong> <?= htmlspecialchars($data['actor']); ?></p>
                                <p class="mb-1"><strong>Durasi:</strong> <?= htmlspecialchars($data['durasi']); ?></p>
                                <p class="mb-1"><strong>Tahun:</strong> <?= htmlspecialchars($data['tahunrilis']); ?></p>
                                <a href="movies-detail.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-outline-danger mt-2">Detail</a>

                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>

    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>