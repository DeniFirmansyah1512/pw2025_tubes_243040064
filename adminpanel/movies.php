<?php
require "session.php";
require "../koneksi.php";

$query = mysqli_query($con, "SELECT a.*, b.nama AS kategori_nama FROM movies a JOIN kategoris b ON a.kategori_id = b.id");
$jumlahmovies = mysqli_num_rows($query);
$querykategoris = mysqli_query($con, "SELECT * FROM kategoris");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Movies</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .movie-thumb {
            width: 80px;
            height: auto;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<?php require "navbar.php"; ?>
<div class="container my-5">
    <h2 class="mb-4">Tambah Film</h2>

    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="judulfilm" class="form-label">Judul Film</label>
            <input type="text" name="judulfilm" id="judulfilm" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="actor" class="form-label">Aktor</label>
            <input type="text" name="actor" id="actor" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" name="foto" id="foto" class="form-control" accept=".jpg,.png,.gif" required>
        </div>

        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi</label>
            <input type="text" name="durasi" id="durasi" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="tahunrilis" class="form-label">Tahun Rilis</label>
            <input type="number" name="tahunrilis" id="tahunrilis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="detail" class="form-label">Sinopsis / Detail</label>
            <textarea name="detail" id="detail" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="kategoris" class="form-label">Kategori</label>
            <select name="kategoris" id="kategoris" class="form-select" required>
                <option value="">-- Pilih Kategori --</option>
                <?php while ($data = mysqli_fetch_array($querykategoris)) : ?>
                    <option value="<?= $data['id'] ?>"><?= htmlspecialchars($data['nama']) ?></option>
                <?php endwhile ?>
            </select>
        </div>

        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
    </form>

    <?php
    if (isset($_POST['simpan'])) {
        $judulfilm = htmlspecialchars($_POST['judulfilm']);
        $actor = htmlspecialchars($_POST['actor']);
        $durasi = htmlspecialchars($_POST['durasi']);
        $tahunrilis = htmlspecialchars($_POST['tahunrilis']);
        $genre = htmlspecialchars($_POST["kategoris"]);
        $detail = htmlspecialchars($_POST["detail"]);

        $target_dir = "../image/";
        $nama_file = basename($_FILES["foto"]["name"]);
        $imageFileType = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];
        $random_name = generateRandomString(20);
        $new_name = $random_name . "." . $imageFileType;
        $target_file = $target_dir . $new_name;

        if ($nama_file != '') {
            if ($image_size > 500000) {
                echo '<div class="alert alert-warning mt-3">Ukuran gambar terlalu besar (maks. 500KB)</div>';
            } elseif (!in_array($imageFileType, ['jpg', 'png', 'gif'])) {
                echo '<div class="alert alert-warning mt-3">Format gambar harus JPG, PNG, atau GIF</div>';
            } else {
                move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

                $queryTambah = mysqli_query($con, "INSERT INTO movies 
                    (judulfilm, actor, foto, durasi, tahunrilis, detail, kategori_id) 
                    VALUES ('$judulfilm','$actor','$new_name','$durasi','$tahunrilis','$detail','$genre')");

                if ($queryTambah) {
                    echo '<div class="alert alert-success mt-3">Data berhasil ditambahkan!</div>';
                    echo '<meta http-equiv="refresh" content="1; url=movies.php" />';
                } else {
                    echo '<div class="alert alert-danger mt-3">Gagal menambahkan data.</div>';
                }
            }
        } else {
            echo '<div class="alert alert-warning mt-3">File gambar wajib diunggah.</div>';
        }
    }
    ?>
</div>

<!-- Tabel Daftar Movie -->
<div class="container mb-5">
    <h3 class="mb-3">Daftar Film (<?= $jumlahmovies ?>)</h3>
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Aktor</th>
                    <th>Foto</th>
                    <th>Durasi</th>
                    <th>Tahun</th>
                    <th>Sinopsis</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($data = mysqli_fetch_array($query)) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($data['judulfilm']) ?></td>
                        <td><?= htmlspecialchars($data['actor']) ?></td>
                        <td><img src="../image/<?= htmlspecialchars($data['foto']) ?>" class="movie-thumb" alt="Poster"></td>
                        <td><?= htmlspecialchars($data['durasi']) ?></td>
                        <td><?= htmlspecialchars($data['tahunrilis']) ?></td>
                        <td><?= nl2br(htmlspecialchars(substr($data['detail'], 0, 80))) ?>...</td>
                        <td><?= htmlspecialchars($data['kategori_nama']) ?></td>
                        <td>
                            <a href="movies-detail.php?p=<?= $data['id'] ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-search"></i> Detail
                            </a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>

