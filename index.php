<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Filmku | Home</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .hover-scale {
            transition: transform 0.3s ease;
        }

        .hover-scale:hover {
            transform: scale(1.03);
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>

    <!-- Hero Banner Split Layout -->
    <div
        class="container-fluid py-5"
        style="background: linear-gradient(rgba(0,0,0,.6), rgba(0,0,0,.6)), url('image/bgfilmku.jpg') center/cover no-repeat;"
        data-aos="fade-up">
        <div class="container">
            <div class="row align-items-center text-white">
                <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                    <h1 class="fw-bold mb-4">🎬 Temukan Film Favoritmu</h1>
                    <p class="lead mb-3">Eksplorasi film terbaik dari berbagai genre hanya di Filmku.</p>
                    <form method="get" action="movies.php" class="mt-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="input-group input-group-lg shadow">
                            <input
                                type="text"
                                class="form-control rounded-start"
                                name="keyword"
                                placeholder="Judul Movies | Genre" />
                            <button type="submit" class="btn warna2 text-white rounded-end">🔍 Telusuri</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-delay="300">
                    <img src="image/icon.jpg" class="img-fluid mt-5" alt="Film Icon" style="max-height: 300px;" />
                </div>
            </div>
        </div>
    </div>

    <!-- Genre Section Horizontal Cards -->
    <div class="container py-5" data-aos="fade-up" data-aos-delay="100">
        <h3 class="fw-bold text-center mb-4">🎯 Genre Favorit</h3>
        <div class="row justify-content-center">
            <?php
            $genres = ['action' => '🔥 Action', 'horror' => '👻 Horror', 'comedy' => '😂 Comedy'];
            foreach ($genres as $key => $value): ?>
                <div class="col-md-3 mb-3" data-aos="zoom-in" data-aos-delay="<?php echo $key === 'action' ? '100' : ($key === 'horror' ? '200' : '300'); ?>">
                    <a href="movies.php?kategori=<?php echo $key; ?>" class="text-decoration-none">
                        <div class="card shadow-lg bg-dark text-white hover-scale text-center py-4 rounded-4">
                            <div class="card-body">
                                <h4 class="card-title fw-bold"><?php echo $value; ?></h4>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- About Section with Image -->
    <div class="container-fluid warna2 text-white py-5" data-aos="fade-up" data-aos-delay="100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0" data-aos="fade-right">
                    <img
                        src="image/about-us.jpg"
                        class="img-fluid rounded-4 shadow"
                        alt="About Filmku"
                        style="max-height: 300px" />
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <p class="lead">
                        "Filmku" adalah platform yang menyajikan beragam film pilihan dari berbagai genre, mulai dari drama,
                        aksi, hingga dokumenter. Temukan cerita luar biasa yang menginspirasi dan menggugah emosi Anda—semua
                        di satu tempat.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Movies List Masonry Style -->
    <div class="container py-5" data-aos="fade-up" data-aos-delay="100">
        <h3 class="fw-bold text-center mb-5">🍿 Rekomendasi Movies</h3>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
            <?php
            require "koneksi.php";
            $queryMovies = mysqli_query($con, "SELECT id, judulfilm, actor, foto, durasi, tahunrilis FROM movies LIMIT 6");
            $i = 0;
            while ($movies = mysqli_fetch_array($queryMovies)) {
                $delay = 100 * $i;
            ?>
                <div class="col" data-aos="zoom-in-up" data-aos-delay="<?php echo $delay; ?>">
                    <div class="card h-100 shadow-sm rounded-4 hover-scale">
                        <img
                            src="image/<?php echo $movies['foto']; ?>"
                            class="card-img-top rounded-top-4"
                            style="height: 300px; object-fit: cover;"
                            alt="<?php echo $movies['judulfilm']; ?>" />
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $movies['judulfilm']; ?></h5>
                            <p class="card-text text-muted">🎭 <?php echo $movies['actor']; ?></p>
                            <p class="small text-muted">
                                🕒 <?php echo $movies['durasi']; ?> | 📅 <?php echo $movies['tahunrilis']; ?>
                            </p>
                            <a href="movies-detail.php?nama=<?php echo $movies['judulfilm']; ?>" class="btn btn-danger w-100 mt-2">🎥 Lihat Detail</a>
                        </div>
                    </div>
                </div>
            <?php $i++;
            } ?>
        </div>
        <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="200">
            <a href="movies.php" class="btn btn-outline-dark px-5 py-3 fs-5 rounded-pill shadow-sm">➕ Lihat Semua Film</a>
        </div>
    </div>

    <!-- Footer -->
    <?php require "footer.php"; ?>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="fontawesome/js/all.min.js"></script>
</body>

</html>