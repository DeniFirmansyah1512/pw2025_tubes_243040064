<?php
require "koneksi.php";

$nama = htmlspecialchars($_GET['nama']);
$queryMovies = mysqli_query($con, "SELECT * FROM movies WHERE judulfilm = '$nama'");
$movies = mysqli_fetch_array($queryMovies);

$queryMoviesTerkait = mysqli_query($con, "SELECT * FROM movies WHERE kategori_id='$movies[kategori_id]' AND id!='$movies[id]' LIMIT 4");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Filmku | Detail Movies</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
</head>

<body>
    <?php require "navbar.php" ?>

    <!-- detail movies -->
    <div class="container-fluid py-5 bg-light" data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center">
                <!-- Gambar Film -->
                <div class="col-lg-5 mb-4" data-aos="fade-right" data-aos-delay="100">
                    <div class="position-relative shadow-lg rounded overflow-hidden">
                        <img src="image/<?php echo $movies['foto']; ?>" class="img-fluid w-100" style="border-radius: 16px;" alt="Poster <?php echo $movies['judulfilm']; ?>" />
                    </div>
                </div>

                <!-- Detail Film -->
                <div class="col-lg-7" data-aos="fade-left" data-aos-delay="200">
                    <h1 class="fw-bold mb-3 text-dark"><?php echo $movies['judulfilm']; ?></h1>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <h5 class="text-muted">📝 Sinopsis Film</h5>
                        <div class="bg-white p-4 rounded-4 shadow-sm fs-6 lh-base" style="line-height: 1.8;">
                            <?php echo nl2br($movies['detail']); ?>
                        </div>
                    </div>

                    <!-- Info Film -->
                    <div class="d-flex flex-wrap gap-3 mb-3">
                        <span class="badge bg-primary fs-6 p-2 rounded-pill" data-aos="zoom-in" data-aos-delay="300">
                            ⏱️ Durasi: <?php echo $movies['durasi']; ?>
                        </span>
                        <span class="badge bg-secondary fs-6 p-2 rounded-pill" data-aos="zoom-in" data-aos-delay="400">
                            📅 Rilis: <?php echo $movies['tahunrilis']; ?>
                        </span>
                        <?php if (!empty($movies['genre'])): ?>
                            <span class="badge bg-warning text-dark fs-6 p-2 rounded-pill" data-aos="zoom-in" data-aos-delay="500">
                                🎭 Genre: <?php echo $movies['genre']; ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <!-- Tombol Nonton -->
                    <a href="#" class="btn btn-danger btn-lg mt-3 shadow-sm px-4 py-2 rounded-3" data-aos="zoom-in" data-aos-delay="600">
                        🎬 Nonton Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Movies Terkait -->
    <div class="container-fluid py-5 warna2" data-aos="fade-up" data-aos-delay="100">
        <div class="container">
            <h2 class="text-center text-white fw-bold mb-5">🎞️ Movies Terkait</h2>
            <div class="row justify-content-center">
                <?php 
                $delay = 0;
                while ($data = mysqli_fetch_array($queryMoviesTerkait)) { 
                    $delay += 100;
                ?>
                    <div class="col-6 col-sm-4 col-md-3 mb-4" data-aos="zoom-in-up" data-aos-delay="<?php echo $delay; ?>">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden hover-scale">
                            <a href="movies-detail.php?nama=<?php echo $data['judulfilm']; ?>">
                                <img src="image/<?php echo $data['foto']; ?>" class="img-fluid w-100" style="height: 250px; object-fit: cover;" alt="<?php echo $data['judulfilm']; ?>" />
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php require "footer.php"; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>
