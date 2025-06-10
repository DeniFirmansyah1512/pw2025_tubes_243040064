<?php
require "koneksi.php";

$keyword = mysqli_real_escape_string($con, $_GET['keyword']);

$query = mysqli_query($con, "
    SELECT m.* FROM movies m
    LEFT JOIN kategoris k ON m.kategori_id = k.id
    WHERE m.judulfilm LIKE '%$keyword%' OR k.nama LIKE '%$keyword%'
");

$count = mysqli_num_rows($query);

if ($count < 1) {
    echo '<div class="col-12"><h4 class="text-center py-5">Movies yang anda cari tidak tersedia</h4></div>';
} else {
    $i = 0;
    while ($data = mysqli_fetch_array($query)) {
        $delay = 100 * $i;
        ?>
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
        <?php
        $i++;
    }
}
?>