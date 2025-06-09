<?php
require "koneksi.php";

$queryKategoris = mysqli_query($con, "SELECT * FROM kategoris");

if (isset($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($con, $_GET['keyword']);
    $queryMovies = mysqli_query(
        $con,
        "SELECT m.* 
        FROM movies m
        LEFT JOIN kategoris k ON m.kategori_id = k.id
        WHERE m.judulfilm LIKE '%$keyword%' OR k.nama LIKE '%$keyword%'"
    );
} else if (isset($_GET['kategori'])) {
    $namaKategori = mysqli_real_escape_string($con, $_GET['kategori']);
    $queryGetkategorisId = mysqli_query($con, "SELECT id FROM kategoris WHERE nama = '$namaKategori'");
    $kategorisId = mysqli_fetch_array($queryGetkategorisId);

    if ($kategorisId) {
        $queryMovies = mysqli_query($con, "SELECT * FROM movies WHERE kategori_id = '$kategorisId[id]'");
    } else {
        $queryMovies = mysqli_query($con, "SELECT * FROM movies WHERE 1=0");
    }
} else {
    $queryMovies = mysqli_query($con, "SELECT * FROM movies");
}

$countData = mysqli_num_rows($queryMovies);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filmku | Movies</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .card-img-top {
            height: 250px;
            object-fit: cover;
        }
        .sidebar-kategori h3 {
            border-bottom: 2px solid #ccc;
            padding-bottom: 10px;
        }
        .kategori-list a {
            text-decoration: none;
        }
        .kategori-icon {
            margin-right: 8px;
        }
        .btn-warna4 {
            background-color: #dc3545;
        }
        .background-movies{
            background-color: #D1D8BE;
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>

    <div class="container-fluid banner-movies d-flex align-items-center justify-content-center" style="background: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url('image/bgfilmku.jpg') center/cover no-repeat; height: 300px;">
        <div class="container text-center" data-aos="zoom-in">
            <h1 class="text-white display-4">Temukan Film Favoritmu</h1>
            <p class="text-white fs-5">Eksplorasi ribuan film menarik hanya di sini</p>
        </div>
    </div>
 <div class="background-movies">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3 mb-5" data-aos="fade-right">
                <div class="p-4 border rounded shadow-sm bg-light">
                    <h3 class="fs-4 mb-4"><i class="fas fa-film me-2"></i> Kategori</h3>
                    <ul class="list-group kategori-list">
                        <?php while ($kategoris = mysqli_fetch_array($queryKategoris)) { ?>
                            <a class="no-decoration" href="movies.php?kategori=<?php echo $kategoris['nama']; ?>">
                                <li class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-tags kategori-icon text-danger"></i>
                                    <?php echo $kategoris['nama']; ?>
                                </li>
                            </a>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-9 data-aos="fade-left">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="text-dark"><i class="fas fa-play-circle me-2 text-danger"></i> Movies</h3>
                </div>
                <div class="row g-4">
                    <?php
                    if ($countData < 1) {
                        echo '<div class="col-12" data-aos="fade-up"><h4 class="text-center py-5">Movies yang anda cari tidak tersedia</h4></div>';
                    }
                    ?>

                    <?php $i = 0; while ($data = mysqli_fetch_array($queryMovies)) { $delay = 100 * $i; ?>
                        <div class="col-sm-6 col-md-4" data-aos="zoom-in-up" data-aos-delay="<?php echo $delay; ?>">
                            <div class="card h-100 shadow-sm border-0 rounded-4">
                                <img src="image/<?php echo $data['foto']; ?>" class="card-img-top rounded-top-4" alt="<?php echo $data['judulfilm']; ?>">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title fw-bold text-truncate"><?php echo $data['judulfilm']; ?></h5>
                                    <p class="card-text text-muted small text-truncate">🎭 <?php echo $data['actor']; ?></p>
                                    <a href="movies-detail.php?nama=<?php echo $data['judulfilm']; ?>" class="btn btn-warna4 text-white mt-auto">Tonton</a>
                                </div>
                            </div>
                        </div>
                    <?php $i++; } ?>
                </div>
            </div>
        </div>
    </div>
 </div>

    <?php require "footer.php"; ?>

    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
            duration: 800
        });
    </script>
</body>

</html>

