<?php
require "session.php";
require "../koneksi.php";

$id = $_GET['id'] ?? '';

if (empty($id)) {
    die("ID film tidak ditemukan.");
}

$query = mysqli_query($con, "SELECT a.*, b.nama AS kategori_nama FROM movies a 
                             JOIN kategoris b ON a.kategori_id = b.id 
                             WHERE a.id = '$id'") or die(mysqli_error($con));

$data = mysqli_fetch_array($query);

$queryKategoris = mysqli_query($con, "SELECT * FROM kategoris WHERE id != '{$data['kategori_id']}'");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Movie - <?= htmlspecialchars($data['judulfilm']) ?></title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 700px;
            margin: 40px auto;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .poster-img {
            max-width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }
        .form-label {
            font-weight: 600;
        }
        .btn-group button {
            min-width: 120px;
        }
        .alert-container {
            max-width: 700px;
            margin: 20px auto 0;
        }
    </style>
</head>
<body>

<?php require "navbar.php" ?>

<div class="alert-container">
    <?php
    if (isset($_POST['simpan'])) {
        $judulfilm = htmlspecialchars($_POST['judulfilm']);
        $actor = htmlspecialchars($_POST['actor']);
        $durasi = htmlspecialchars($_POST['durasi']);
        $tahunrilis = htmlspecialchars($_POST['tahunrilis']);
        $detail = htmlspecialchars($_POST['detail']);
        $genre = htmlspecialchars($_POST['kategoris']);

        if ($judulfilm === '' || $actor === '' || $durasi === '' || $tahunrilis === '' || $genre === '' || $detail === '') {
            echo '<div class="alert alert-warning">Semua field wajib diisi</div>';
        } else {
            $updateQuery = "UPDATE movies 
                            SET kategori_id = '$genre', 
                                judulfilm = '$judulfilm', 
                                actor = '$actor', 
                                durasi = '$durasi', 
                                tahunrilis = '$tahunrilis',
                                detail = '$detail'
                            WHERE id = '$id'";
            $queryUpdate = mysqli_query($con, $updateQuery) or die(mysqli_error($con));

            if ($_FILES["foto"]["name"] != '') {
                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $image_size = $_FILES["foto"]["size"];
                $random_name = generateRandomString(20);
                $new_name = $random_name . "." . $imageFileType;

                if ($image_size > 500000) {
                    echo '<div class="alert alert-warning">File tidak boleh lebih dari 500KB</div>';
                } elseif (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                    echo '<div class="alert alert-warning">Format file harus jpg, jpeg, png, atau gif</div>';
                } else {
                    move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                    mysqli_query($con, "UPDATE movies SET foto = '$new_name' WHERE id = '$id'") or die(mysqli_error($con));
                }
            }

            echo '<div class="alert alert-success">Data berhasil diperbarui</div>';
            echo '<meta http-equiv="refresh" content="1; url=movies.php">';
        }
    }

    if (isset($_POST['hapus'])) {
        $queryHapus = mysqli_query($con, "DELETE FROM movies WHERE id = '$id'") or die(mysqli_error($con));
        if ($queryHapus) {
            echo '<div class="alert alert-danger">Data berhasil dihapus</div>';
            echo '<meta http-equiv="refresh" content="1; url=movies.php">';
        }
    }
    ?>
</div>

<div class="card p-4">
    <h2 class="mb-4 text-center">Detail Movie</h2>

    <form action="" method="post" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
            <label for="judulfilm" class="form-label">Judul Film</label>
            <input type="text" class="form-control" id="judulfilm" name="judulfilm" value="<?= htmlspecialchars($data['judulfilm']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="actor" class="form-label">Actor</label>
            <input type="text" class="form-control" id="actor" name="actor" value="<?= htmlspecialchars($data['actor']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label d-block">Poster Saat Ini</label>
            <img src="../image/<?= htmlspecialchars($data['foto']) ?>" alt="Poster" class="poster-img mb-3" />
            <input type="file" class="form-control" name="foto" id="foto" accept=".jpg,.jpeg,.png,.gif" />
            <small class="form-text text-muted">Format: jpg, jpeg, png, gif. Max size: 500KB.</small>
        </div>

        <div class="mb-3">
            <label for="durasi" class="form-label">Durasi</label>
            <input type="text" class="form-control" id="durasi" name="durasi" value="<?= htmlspecialchars($data['durasi']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="tahunrilis" class="form-label">Tahun Rilis</label>
            <input type="number" class="form-control" id="tahunrilis" name="tahunrilis" value="<?= htmlspecialchars($data['tahunrilis']) ?>" required min="1900" max="<?= date('Y') ?>">
        </div>

        <div class="mb-4">
            <label for="detail" class="form-label">Sinopsis / Detail Film</label>
            <textarea name="detail" id="detail" class="form-control" rows="4" required><?= htmlspecialchars($data['detail'] ?? '') ?></textarea>
        </div>

        <div class="mb-4">
            <label for="kategoris" class="form-label">Kategori</label>
            <select name="kategoris" id="kategoris" class="form-select" required>
                <option value="<?= $data['kategori_id'] ?>" selected><?= htmlspecialchars($data['kategori_nama']) ?></option>
                <?php while ($dataKategori = mysqli_fetch_array($queryKategoris)) { ?>
                    <option value="<?= $dataKategori["id"] ?>"><?= htmlspecialchars($dataKategori['nama']) ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <button type="submit" name="simpan" class="btn btn-primary px-4">
                <i class="bi bi-save"></i> Simpan
            </button>
            <button type="submit" name="hapus" class="btn btn-danger px-4" onclick="return confirm('Yakin ingin menghapus data ini?');">
                <i class="bi bi-trash3"></i> Hapus
            </button>
        </div>
    </form>
</div>

<script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.js"></script>
</body>
</html>

